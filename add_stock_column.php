<?php
require_once 'config/database.php';
require_once 'includes/Database.php';

$db = Database::getInstance();

// Stock kolonunu ekle
$sql = "ALTER TABLE product_variants ADD COLUMN stock INTEGER DEFAULT 1000";

try {
    $result = $db->query($sql);
    echo "Stock kolonu eklendi!\n";
    
    // Şimdi stok sayılarını güncelle
    $updateSql = "UPDATE product_variants SET stock = CASE 
        WHEN name = 'Malt' THEN 100 
        WHEN name = 'Tablet' THEN 80 
        WHEN name = 'Jel' THEN 60 
        ELSE 1000 
    END";
    
    $result = $db->query($updateSql);
    echo "Stok sayıları güncellendi!\n";
    
    // Güncellenmiş stokları göster
    $checkSql = "SELECT p.name, pv.name as form_name, pv.stock FROM product_variants pv 
                 JOIN products p ON pv.product_id = p.id 
                 ORDER BY p.name, pv.name";
    $stocks = $db->fetchAll($checkSql);
    
    echo "\nGüncel stok durumu:\n";
    echo "==================\n";
    foreach ($stocks as $stock) {
        echo sprintf("%-20s %-10s %d adet\n", $stock['name'], $stock['form_name'], $stock['stock']);
    }
    
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage() . "\n";
}
?>
