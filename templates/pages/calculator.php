<?php
// State Management
$step = isset($_POST['step']) ? (int) $_POST['step'] : 1;
$inputs = $_POST;
$mode = $inputs['mode'] ?? 'simple';

// Back/Next Logic
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'back')
        $step = max(1, $step - 1);
    if ($_POST['action'] === 'next')
        $step++;
}
if ($step === 3 && $mode === 'simple')
    $step = 4;
?>

<!-- Clean Professional Wrapper -->
<div class="min-h-[80vh] py-12 px-4 sm:px-6 lg:px-8 font-sans bg-slate-50">

    <!-- Results Dashboard -->
    <?php if ($step === 4 && isset($results)): ?>
        <div id="results-print-area" class="max-w-5xl mx-auto animate-fadeInUp">

            <!-- Professional Branding (Print Only) -->
            <div class="hidden print-mode mb-8 border-b border-slate-200 pb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">HVAC Load Calculation Report</h1>
                        <p class="text-slate-500 text-sm">Generated on <?= date('F j, Y') ?></p>
                    </div>
                    <div class="text-right">
                        <div class="bg-slate-100 rounded h-12 w-48 flex items-center justify-center text-slate-400 text-xs font-bold border border-slate-200 dashed">
                            [Company Logo Placeholder]
                        </div>
                        <p class="text-xs text-slate-400 mt-1">License #: _________________</p>
                    </div>
                </div>
            </div>

            <!-- Success Header (Screen Only) -->
            <div class="text-center mb-10 no-print">
                <div
                    class="inline-flex items-center justify-center p-3 rounded-full bg-green-100 text-green-700 mb-4 shadow-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900 mb-2">Calculation Complete</h2>
                <p class="text-lg text-slate-600">Here are the estimated load requirements for your home in
                    <strong><?= htmlspecialchars($results['details']['location']) ?></strong>.</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8 items-start">

                <!-- Main Results Card -->
                <div
                    class="lg:col-span-2 bg-white rounded-2xl shadow-xl shadow-slate-200/60 overflow-hidden border border-slate-100">
                    <div class="p-8 md:p-10">
                        <div class="grid md:grid-cols-2 gap-8 md:gap-12">
                            <!-- Cooling Load -->
                            <div class="text-center md:text-left relative">
                                <span
                                    class="inline-block px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-bold uppercase tracking-wider mb-2">Cooling
                                    Needed</span>
                                <div class="flex items-baseline justify-center md:justify-start gap-2 mb-2">
                                    <span
                                        class="text-5xl font-extrabold text-slate-900 tracking-tight"><?= number_format($results['cooling']) ?></span>
                                    <span class="text-slate-500 font-medium">BTU/hr</span>
                                </div>
                                <div class="text-lg font-bold text-blue-600"><?= $results['tonnage'] ?> Tons</div>
                                <p class="text-sm text-slate-400 mt-2">Capacity required to keep your home cool in summer.
                                </p>
                            </div>

                            <!-- Divider for mobile -->
                            <div class="block md:hidden h-px bg-slate-100 w-full"></div>

                            <!-- Heating Load -->
                            <div class="text-center md:text-left relative">
                                <span
                                    class="inline-block px-3 py-1 bg-red-50 text-red-700 rounded-full text-xs font-bold uppercase tracking-wider mb-2">Heating
                                    Needed</span>
                                <div class="flex items-baseline justify-center md:justify-start gap-2 mb-2">
                                    <span
                                        class="text-5xl font-extrabold text-slate-900 tracking-tight"><?= number_format($results['heating']) ?></span>
                                    <span class="text-slate-500 font-medium">BTU/hr</span>
                                </div>
                                <div class="text-lg font-bold text-red-600">
                                    <?= number_format($results['heating'] / 1000, 1) ?> kBTU</div>
                                <p class="text-sm text-slate-400 mt-2">Capacity required to keep your home warm in winter.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Bar -->
                    <div
                        class="bg-slate-50 border-t border-slate-100 px-8 py-6 flex flex-col sm:flex-row gap-4 justify-between items-center">
                        <div class="text-sm text-slate-500 font-medium">
                            <span class="block">Calculated per Manual J standards.</span>
                        </div>
                        <div class="flex gap-4 no-print">
                            <button onclick="downloadPDF(this)"
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-slate-900 text-white font-bold rounded-lg hover:bg-slate-800 transition-colors shadow-lg shadow-slate-900/10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span>Download Report</span>
                            </button>
                            <a href="/calculator"
                                class="inline-flex items-center gap-2 px-6 py-2.5 bg-white text-slate-700 font-bold border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                                Start Over
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Insights Sidebar -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Key Factors
                        </h3>

                        <!-- Solar -->
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1.5">
                                <span class="text-slate-600">Solar Heat Gain</span>
                                <span
                                    class="font-bold text-slate-900"><?= number_format($results['details']['solar_gain']) ?>
                                    BTU</span>
                            </div>
                            <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                                <?php $solarPct = min(100, ($results['details']['solar_gain'] / $results['cooling']) * 100); ?>
                                <div class="h-full bg-yellow-400 rounded-full" style="width: <?= $solarPct ?>%"></div>
                            </div>
                        </div>

                        <!-- Duct Loss -->
                        <?php if ($results['details']['duct_loss_pct'] > 0): ?>
                            <div>
                                <div class="flex justify-between text-sm mb-1.5">
                                    <span class="text-slate-600">Duct Efficiency Loss</span>
                                    <span class="font-bold text-red-600">+<?= $results['details']['duct_loss_pct'] ?>%</span>
                                </div>
                                <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-red-400 rounded-full"
                                        style="width: <?= $results['details']['duct_loss_pct'] ?>%"></div>
                                </div>
                                <p class="text-xs text-slate-400 mt-2">Ducts in unconditioned spaces increase load
                                    significantly.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Quick Tips -->
                    <?php if (!empty($results['tips'])): ?>
                        <div class="space-y-4">
                            <?php foreach ($results['tips'] as $tip): ?>
                                <div class="bg-blue-50 rounded-2xl border border-blue-100 p-6">
                                    <h3 class="font-bold text-blue-900 mb-3 text-sm uppercase tracking-wide"><?= $tip['type'] === 'compliance' ? 'Compliance Warning' : 'Recommendation' ?></h3>
                                    <p class="text-blue-800 font-bold mb-1"><?= $tip['title'] ?></p>
                                    <p class="text-sm text-blue-600"><?= $tip['desc'] ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Regulatory Footer (Print Only) -->
            <div class="hidden print-mode mt-8 pt-6 border-t border-slate-200 text-xs text-slate-500">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <strong class="block text-slate-700 mb-1">2026 Regulatory Compliance Statement</strong>
                        <p>This calculation is performed in accordance with ASHRAE Fundamentals and ACCA Manual J interpretation. Equipment selection must comply with:</p>
                        <ul class="list-disc pl-4 mt-1 space-y-0.5">
                            <li><strong>DOE M1 (SEER2/EER2):</strong> 10 CFR 430.32(c)</li>
                            <li><strong>EPA AIM Act (A2L):</strong> Use of low-GWP refrigerants (R-454B/R-32) where applicable.</li>
                        </ul>
                    </div>
                    <div class="text-right">
                        <p><strong>Software Version:</strong> 2026.1 Professional Build</p>
                        <p class="mt-1">Technician Signature: ___________________________</p>
                        <p>Date: ___________________________</p>
                    </div>
                </div>
            </div>

            <!-- PDF Script -->
            <script src="/assets/js/html2pdf.bundle.min.js"></script>
            <script>
                function downloadPDF(btn) {
                    const originalText = btn.innerHTML;
                    btn.innerHTML = 'Generating...';
                    btn.disabled = true;

                    const element = document.getElementById('results-print-area');
                    const opt = {
                        margin: 0.3,
                        filename: 'Manual_J_Report.pdf',
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: { scale: 2, useCORS: true, letterRendering: true },
                        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
                        enableLinks: false // Disable links to prevent rendering issues
                    };
                    
                    element.classList.add('print-mode');
                    
                    html2pdf()
                        .from(element)
                        .set(opt)
                        .save()
                        .then(() => {
                            element.classList.remove('print-mode');
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                        })
                        .catch(err => {
                            console.error('PDF Generation Error:', err);
                            element.classList.remove('print-mode');
                            btn.innerHTML = 'Error';
                            alert('Failed to generate PDF. Please try again.');
                        });
                }
            </script>
            <style>
                .print-mode .no-print {
                    display: none !important;
                }
                .print-mode .hidden.print-mode {
                    display: block !important;
                }
                .print-mode .grid {
                    display: block; /* Stack grids for simple PDF flow or keep grid if html2pdf handles it */
                }
                /* Force grid layout in PDF if supported, else fallback to block */
                .print-mode .grid.lg\:grid-cols-3 {
                    display: grid;
                    grid-template-columns: 2fr 1fr;
                }
            </style>
        </div>

    <?php else: ?>

        <!-- Configurator Form -->
        <div class="w-full max-w-xl mx-auto">

            <!-- Simple Progress -->
            <div class="mb-8 text-center">
                <?php if (isset($resultError)): ?>
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 text-left rounded shadow-sm">
                        <p class="font-bold">Calculation Error</p>
                        <p><?= htmlspecialchars($resultError) ?></p>
                    </div>
                <?php endif; ?>

                <span
                    class="inline-block py-1 px-3 rounded-full bg-slate-100/80 text-slate-500 text-xs font-bold uppercase tracking-wider mb-3">
                    Step <?= $step ?> of <?= $mode === 'advanced' ? '3' : '2' ?>
                </span>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">
                    <?php
                    if ($step === 1)
                        echo 'Property Details';
                    elseif ($step === 2)
                        echo 'Insulation & Windows';
                    elseif ($step === 3)
                        echo 'Advanced Details';
                    ?>
                </h1>
                <p class="text-slate-500 mt-2">
                    <?php
                    if ($step === 1)
                        echo 'Basic information about the building structure.';
                    elseif ($step === 2)
                        echo 'Tell us about the thermal efficiency.';
                    elseif ($step === 3)
                        echo 'Orientation and air leakage details.';
                    ?>
                </p>
            </div>

            <form method="POST" action="/calculator"
                class="bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
                <!-- Data Preservation -->
                <?php foreach ($inputs as $key => $val):
                    if ($key !== 'step' && $key !== 'action' && $key !== 'csrf_token')
                        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($val) . '">';
                endforeach; ?>
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <div class="p-8 space-y-8">
                    <!-- STEP 1 -->
                    <?php if ($step === 1): ?>
                        <div class="animate-fadeIn space-y-6">
                            <!-- Mode Selection -->
                            <div class="bg-slate-50 p-1.5 rounded-xl flex relative">
                                <label
                                    class="flex-1 text-center cursor-pointer opacity-80 hover:opacity-100 transition-opacity">
                                    <input type="radio" name="mode" value="simple" class="peer sr-only"
                                        <?= (!isset($inputs['mode']) || $inputs['mode'] === 'simple') ? 'checked' : '' ?>>

                                    <span
                                        class="block py-2.5 px-4 rounded-lg text-sm font-bold text-slate-600 peer-checked:bg-white peer-checked:text-slate-900 peer-checked:shadow-sm transition-all">Simple
                                        Mode</span>
                                </label>
                                <label
                                    class="flex-1 text-center cursor-pointer opacity-80 hover:opacity-100 transition-opacity">
                                    <input type="radio" name="mode" value="advanced" class="peer sr-only"
                                        <?= (isset($inputs['mode']) && $inputs['mode'] === 'advanced') ? 'checked' : '' ?>>

                                    <span
                                        class="block py-2.5 px-4 rounded-lg text-sm font-bold text-slate-600 peer-checked:bg-white peer-checked:text-slate-900 peer-checked:shadow-sm transition-all">Advanced
                                        Mode</span>
                                </label>
                            </div>

                            <!-- Location -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">State *</label>
                                    <select name="state" id="state-select" required
                                        class="block w-full rounded-xl border-slate-200 py-3.5 px-4 text-slate-900 font-medium focus:border-blue-500 focus:ring-blue-500 bg-slate-50 hover:bg-white transition-colors cursor-pointer">
                                        <option value="">Select State</option>
                                        <?php foreach (['AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming'] as $code => $name): ?>
                                            <option value="<?= $code ?>" <?= (isset($inputs['state']) && $inputs['state'] === $code) ? 'selected' : '' ?>><?= $name ?></option>

                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id="city-wrapper" class="hidden">
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Nearest City <span
                                            class="text-slate-400 font-normal">(Optional)</span></label>
                                    <select name="city" id="city-select"
                                        class="block w-full rounded-xl border-slate-200 py-3.5 px-4 text-slate-900 font-medium focus:border-blue-500 focus:ring-blue-500 bg-slate-50 hover:bg-white transition-colors cursor-pointer">
                                        <option value="">State Average</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Dimensions -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Floor Area *</label>
                                    <div class="relative">
                                        <input type="number" name="area" required min="100" max="10000"
                                            value="<?= htmlspecialchars($inputs['area'] ?? '') ?>" placeholder="e.g. 2000"
                                            class="block w-full rounded-xl border-slate-200 py-3.5 px-4 pr-12 text-slate-900 font-bold focus:border-blue-500 focus:ring-blue-500 text-lg">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                            <span class="text-slate-400 font-bold text-xs">ft²</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Ceiling Height *</label>
                                    <div class="relative">
                                        <select name="ceiling_height" required
                                            class="block w-full rounded-xl border-slate-200 py-3.5 px-4 text-slate-900 font-bold focus:border-blue-500 focus:ring-blue-500 text-lg cursor-pointer bg-white">
                                            <option value="8" <?= (!isset($inputs['ceiling_height']) || $inputs['ceiling_height'] == 8) ? 'selected' : '' ?>>
                                                8 ft</option>
                                            <option value="9" <?= (isset($inputs['ceiling_height']) && $inputs['ceiling_height'] == 9) ? 'selected' : '' ?>>
                                                9 ft</option>
                                            <option value="10" <?= (isset($inputs['ceiling_height']) && $inputs['ceiling_height'] == 10) ? 'selected' : '' ?>>
                                                10 ft</option>
                                            <option value="12" <?= (isset($inputs['ceiling_height']) && $inputs['ceiling_height'] == 12) ? 'selected' : '' ?>>
                                                12 ft</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- JS Logic -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const CLIMATE_DATA = <?= json_encode(\Logic\ClimateData::DATA) ?>; const s = document.getElementById('state-select'), c = document.getElementById('city-select'), w = document.getElementById('city-wrapper');
                                    function u(d = null) {
                                        const v = s.value; c.innerHTML = '<option value="">State Average</option>'; if (v && CLIMATE_DATA[v]) {
                                            const dt = CLIMATE_DATA[v]; let h = false; if (dt.cities) { Object.keys(dt.cities).sort().forEach(cy => { const o = document.createElement('option'); o.value = cy; o.textContent = cy; if (d && d === cy) o.selected = true; c.appendChild(o); h = true; }) } else if (dt.city) { const o = document.createElement('option'); o.value = dt.city; o.textContent = dt.city; if (d && d === dt.city) o.selected = true; c.appendChild(o); h = true; }
                                            w.classList.toggle('hidden', !h);
                                        }
                                    }
                                    
                                    // Auto-Save Logic (2026.1 Feature)
                                    const inputs = document.querySelectorAll('input, select');
                                    function saveInputs() {
                                        const data = {};
                                        inputs.forEach(i => {
                                            if (i.name && i.name !== 'csrf_token' && i.type !== 'hidden') {
                                                if (i.type === 'radio' && !i.checked) return;
                                                data[i.name] = i.value;
                                            }
                                        });
                                        localStorage.setItem('hvac_calc_autosave', JSON.stringify(data));
                                    }
                                    
                                    function restoreInputs() {
                                        const saved = localStorage.getItem('hvac_calc_autosave');
                                        if (saved) {
                                            try {
                                                const data = JSON.parse(saved);
                                                // Only restore if this is a fresh load (inputs empty other than defaults)
                                                // For now, simpler approach: just restore to console log for debugging or specific fields if empty
                                                // Proper implementation:
                                                Object.keys(data).forEach(k => {
                                                    const el = document.querySelector(`[name="${k}"]`);
                                                    if (el) {
                                                        if (el.type === 'radio') {
                                                            const radio = document.querySelector(`[name="${k}"][value="${data[k]}"]`);
                                                            if (radio) radio.checked = true;
                                                        } else {
                                                            el.value = data[k];
                                                        }
                                                    }
                                                });
                                                u(data.city); // Update city dropdown
                                            } catch (e) {
                                                console.error('Auto-Restore Fail', e);
                                            }
                                        }
                                    }

                                    inputs.forEach(i => i.addEventListener('change', saveInputs));
                                    
                                    // Only restore on Step 1 initial load
                                    if (!document.querySelector('input[name="step"][value="2"]') && !document.querySelector('input[name="step"][value="3"]')) {
                                       restoreInputs(); 
                                       console.log('Auto-Restore: Attempted to restore inputs from storage.');
                                    }
                                    
                                    s.addEventListener('change', () => u()); 
                                    u('<?= htmlspecialchars($inputs['city'] ?? '') ?>');

                                });
                            </script>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Square Footage</label>
                                    <div class="relative">
                                        <input type="number" name="area"
                                            value="<?= htmlspecialchars($inputs['area'] ?? '2000') ?>"
                                            class="block w-full rounded-xl border-slate-200 py-3.5 px-4 pr-12 text-slate-900 font-bold focus:border-blue-500 focus:ring-blue-500 text-lg">

                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-medium">sq
                                            ft</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Ceiling Height</label>
                                    <div class="relative">
                                        <select name="ceiling_height"
                                            class="block w-full rounded-xl border-slate-200 py-3.5 px-4 text-slate-900 font-bold focus:border-blue-500 focus:ring-blue-500 text-lg">
                                            <?php for ($h = 7; $h <= 12; $h++): ?>
                                                <option value="<?= $h ?>" <?= (isset($inputs['ceiling_height']) && $inputs['ceiling_height'] == $h) ? 'selected' : ($h == 8 ? 'selected' : '') ?>><?= $h ?>
                                                    ft</option>
                                            <?php endfor; ?>
                                            <option value="14" <?= (isset($inputs['ceiling_height']) && $inputs['ceiling_height'] == 14) ? 'selected' : '' ?>>14 ft</option>
                                            <option value="16" <?= (isset($inputs['ceiling_height']) && $inputs['ceiling_height'] == 16) ? 'selected' : '' ?>>16 ft</option>
                                            <option value="20" <?= (isset($inputs['ceiling_height']) && $inputs['ceiling_height'] == 20) ? 'selected' : '' ?>>20+ ft</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- STEP 2 -->
                    <?php if ($step === 2): ?>
                        <div class="animate-fadeIn space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Wall Insulation Quality</label>
                                <div class="grid sm:grid-cols-3 gap-3">
                                    <!-- Poor -->
                                    <label class="cursor-pointer relative group">
                                        <input type="radio" name="insulation_wall" value="poor" class="peer sr-only"
                                            <?= (isset($inputs['insulation_wall']) && $inputs['insulation_wall'] === 'poor') ? 'checked' : '' ?>>
                                        <div
                                            class="p-4 rounded-xl border-2 border-slate-100 bg-slate-50 peer-checked:border-blue-500 peer-checked:bg-blue-50/50 hover:bg-white transition-all text-center h-full">
                                            <div class="font-bold text-slate-900 mb-1">Poor</div>
                                            <div class="text-xs text-slate-500">Little/No Insulation<br>(Older Homes)</div>
                                        </div>
                                    </label>
                                    <!-- Average -->
                                    <label class="cursor-pointer relative group">
                                        <input type="radio" name="insulation_wall" value="average" class="peer sr-only"
                                            <?= (!isset($inputs['insulation_wall']) || $inputs['insulation_wall'] === 'average') ? 'checked' : '' ?>>
                                        <div
                                            class="p-4 rounded-xl border-2 border-slate-100 bg-slate-50 peer-checked:border-blue-500 peer-checked:bg-blue-50/50 hover:bg-white transition-all text-center h-full">
                                            <div class="font-bold text-slate-900 mb-1">Average</div>
                                            <div class="text-xs text-slate-500">Standard Insulation<br>(Typical)</div>
                                        </div>
                                    </label>
                                    <!-- Good -->
                                    <label class="cursor-pointer relative group">
                                        <input type="radio" name="insulation_wall" value="good" class="peer sr-only"
                                            <?= (isset($inputs['insulation_wall']) && $inputs['insulation_wall'] === 'good') ? 'checked' : '' ?>>
                                        <div
                                            class="p-4 rounded-xl border-2 border-slate-100 bg-slate-50 peer-checked:border-blue-500 peer-checked:bg-blue-50/50 hover:bg-white transition-all text-center h-full">
                                            <div class="font-bold text-slate-900 mb-1">Good</div>
                                            <div class="text-xs text-slate-500">High Efficiency<br>(Modern)</div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Attic/Ceiling Insulation</label>
                                <div class="grid sm:grid-cols-3 gap-3">
                                    <!-- Poor -->
                                    <label class="cursor-pointer relative group">
                                        <input type="radio" name="insulation_ceiling" value="poor" class="peer sr-only"
                                            <?= (isset($inputs['insulation_ceiling']) && $inputs['insulation_ceiling'] === 'poor') ? 'checked' : '' ?>>
                                        <div
                                            class="p-4 rounded-xl border-2 border-slate-100 bg-slate-50 peer-checked:border-blue-500 peer-checked:bg-blue-50/50 hover:bg-white transition-all text-center h-full">
                                            <div class="font-bold text-slate-900 mb-1">Poor</div>
                                            <div class="text-xs text-slate-500">R-19 or Less</div>
                                        </div>
                                    </label>
                                    <!-- Average -->
                                    <label class="cursor-pointer relative group">
                                        <input type="radio" name="insulation_ceiling" value="average" class="peer sr-only"
                                            <?= (!isset($inputs['insulation_ceiling']) || $inputs['insulation_ceiling'] === 'average') ? 'checked' : '' ?>>
                                        <div
                                            class="p-4 rounded-xl border-2 border-slate-100 bg-slate-50 peer-checked:border-blue-500 peer-checked:bg-blue-50/50 hover:bg-white transition-all text-center h-full">
                                            <div class="font-bold text-slate-900 mb-1">Average</div>
                                            <div class="text-xs text-slate-500">R-30 (Standard)</div>
                                        </div>
                                    </label>
                                    <!-- Good -->
                                    <label class="cursor-pointer relative group">
                                        <input type="radio" name="insulation_ceiling" value="good" class="peer sr-only"
                                            <?= (isset($inputs['insulation_ceiling']) && $inputs['insulation_ceiling'] === 'good') ? 'checked' : '' ?>>
                                        <div
                                            class="p-4 rounded-xl border-2 border-slate-100 bg-slate-50 peer-checked:border-blue-500 peer-checked:bg-blue-50/50 hover:bg-white transition-all text-center h-full">
                                            <div class="font-bold text-slate-900 mb-1">Good</div>
                                            <div class="text-xs text-slate-500">R-50+ (High)</div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Window Type</label>
                                <select name="window_type"
                                    class="block w-full rounded-xl border-slate-200 py-3.5 px-4 text-slate-900 font-medium focus:border-blue-500 focus:ring-blue-500 bg-slate-50 hover:bg-white transition-colors cursor-pointer">
                                    <option value="single" <?= (isset($inputs['window_type']) && $inputs['window_type'] === 'single') ? 'selected' : '' ?>>Single Pane (Older Homes)
                                    </option>
                                    <option value="double" <?= (!isset($inputs['window_type']) || $inputs['window_type'] === 'double') ? 'selected' : '' ?>>Double Pane (Standard)</option>
                                    <option value="double-lowe" <?= (isset($inputs['window_type']) && $inputs['window_type'] === 'double-lowe') ? 'selected' : '' ?>>High Efficiency (Low-E)
                                    </option>
                                </select>
                            </div>

                            <?php if ($mode === 'simple'): ?>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Total Window Area (Sq Ft) <span
                                            class="text-slate-400 font-normal ml-1">(Optional)</span></label>
                                    <input type="number" name="window_area" placeholder="e.g. 300"
                                        value="<?= htmlspecialchars($inputs['window_area'] ?? '') ?>"
                                        class="block w-full rounded-xl border-slate-200 py-3.5 px-4 text-slate-900 font-medium focus:border-blue-500 focus:ring-blue-500">

                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- STEP 3 -->
                    <?php if ($step === 3): ?>
                        <div class="animate-fadeIn space-y-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-4">Window Area by Direction (Sq
                                    Ft)</label>
                                <p class="text-xs text-slate-500 mb-4 -mt-2">Estimate the total window area for each side of the
                                    house.</p>
                                <div class="grid grid-cols-2 gap-4">
                                    <?php foreach (['n' => 'North', 'e' => 'East', 's' => 'South', 'w' => 'West'] as $k => $label): ?>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1"><?= $label ?>
                                                Side</label>
                                            <input type="number" name="win_<?= $k ?>" placeholder="0"
                                                value="<?= htmlspecialchars($inputs['win_' . $k] ?? '') ?>"
                                                class="block w-full rounded-lg border-slate-200 py-2.5 px-4 text-slate-900 font-medium focus:border-blue-500 focus:ring-blue-500">

                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">How drafty is the house?</label>
                                <select name="air_tightness"
                                    class="block w-full rounded-xl border-slate-200 py-3.5 px-4 text-slate-900 font-medium focus:border-blue-500 focus:ring-blue-500 bg-slate-50 hover:bg-white transition-colors cursor-pointer">
                                    <option value="tight" <?= (isset($inputs['air_tightness']) && $inputs['air_tightness'] === 'tight') ? 'selected' : '' ?>>Not Drafty (New Home / Tight)
                                    </option>
                                    <option value="average" <?= (!isset($inputs['air_tightness']) || $inputs['air_tightness'] === 'average') ? 'selected' : '' ?>>Average for age</option>
                                    <option value="leaky" <?= (isset($inputs['air_tightness']) && $inputs['air_tightness'] === 'leaky') ? 'selected' : '' ?>>Very Drafty (Old Home / Leaky)
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Where are the ducts located?</label>
                                <select name="duct_location"
                                    class="block w-full rounded-xl border-slate-200 py-3.5 px-4 text-slate-900 font-medium focus:border-blue-500 focus:ring-blue-500 bg-slate-50 hover:bg-white transition-colors cursor-pointer">
                                    <option value="conditions" <?= (!isset($inputs['duct_location']) || $inputs['duct_location'] === 'conditions') ? 'selected' : '' ?>>Inside the house
                                        (Conditioned)</option>
                                    <option value="attic" <?= (isset($inputs['duct_location']) && $inputs['duct_location'] === 'attic') ? 'selected' : '' ?>>In the Attic (Hot in Summer)
                                    </option>
                                    <option value="crawl" <?= (isset($inputs['duct_location']) && $inputs['duct_location'] === 'crawl') ? 'selected' : '' ?>>Crawlspace / Basement</option>
                                </select>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Footer Controls -->
                <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
                    <?php if ($step > 1): ?>
                        <button type="submit" name="action" value="back"
                            class="text-slate-500 font-bold hover:text-slate-800 transition-colors">
                            &larr; Back
                        </button>
                    <?php else: ?>
                        <span class="text-xs text-slate-400 font-medium">Takes < 1 min</span>
                            <?php endif; ?>

                            <?php if ($step < ($mode === 'advanced' ? 3 : 2)): ?>
                                <button type="submit" name="action" value="next"
                                    class="px-8 py-3 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-colors shadow-lg shadow-slate-900/20">
                                    Continue &rarr;
                                </button>
                <input type="hidden" name="step" value="<?= $step ?>">
                            <?php else: ?>
                                <button type="submit" name="force_calc" value="true"
                                    class="px-8 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/20">
                                    Show Results
                                </button>
                                <input type="hidden" name="step" value="4">
                            <?php endif; ?>
                </div>
            </form>
            
            <script>
                document.querySelector('form').addEventListener('submit', function(e) {
                    const btn = e.submitter;
                    if (!btn) return;
                    
                    const originalText = btn.innerText;
                    btn.disabled = true;
                    btn.classList.add('opacity-75', 'cursor-not-allowed');
                    btn.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    `;

                    // Create a hidden input to simulate the button click for the backend
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = btn.name;
                    hiddenInput.value = btn.value;
                    this.appendChild(hiddenInput);
                });
            </script>
        </div>

    <?php endif; ?>
</div>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .animate-fadeIn {
        animation: fadeInUp 0.3s ease-out forwards;
    }

    /* Enhance select readability */
    select {
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 1rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
    }
</style>