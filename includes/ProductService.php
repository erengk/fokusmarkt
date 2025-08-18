<?php
require_once __DIR__ . '/Language.php';
require_once __DIR__ . '/Database.php';

class ProductService {
    private static $instance = null;
    private $db = null;
    private $lang = null;
    
    private function __construct() {
        $this->db = Database::getInstance();
        $this->lang = Language::getInstance();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    // Ürün detaylarını getir
    public function getProductBySlug($productSlug) {
        // Hardcoded ürün verileri (gerçek uygulamada veritabanından gelecek)
        $products = [
            'o2-care' => [
                'name' => 'O2 Care',
                'description' => 'Solunum sistemi desteği',
                'price' => 89.99,
                'category' => 'solunum-sistemi',
                'benefits' => ['Solunum yollarını açar', 'Nefes almayı kolaylaştırır'],
                'indications' => ['Solunum güçlüğü', 'Öksürük', 'Burun tıkanıklığı'],
                'warnings' => ['Veteriner kontrolünde kullanın'],
                'ingredients' => [
                    ['name' => 'Vitamin C', 'function' => 'Bağışıklık sistemi desteği'],
                    ['name' => 'Echinacea', 'function' => 'Doğal bağışıklık güçlendirici'],
                    ['name' => 'Propolis', 'function' => 'Antibakteriyel etki']
                ]
            ],
            'canivir' => [
                'name' => 'Canivir',
                'description' => 'Bağışıklık sistemi desteği',
                'price' => 129.99,
                'category' => 'immunoterapi',
                'benefits' => ['Bağışıklığı güçlendirir', 'Viral enfeksiyonlara karşı korur'],
                'indications' => ['Bağışıklık zayıflığı', 'Viral enfeksiyonlar'],
                'warnings' => ['Hamilelikte kullanmayın'],
                'ingredients' => [
                    ['name' => 'Lizin', 'function' => 'Amino asit desteği'],
                    ['name' => 'Vitamin D', 'function' => 'Bağışıklık sistemi desteği'],
                    ['name' => 'Çinko', 'function' => 'Mineral desteği']
                ]
            ],
            'felovir' => [
                'name' => 'Felovir',
                'description' => 'Kedi bağışıklık sistemi desteği',
                'price' => 119.99,
                'category' => 'immunoterapi',
                'benefits' => ['Kedi bağışıklığını güçlendirir', 'Viral enfeksiyonlara karşı korur'],
                'indications' => ['Kedi bağışıklık zayıflığı', 'Viral enfeksiyonlar'],
                'warnings' => ['Veteriner kontrolünde kullanın'],
                'ingredients' => [
                    ['name' => 'Lizin', 'function' => 'Amino asit desteği'],
                    ['name' => 'Vitamin C', 'function' => 'Bağışıklık sistemi desteği'],
                    ['name' => 'Beta Glukan', 'function' => 'Doğal bağışıklık güçlendirici']
                ]
            ],
            'petimmun' => [
                'name' => 'Petimmun',
                'description' => 'Evcil hayvan bağışıklık sistemi desteği',
                'price' => 99.99,
                'category' => 'immunoterapi',
                'benefits' => ['Genel bağışıklık desteği', 'Enfeksiyonlara karşı koruma'],
                'indications' => ['Bağışıklık zayıflığı', 'Genel sağlık desteği'],
                'warnings' => ['Düzenli kullanım önerilir'],
                'ingredients' => [
                    ['name' => 'Vitamin C', 'function' => 'Bağışıklık sistemi desteği'],
                    ['name' => 'Vitamin E', 'function' => 'Antioksidan etki'],
                    ['name' => 'Selenyum', 'function' => 'Mineral desteği']
                ]
            ],
            'ease-off' => [
                'name' => 'Ease Off',
                'description' => 'Sakinleştirici ve stres azaltıcı',
                'price' => 89.99,
                'category' => 'sakinlestirici',
                'benefits' => ['Stresi azaltır', 'Sakinleştirici etki'],
                'indications' => ['Stres', 'Anksiyete', 'Sakinleştirme ihtiyacı'],
                'warnings' => ['Araç kullanımından önce kullanmayın'],
                'ingredients' => [
                    ['name' => 'L-Theanine', 'function' => 'Sakinleştirici amino asit'],
                    ['name' => 'Papatya', 'function' => 'Doğal sakinleştirici'],
                    ['name' => 'Lavanta', 'function' => 'Stres azaltıcı']
                ]
            ],
            'bladder-control' => [
                'name' => 'Bladder Control',
                'description' => 'İdrar kesesi kontrolü ve sağlığı',
                'price' => 109.99,
                'category' => 'uriner-sistem',
                'benefits' => ['İdrar kesesi sağlığını destekler', 'Kontrolü artırır'],
                'indications' => ['İdrar kaçırma', 'İdrar kesesi problemleri'],
                'warnings' => ['Veteriner kontrolünde kullanın'],
                'ingredients' => [
                    ['name' => 'Cranberry', 'function' => 'İdrar yolu sağlığı'],
                    ['name' => 'D-Mannose', 'function' => 'Bakteri bağlayıcı'],
                    ['name' => 'Vitamin C', 'function' => 'Bağışıklık desteği']
                ]
            ],
            'uticare' => [
                'name' => 'Uticare',
                'description' => 'Üriner sistem sağlığı',
                'price' => 94.99,
                'category' => 'uriner-sistem',
                'benefits' => ['Üriner sistem sağlığını destekler', 'Enfeksiyonlara karşı korur'],
                'indications' => ['Üriner sistem problemleri', 'Enfeksiyon riski'],
                'warnings' => ['Bol su ile kullanın'],
                'ingredients' => [
                    ['name' => 'Cranberry', 'function' => 'Doğal antibakteriyel'],
                    ['name' => 'Vitamin C', 'function' => 'Bağışıklık desteği'],
                    ['name' => 'Çinko', 'function' => 'Mineral desteği']
                ]
            ],
            'renacure' => [
                'name' => 'Renacure',
                'description' => 'Böbrek sağlığı ve fonksiyonu',
                'price' => 124.99,
                'category' => 'bobrek-sagligi',
                'benefits' => ['Böbrek fonksiyonunu destekler', 'Detoks etkisi'],
                'indications' => ['Böbrek problemleri', 'Detoks ihtiyacı'],
                'warnings' => ['Veteriner kontrolünde kullanın'],
                'ingredients' => [
                    ['name' => 'Milk Thistle', 'function' => 'Karaciğer koruyucu'],
                    ['name' => 'Dandelion', 'function' => 'Doğal diüretik'],
                    ['name' => 'Vitamin B', 'function' => 'Enerji metabolizması']
                ]
            ],
            'salmonoil' => [
                'name' => 'Salmon Oil',
                'description' => 'Omega-3 yağ asitleri desteği',
                'price' => 79.99,
                'category' => 'tuy-ve-deri-sagligi',
                'benefits' => ['Cilt ve tüy sağlığını destekler', 'Omega-3 desteği'],
                'indications' => ['Kuru cilt', 'Tüy problemleri', 'Omega-3 eksikliği'],
                'warnings' => ['Balık alerjisi varsa kullanmayın'],
                'ingredients' => [
                    ['name' => 'Omega-3', 'function' => 'Esansiyel yağ asitleri'],
                    ['name' => 'EPA', 'function' => 'Anti-inflamatuar'],
                    ['name' => 'DHA', 'function' => 'Beyin sağlığı']
                ]
            ],
            'retino-a' => [
                'name' => 'Retino-A',
                'description' => 'Cilt sağlığı ve yenilenmesi',
                'price' => 89.99,
                'category' => 'tuy-ve-deri-sagligi',
                'benefits' => ['Cilt yenilenmesini destekler', 'Akne tedavisi'],
                'indications' => ['Akne', 'Cilt problemleri', 'Yenilenme ihtiyacı'],
                'warnings' => ['Güneş ışığından koruyun'],
                'ingredients' => [
                    ['name' => 'Retinol', 'function' => 'Cilt yenileyici'],
                    ['name' => 'Vitamin A', 'function' => 'Cilt sağlığı'],
                    ['name' => 'Aloe Vera', 'function' => 'Yatıştırıcı etki']
                ]
            ],
            'phytospan' => [
                'name' => 'Phytospan',
                'description' => 'Bitkisel solunum sistemi desteği',
                'price' => 84.99,
                'category' => 'solunum-sistemi',
                'benefits' => ['Solunum yollarını açar', 'Bitkisel destek'],
                'indications' => ['Solunum problemleri', 'Öksürük', 'Soğuk algınlığı'],
                'warnings' => ['Alerjik reaksiyon riski'],
                'ingredients' => [
                    ['name' => 'Echinacea', 'function' => 'Doğal bağışıklık güçlendirici'],
                    ['name' => 'Thyme', 'function' => 'Solunum yolu açıcı'],
                    ['name' => 'Honey', 'function' => 'Doğal antibakteriyel']
                ]
            ],
            'multivit' => [
                'name' => 'Multivit',
                'description' => 'Çoklu vitamin ve mineral desteği',
                'price' => 69.99,
                'category' => 'kemik-sagligi',
                'benefits' => ['Genel sağlık desteği', 'Vitamin eksikliği giderici'],
                'indications' => ['Vitamin eksikliği', 'Genel sağlık desteği'],
                'warnings' => ['Aşırı doz kullanmayın'],
                'ingredients' => [
                    ['name' => 'Vitamin A', 'function' => 'Görme sağlığı'],
                    ['name' => 'Vitamin D', 'function' => 'Kemik sağlığı'],
                    ['name' => 'Vitamin E', 'function' => 'Antioksidan']
                ]
            ],
            'm-b-care' => [
                'name' => 'M&B Care',
                'description' => 'Gebelik ve emzirme dönemi desteği',
                'price' => 114.99,
                'category' => 'gebelik-ve-emzirme-sagligi',
                'benefits' => ['Gebelik dönemi desteği', 'Emzirme kalitesini artırır'],
                'indications' => ['Gebelik dönemi', 'Emzirme dönemi'],
                'warnings' => ['Veteriner kontrolünde kullanın'],
                'ingredients' => [
                    ['name' => 'Folic Acid', 'function' => 'Gebelik desteği'],
                    ['name' => 'Iron', 'function' => 'Demir desteği'],
                    ['name' => 'Calcium', 'function' => 'Kalsiyum desteği']
                ]
            ],
            'dermacumin' => [
                'name' => 'Dermacumin',
                'description' => 'Cilt ve tüy sağlığı',
                'price' => 94.99,
                'category' => 'tuy-ve-deri-sagligi',
                'benefits' => ['Cilt sağlığını destekler', 'Tüy kalitesini artırır'],
                'indications' => ['Cilt problemleri', 'Tüy problemleri'],
                'warnings' => ['Düzenli kullanım önerilir'],
                'ingredients' => [
                    ['name' => 'Biotin', 'function' => 'Tüy sağlığı'],
                    ['name' => 'Zinc', 'function' => 'Cilt sağlığı'],
                    ['name' => 'Omega-6', 'function' => 'Esansiyel yağ asitleri']
                ]
            ],
            'derma-zn' => [
                'name' => 'Derma-Zn',
                'description' => 'Çinko destekli cilt sağlığı',
                'price' => 79.99,
                'category' => 'tuy-ve-deri-sagligi',
                'benefits' => ['Çinko desteği', 'Cilt sağlığını destekler'],
                'indications' => ['Çinko eksikliği', 'Cilt problemleri'],
                'warnings' => ['Aşırı doz kullanmayın'],
                'ingredients' => [
                    ['name' => 'Zinc', 'function' => 'Cilt sağlığı'],
                    ['name' => 'Vitamin C', 'function' => 'Antioksidan'],
                    ['name' => 'Copper', 'function' => 'Mineral dengesi']
                ]
            ],
            'derma-hairball' => [
                'name' => 'Derma Hairball',
                'description' => 'Tüy yumağı kontrolü ve cilt sağlığı',
                'price' => 89.99,
                'category' => 'tuy-ve-deri-sagligi',
                'benefits' => ['Tüy yumağı oluşumunu önler', 'Cilt sağlığını destekler'],
                'indications' => ['Tüy yumağı problemi', 'Cilt problemleri'],
                'warnings' => ['Düzenli taranma önerilir'],
                'ingredients' => [
                    ['name' => 'Psyllium', 'function' => 'Sindirim desteği'],
                    ['name' => 'Fish Oil', 'function' => 'Omega-3 desteği'],
                    ['name' => 'Vitamin E', 'function' => 'Cilt sağlığı']
                ]
            ],
            'dental-care' => [
                'name' => 'Dental Care',
                'description' => 'Ağız ve diş sağlığı',
                'price' => 79.99,
                'category' => 'agiz-ve-dis-sagligi',
                'benefits' => ['Diş taşını önler', 'Ağız kokusunu giderir'],
                'indications' => ['Diş taşı', 'Ağız kokusu', 'Diş eti problemleri'],
                'warnings' => ['Düzenli diş fırçalama ile birlikte kullanın'],
                'ingredients' => [
                    ['name' => 'Klorofil', 'function' => 'Doğal temizleyici'],
                    ['name' => 'Mentol', 'function' => 'Ferahlatıcı etki'],
                    ['name' => 'Kalsiyum', 'function' => 'Diş sağlığı desteği']
                ]
            ],
            'coprophagia' => [
                'name' => 'Coprophagia',
                'description' => 'Dışkı yeme davranışı kontrolü',
                'price' => 84.99,
                'category' => 'diski-yeme',
                'benefits' => ['Dışkı yeme davranışını azaltır', 'Sindirim sağlığını destekler'],
                'indications' => ['Dışkı yeme davranışı', 'Sindirim problemleri'],
                'warnings' => ['Davranış değişikliği zaman alabilir'],
                'ingredients' => [
                    ['name' => 'Probiotics', 'function' => 'Sindirim sağlığı'],
                    ['name' => 'Enzymes', 'function' => 'Sindirim desteği'],
                    ['name' => 'Fiber', 'function' => 'Bağırsak sağlığı']
                ]
            ],
            'cartilagoflex' => [
                'name' => 'Cartilagoflex',
                'description' => 'Eklem sağlığı ve esnekliği',
                'price' => 119.99,
                'category' => 'eklem-sagligi',
                'benefits' => ['Eklem esnekliğini artırır', 'Eklem sağlığını destekler'],
                'indications' => ['Eklem problemleri', 'Hareket zorluğu'],
                'warnings' => ['Düzenli egzersiz ile birlikte kullanın'],
                'ingredients' => [
                    ['name' => 'Glucosamine', 'function' => 'Eklem sağlığı'],
                    ['name' => 'Chondroitin', 'function' => 'Kıkırdak desteği'],
                    ['name' => 'MSM', 'function' => 'Sülfür desteği']
                ]
            ]
        ];
        
        $product = $products[$productSlug] ?? null;
        if (!$product) {
            return null;
        }
        
        // Dil paketinden çevirileri uygula
        $translatedName = $this->lang->get("products.{$productSlug}.name");
        if ($translatedName && $translatedName !== "products.{$productSlug}.name") {
            $product['name'] = $translatedName;
        }
        
        return $product;
    }
    
    // Ürün görsellerini getir
    public function getProductImagesBySlug($productSlug) {
        $images = [];
        $basePath = "assets/products/{$this->lang->getCurrentLang()}";
        
        // Ürün slug'ını dosya sistemi formatına çevir
        $fileSystemSlug = str_replace(['-', '_'], '_', $productSlug);
        
        // Alt klasörleri tara (malt, tablet, jel, vb.)
        $productPath = $basePath . '/' . $fileSystemSlug;
        if (is_dir($productPath)) {
            $subFolders = scandir($productPath);
            foreach ($subFolders as $subFolder) {
                if ($subFolder === '.' || $subFolder === '..') continue;
                
                $fullPath = $productPath . '/' . $subFolder;
                if (is_dir($fullPath)) {
                    $files = scandir($fullPath);
                    foreach ($files as $file) {
                        if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                            $images[] = [
                                'filename' => $file,
                                'path' => $fullPath . '/' . $file,
                                'url' => '/' . $fullPath . '/' . $file,
                                'product' => $productSlug,
                                'form' => $subFolder
                            ];
                        }
                    }
                }
            }
        }
        
        return $images;
    }
    
    // Kategoriye göre ürünleri getir
    public function getProductsByCategory($category) {
        // CategoryService'i kullan
        $categoryService = CategoryService::getInstance();
        return $categoryService->getProductsByCategory($category);
    }
    
    // İlgili ürünleri getir
    public function getRelatedProducts($productSlug, $limit = 4) {
        $product = $this->getProductBySlug($productSlug);
        if (!$product) return [];
        
        $category = $product['category'];
        $categoryProducts = $this->getProductsByCategory($category);
        
        // Aynı ürünü hariç tut
        $related = array_filter($categoryProducts, function($p) use ($productSlug) {
            return $p['slug'] !== $productSlug;
        });
        
        return array_slice($related, 0, $limit);
    }
}
?>
