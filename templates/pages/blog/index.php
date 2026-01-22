<?php
// Blog Index Template
$articles = [
    [
        'title' => 'What Is a Manual J Load Calculation?',
        'slug' => 'what-is-manual-j-load-calculation',
        'desc' => 'A simple explanation for homeowners. Understand why this engineering standard is critical for comfort and efficiency.',
        'category' => 'Basics'
    ],
    [
        'title' => 'How to Calculate HVAC Load for a House',
        'slug' => 'how-to-calculate-hvac-load',
        'desc' => 'A step-by-step guide to the Manual J method. Learn what goes into sizing your heating and cooling system.',
        'category' => 'DIY Guide'
    ],
    [
        'title' => 'How Many BTUs Do I Need for My House?',
        'slug' => 'how-many-btus-do-i-need',
        'desc' => 'Stop guessing. Learn why square footage estimates fail and how to determine your exact BTU requirements.',
        'category' => 'Sizing'
    ],
    [
        'title' => 'HVAC Tonnage Explained',
        'slug' => 'hvac-tonnage-explained',
        'desc' => 'Converting Manual J BTUs to system size. What does "2.5 tons" actually mean for your home?',
        'category' => 'Technical'
    ],
    [
        'title' => 'Why Oversizing Your AC Is a Costly Mistake',
        'slug' => 'oversized-air-conditioner-problems',
        'desc' => 'Bigger is not better. Discover the hidden costs of short-cycling, humidity issues, and mold risks.',
        'category' => 'Mistakes'
    ],
    [
        'title' => 'Manual J vs Rule-of-Thumb HVAC Sizing',
        'slug' => 'manual-j-vs-rule-of-thumb',
        'desc' => 'What contractors get wrong when they guess. Compare scientific analysis against the old "500 sq ft" rule.',
        'category' => 'Comparison'
    ],
    [
        'title' => 'How Insulation Affects Heating & Cooling Load',
        'slug' => 'how-insulation-affects-hvac-load',
        'desc' => 'See how upgrading your R-values can drastically reduce the size of the HVAC equipment you need.',
        'category' => 'Efficiency'
    ],
    [
        'title' => 'How Windows Affect HVAC Load',
        'slug' => 'how-windows-affect-hvac-load',
        'desc' => 'Understanding SHGC, U-Factor, and orientation. Why your west-facing windows matter most.',
        'category' => 'Efficiency'
    ],
    [
        'title' => 'Air Leakage, ACH, and HVAC Load',
        'slug' => 'air-leakage-hvac-load',
        'desc' => 'What Manual J accounts for regarding infiltration. Why a tight house needs a smaller unit.',
        'category' => 'Technical'
    ],
    [
        'title' => 'When to Hire a Pro for Manual J',
        'slug' => 'hire-pro-manual-j-calculation',
        'desc' => 'Knowing when to DIY and when to call a licensed engineer for a certified load calculation report.',
        'category' => 'Professional'
    ],
];
?>

<div class="bg-slate-50 min-h-screen py-12 md:py-20">
    <div class="container mx-auto px-4 max-w-6xl">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-bold tracking-wide uppercase text-sm">HVAC Sizing Knowledge Hub</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mt-2 mb-4">Master Your Home's Climate</h1>
            <p class="text-xl text-slate-600 max-w-2xl mx-auto">Expert guides on Manual J calculations, energy
                efficiency, and properly sizing your heating and cooling equipment.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($articles as $article): ?>
                <a href="/blog/<?= $article['slug'] ?>"
                    class="group bg-white rounded-2xl p-8 shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
                    <div class="mb-4">
                        <span
                            class="inline-block px-3 py-1 bg-slate-100 text-slate-600 text-xs font-bold uppercase rounded-full group-hover:bg-blue-50 group-hover:text-blue-600 transition-colors">
                            <?= $article['category'] ?>
                        </span>
                    </div>
                    <h2 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors">
                        <?= $article['title'] ?>
                    </h2>
                    <p class="text-slate-600 mb-6 flex-grow leading-relaxed">
                        <?= $article['desc'] ?>
                    </p>
                    <div class="flex items-center text-blue-600 font-bold text-sm">
                        Read Article
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- CTA -->
        <div class="mt-20 bg-blue-600 rounded-3xl p-8 md:p-12 text-center text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
            <div class="relative z-10 max-w-2xl mx-auto">
                <h2 class="text-3xl font-bold mb-6">Ready to apply what you've learned?</h2>
                <p class="text-blue-100 mb-8 text-lg">Use our free Manual J Calculator to get specific numbers for your
                    home's unique layout and insulation.</p>
                <a href="/calculator"
                    class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-700 font-bold rounded-xl hover:bg-blue-50 transition-colors shadow-lg">
                    Start Calculation
                </a>
            </div>
        </div>
    </div>
</div>