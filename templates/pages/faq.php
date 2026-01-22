<div class="container mx-auto px-4 py-12 max-w-3xl">
    <h1 class="text-3xl font-bold mb-8 text-center text-slate-900">Frequently Asked Questions</h1>

    <div class="space-y-6">
        <?php
        $faqs = [
            [
                'q' => 'What is a Manual J calculation?',
                'a' => 'Manual J is the industry standard (ACCA) protocol for determining how much heating and cooling a home needs. It calculates heat loss and gain based on climate, insulation, windows, and other factors.'
            ],
            [
                'q' => 'Is this calculator 100% accurate?',
                'a' => 'This tool is an <strong>estimator</strong> based on Manual J principles. While highly accurate for standard homes, a certified HVAC professional should perform a precise calculation before you purchase equipment.'
            ],
            [
                'q' => 'Why does my contractor want to just install a 3-ton unit?',
                'a' => 'Many contractors use "Rule of Thumb" sizing (e.g., 1 ton per 500 sq ft) to save time. This often leads to oversizing, which causes high humidity, mold risk, and short cycling.'
            ],
            [
                'q' => 'What happens if my AC is oversized?',
                'a' => 'An oversized AC cools the air too quickly without removing humidity. This results in a "clammy" cold feeling and higher energy bills due to frequent startup cycles.'
            ],
            [
                'q' => 'How do I find my insulation R-values?',
                'a' => 'Check your attic floor or walls. Fiberglass batts often have the R-value printed on them. If you don\'t know, "Average" is a safe baseline for homes built after 1990.'
            ]
        ];
        ?>

        <?php foreach ($faqs as $i => $faq): ?>
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                <button
                    class="w-full text-left p-4 font-semibold text-slate-800 flex justify-between items-center focus:outline-none"
                    onclick="document.getElementById('faq-ans-<?= $i ?>').classList.toggle('hidden')">
                    <span>
                        <?= $faq['q'] ?>
                    </span>
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="faq-ans-<?= $i ?>" class="hidden p-4 pt-0 text-slate-600 bg-slate-50 border-t border-slate-100">
                    <?= $faq['a'] ?>
                </div>
            </div>
            <!-- FAQ Schema Injection -->
            <script type="application/ld+json">
                {
                  "@context": "https://schema.org",
                  "@type": "Question",
                  "name": "<?= htmlspecialchars($faq['q']) ?>",
                  "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "<?= htmlspecialchars(strip_tags($faq['a'])) ?>"
                  }
                }
                </script>
        <?php endforeach; ?>
    </div>
</div>