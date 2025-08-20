<?php
require_once 'config/database.php';
require_once 'includes/Database.php';

$db = Database::getInstance();

// Bir ürünün verilerini kontrol et
$product = $db->fetchOne("SELECT name, benefits, faq FROM products WHERE slug = 'phytospan'");

echo "PHYTOSPAN Ürün Verileri:\n";
echo "=======================\n";
echo "Ürün Adı: " . $product['name'] . "\n";
echo "Benefits: " . ($product['benefits'] ?: 'BOŞ') . "\n";
echo "FAQ: " . ($product['faq'] ?: 'BOŞ') . "\n";

// Tüm ürünlerde benefits ve faq kontrolü
$products = $db->fetchAll("SELECT name, benefits, faq FROM products LIMIT 3");

echo "\nİlk 3 Ürün Kontrolü:\n";
echo "==================\n";
foreach ($products as $p) {
    echo $p['name'] . ":\n";
    echo "  Benefits: " . (empty($p['benefits']) ? 'BOŞ' : 'VAR') . "\n";
    echo "  FAQ: " . (empty($p['faq']) ? 'BOŞ' : 'VAR') . "\n";
}
?>
