<?php

namespace Logic;

/**
 * Server-side implementation of Manual J Load Calculation
 */
class Calculator
{

    /**
     * Design Temperature Data
     * Loaded from ClimateData class
     */

    private const INSULATION = [
        'walls' => [
            'poor' => 0.25,     // R-4
            'average' => 0.076, // R-13
            'good' => 0.045     // R-22
        ],
        'ceiling' => [
            'poor' => 0.1,      // R-10
            'average' => 0.033, // R-30
            'good' => 0.02      // R-50
        ]
    ];

    private const WINDOWS = [
        'single' => ['u' => 1.2, 'shgc' => 0.8],
        'double' => ['u' => 0.5, 'shgc' => 0.6],
        'double-lowe' => ['u' => 0.35, 'shgc' => 0.3]
    ];

    public static function calculate(array $data): array
    {
        // Validation
        if (empty($data['state'])) {
            throw new \InvalidArgumentException("State selection is required.");
        }
        if (empty($data['area']) || (float) $data['area'] <= 0) {
            throw new \InvalidArgumentException("Valid floor area (sq ft) is required.");
        }
        if (empty($data['ceiling_height']) || (float) $data['ceiling_height'] <= 0) {
            throw new \InvalidArgumentException("Valid ceiling height is required.");
        }

        $area = (float) $data['area'];
        $height = (float) $data['ceiling_height'];

        // Temperatures
        $state = $data['state'];
        $city = $data['city'] ?? '';

        $summerT = 90;
        $winterT = 30;
        $locationLabel = $state;

        // Try to find specific city data
        if ($state && class_exists('Logic\ClimateData')) {
            $allData = ClimateData::DATA;
            if (isset($allData[$state])) {
                $sData = $allData[$state];
                $locationLabel = $sData['state']; // Full name

                // Default state values
                $summerT = $sData['summer'];
                $winterT = $sData['winter'];

                // Specific City Check
                if ($city) {
                    if (isset($sData['cities'][$city])) {
                        $summerT = $sData['cities'][$city]['summer'];
                        $winterT = $sData['cities'][$city]['winter'];
                        $locationLabel .= " ($city)";
                    } elseif (isset($sData['city']) && $sData['city'] === $city) {
                        // Matches the single main city
                        // Values already set
                        $locationLabel .= " ($city)";
                    }
                }
            }
        }

        if (!empty($data['summer_temp']))
            $summerT = (float) $data['summer_temp'];
        if (!empty($data['winter_temp']))
            $winterT = (float) $data['winter_temp'];

        if (!empty($data['summer_temp']))
            $summerT = (float) $data['summer_temp'];
        if (!empty($data['winter_temp']))
            $winterT = (float) $data['winter_temp'];

        $dT_cool = $summerT - 75;
        $dT_heat = 70 - $winterT;

        // --- ENVELOPE ---
        $perimeter = sqrt($area) * 4;
        $wallArea = $perimeter * $height;

        $u_wall = self::INSULATION['walls'][$data['insulation_wall'] ?? 'average'] ?? 0.076;
        $u_ceiling = self::INSULATION['ceiling'][$data['insulation_ceiling'] ?? 'average'] ?? 0.033;

        $winType = $data['window_type'] ?? 'double';
        $u_window = self::WINDOWS[$winType]['u'] ?? 0.5;
        $shgc = self::WINDOWS[$winType]['shgc'] ?? 0.6;

        // Window Area Input: Total OR Directional
        $win_n = (float) ($data['win_n'] ?? 0);
        $win_e = (float) ($data['win_e'] ?? 0);
        $win_s = (float) ($data['win_s'] ?? 0);
        $win_w = (float) ($data['win_w'] ?? 0);

        if ($win_n + $win_e + $win_s + $win_w > 0) {
            // Use directional inputs
            $winArea = $win_n + $win_e + $win_s + $win_w;
        } else {
            // Use total or default
            $winArea = !empty($data['window_area']) ? (float) $data['window_area'] : ($area * 0.15);
            // Distribute evenly for calc if not specified
            $win_n = $win_e = $win_s = $win_w = $winArea / 4;
        }

        $netWallArea = max(0, $wallArea - $winArea);

        // --- LOADS (BTU/h) ---

        // 1. Transmission
        $q_wall_cool = $netWallArea * $u_wall * $dT_cool;
        $q_wall_heat = $netWallArea * $u_wall * $dT_heat;

        $q_ceil_cool = $area * $u_ceiling * ($dT_cool + 10);
        $q_ceil_heat = $area * $u_ceiling * $dT_heat;

        $q_win_cond_cool = $winArea * $u_window * $dT_cool;
        $q_win_cond_heat = $winArea * $u_window * $dT_heat;

        // 2. Solar Gain (Directional)
        // Factors (Simplified Manual J avg roughly): N=35, E/W=70, S=50 (high sun angle)
        // With shading credit if selected
        $shadeFactor = !empty($data['shading']) ? 0.6 : 1.0;

        $solar_n = $win_n * $shgc * 30 * $shadeFactor;
        $solar_e = $win_e * $shgc * 75 * $shadeFactor;
        $solar_s = $win_s * $shgc * 55 * $shadeFactor;
        $solar_w = $win_w * $shgc * 75 * $shadeFactor; // West is killer

        $solar_cool = $solar_n + $solar_e + $solar_s + $solar_w;
        $solar_heat = 0;

        // 3. Infiltration & Ducts
        $volume = $area * $height;
        $ach = match ($data['air_tightness'] ?? 'average') {
            'tight' => 0.35,
            'average' => 0.5,
            'leaky' => 0.85,
            default => 0.5
        };
        $cfm = ($volume * $ach) / 60;

        $q_inf_cool = 1.1 * $cfm * $dT_cool;
        $q_inf_heat = 1.1 * $cfm * $dT_heat;

        // Duct Losses (Simple multiplier)
        $ductFactor = match ($data['duct_location'] ?? 'conditions') {
            'attic' => 0.15, // 15% loss
            'crawl' => 0.10,
            default => 0.0
        };

        // 4. Internal Gains
        $occupants = (int) ($data['occupants'] ?? 3);
        $q_people = $occupants * 230;
        $q_appliances = 1200;

        // TOTALS
        $sensibleCooling = $q_wall_cool + $q_ceil_cool + $q_win_cond_cool + $solar_cool + $q_inf_cool + $q_people + $q_appliances;

        // Add Duct Loss
        $sensibleCooling *= (1 + $ductFactor);

        // Latent Load (Humidity)
        // Rule of thumb: 30% of sensible for humid, 10% for dry
        $latentFactor = ($state === 'FL' || $state === 'TX') ? 0.3 : 0.15;
        $totalCooling = $sensibleCooling * (1 + $latentFactor);

        $totalHeating = $q_wall_heat + $q_ceil_heat + $q_win_cond_heat + $q_inf_heat;
        $totalHeating *= (1 + $ductFactor);

        // Safety Margin
        $totalCooling *= 1.1;
        $totalHeating *= 1.1;

        // GENERATE SMART TIPS
        $tips = self::generateTips($data, $ductFactor, $solar_cool, $sensibleCooling);

        return [
            'cooling' => round($totalCooling),
            'heating' => round($totalHeating),
            'tonnage' => round($totalCooling / 12000, 1),
            'details' => [
                'area' => $area,
                'location' => $locationLabel,
                'summer_temp' => $summerT,
                'solar_gain' => round($solar_cool),
                'duct_loss_pct' => $ductFactor * 100
            ],
            'tips' => $tips
        ];
    }

    private static function generateTips(array $data, float $ductLoss, float $solarLoad, float $totalSensible): array
    {
        $tips = [];

        // 1. Check Insulation
        $wallIns = $data['insulation_wall'] ?? 'average';
        $ceilIns = $data['insulation_ceiling'] ?? 'average';

        if ($wallIns === 'poor' || $ceilIns === 'poor') {
            $tips[] = [
                'type' => 'efficiency',
                'title' => 'Upgrade Insulation',
                'desc' => 'Your insulation rating is low. Upgrading to R-13+ in walls or R-30+ in attics can reduce loads by 15-20% and lower utility bills immediately.',
                'impact' => 'High'
            ];
        }

        // 2. Check Windows
        $winType = $data['window_type'] ?? 'double';
        if ($winType === 'single') {
            $tips[] = [
                'type' => 'upgrade',
                'title' => 'Replace Single Pane Windows',
                'desc' => 'Single-pane windows are a major source of heat gain/loss. Installing Double-pane Low-E windows can cut your Cooling Load significantly.',
                'impact' => 'Critical'
            ];
        }

        // 3. Solar Gain Check (> 20% of sensible load)
        if ($totalSensible > 0 && ($solarLoad / $totalSensible) > 0.20) {
            $tips[] = [
                'type' => 'solar',
                'title' => 'High Solar Heat Gain',
                'desc' => 'Solar heat is contributing over 20% of your cooling load. Consider exterior shading, planting trees, or solar screens on South/West windows.',
                'impact' => 'Medium'
            ];
        }

        // 4. Ductwork
        if ($ductLoss > 0) {
            $tips[] = [
                'type' => 'maintenance',
                'title' => 'Ducts in Unconditioned Space',
                'desc' => 'Ducts in the attic or crawlspace gain heat. Ensure they are well-sealed (mastic) and insulated to R-8 to prevent capacity loss.',
                'impact' => 'High'
            ];
        }

        // 5. Air Tightness
        $tightness = $data['air_tightness'] ?? 'average';
        if ($tightness === 'leaky') {
            $tips[] = [
                'type' => 'sealing',
                'title' => 'Seal Air Leaks',
                'desc' => 'Your home is rated as "leaky". Weatherstripping doors and caulking windows is a cheap DIY way to reduce infiltration load.',
                'impact' => 'Medium'
            ];
        }

        // 6. A2L Refrigerant Warning (2026 Shift) & Charge Limit
        // ASHRAE 15 simplified: Max charge ~ 3.9 lbs/1000 ft3 for R-454B (approx)
        // If system is large for the volume, flag it.
        if ($totalSensible > 0) {
            $volume = ($data['area'] ?? 2000) * ($data['ceiling_height'] ?? 8);
            $estCharge = ($totalSensible / 12000) * 2.5; // Roughly 2.5 lbs per ton
            $maxCharge = ($volume / 1000) * 3.8; // ~3.8-4.0 lbs per 1000ft3 for A2L

            $a2lDesc = 'New low-GWP refrigerants (R-454B/R-32) are highly sensitive to short-cycling. ';
            if ($estCharge > $maxCharge) {
                $a2lDesc .= "WARNING: Estimated refrigerant charge ({$estCharge} lbs) may exceed ASHRAE 15 limits for this volume ({$maxCharge} lbs). Verify smallest room volume.";
            } else {
                $a2lDesc .= "System appears within Safe Charge Limits ($estCharge lbs < $maxCharge lbs max), but verify per ASHRAE 15.";
            }

            $tips[] = [
                'type' => 'compliance',
                'title' => '2026 A2L Refrigerant Safety',
                'desc' => $a2lDesc,
                'impact' => 'Critical'
            ];
        }

        // 7. SEER2 Standard (Regional Logic)
        $region = 'North';
        if ($data['state'] && class_exists('Logic\ClimateData')) {
            $region = \Logic\ClimateData::getRegion($data['state']);
        }

        // Capacity Logic for 2026 Split (<45k vs >=45k)
        $capacityBtu = round($totalSensible * 1.15); // Rough tonnage estimate
        $isLargeSystem = $capacityBtu >= 45000;

        $seerWarning = '';
        if ($region === 'North') {
            $seerWarning = $isLargeSystem
                ? 'Region: NORTH. System ≥ 45k BTU req. 14.3 SEER2.'
                : 'Region: NORTH. System < 45k BTU req. 13.4 SEER2.';
        } elseif ($region === 'Southeast') {
            $seerWarning = 'Region: SOUTHEAST. Requires 14.3 SEER2 min.';
        } else { // Southwest
            $eer = $isLargeSystem ? '10.2 EER2' : '11.7 EER2';
            $seerWarning = "Region: SOUTHWEST. Requires 14.3 SEER2 & $eer Check.";
        }

        $tips[] = [
            'type' => 'efficiency',
            'title' => '2026 SEER2 Compliance',
            'desc' => "Mandatory: $seerWarning Ensure equipment meets these DOE M1 testing standards.",
            'impact' => 'High'
        ];

        return $tips;
    }
}
