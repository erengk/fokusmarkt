<?php
// Start session
session_start();

// Load configuration
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/Language.php';

$lang = Language::getInstance();

// Handle language change
if (isset($_GET['lang']) && in_array($_GET['lang'], $lang->getSupportedLanguages())) {
    $newLang = $_GET['lang'];
    $lang->setLanguage($newLang);
    
    // Redirect back to previous page or home
    $redirect = $_GET['redirect'] ?? '/';
    header("Location: $redirect");
    exit;
}

// If no language specified, redirect to home
header("Location: /");
exit;
?>
