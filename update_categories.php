<?php
// Category Update Script
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/Database.php';

echo "🔄 Fokus Markt Category Update\n";
echo "=============================\n\n";

try {
    $db = Database::getInstance();
    
    echo "📊 Updating categories...\n";
    
    // Update SQL dosyasını çalıştır
    $updateSql = file_get_contents(__DIR__ . '/database/update_categories.sql');
    $db->getConnection()->exec($updateSql);
    
    echo "✅ Categories updated successfully!\n\n";
    
    // Yeni kategorileri listele
    $categories = $db->fetchAll("SELECT name, slug FROM categories ORDER BY sort_order");
    
    echo "📋 Updated Categories:\n";
    foreach ($categories as $category) {
        echo "- {$category['name']} ({$category['slug']})\n";
    }
    
    echo "\n📈 Category-Product Relationships:\n";
    
    // Her kategori için ürün sayısını göster
    $categoryProducts = $db->fetchAll("
        SELECT c.name, COUNT(pc.product_id) as product_count 
        FROM categories c 
        LEFT JOIN product_categories pc ON c.id = pc.category_id 
        GROUP BY c.id, c.name 
        ORDER BY c.sort_order
    ");
    
    foreach ($categoryProducts as $cp) {
        echo "- {$cp['name']}: {$cp['product_count']} ürün\n";
    }
    
    echo "\n🎉 Category update completed successfully!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
