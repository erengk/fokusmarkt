<?php
// Check Categories Script
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/Database.php';

echo "📊 Fokus Markt - Category Status Check\n";
echo "=====================================\n\n";

try {
    $db = Database::getInstance();
    
    // Tüm kategorileri ve ürün sayılarını listele
    $categoryProducts = $db->fetchAll("
        SELECT c.name, c.slug, COUNT(pc.product_id) as product_count 
        FROM categories c 
        LEFT JOIN product_categories pc ON c.id = pc.category_id 
        GROUP BY c.id, c.name, c.slug 
        ORDER BY c.sort_order
    ");
    
    echo "📋 Kategoriler ve Ürün Sayıları:\n";
    echo "================================\n";
    
    foreach ($categoryProducts as $cp) {
        echo "• {$cp['name']} ({$cp['slug']}): {$cp['product_count']} ürün\n";
        
        // Her kategori için ürünleri listele
        $products = $db->fetchAll("
            SELECT p.name 
            FROM products p 
            JOIN product_categories pc ON p.id = pc.product_id 
            JOIN categories c ON pc.category_id = c.id 
            WHERE c.slug = ? 
            ORDER BY p.name
        ", [$cp['slug']]);
        
        if (!empty($products)) {
            foreach ($products as $product) {
                echo "  - {$product['name']}\n";
            }
        }
        echo "\n";
    }
    
    // Toplam istatistikler
    $totalProducts = $db->fetchOne("SELECT COUNT(*) as count FROM products")['count'];
    $totalCategories = $db->fetchOne("SELECT COUNT(*) as count FROM categories")['count'];
    
    echo "📈 Genel İstatistikler:\n";
    echo "======================\n";
    echo "• Toplam Ürün: {$totalProducts}\n";
    echo "• Toplam Kategori: {$totalCategories}\n";
    
    echo "\n✅ Category check completed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
