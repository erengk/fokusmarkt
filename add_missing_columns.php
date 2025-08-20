<?php
require_once 'config/database.php';
require_once 'includes/Database.php';

$db = Database::getInstance();

echo "Eksik kolonlar ekleniyor...\n";

try {
    // Benefits kolonu ekle
    $sql = "ALTER TABLE products ADD COLUMN benefits TEXT";
    $db->query($sql);
    echo "✅ Benefits kolonu eklendi\n";
} catch (Exception $e) {
    echo "Benefits kolonu zaten var veya hata: " . $e->getMessage() . "\n";
}

try {
    // FAQ kolonu ekle
    $sql = "ALTER TABLE products ADD COLUMN faq TEXT";
    $db->query($sql);
    echo "✅ FAQ kolonu eklendi\n";
} catch (Exception $e) {
    echo "FAQ kolonu zaten var veya hata: " . $e->getMessage() . "\n";
}

echo "Tamamlandı!\n";
?>
