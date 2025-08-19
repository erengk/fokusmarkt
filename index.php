<?php
// Start session
session_start();

// Load configuration
require_once __DIR__ . '/config/database.php';

// Load required classes
require_once __DIR__ . '/includes/Language.php';
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/includes/Product.php';

// Simple routing
$request_uri = $_SERVER['REQUEST_URI'];
$path = parse_url($request_uri, PHP_URL_PATH);
$path = trim($path, '/');

// Remove query string
$path = explode('?', $path)[0];

// Check for language prefix (en/, de/, tr/)
$language = 'tr'; // default language
$pathParts = explode('/', $path);

if (in_array($pathParts[0], ['en', 'de', 'tr'])) {
    $language = $pathParts[0];
    $path = implode('/', array_slice($pathParts, 1));
    
    // Set language
    $lang = Language::getInstance();
    $lang->setLanguage($language);
}

// Route to appropriate page
switch ($path) {
    case 'language':
        include __DIR__ . '/pages/language.php';
        break;
        
    case '':
    case 'home':
        include __DIR__ . '/pages/home.php';
        break;
        
    case 'category':
        include __DIR__ . '/pages/category.php';
        break;
        
    case 'product':
        include __DIR__ . '/pages/product.php';
        break;
        
    // Ürün sayfaları için routing
    case 'o2-care':
    case 'canivir':
    case 'felovir':
    case 'petimmun':
    case 'ease-off':
    case 'bladder-control':
    case 'uticare':
    case 'renacure':
    case 'salmonoil':
    case 'retino-a':
    case 'phytospan':
    case 'multivit':
    case 'm-b-care':
    case 'dermacumin':
    case 'derma-zn':
    case 'derma-hairball':
    case 'dental-care':
    case 'coprophagia':
    case 'cartilagoflex':
        // Ürün slug'ını al ve product.php'ye yönlendir
        $productSlug = $path;
        include __DIR__ . '/pages/product.php';
        break;
        
    case 'dogs':
        include __DIR__ . '/pages/category.php';
        break;
        
    case 'cats':
        include __DIR__ . '/pages/category.php';
        break;
        
    case 'explore':
        include __DIR__ . '/pages/category.php';
        break;
        
    case 'about':
    case 'hakkimizda':
        include __DIR__ . '/pages/about.php';
        break;
        
    case 'contact':
    case 'iletisim':
        include __DIR__ . '/pages/contact.php';
        break;
        
    case 'login':
        include __DIR__ . '/pages/login.php';
        break;
        
    case 'register':
        include __DIR__ . '/pages/register.php';
        break;
        
    case 'cart':
        include __DIR__ . '/pages/cart.php';
        break;
        
    default:
        // Check if it's a product or category page
        if (strpos($path, 'products/') === 0 || strpos($path, 'categories/') === 0) {
            include __DIR__ . '/pages/category.php';
        } else {
            // 404 page
            http_response_code(404);
            include __DIR__ . '/pages/404.php';
        }
        break;
}
?>
