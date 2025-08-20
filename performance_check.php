<?php
require_once 'config/database.php';
require_once 'includes/Database.php';
require_once 'includes/Product.php';

$db = Database::getInstance();
$product = Product::getInstance();

echo "Performans Testi Başlıyor...\n";
echo "==========================\n\n";

$startTime = microtime(true);

// Test 1: Ürün detayları çekme
echo "Test 1: Ürün detayları çekme\n";
$productStart = microtime(true);
$productDetails = $product->getProductBySlug('phytospan');
$productTime = microtime(true) - $productStart;
echo "Süre: " . number_format($productTime, 4) . " saniye\n";

// Test 2: Ürün formları çekme
echo "\nTest 2: Ürün formları çekme\n";
$formsStart = microtime(true);
$productForms = $product->getProductForms('phytospan');
$formsTime = microtime(true) - $formsStart;
echo "Süre: " . number_format($formsTime, 4) . " saniye\n";

// Test 3: Ürün görselleri çekme
echo "\nTest 3: Ürün görselleri çekme\n";
$imagesStart = microtime(true);
$productImages = $product->getProductImages('phytospan');
$imagesTime = microtime(true) - $imagesStart;
echo "Süre: " . number_format($imagesTime, 4) . " saniye\n";

// Test 4: Birlikte iyi gider ürünleri çekme
echo "\nTest 4: Birlikte iyi gider ürünleri çekme\n";
$complementaryStart = microtime(true);
$complementaryProducts = $product->getComplementaryProducts('phytospan', 6);
$complementaryTime = microtime(true) - $complementaryStart;
echo "Süre: " . number_format($complementaryTime, 4) . " saniye\n";

$totalTime = microtime(true) - $startTime;
echo "\nToplam Süre: " . number_format($totalTime, 4) . " saniye\n";

// En yavaş işlemi tespit et
$times = [
    'Ürün Detayları' => $productTime,
    'Ürün Formları' => $formsTime,
    'Ürün Görselleri' => $imagesTime,
    'Birlikte İyi Gider' => $complementaryTime
];

$slowest = array_keys($times, max($times))[0];
echo "En Yavaş İşlem: $slowest (" . number_format(max($times), 4) . " saniye)\n";

if ($totalTime > 1.0) {
    echo "\n⚠️  UYARI: Sayfa yükleme süresi çok yavaş (>1 saniye)\n";
} elseif ($totalTime > 0.5) {
    echo "\n⚠️  UYARI: Sayfa yükleme süresi yavaş (>0.5 saniye)\n";
} else {
    echo "\n✅ Sayfa yükleme süresi normal\n";
}
?>
