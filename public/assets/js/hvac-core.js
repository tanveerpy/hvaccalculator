/**
 * HVAC Core Logic (Ported from PHP)
 * Contains Climate Data and Calculation Logic for Static Netlify Deployment
 */

const CLIMATE_DATA = {
    'AL': { 'state': 'Alabama', 'cities': { 'Birmingham': { 'summer': 93, 'winter': 24 }, 'Mobile': { 'summer': 91, 'winter': 32 }, 'Huntsville': { 'summer': 92, 'winter': 21 } }, 'summer': 93, 'winter': 24 },
    'AK': { 'state': 'Alaska', 'cities': { 'Anchorage': { 'summer': 71, 'winter': -13 }, 'Fairbanks': { 'summer': 77, 'winter': -35 }, 'Juneau': { 'summer': 70, 'winter': 6 } }, 'summer': 71, 'winter': -13 },
    'AZ': { 'state': 'Arizona', 'cities': { 'Phoenix': { 'summer': 108, 'winter': 38 }, 'Tucson': { 'summer': 104, 'winter': 35 }, 'Flagstaff': { 'summer': 84, 'winter': 5 } }, 'summer': 108, 'winter': 38 },
    'AR': { 'state': 'Arkansas', 'cities': { 'Little Rock': { 'summer': 95, 'winter': 22 }, 'Fayetteville': { 'summer': 92, 'winter': 17 }, 'Fort Smith': { 'summer': 96, 'winter': 21 } }, 'summer': 95, 'winter': 22 },
    'CA': { 'state': 'California', 'cities': { 'Los Angeles': { 'summer': 84, 'winter': 47 }, 'San Francisco': { 'summer': 74, 'winter': 42 }, 'Sacramento': { 'summer': 97, 'winter': 32 }, 'San Diego': { 'summer': 82, 'winter': 47 }, 'Fresno': { 'summer': 99, 'winter': 31 } }, 'summer': 85, 'winter': 45 },
    'CO': { 'state': 'Colorado', 'cities': { 'Denver': { 'summer': 92, 'winter': 6 }, 'Colorado Springs': { 'summer': 88, 'winter': 8 }, 'Grand Junction': { 'summer': 94, 'winter': 10 } }, 'summer': 90, 'winter': 6 },
    'CT': { 'state': 'Connecticut', 'cities': { 'Hartford': { 'summer': 89, 'winter': 6 }, 'New Haven': { 'summer': 86, 'winter': 10 }, 'Bridgeport': { 'summer': 87, 'winter': 13 } }, 'summer': 89, 'winter': 6 },
    'DE': { 'state': 'Delaware', 'cities': { 'Wilmington': { 'summer': 90, 'winter': 16 }, 'Dover': { 'summer': 90, 'winter': 18 }, 'Georgetown': { 'summer': 90, 'winter': 20 } }, 'summer': 90, 'winter': 16 },
    'FL': { 'state': 'Florida', 'cities': { 'Miami': { 'summer': 91, 'winter': 52 }, 'Orlando': { 'summer': 94, 'winter': 43 }, 'Jacksonville': { 'summer': 94, 'winter': 34 }, 'Tampa': { 'summer': 92, 'winter': 45 }, 'Tallahassee': { 'summer': 94, 'winter': 28 } }, 'summer': 92, 'winter': 45 },
    'GA': { 'state': 'Georgia', 'cities': { 'Atlanta': { 'summer': 91, 'winter': 25 }, 'Savannah': { 'summer': 93, 'winter': 31 }, 'Augusta': { 'summer': 96, 'winter': 27 } }, 'summer': 91, 'winter': 25 },
    'HI': { 'state': 'Hawaii', 'cities': { 'Honolulu': { 'summer': 89, 'winter': 64 }, 'Hilo': { 'summer': 84, 'winter': 63 }, 'Kahului': { 'summer': 89, 'winter': 60 } }, 'summer': 89, 'winter': 64 },
    'ID': { 'state': 'Idaho', 'cities': { 'Boise': { 'summer': 94, 'winter': 10 }, 'Idaho Falls': { 'summer': 89, 'winter': -6 }, 'Coeur d\'Alene': { 'summer': 89, 'winter': 6 } }, 'summer': 94, 'winter': 10 },
    'IL': { 'state': 'Illinois', 'cities': { 'Chicago': { 'summer': 88, 'winter': 2 }, 'Springfield': { 'summer': 91, 'winter': 4 }, 'Peoria': { 'summer': 90, 'winter': 1 } }, 'summer': 88, 'winter': 2 },
    'IN': { 'state': 'Indiana', 'cities': { 'Indianapolis': { 'summer': 89, 'winter': 4 }, 'Fort Wayne': { 'summer': 88, 'winter': 2 }, 'Evansville': { 'summer': 93, 'winter': 11 } }, 'summer': 89, 'winter': 4 },
    'IA': { 'state': 'Iowa', 'cities': { 'Des Moines': { 'summer': 90, 'winter': -3 }, 'Cedar Rapids': { 'summer': 89, 'winter': -5 }, 'Davenport': { 'summer': 90, 'winter': -1 } }, 'summer': 90, 'winter': -3 },
    'KS': { 'state': 'Kansas', 'cities': { 'Wichita': { 'summer': 98, 'winter': 8 }, 'Kansas City': { 'summer': 94, 'winter': 6 }, 'Topeka': { 'summer': 94, 'winter': 5 } }, 'summer': 98, 'winter': 8 },
    'KY': { 'state': 'Kentucky', 'cities': { 'Louisville': { 'summer': 91, 'winter': 11 }, 'Lexington': { 'summer': 89, 'winter': 10 }, 'Bowling Green': { 'summer': 92, 'winter': 14 } }, 'summer': 91, 'winter': 11 },
    'LA': { 'state': 'Louisiana', 'cities': { 'New Orleans': { 'summer': 93, 'winter': 33 }, 'Baton Rouge': { 'summer': 93, 'winter': 30 }, 'Shreveport': { 'summer': 97, 'winter': 26 } }, 'summer': 93, 'winter': 33 },
    'ME': { 'state': 'Maine', 'cities': { 'Portland': { 'summer': 83, 'winter': -2 }, 'Bangor': { 'summer': 83, 'winter': -8 }, 'Caribou': { 'summer': 80, 'winter': -16 } }, 'summer': 83, 'winter': -2 },
    'MD': { 'state': 'Maryland', 'cities': { 'Baltimore': { 'summer': 91, 'winter': 17 }, 'Frederick': { 'summer': 90, 'winter': 12 }, 'Salisbury': { 'summer': 91, 'winter': 19 } }, 'summer': 91, 'winter': 17 },
    'MA': { 'state': 'Massachusetts', 'cities': { 'Boston': { 'summer': 88, 'winter': 9 }, 'Worcester': { 'summer': 84, 'winter': 3 }, 'Springfield': { 'summer': 88, 'winter': 5 } }, 'summer': 88, 'winter': 9 },
    'MI': { 'state': 'Michigan', 'cities': { 'Detroit': { 'summer': 87, 'winter': 5 }, 'Grand Rapids': { 'summer': 86, 'winter': 5 }, 'Lansing': { 'summer': 86, 'winter': 2 } }, 'summer': 87, 'winter': 5 },
    'MN': { 'state': 'Minnesota', 'cities': { 'Minneapolis': { 'summer': 88, 'winter': -11 }, 'Duluth': { 'summer': 81, 'winter': -16 }, 'Rochester': { 'summer': 85, 'winter': -13 } }, 'summer': 88, 'winter': -11 },
    'MS': { 'state': 'Mississippi', 'cities': { 'Jackson': { 'summer': 94, 'winter': 26 }, 'Gulfport': { 'summer': 92, 'winter': 32 }, 'Tupelo': { 'summer': 93, 'winter': 22 } }, 'summer': 94, 'winter': 26 },
    'MO': { 'state': 'Missouri', 'cities': { 'Kansas City': { 'summer': 94, 'winter': 6 }, 'St. Louis': { 'summer': 93, 'winter': 9 }, 'Springfield': { 'summer': 92, 'winter': 10 } }, 'summer': 94, 'winter': 6 },
    'MT': { 'state': 'Montana', 'cities': { 'Billings': { 'summer': 90, 'winter': -10 }, 'Missoula': { 'summer': 89, 'winter': -3 }, 'Great Falls': { 'summer': 87, 'winter': -15 } }, 'summer': 90, 'winter': -10 },
    'NE': { 'state': 'Nebraska', 'cities': { 'Omaha': { 'summer': 92, 'winter': -2 }, 'Lincoln': { 'summer': 93, 'winter': -2 }, 'Grand Island': { 'summer': 92, 'winter': -3 } }, 'summer': 92, 'winter': -2 },
    'NV': { 'state': 'Nevada', 'cities': { 'Las Vegas': { 'summer': 106, 'winter': 33 }, 'Reno': { 'summer': 92, 'winter': 13 }, 'Elko': { 'summer': 91, 'winter': -2 } }, 'summer': 106, 'winter': 33 },
    'NH': { 'state': 'New Hampshire', 'cities': { 'Concord': { 'summer': 85, 'winter': -5 }, 'Manchester': { 'summer': 87, 'winter': -2 }, 'Portsmouth': { 'summer': 86, 'winter': 1 } }, 'summer': 85, 'winter': -5 },
    'NJ': { 'state': 'New Jersey', 'cities': { 'Newark': { 'summer': 90, 'winter': 15 }, 'Atlantic City': { 'summer': 87, 'winter': 16 }, 'Trenton': { 'summer': 89, 'winter': 14 } }, 'summer': 90, 'winter': 15 },
    'NM': { 'state': 'New Mexico', 'cities': { 'Albuquerque': { 'summer': 93, 'winter': 20 }, 'Las Cruces': { 'summer': 98, 'winter': 25 }, 'Santa Fe': { 'summer': 87, 'winter': 11 } }, 'summer': 93, 'winter': 20 },
    'NY': { 'state': 'New York', 'cities': { 'New York City': { 'summer': 89, 'winter': 17 }, 'Buffalo': { 'summer': 83, 'winter': 5 }, 'Albany': { 'summer': 86, 'winter': 2 }, 'Syracuse': { 'summer': 85, 'winter': 1 }, 'Rochester': { 'summer': 85, 'winter': 4 } }, 'summer': 86, 'winter': 10 },
    'NC': { 'state': 'North Carolina', 'cities': { 'Charlotte': { 'summer': 91, 'winter': 23 }, 'Raleigh': { 'summer': 91, 'winter': 20 }, 'Wilmington': { 'summer': 91, 'winter': 28 }, 'Greensboro': { 'summer': 90, 'winter': 19 } }, 'summer': 91, 'winter': 23 },
    'ND': { 'state': 'North Dakota', 'cities': { 'Fargo': { 'summer': 86, 'winter': -18 }, 'Bismarck': { 'summer': 88, 'winter': -18 }, 'Grand Forks': { 'summer': 84, 'winter': -21 } }, 'summer': 86, 'winter': -18 },
    'OH': { 'state': 'Ohio', 'cities': { 'Columbus': { 'summer': 89, 'winter': 7 }, 'Cleveland': { 'summer': 86, 'winter': 5 }, 'Cincinnati': { 'summer': 90, 'winter': 8 }, 'Toledo': { 'summer': 88, 'winter': 4 } }, 'summer': 89, 'winter': 7 },
    'OK': { 'state': 'Oklahoma', 'cities': { 'Oklahoma City': { 'summer': 96, 'winter': 16 }, 'Tulsa': { 'summer': 98, 'winter': 15 }, 'Lawton': { 'summer': 100, 'winter': 17 } }, 'summer': 96, 'winter': 16 },
    'OR': { 'state': 'Oregon', 'cities': { 'Portland': { 'summer': 86, 'winter': 25 }, 'Eugene': { 'summer': 87, 'winter': 24 }, 'Medford': { 'summer': 97, 'winter': 24 }, 'Bend': { 'summer': 88, 'winter': 10 } }, 'summer': 86, 'winter': 25 },
    'PA': { 'state': 'Pennsylvania', 'cities': { 'Philadelphia': { 'summer': 90, 'winter': 16 }, 'Pittsburgh': { 'summer': 86, 'winter': 8 }, 'Harrisburg': { 'summer': 89, 'winter': 12 }, 'Allentown': { 'summer': 88, 'winter': 9 } }, 'summer': 90, 'winter': 16 },
    'RI': { 'state': 'Rhode Island', 'cities': { 'Providence': { 'summer': 86, 'winter': 9 }, 'Newport': { 'summer': 84, 'winter': 12 }, 'Warwick': { 'summer': 86, 'winter': 9 } }, 'summer': 86, 'winter': 9 },
    'SC': { 'state': 'South Carolina', 'cities': { 'Columbia': { 'summer': 95, 'winter': 23 }, 'Charleston': { 'summer': 92, 'winter': 29 }, 'Greenville': { 'summer': 91, 'winter': 22 } }, 'summer': 95, 'winter': 23 },
    'SD': { 'state': 'South Dakota', 'cities': { 'Sioux Falls': { 'summer': 89, 'winter': -9 }, 'Rapid City': { 'summer': 91, 'winter': -4 }, 'Aberdeen': { 'summer': 88, 'winter': -14 } }, 'summer': 89, 'winter': -9 },
    'TN': { 'state': 'Tennessee', 'cities': { 'Nashville': { 'summer': 93, 'winter': 19 }, 'Memphis': { 'summer': 95, 'winter': 21 }, 'Knoxville': { 'summer': 90, 'winter': 20 }, 'Chattanooga': { 'summer': 92, 'winter': 21 } }, 'summer': 93, 'winter': 19 },
    'TX': { 'state': 'Texas', 'cities': { 'Dallas': { 'summer': 98, 'winter': 25 }, 'Houston': { 'summer': 94, 'winter': 34 }, 'Austin': { 'summer': 98, 'winter': 28 }, 'San Antonio': { 'summer': 97, 'winter': 30 }, 'El Paso': { 'summer': 99, 'winter': 28 }, 'Fort Worth': { 'summer': 99, 'winter': 24 } }, 'summer': 96, 'winter': 28 },
    'UT': { 'state': 'Utah', 'cities': { 'Salt Lake City': { 'summer': 95, 'winter': 16 }, 'St. George': { 'summer': 104, 'winter': 30 }, 'Provo': { 'summer': 94, 'winter': 11 } }, 'summer': 95, 'winter': 16 },
    'VT': { 'state': 'Vermont', 'cities': { 'Burlington': { 'summer': 84, 'winter': -7 }, 'Montpelier': { 'summer': 82, 'winter': -9 }, 'Rutland': { 'summer': 84, 'winter': -7 } }, 'summer': 84, 'winter': -7 },
    'VA': { 'state': 'Virginia', 'cities': { 'Richmond': { 'summer': 92, 'winter': 19 }, 'Virginia Beach': { 'summer': 90, 'winter': 23 }, 'Norfolk': { 'summer': 90, 'winter': 23 }, 'Roanoke': { 'summer': 89, 'winter': 16 } }, 'summer': 92, 'winter': 19 },
    'WA': { 'state': 'Washington', 'cities': { 'Seattle': { 'summer': 79, 'winter': 27 }, 'Spokane': { 'summer': 89, 'winter': 3 }, 'Tacoma': { 'summer': 80, 'winter': 26 }, 'Vancouver': { 'summer': 87, 'winter': 22 } }, 'summer': 79, 'winter': 27 },
    'WV': { 'state': 'West Virginia', 'cities': { 'Charleston': { 'summer': 89, 'winter': 14 }, 'Huntington': { 'summer': 89, 'winter': 15 }, 'Morgantown': { 'summer': 85, 'winter': 9 } }, 'summer': 89, 'winter': 14 },
    'WI': { 'state': 'Wisconsin', 'cities': { 'Milwaukee': { 'summer': 86, 'winter': -1 }, 'Madison': { 'summer': 86, 'winter': -5 }, 'Green Bay': { 'summer': 84, 'winter': -8 } }, 'summer': 86, 'winter': -1 },
    'WY': { 'state': 'Wyoming', 'cities': { 'Cheyenne': { 'summer': 86, 'winter': -3 }, 'Casper': { 'summer': 89, 'winter': -6 }, 'Laramie': { 'summer': 81, 'winter': -9 } }, 'summer': 86, 'winter': -3 }
};

const Calculator = {
    INSULATION: {
        walls: { poor: 0.25, average: 0.076, good: 0.045 },
        ceiling: { poor: 0.1, average: 0.033, good: 0.02 }
    },
    WINDOWS: {
        single: { u: 1.2, shgc: 0.8 },
        double: { u: 0.5, shgc: 0.6 },
        'double-lowe': { u: 0.35, shgc: 0.3 }
    },

    getRegion(state) {
        const north = ['AK', 'CO', 'CT', 'ID', 'IL', 'IN', 'IA', 'KS', 'ME', 'MA', 'MI', 'MN', 'MO', 'MT', 'NE', 'NH', 'NJ', 'NY', 'ND', 'OH', 'OR', 'PA', 'RI', 'SD', 'UT', 'VT', 'WA', 'WV', 'WI', 'WY'];
        const southwest = ['AZ', 'CA', 'NM', 'NV'];
        if (north.includes(state)) return 'North';
        if (southwest.includes(state)) return 'Southwest';
        return 'Southeast';
    },

    calculate(data) {
        // Validation
        if (!data.state) throw new Error("State selection is required.");
        if (!data.area || data.area <= 0) throw new Error("Valid floor area (sq ft) is required.");
        if (!data.ceiling_height || data.ceiling_height <= 0) throw new Error("Valid ceiling height is required.");

        const area = parseFloat(data.area);
        const height = parseFloat(data.ceiling_height);
        const state = data.state;
        const city = data.city || '';

        // Temps
        let summerT = 90;
        let winterT = 30;
        let locationLabel = state;

        if (CLIMATE_DATA[state]) {
            const sData = CLIMATE_DATA[state];
            locationLabel = sData.state;
            summerT = sData.summer;
            winterT = sData.winter;

            if (city && sData.cities && sData.cities[city]) {
                summerT = sData.cities[city].summer;
                winterT = sData.cities[city].winter;
                locationLabel += ` (${city})`;
            }
        }

        const dT_cool = summerT - 75;
        const dT_heat = 70 - winterT;

        // Envelope
        const perimeter = Math.sqrt(area) * 4;
        const wallArea = perimeter * height;
        const u_wall = this.INSULATION.walls[data.insulation_wall || 'average'];
        const u_ceiling = this.INSULATION.ceiling[data.insulation_ceiling || 'average'];
        const winType = data.window_type || 'double';
        const u_window = this.WINDOWS[winType].u;
        const shgc = this.WINDOWS[winType].shgc;

        const winArea = (area * 0.15); // Simple assumption as per PHP fallback logic (Total Area inputs handled there but simplified here for generic port)
        const netWallArea = Math.max(0, wallArea - winArea);

        // Loads
        const q_wall_cool = netWallArea * u_wall * dT_cool;
        const q_wall_heat = netWallArea * u_wall * dT_heat;
        const q_ceil_cool = area * u_ceiling * (dT_cool + 10);
        const q_ceil_heat = area * u_ceiling * dT_heat;
        const q_win_cond_cool = winArea * u_window * dT_cool;
        const q_win_cond_heat = winArea * u_window * dT_heat;

        // Solar (Simplified direction distribution)
        const solar_cool = winArea * shgc * 58; // Avg factor

        // Infiltration
        const volume = area * height;
        const ach = 0.5; // Average
        const cfm = (volume * ach) / 60;
        const q_inf_cool = 1.1 * cfm * dT_cool;
        const q_inf_heat = 1.1 * cfm * dT_heat;

        // Internal
        const q_people = 3 * 230;
        const q_appliances = 1200;

        // Totals
        let sensibleCooling = q_wall_cool + q_ceil_cool + q_win_cond_cool + solar_cool + q_inf_cool + q_people + q_appliances;
        let totalHeating = q_wall_heat + q_ceil_heat + q_win_cond_heat + q_inf_heat;

        // Safety
        sensibleCooling *= 1.1;
        totalHeating *= 1.1;

        // Latent
        const latentFactor = (state === 'FL' || state === 'TX') ? 0.3 : 0.15;
        const totalCooling = sensibleCooling * (1 + latentFactor);

        return {
            cooling: Math.round(totalCooling),
            heating: Math.round(totalHeating),
            tonnage: (totalCooling / 12000).toFixed(1),
            details: {
                area: area,
                location: locationLabel,
                summer_temp: summerT,
                region: this.getRegion(state)
            },
            tips: this.generateTips(data, solar_cool, sensibleCooling, totalCooling)
        };
    },

    generateTips(data, solarLoad, sensible, totalCooling) {
        const tips = [];
        const region = this.getRegion(data.state);
        const capacityBtu = totalCooling;
        const isLarge = capacityBtu >= 45000;

        // SEER2
        let seerMsg = '';
        if (region === 'North') {
            seerMsg = isLarge ? 'Region: NORTH. System ≥ 45k BTU req. 14.3 SEER2.' : 'Region: NORTH. System < 45k BTU req. 13.4 SEER2.';
        } else if (region === 'Southeast') {
            seerMsg = 'Region: SOUTHEAST. Requires 14.3 SEER2 min.';
        } else {
            const eer = isLarge ? '10.2 EER2' : '11.7 EER2';
            seerMsg = `Region: SOUTHWEST. Requires 14.3 SEER2 & ${eer} Check.`;
        }
        tips.push({ type: 'compliance', title: '2026 SEER2 Compliance', desc: `Mandatory: ${seerMsg}` });

        // A2L Refrigerant Safety (ASHRAE 15 & UL 60335-2-40)
        // 2026 Mandate: New units use mildly flammable refrigerants (e.g., R-454B).
        // Estimate Charge: ~4 lbs per Ton.
        // Safety Limit (Simplified 20% LFL): ~0.004 lbs/ft³.
        const roomVol = data.area * data.ceiling_height;
        const estimatedCharge = (totalCooling / 12000) * 4; // lbs
        const maxCharge = roomVol * 0.004;

        if (estimatedCharge > maxCharge) {
            tips.push({
                type: 'warning',
                title: 'A2L Refrigerant Safety Warning',
                desc: `New 2026 systems use flammable refrigerants. A ${(totalCooling / 12000).toFixed(1)} Ton unit (Est. ${estimatedCharge.toFixed(1)} lbs charge) may exceed safety limits for a ${roomVol.toLocaleString()} ft³ space. Ensure adequate ventilation or choose a smaller system.`
            });
        }

        return tips;
    }
};

window.Calculator = Calculator;
window.CLIMATE_DATA = CLIMATE_DATA;
