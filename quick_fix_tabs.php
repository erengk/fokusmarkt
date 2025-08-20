<?php
require_once 'config/database.php';
require_once 'includes/Database.php';

$db = Database::getInstance();

// Sadece benefits ve faq kolonlarını düzelt (mevcut kolonlar)
echo "Hızlı Tab Düzeltmesi...\n";

// Benefits ekle
$benefits = [
    'Doğal içeriklerle üretilmiştir',
    'Veteriner hekim onaylıdır', 
    'Yan etki riski düşüktür',
    'Kolay kullanım sağlar',
    'Uzun süreli etki gösterir'
];

$benefitsJson = json_encode($benefits, JSON_UNESCAPED_UNICODE);
$sql = "UPDATE products SET benefits = ? WHERE benefits IS NULL OR benefits = ''";
$result = $db->query($sql, [$benefitsJson]);
echo "✅ Benefits güncellendi\n";

// FAQ ekle
$faq = [
    [
        'question' => 'Bu ürün yan etkisi var mı?',
        'answer' => 'Ürün doğal içeriklerden üretilmiştir. Nadir durumlarda hassasiyet reaksiyonu görülebilir.'
    ],
    [
        'question' => 'Etkisini ne kadar sürede gösterir?',
        'answer' => 'Genellikle 7-14 gün içerisinde etki görülmeye başlar.'
    ],
    [
        'question' => 'Hem kedi hem köpek için kullanılabilir mi?',
        'answer' => 'Evet, ürün hem kedi hem de köpekler için güvenle kullanılabilir.'
    ]
];

$faqJson = json_encode($faq, JSON_UNESCAPED_UNICODE);
$sql = "UPDATE products SET faq = ? WHERE faq IS NULL OR faq = ''";
$result = $db->query($sql, [$faqJson]);
echo "✅ FAQ güncellendi\n";

echo "Tamamlandı!\n";
?>
