<article class="bg-white min-h-screen">
    <header class="bg-slate-900 text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-pattern-dark opacity-10"></div>
        <div class="container mx-auto px-4 max-w-4xl relative z-10 text-center">
            <span class="text-blue-400 font-bold tracking-wider uppercase text-sm mb-4 block">Advanced Tech</span>
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight">Air Leakage, ACH, and HVAC Load: What
                Manual J Accounts For</h1>
            <p class="text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed">What Manual J accounts for regarding
                infiltration. Why a tight house needs a smaller unit.</p>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12 max-w-3xl">
        <nav class="flex items-center text-sm text-slate-500 mb-12">
            <a href="/" class="hover:text-blue-600 transition-colors">Home</a>
            <span class="mx-3">/</span>
            <a href="/blog" class="hover:text-blue-600 transition-colors">Blog</a>
            <span class="mx-3">/</span>
            <span class="text-slate-900 font-medium">Air Leakage</span>
        </nav>

        <!-- Key Takeaways -->
        <div class="bg-blue-50 border-l-4 border-blue-600 p-8 rounded-lg mb-12">
            <h2 class="text-xl font-bold text-blue-900 mb-4 font-sans mt-0">Key Takeaways</h2>
            <ul class="space-y-3">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="text-blue-800">Infiltration is the "unseen load" often ignored by basic
                        estimates.</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="text-blue-800">Modern homes (Tight) need dramatically less heating output than older
                        (Leaky) homes.</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span class="text-blue-800">Sealing your home ("Envelope Improvements") should happen BEFORE you buy
                        a new HVAC.</span>
                </li>
            </ul>
        </div>

        <!-- Table of Contents -->
        <div class="mb-12 p-6 bg-slate-50 rounded-lg border border-slate-200">
            <h3 class="font-bold text-slate-900 mb-4 text-lg">Table of Contents</h3>
            <ul class="space-y-2 text-sm text-slate-600">
                <li><a href="#basics" class="hover:text-blue-600 hover:underline">1. Infiltration Basics</a></li>
                <li><a href="#blower-door" class="hover:text-blue-600 hover:underline">2. The Blower Door Test</a></li>
                <li><a href="#ach" class="hover:text-blue-600 hover:underline">3. Understanding ACH50</a></li>
                <li><a href="#impact" class="hover:text-blue-600 hover:underline">4. Impact on Sizing</a></li>
            </ul>
        </div>

        <div
            class="prose prose-lg prose-slate max-w-none prose-headings:font-bold prose-headings:text-slate-900 prose-a:text-blue-600 hover:prose-a:text-blue-700">
            <p class="lead text-xl text-slate-700 font-medium">
                Infiltration (air leakage) is the uncontrolled entry of outside air into your home. It brings heat and
                humidity in summer, and cold dry air in winter.
            </p>

            <h2 id="basics">1. Infiltration Basics</h2>
            <p>
                Imagine trying to heat a house with a window open. That is what air leakage is, just spread across
                thousands of tiny cracks in your outlets, baseboards, and attic penetrations.
            </p>
            <p>
                Manual J accounts for this using a multiplier based on the "Tightness" of the construction.
            </p>

            <h2 id="blower-door">2. The Blower Door Test</h2>
            <p>
                How do you know if your home is leaky? Professional energy auditors specific test called a
                <strong>Blower Door Test</strong>.
            </p>
            <ol>
                <li>They mount a powerful fan in your front door.</li>
                <li>They depressurize the house to -50 Pascals (simulating a 20mph wind on all sides).</li>
                <li>They measure exactly how much air is being pulled through the cracks.</li>
            </ol>

            <h2 id="ach">3. Understanding ACH50</h2>
            <p>
                The result of the test is given in <strong>ACH50</strong> (Air Changes per Hour at 50 Pascals).
            </p>
            <table class="w-full text-left my-6 border-collapse not-prose border border-slate-200">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="p-2 border">Tightness Class</th>
                        <th class="p-2 border">ACH50 Range</th>
                        <th class="p-2 border">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-2 border"><strong>Leaky</strong></td>
                        <td class="p-2 border">10 - 20+</td>
                        <td class="p-2 border">Old homes. Drafty. Can feel wind inside.</td>
                    </tr>
                    <tr>
                        <td class="p-2 border"><strong>Average</strong></td>
                        <td class="p-2 border">5 - 7</td>
                        <td class="p-2 border">Standard code-built homes (2000-2015).</td>
                    </tr>
                    <tr>
                        <td class="p-2 border"><strong>Tight</strong></td>
                        <td class="p-2 border">1 - 3</td>
                        <td class="p-2 border">Modern high-performance homes.</td>
                    </tr>
                    <tr>
                        <td class="p-2 border"><strong>Passive House</strong></td>
                        <td class="p-2 border">
                            < 0.6</td>
                        <td class="p-2 border">Requires mechanical ventilation (ERV) to breathe.</td>
                    </tr>
                </tbody>
            </table>

            <h2 id="impact">4. Impact on Sizing</h2>
            <p>
                For a leaky house, infiltration can account for <strong>30-40% of the total heating load</strong>.
            </p>
            <p>
                However, for a modern tight house, infiltration is negligible. If you size a system based on "Rule of
                Thumb" for a tight house, you will be massively oversized because the "thumb" assumes a leaky barn.
            </p>

            <div class="bg-blue-50 border-l-4 border-blue-600 p-6 my-8 not-prose rounded-r-xl">
                <h3 class="text-lg font-bold text-blue-900 mb-2">Check your tightness setting</h3>
                <p class="text-blue-800 mb-4">Our calculator allows you to set "Leaky", "Average", or "Tight" to see how
                    it changes the BTU requirements.</p>
                <a href="/calculator"
                    class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition-colors">
                    Run Calculation &rarr;
                </a>
            </div>

            <div class="bg-slate-100 p-6 rounded-lg text-sm text-slate-600 border border-slate-200">
                <strong>Pro Tip:</strong> If your home is very leaky, spend money on "Air Sealing" (caulk and foam)
                before buying a new HVAC unit. It pays for itself in months.
            </div>

        </div>
    </div>
</article>