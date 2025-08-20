<?php
require_once 'config/database.php';
require_once 'includes/Database.php';
require_once 'includes/Product.php';

$db = Database::getInstance();
$product = Product::getInstance();

// Tüm ürünleri al
$products = $db->fetchAll("SELECT id, name, slug FROM products WHERE is_active = 1 ORDER BY name");

echo "Ürün Tab Menüleri Kontrol Raporu\n";
echo "================================\n\n";

foreach ($products as $productData) {
    $productSlug = $productData['slug'];
    $productName = $productData['name'];
    
    echo "Ürün: $productName ($productSlug)\n";
    echo "----------------------------------------\n";
    
    // Ürün detaylarını al
    $productDetails = $product->getProductBySlug($productSlug);
    
    // Tab içeriklerini kontrol et
    $tabs = [
        'description' => [
            'title' => 'Ürün Açıklaması',
            'content' => $productDetails['description'] ?? '',
            'short_description' => $productDetails['short_description'] ?? '',
            'active_ingredients' => $productDetails['active_ingredients'] ?? ''
        ],
        'indications' => [
            'title' => 'Endikasyonlar',
            'content' => $productDetails['indications'] ?? []
        ],
        'ingredients' => [
            'title' => 'İçerik',
            'content' => $productDetails['ingredients'] ?? []
        ],
        'usage' => [
            'title' => 'Kullanım',
            'content' => $productDetails['dosage_instructions'] ?? ''
        ],
        'specifications' => [
            'title' => 'Özellikler',
            'content' => $productDetails['benefits'] ?? []
        ],
        'reviews' => [
            'title' => 'Değerlendirmeler',
            'content' => 'Yorum sistemi henüz aktif değil'
        ],
        'faq' => [
            'title' => 'Sık Sorulanlar',
            'content' => $productDetails['faq'] ?? []
        ]
    ];
    
    foreach ($tabs as $tabKey => $tabData) {
        $hasContent = false;
        
        if ($tabKey === 'description') {
            $hasContent = !empty($tabData['content']) || !empty($tabData['short_description']) || !empty($tabData['active_ingredients']);
        } elseif ($tabKey === 'indications' || $tabKey === 'ingredients' || $tabKey === 'specifications') {
            $hasContent = !empty($tabData['content']) && is_array($tabData['content']) && count($tabData['content']) > 0;
        } elseif ($tabKey === 'usage') {
            $hasContent = !empty($tabData['content']);
        } elseif ($tabKey === 'faq') {
            $hasContent = !empty($tabData['content']) && is_array($tabData['content']) && count($tabData['content']) > 0;
        } elseif ($tabKey === 'reviews') {
            $hasContent = true; // Her zaman göster
        }
        
        $status = $hasContent ? "✅ Açılıyor" : "❌ Açılmıyor";
        echo sprintf("  %-15s: %s\n", $tabData['title'], $status);
        
        if (!$hasContent && $tabKey !== 'reviews') {
            echo "    Eksik içerik türü: ";
            if ($tabKey === 'description') {
                if (empty($tabData['content'])) echo "Ana açıklama, ";
                if (empty($tabData['short_description'])) echo "Kısa açıklama, ";
                if (empty($tabData['active_ingredients'])) echo "Aktif içerikler";
            } elseif (is_array($tabData['content'])) {
                echo "Dizi boş veya yok";
            } else {
                echo "Metin boş veya yok";
            }
            echo "\n";
        }
    }
    
    echo "\n";
}

echo "Kontrol tamamlandı!\n";
?>
