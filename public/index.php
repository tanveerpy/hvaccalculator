<?php
/**
 * HVAC Manual J Load Calculator - Entry Point
 * Routing is handled here (Simple Router)
 */

// Security Headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");

// Start Session for CSRF
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CSRF Token Generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Basic Router
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);

// Helper to render templates
function render($template, $data = [])
{
    // Add Global Data
    $data['csrf_token'] = $_SESSION['csrf_token'];
    $data['current_path'] = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // SEO Defaults
    $data['canonical'] = $data['canonical'] ?? (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    extract($data);
    $layout = __DIR__ . '/../templates/layouts/base.php';
    $view = __DIR__ . '/../templates/pages/' . $template . '.php';

    if (file_exists($layout)) {
        include $layout;
    } else {
        echo "Layout not found";
    }
}

// Routes
switch ($path) {
    case '/':
    case '/index.php':
        render('home', ['title' => 'HVAC Manual J Load Calculator']);
        break;

    case '/calculator':
        $viewData = ['title' => 'Load Calculator Tool'];

        // Dependencies
        require_once __DIR__ . '/../src/Logic/Calculator.php';
        require_once __DIR__ . '/../src/Logic/ClimateData.php';

        // Handle POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF Check
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                http_response_code(403);
                die('Invalid CSRF Token. Please refresh the page and try again.');
            }

            try {
                $results = \Logic\Calculator::calculate($_POST);
                $viewData['results'] = $results;
            } catch (\InvalidArgumentException $e) {
                // Validation failed (expected if data is missing or incomplete)
                $viewData['resultError'] = $e->getMessage();
            } catch (\Exception $e) {
                $viewData['resultError'] = "An unexpected error occurred.";
            }
            $viewData['inputs'] = $_POST; // Persist inputs
        }

        render('calculator', $viewData);
        break;

    case '/manual-j-vs-rule-of-thumb':
        // Legacy route redirect or keep as is? User wanted Article 6 to be this content.
        // Let's keep it for now but maybe alias it in the future.
        render('comparison', ['title' => 'Manual J vs Rule of Thumb']);
        break;

    case '/blog':
        render('blog/index', ['title' => 'HVAC Sizing Blog - Manual J']);
        break;

    default:
        // Blog Post Routing
        if (strpos($path, '/blog/') === 0) {
            $slug = substr($path, 6); // remove '/blog/'
            // Sanitize slug
            $slug = preg_replace('/[^a-z0-9-]/', '', $slug);

            if (file_exists(__DIR__ . '/../templates/pages/blog/' . $slug . '.php')) {
                // Title format could be improved dynamically or inside the template
                render('blog/' . $slug, ['title' => ucwords(str_replace('-', ' ', $slug)) . ' - Manual J Calc']);
                break;
            }
        }

        http_response_code(404);
        render('404', ['title' => 'Page Not Found']);
        break;
}
