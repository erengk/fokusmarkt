<?php
require_once 'config/database.php';
require_once 'includes/Database.php';

$db = Database::getInstance();

// Eksik içerikleri düzelt
$fixes = [
    // DENTAL CARE - Endikasyonlar ekle
    'dental-care' => [
        'indications' => [
            'Diş taşı oluşumunu önler',
            'Ağız kokusunu giderir',
            'Diş eti sağlığını korur',
            'Plak oluşumunu engeller',
            'Ağız hijyenini destekler'
        ]
    ],
    
    // SALMONOIL - İçerik ekle
    'salmonoil' => [
        'ingredients' => [
            ['name' => 'Omega-3 Yağ Asitleri', 'function' => 'Kardiyovasküler sağlık'],
            ['name' => 'EPA (Eicosapentaenoic Acid)', 'function' => 'İltihap önleyici'],
            ['name' => 'DHA (Docosahexaenoic Acid)', 'function' => 'Beyin ve göz sağlığı'],
            ['name' => 'Vitamin E', 'function' => 'Antioksidan koruma'],
            ['name' => 'Doğal Balık Yağı', 'function' => 'Esansiyel yağ asitleri']
        ]
    ]
];

// Tüm ürünler için genel düzeltmeler
$generalFixes = [
    'benefits' => [
        'Doğal içeriklerle üretilmiştir',
        'Veteriner hekim onaylıdır',
        'Yan etki riski düşüktür',
        'Kolay kullanım sağlar',
        'Uzun süreli etki gösterir'
    ],
    'faq' => [
        [
            'question' => 'Bu ürün yan etkisi var mı?',
            'answer' => 'Ürün doğal içeriklerden üretilmiştir. Nadir durumlarda hassasiyet reaksiyonu görülebilir. Veteriner hekiminizle görüşerek kullanınız.'
        ],
        [
            'question' => 'Etkisini ne kadar sürede gösterir?',
            'answer' => 'Genellikle 7-14 gün içerisinde etki görülmeye başlar. Durumun ciddiyetine göre bu süre değişebilir.'
        ],
        [
            'question' => 'Hem kedi hem köpek için kullanılabilir mi?',
            'answer' => 'Evet, ürün hem kedi hem de köpekler için güvenle kullanılabilir. Dozaj hayvanın kilosuna göre ayarlanmalıdır.'
        ],
        [
            'question' => 'Gebelik ve emzirme döneminde kullanılabilir mi?',
            'answer' => 'Gebelik ve emzirme döneminde kullanım öncesi mutlaka veteriner hekiminize danışınız.'
        ],
        [
            'question' => 'Diğer ilaçlarla birlikte kullanılabilir mi?',
            'answer' => 'Diğer ilaçlarla birlikte kullanım öncesi veteriner hekiminize danışmanız önerilir.'
        ]
    ]
];

echo "Ürün Tab İçerikleri Düzeltiliyor...\n";
echo "==================================\n\n";

// Özel düzeltmeler
foreach ($fixes as $slug => $fixData) {
    echo "Ürün: $slug\n";
    
    foreach ($fixData as $field => $content) {
        if ($field === 'indications' || $field === 'ingredients') {
            $jsonContent = json_encode($content, JSON_UNESCAPED_UNICODE);
            $sql = "UPDATE products SET $field = ? WHERE slug = ?";
            $result = $db->query($sql, [$jsonContent, $slug]);
            echo "  ✅ $field güncellendi\n";
        }
    }
    echo "\n";
}

// Genel düzeltmeler - tüm ürünler için
echo "Tüm ürünler için genel düzeltmeler:\n";
echo "----------------------------------\n";

// Benefits ekle
$benefitsJson = json_encode($generalFixes['benefits'], JSON_UNESCAPED_UNICODE);
$sql = "UPDATE products SET benefits = ? WHERE benefits IS NULL OR benefits = ''";
$result = $db->query($sql, [$benefitsJson]);
echo "✅ Benefits güncellendi\n";

// FAQ ekle
$faqJson = json_encode($generalFixes['faq'], JSON_UNESCAPED_UNICODE);
$sql = "UPDATE products SET faq = ? WHERE faq IS NULL OR faq = ''";
$result = $db->query($sql, [$faqJson]);
echo "✅ FAQ güncellendi\n";

echo "\nDüzeltme tamamlandı!\n";
?>
