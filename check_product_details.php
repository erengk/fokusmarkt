<?php
require_once 'config/database.php';
require_once 'includes/Database.php';

$db = Database::getInstance();

// Tüm ürünleri al
$products = $db->fetchAll("SELECT id, name, slug, description, benefits, faq FROM products WHERE is_active = 1 ORDER BY name");

echo "Ürün Detayları Kontrolü\n";
echo "======================\n\n";

foreach ($products as $product) {
    echo "Ürün: " . $product['name'] . " (" . $product['slug'] . ")\n";
    echo "----------------------------------------\n";
    
    // Description kontrolü
    $descLength = strlen($product['description'] ?? '');
    echo "Açıklama uzunluğu: " . $descLength . " karakter\n";
    
    // Benefits kontrolü
    $benefits = json_decode($product['benefits'] ?? '[]', true);
    $benefitsCount = is_array($benefits) ? count($benefits) : 0;
    echo "Özellik sayısı: " . $benefitsCount . "\n";
    
    // FAQ kontrolü
    $faq = json_decode($product['faq'] ?? '[]', true);
    $faqCount = is_array($faq) ? count($faq) : 0;
    echo "FAQ sayısı: " . $faqCount . "\n";
    
    // Genel şablon mu özel mi kontrol et
    if ($benefitsCount > 0) {
        $firstBenefit = is_array($benefits) ? $benefits[0] : '';
        if (strpos($firstBenefit, 'Doğal içeriklerle üretilmiştir') !== false) {
            echo "⚠️  Genel şablon kullanılmış\n";
        } else {
            echo "✅ Özel bilgiler var\n";
        }
    }
    
    if ($faqCount > 0) {
        $firstFaq = is_array($faq) ? ($faq[0]['question'] ?? '') : '';
        if (strpos($firstFaq, 'Bu ürün yan etkisi var mı?') !== false) {
            echo "⚠️  Genel FAQ şablonu kullanılmış\n";
        } else {
            echo "✅ Özel FAQ var\n";
        }
    }
    
    echo "\n";
}

echo "Kontrol tamamlandı!\n";
?>
