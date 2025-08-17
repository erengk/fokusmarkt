<?php
// Database Initialization Script
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/Database.php';

echo "🚀 Fokus Markt Database Initialization\n";
echo "=====================================\n\n";

try {
    $db = Database::getInstance();
    
    echo "📊 Checking database status...\n";
    
    $initialized = $db->initialize();
    
    if ($initialized) {
        echo "✅ Database initialized successfully!\n";
        echo "📋 Tables created and seed data inserted.\n\n";
        
        // Verify data
        $products = $db->fetchAll("SELECT COUNT(*) as count FROM products");
        $categories = $db->fetchAll("SELECT COUNT(*) as count FROM categories");
        $indications = $db->fetchAll("SELECT COUNT(*) as count FROM indications");
        
        echo "📈 Database Statistics:\n";
        echo "- Products: " . $products[0]['count'] . "\n";
        echo "- Categories: " . $categories[0]['count'] . "\n";
        echo "- Indications: " . $indications[0]['count'] . "\n";
        
    } else {
        echo "ℹ️  Database already exists and initialized.\n";
    }
    
    echo "\n🎉 Database setup completed successfully!\n";
    echo "🌐 You can now access the website at: http://localhost:8000\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
