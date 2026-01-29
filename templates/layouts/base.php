<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'HVAC Manual J Load Calculator' ?></title>
    <meta name="description"
        content="<?= $metaDescription ?? 'Free simplified Manual J Load Calculator for HVAC sizing. Estimate cooling and heating loads (BTU/hr) for your home.' ?>">
    <link rel="canonical" href="<?= $canonical ?? 'https://writeoffcalc.com' . ($current_path ?? '/') ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= $canonical ?? 'https://writeoffcalc.com/' ?>">
    <meta property="og:title" content="<?= $title ?? 'HVAC Manual J Load Calculator' ?>">
    <meta property="og:description"
        content="<?= $metaDescription ?? 'Free simplified Manual J Load Calculator for HVAC sizing. Estimate cooling and heating loads (BTU/hr) for your home.' ?>">
    <meta property="og:image" content="<?= $ogImage ?? 'https://writeoffcalc.com/assets/images/og-share.jpg' ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $title ?? 'HVAC Manual J Load Calculator' ?>">
    <meta name="twitter:description"
        content="<?= $metaDescription ?? 'Free simplified Manual J Load Calculator for HVAC sizing. Estimate cooling and heating loads (BTU/hr) for your home.' ?>">
    <meta name="twitter:image" content="<?= $ogImage ?? 'https://writeoffcalc.com/assets/images/og-share.jpg' ?>">

    <!-- <link href="/assets/css/style.css" rel="stylesheet"> -->
    <script src="/assets/js/theme-config.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
    <!-- Preconnect to fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Outfit:wght@400;500;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">



    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7838469019748860"
        crossorigin="anonymous"></script>

    <?php include __DIR__ . '/../partials/schema.php'; ?>
    <style>
        body {
            background-color: #f8fafc;
        }

        ::selection {
            background-color: #0ea5e9;
            color: white;
        }

        /* Technical scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 font-sans antialiased relative selection:bg-primary-500 selection:text-white">
    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="container mx-auto px-4 h-16 flex items-center justify-between">
            <a href="/" class="group flex items-center gap-3">
                <div
                    class="w-8 h-8 rounded bg-slate-900 text-white flex items-center justify-center shadow-lg group-hover:bg-primary-600 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                        <polyline points="14 2 14 8 20 8" />
                        <path d="M12 18l-2-2" />
                        <path d="M12 18l2-2" />
                        <path d="M12 12v6" />
                        <path d="M8 12h8" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-base font-bold font-display text-slate-900 leading-none">Manual J</span>
                    <span class="text-[10px] font-mono uppercase tracking-wider text-slate-500 font-medium">Load
                        Calculator</span>
                </div>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex gap-8 text-sm font-medium text-slate-600">
                <a href="/calculator" class="hover:text-primary-600 transition flex items-center gap-1 group">
                    <span
                        class="w-1.5 h-1.5 rounded-full bg-transparent group-hover:bg-primary-600 transition-colors"></span>
                    Calculator
                </a>
                <a href="/manual-j-vs-rule-of-thumb"
                    class="hover:text-primary-600 transition flex items-center gap-1 group">
                    <span
                        class="w-1.5 h-1.5 rounded-full bg-transparent group-hover:bg-primary-600 transition-colors"></span>
                    Manual J Vs Rule of Thumb
                </a>
                <a href="#faq" class="hover:text-primary-600 transition flex items-center gap-1 group">
                    <span
                        class="w-1.5 h-1.5 rounded-full bg-transparent group-hover:bg-primary-600 transition-colors"></span>
                    FAQ
                </a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="/calculator"
                    class="inline-flex items-center justify-center h-9 px-4 text-sm font-semibold text-white bg-slate-900 rounded hover:bg-blue-600 transition-all shadow-sm">
                    <span>Start Calc</span>
                    <svg class="w-4 h-4 ml-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6">
                        </path>
                    </svg>
                </a>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-slate-100 bg-white">
            <nav class="flex flex-col p-4 space-y-4 text-sm font-medium text-slate-600">
                <a href="/calculator" class="block py-2 hover:text-primary-600">Calculator</a>
                <a href="/manual-j-vs-rule-of-thumb" class="block py-2 hover:text-primary-600">Manual J Vs Rule of
                    Thumb</a>
                <a href="#faq" class="block py-2 hover:text-primary-600">FAQ</a>
            </nav>
        </div>

        <script>
            document.getElementById('mobile-menu-btn').addEventListener('click', function () {
                document.getElementById('mobile-menu').classList.toggle('hidden');
            });
        </script>
    </header>

    <main class="min-h-[calc(100vh-64px-300px)]">
        <?php include $view; ?>
    </main>

    <footer class="bg-slate-900 text-slate-400 py-12 mt-20">
        <div class="container mx-auto px-4 grid md:grid-cols-3 gap-8 text-sm">
            <div>
                <h3 class="text-white font-semibold mb-4">Manual J Calculator</h3>
                <p class="mb-4">Free tool to estimate residential heating and cooling loads. Designed for homeowners and
                    HVAC pros.</p>
                <p>&copy; <?= date('Y') ?> Manual J Calc. All rights reserved. <span
                        class="text-slate-600 ml-2 text-xs">Build 2026.1</span></p>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-4">Resources</h3>
                <ul class="space-y-2">
                    <li><a href="/manual-j-vs-rule-of-thumb" class="hover:text-white">Why Manual J?</a></li>
                    <li><a href="#" class="hover:text-white">Glossary</a></li>
                    <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-4">Disclaimer</h3>
                <p>This tool provides estimates only. Always verify equipment sizing with a licensed HVAC professional
                    performing a full ACCA Manual J calculation.</p>
            </div>
        </div>
    </footer>

    <script src="/assets/js/app.js" defer></script>
</body>

</html>