<?php
require_once 'config/database.php';
require_once 'includes/Database.php';

$db = Database::getInstance();

echo "JSON Formatına Çeviriliyor...\n";

// Benefits için JSON formatı
$benefits = [
    'Doğal içeriklerle üretilmiştir',
    'Veteriner hekim onaylıdır',
    'Yan etki riski düşüktür',
    'Kolay kullanım sağlar',
    'Uzun süreli etki gösterir'
];

$benefitsJson = json_encode($benefits, JSON_UNESCAPED_UNICODE);

// FAQ için JSON formatı
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

// Tüm ürünleri güncelle
$sql = "UPDATE products SET benefits = ?, faq = ?";
$result = $db->query($sql, [$benefitsJson, $faqJson]);

echo "✅ Tüm ürünler güncellendi\n";
echo "Benefits JSON: " . $benefitsJson . "\n";
echo "FAQ JSON: " . $faqJson . "\n";
echo "Tamamlandı!\n";
?>
