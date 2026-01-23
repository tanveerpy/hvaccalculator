const fs = require('fs');

// Mock window environment
const window = {};
global.window = window;

// Load the HVAC Core Logic
const coreCode = fs.readFileSync('./public/assets/js/hvac-core.js', 'utf8');
eval(coreCode);

// Test Helper
function runTest(name, input, expectWarning) {
    console.log(`\n--- Test: ${name} ---`);
    console.log(`Input: Area=${input.area}, Height=${input.ceiling_height}, State=${input.state}`);

    try {
        const result = window.Calculator.calculate(input);
        const tips = result.tips;
        const a2lWarning = tips.find(t => t.title.includes('A2L Refrigerant'));

        console.log(`Result: ${result.tonnage} Tons`);
        if (a2lWarning) {
            console.log(`[WARNING FOUND] ${a2lWarning.desc}`);
            if (expectWarning) console.log("✅ PASS: Warning triggered as expected.");
            else console.log("❌ FAIL: Warning triggered unexpectedly!");
        } else {
            console.log("[NO WARNING]");
            if (!expectWarning) console.log("✅ PASS: No warning as expected.");
            else console.log("❌ FAIL: Expected warning but got none!");
        }
    } catch (e) {
        console.error("ERROR:", e.message);
    }
}

// Case 1: Normal House (Should be SAFE)
runTest('Normal House', {
    state: 'FL',
    area: 2000,
    ceiling_height: 9,
    insulation_wall: 'average',
    insulation_ceiling: 'average',
    window_type: 'double'
}, false);

// Case 2: Tiny Room / High Load (Should be UNSAFE)
// 150 sq ft matches a small bedroom.
// We force high load by picking a hot state and poor insulation to drive up tonnage relative to volume.
runTest('Tiny Hot Room', {
    state: 'AZ',
    area: 150,
    ceiling_height: 8, // Vol = 1200. Max Charge = 4.8 lbs (~1.2 Tons)
    insulation_wall: 'poor',
    insulation_ceiling: 'poor',
    window_type: 'single'
}, true);
