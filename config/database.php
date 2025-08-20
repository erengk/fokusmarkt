<?php
// Database Configuration
define('DB_TYPE', 'mysql'); // sqlite, mysql, pgsql
define('DB_HOST', 'localhost');
define('DB_NAME', 'fokusmarkt');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// SQLite Database Path (for backup)
define('DB_PATH', __DIR__ . '/../database/fokusmarkt.db');

// Site Configuration
define('SITE_NAME', 'Fokus Markt');
define('SITE_URL', 'http://localhost:8000');
define('DEFAULT_LANG', 'tr');

// Session Configuration
define('SESSION_NAME', 'fokusmarkt_session');
define('SESSION_LIFETIME', 3600); // 1 hour

// File Upload Configuration
define('UPLOAD_MAX_SIZE', 5242880); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('UPLOAD_PATH', __DIR__ . '/../public/uploads/');

// Security Configuration
define('CSRF_TOKEN_NAME', 'csrf_token');
define('PASSWORD_COST', 12);

// Cache Configuration
define('CACHE_ENABLED', true);
define('CACHE_PATH', __DIR__ . '/../storage/cache/');
define('CACHE_LIFETIME', 3600); // 1 hour

// Error Reporting (Development)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../storage/logs/error.log');

// Timezone
date_default_timezone_set('Europe/Istanbul');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_name(SESSION_NAME);
    session_start();
}

// Create database directory if not exists
if (!file_exists(dirname(DB_PATH))) {
    mkdir(dirname(DB_PATH), 0755, true);
}

// Create storage directories if not exists
$storage_dirs = [
    __DIR__ . '/../storage/cache/',
    __DIR__ . '/../storage/logs/',
    __DIR__ . '/../storage/sessions/',
    __DIR__ . '/../public/uploads/'
];

foreach ($storage_dirs as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }
}
?>
