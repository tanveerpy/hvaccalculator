<article class="bg-white min-h-screen">
    <header class="bg-slate-900 text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-pattern-dark opacity-10"></div>
        <div class="container mx-auto px-4 max-w-4xl relative z-10 text-center">
            <span class="text-blue-400 font-bold tracking-wider uppercase text-sm mb-4 block">DIY Guide</span>
            <h1 class="text-4xl md:text-5xl font-extrabold mb-6 leading-tight">How to Calculate HVAC Load for a House
                (Step-by-Step)</h1>
            <p class="text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed">Stop guessing. Learn the 5 specific data
                points you need to accurately size your heating and cooling system.</p>
        </div>
    </header>

    <div class="container mx-auto px-4 py-12 max-w-3xl">
        <nav class="flex items-center text-sm text-slate-500 mb-12">
            <a href="/" class="hover:text-blue-600 transition-colors">Home</a>
            <span class="mx-3">/</span>
            <a href="/blog" class="hover:text-blue-600 transition-colors">Blog</a>
            <span class="mx-3">/</span>
            <span class="text-slate-900 font-medium">How to Calculate</span>
        </nav>

        <!-- Key Takeaways -->
        <div class="bg-blue-50 border-l-4 border-blue-600 p-8 rounded-lg mb-12">
            <h2 class="text-xl font-bold text-blue-900 mb-4 font-sans mt-0">Key Takeaways</h2>
            <ul class="space-y-3">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-blue-800">You need more than just square footage; insulation, windows, and climate
                        matter.</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-blue-800">Outdoor design temperature determines your peak load
                        requirements.</span>
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-blue-800">Accurate measurements of windows and walls are critical for a valid
                        calculation.</span>
                </li>
            </ul>
        </div>

        <!-- Table of Contents -->
        <div class="mb-12 p-6 bg-slate-50 rounded-lg border border-slate-200">
            <h3 class="font-bold text-slate-900 mb-4 text-lg">Table of Contents</h3>
            <ul class="space-y-2 text-sm text-slate-600">
                <li><a href="#inputs" class="hover:text-blue-600 hover:underline">1. The Core Inputs</a></li>
                <li><a href="#climate" class="hover:text-blue-600 hover:underline">2. Determine Design Temperatures</a>
                </li>
                <li><a href="#envelope" class="hover:text-blue-600 hover:underline">3. Measure Your Thermal Envelope</a>
                </li>
                <li><a href="#insulation" class="hover:text-blue-600 hover:underline">4. Assess Insulation & Windows</a>
                </li>
                <li><a href="#calculation" class="hover:text-blue-600 hover:underline">5. The Calculation Process</a>
                </li>
            </ul>
        </div>

        <div
            class="prose prose-lg prose-slate max-w-none prose-headings:font-bold prose-headings:text-slate-900 prose-a:text-blue-600 hover:prose-a:text-blue-700">
            <p class="lead text-xl text-slate-700 font-medium">
                Calculating HVAC load is about physics, not guesswork. It measures how fast heat enters your home in
                summer and leaves in winter.
            </p>

            <figure class="my-10">
                <img src="/assets/img/manual_j_process_diagram.png" alt="Manual J Calculation Process Inputs"
                    class="rounded-xl shadow-lg border border-slate-200 w-full">
                <figcaption class="text-center text-sm text-slate-500 mt-3">The key factors that influence your home's
                    heating and cooling load.</figcaption>
            </figure>

            <h2 id="inputs">1. The Core Inputs</h2>
            <p>
                To perform a calculation (Manual J), you are solving an equation that balances heat gain against heat
                loss. The primary variables are:
            </p>
            <ul>
                <li><strong>Delta T:</strong> The temperature difference between inside and outside.</li>
                <li><strong>Area (Sq Footage):</strong> The surface area of walls, ceilings, and floors exposed to the
                    outside.</li>
                <li><strong>U-Factor (Insulation):</strong> How easily heat moves through those surfaces.</li>
                <li><strong>Solar Gain:</strong> Heat energy from sunlight entering through glass.</li>
                <li><strong>Infiltration:</strong> Air leakage through cracks.</li>
            </ul>

            <h2 id="climate">2. Determine Design Temperatures</h2>
            <p>
                You don't design for the hottest day ever recorded, but for the statistical "1% design day" (for
                cooling) and "99% design day" (for heating).
            </p>
            <p>
                For example, in Phoenix, AZ, your cooling design temp might be 108°F. If you design for 120°F (the
                record high), your system will be oversized 99% of the year.
            </p>

            <h2 id="envelope">3. Measure Your Thermal Envelope</h2>
            <p>
                Walk around your home with a tape measure. You need the gross area of all exterior walls. Then, measure
                all windows and doors.
            </p>
            <div class="bg-gray-50 border-l-4 border-gray-400 p-4 my-6">
                <p class="font-bold text-sm uppercase text-gray-500 mb-1">Formula Tip</p>
                <p class="font-mono text-slate-800">Net Wall Area = Gross Wall Area - (Window Area + Door Area)</p>
            </div>
            <p>
                Why separates them? Because glass transfers heat 10x-20x faster than an insulated wall.
            </p>

            <h2 id="insulation">4. Assess Insulation & Windows</h2>
            <p>
                Check your attic. If you see pink fiberglass fluff up to the joists, you likely have R-19 or R-30. If
                you have newer spray foam, it could be R-49.
            </p>
            <p>
                For windows, look for a NFRC sticker. If not found, assume:
            </p>
            <ul>
                <li><strong>Single Pane:</strong> High heat transfer (U-factor ~1.0)</li>
                <li><strong>Double Pane Clear:</strong> Moderate (U-factor ~0.5)</li>
                <li><strong>Double Pane Low-E:</strong> Low heat transfer (U-factor ~0.3)</li>
            </ul>

            <h2 id="calculation">5. The Calculation Process</h2>
            <p>
                While the math is complex to do by hand (Q = U * A * \u2206T), modern software automates this.
            </p>
            <ol>
                <li>Enter your Zip Code (auto-fills weather data).</li>
                <li>Input your building materials (Walls, Ceiling, Floor).</li>
                <li>Input your window dimensions and orientation (West windows add more heat!).</li>
                <li>Input air tightness (leaky vs tight).</li>
            </ol>
            <p>
                The result will give you the <strong>Sensible Load</strong> (temperature change) and <strong>Latent
                    Load</strong> (humidity removal), which combine to form the Total Load.
            </p>

            <div class="bg-slate-900 p-8 rounded-xl text-center border border-slate-800 text-white mt-12">
                <h3 class="text-2xl font-bold mb-4 mt-0 text-white">Ready to Run the Numbers?</h3>
                <p class="text-slate-300 mb-8">Our free calculator handles all the complex math for you in seconds.</p>
                <a href="/calculator"
                    class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-500 transition-colors shadow-lg shadow-blue-900/50">
                    Start Your Calculation
                </a>
            </div>

        </div>
    </div>
</article>