<?php
/**
 * JSON-LD Schema Generator
 * Outputs structured data for SEO (SoftwareApplication, FAQ, Breadcrumbs)
 */

$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";

$schemas = [];

// 1. WebSite Schema (Global)
$schemas[] = [
    "@context" => "https://schema.org",
    "@type" => "WebSite",
    "name" => "HVAC Manual J Load Calculator",
    "url" => $baseUrl,
    "potentialAction" => [
        "@type" => "SearchAction",
        "target" => "$baseUrl/search?q={search_term_string}",
        "query-input" => "required name=search_term_string"
    ]
];

// 2. Organization Schema (Global)
$schemas[] = [
    "@context" => "https://schema.org",
    "@type" => "Organization",
    "name" => "HVAC Load Calc Co.",
    "url" => $baseUrl,
    "logo" => "$baseUrl/assets/logo.png",
    "contactPoint" => [
        "@type" => "ContactPoint",
        "telephone" => "+1-555-0199",
        "contactType" => "Customer Support"
    ]
];

// 3. Page Specific Schemas
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = array_filter(explode('/', $path));

// Dynamic BreadcrumbList
$breadcrumbItems = [
    [
        "@type" => "ListItem",
        "position" => 1,
        "name" => "Home",
        "item" => $baseUrl
    ]
];

$position = 2;
$accumulatedPath = '';

foreach ($segments as $segment) {
    if ($segment === 'index.php')
        continue;

    $accumulatedPath .= '/' . $segment;
    $name = ucwords(str_replace('-', ' ', $segment));

    $breadcrumbItems[] = [
        "@type" => "ListItem",
        "position" => $position++,
        "name" => $name,
        "item" => $baseUrl . $accumulatedPath
    ];
}

$schemas[] = [
    "@context" => "https://schema.org",
    "@type" => "BreadcrumbList",
    "itemListElement" => $breadcrumbItems
];


if ($path === '/' || $path === '/index.php') {
    // --- HOME PAGE SCHEMA ---

    // SoftwareApplication
    $schemas[] = [
        "@context" => "https://schema.org",
        "@type" => "SoftwareApplication",
        "name" => "Manual J Load Calculator",
        "applicationCategory" => "BusinessApplication",
        "operatingSystem" => "Web",
        "offers" => [
            "@type" => "Offer",
            "price" => "0",
            "priceCurrency" => "USD"
        ],
        "featureList" => "Cooling Load Calculation, Heating Load Calculation, Manual J Compliance, Glazing Analysis",
        "screenshot" => "$baseUrl/assets/images/calculator-screenshot.jpg"
    ];

    // FAQPage (from home.php content)
    $schemas[] = [
        "@context" => "https://schema.org",
        "@type" => "FAQPage",
        "mainEntity" => [
            [
                "@type" => "Question",
                "name" => "What is a Manual J Load Calculation?",
                "acceptedAnswer" => [
                    "@type" => "Answer",
                    "text" => "Manual J is the industry standard protocol designed by ACCA (Air Conditioning Contractors of America) to calculate the precise heating and cooling loads for residential structures."
                ]
            ],
            [
                "@type" => "Question",
                "name" => "Why can't I just use 500 sq ft per ton?",
                "acceptedAnswer" => [
                    "@type" => "Answer",
                    "text" => "The 'rule of thumb' (e.g., 500 sq ft/ton) ignores critical factors like insulation, windows, orientation, and local climate. This often leads to oversizing, humidity issues, and short-cycling."
                ]
            ],
            [
                "@type" => "Question",
                "name" => "Is this calculator free?",
                "acceptedAnswer" => [
                    "@type" => "Answer",
                    "text" => "Yes, this is a free simplified Manual J tool. For permit-ready reports, we recommend consulting a licensed mechanical engineer."
                ]
            ]
        ]
    ];

}

// Output JSON-LD
foreach ($schemas as $schema) {
    echo '<script type="application/ld+json">' . json_encode($schema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}