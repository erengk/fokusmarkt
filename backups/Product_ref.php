<?php
require_once __DIR__ . '/Language.php';
require_once __DIR__ . '/Database.php';

class Product {
    private static $instance = null;
    private $config = [];
    private $currentLang = 'tr';
    private $db = null;
    
    private function __construct() {
        $this->loadConfig();
        $this->setLanguage();
        $this->db = Database::getInstance();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function loadConfig() {
        $configFile = __DIR__ . '/../config/products.json';
        if (file_exists($configFile)) {
            $this->config = json_decode(file_get_contents($configFile), true);
        }
    }
    
    private function setLanguage() {
        $lang = Language::getInstance();
        $this->currentLang = $lang->getCurrentLang();
    }
    
    // Veritabanından kategorileri getir
    public function getCategories() {
        $categories = $this->db->fetchAll("
            SELECT slug, name, description, sort_order 
            FROM categories 
            WHERE is_active = 1 
            ORDER BY sort_order
        ");
        
        $result = [];
        foreach ($categories as $category) {
            $result[] = $category['slug'];
        }
        return $result;
    }
    
    public function getCategoryInfo($category) {
        $categoryData = $this->db->fetchOne("
            SELECT name, description, slug 
            FROM categories 
            WHERE slug = ? AND is_active = 1
        ", [$category]);
        
        if ($categoryData) {
            return [
                'name' => $categoryData['name'],
                'description' => $categoryData['description'],
                'slug' => $categoryData['slug']
            ];
        }
        
        return null;
    }
    
    public function getCategoryName($category) {
        // Önce dil paketinden çeviri dene
        $lang = Language::getInstance();
        $translatedName = $lang->get("category.{$category}");
        
        if ($translatedName && $translatedName !== "category.{$category}") {
            return $translatedName;
        }
        
        // Dil paketinde yoksa veritabanından al
        $info = $this->getCategoryInfo($category);
        return $info['name'] ?? $category;
    }
    
    public function getCategoryDescription($category) {
        $info = $this->getCategoryInfo($category);
        return $info['description'] ?? '';
    }
    
    public function getSubcategories($category) {
        // Şimdilik boş döndür, alt kategoriler yok
        return [];
    }
    
    public function getPetTypes() {
        $species = $this->db->fetchAll("
            SELECT slug, name 
            FROM species 
            WHERE is_active = 1 
            ORDER BY id
        ");
        
        $types = [];
        $lang = Language::getInstance();
        
        foreach ($species as $specie) {
            // Dil paketinden çeviri dene
            $translatedName = $lang->get("pet_types.{$specie['slug']}");
            if ($translatedName && $translatedName !== "pet_types.{$specie['slug']}") {
                $types[$specie['slug']] = $translatedName;
            } else {
                $types[$specie['slug']] = $specie['name'];
            }
        }
        
        return $types;
    }
    
    public function getPetTypeName($type) {
        $specie = $this->db->fetchOne("
            SELECT name FROM species WHERE slug = ? AND is_active = 1
        ", [$type]);
        
        return $specie['name'] ?? $type;
    }
    
    public function getProductsPath($category = null, $subcategory = null, $petType = null) {
        $path = "assets/products/{$this->currentLang}";
        
        if ($category) {
            $path .= "/{$category}";
        }
        
        if ($subcategory) {
            $path .= "/{$subcategory}";
        }
        
        if ($petType) {
            $path .= "/{$petType}";
        }
        
        return $path;
    }
    
    public function getProductImages($category = null, $subcategory = null, $petType = null) {
        $path = $this->getProductsPath($category, $subcategory, $petType);
        $images = [];
        
        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $file) {
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $images[] = [
                        'filename' => $file,
                        'path' => $path . '/' . $file,
                        'url' => '/' . $path . '/' . $file
                    ];
                }
            }
        }
        
        return $images;
    }
    

    
    // Ürün slug'ına göre görselleri getir
    public function getProductImagesBySlug($productSlug) {
        $images = [];
        
        // Ürün slug'ını dosya yoluna çevir (örn: dental-care -> dental_care, o2-care -> o2_care)
        $productPath = str_replace('-', '_', $productSlug);
        $basePath = "assets/products/{$this->currentLang}/{$productPath}";
        
        // Alt klasörleri kontrol et (tablet, malt, jel)
        $subFolders = ['tablet', 'malt', 'jel'];
        
        foreach ($subFolders as $subFolder) {
            $fullPath = $basePath . '/' . $subFolder;
            if (is_dir($fullPath)) {
                $files = scandir($fullPath);
                foreach ($files as $file) {
                    if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                        // Tüm görselleri al (rehber dahil)
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
        
        return $images;
    }
    
    // Kategori için ana görsel getir
    public function getCategoryMainImage($categorySlug) {
        $images = $this->getCategoryImages($categorySlug);
        
        if (!empty($images)) {
            // İlk görseli döndür
            return $images[0];
        }
        
        return null;
    }
    
    // Kategori için tüm ürün görsellerini getir (slayt için)
    public function getCategoryImages($categorySlug) {
        // Önce kategoriye ait ürünleri al
        $products = $this->getProductsByCategory($categorySlug);
        $allImages = [];
        
        foreach ($products as $productSlug => $productData) {
            // Her ürün için görselleri al
            $productImages = $this->getProductImagesBySlug($productSlug);
            
            foreach ($productImages as $image) {
                $allImages[] = [
                    'url' => $image['url'],
                    'alt' => $productData['name'] . ' - ' . $image['form'],
                    'product' => $productSlug,
                    'form' => $image['form']
                ];
            }
        }
        
        // Görselleri karıştır ve maksimum 5 görsel göster (performans için)
        shuffle($allImages);
        return array_slice($allImages, 0, 5);
    }
    
    public function getProductForms() {
        $forms = [];
        foreach ($this->config['product_forms'] ?? [] as $key => $names) {
            $forms[$key] = $names[$this->currentLang] ?? $key;
        }
        return $forms;
    }
    
    public function getProductFormName($form) {
        return $this->config['product_forms'][$form][$this->currentLang] ?? $form;
    }
    
    // Veritabanından ürünleri getir
    public function getProducts() {
        $products = $this->db->fetchAll("
            SELECT id, name, slug, description, short_description, is_active, sort_order
            FROM products 
            WHERE is_active = 1 
            ORDER BY sort_order, name
        ");
        
        $result = [];
        foreach ($products as $product) {
            $result[$product['slug']] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'description' => $product['description'],
                'short_description' => $product['short_description']
            ];
        }
        
        return $result;
    }
    
    public function getProductInfo($productName) {
        $product = $this->db->fetchOne("
            SELECT id, name, slug, description, short_description, active_ingredients, benefits, dosage_instructions, faq
            FROM products 
            WHERE slug = ? AND is_active = 1
        ", [$productName]);
        
        return $product;
    }
    
    // Kategoriye göre ürünleri getir (dosya sisteminden)
    public function getProductsByCategory($category) {
        // Kategori-ürün eşleştirmesi (verilen listeye göre)
        $categoryProductMap = [
            'eklem-sagligi' => ['cartilagoflex'],
            'immunoterapi' => ['canivir', 'felovir', 'petimmun'],
            'sakinlestirici' => ['ease-off'],
            'uriner-sistem' => ['bladder-control', 'uticare'],
            'tuy-ve-deri-sagligi' => ['dermacumin', 'retino-a', 'derma-zn', 'derma-hairball', 'salmonoil'],
            'bobrek-sagligi' => ['renacure'],
            'sindirim-sistemi' => ['canivir', 'coprophagia', 'petimmun', 'derma-hairball'],
            'solunum-sistemi' => ['o2-care', 'phytospan'],
            'kemik-sagligi' => ['multivit'],
            'gebelik-ve-emzirme-sagligi' => ['m-b-care'],
            'diski-yeme' => ['coprophagia'],
            'soguk-alginligi' => ['phytospan', 'petimmun', 'o2-care'],
            'agiz-ve-dis-sagligi' => ['dental-care']
        ];
        
        $productSlugs = $categoryProductMap[$category] ?? [];
        $result = [];
        
        foreach ($productSlugs as $productSlug) {
            $result[$productSlug] = [
                'name' => ucwords(str_replace(['-', '_'], ' ', $productSlug)),
                'slug' => $productSlug,
                'description' => 'Ürün açıklaması'
            ];
        }
        
        return $result;
    }
    
    public function getProductsByForm($form) {
        $products = $this->db->fetchAll("
            SELECT DISTINCT p.id, p.name, p.slug, p.description, p.short_description
            FROM products p
            JOIN product_variants pv ON p.id = pv.product_id
            WHERE pv.name = ? AND p.is_active = 1 AND pv.is_active = 1
            ORDER BY p.sort_order, p.name
        ", [$form]);
        
        $result = [];
        foreach ($products as $product) {
            $result[$product['slug']] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'description' => $product['description'],
                'short_description' => $product['short_description']
            ];
        }
        
        return $result;
    }
    
    public function getCategoryBreadcrumb($category, $subcategory = null) {
        $breadcrumb = [];
        
        // Ana sayfa
        $breadcrumb[] = [
            'name' => $this->getTranslation('home'),
            'url' => '/'
        ];
        
        // Kategori
        if ($category) {
            $categoryInfo = $this->getCategoryInfo($category);
            $breadcrumb[] = [
                'name' => $categoryInfo['name'] ?? $category,
                'url' => "/kategoriler/{$category}"
            ];
        }
        
        // Alt kategori
        if ($subcategory) {
            $subcategories = $this->getSubcategories($category);
            $subcategoryName = $subcategories[$subcategory] ?? $subcategory;
            $breadcrumb[] = [
                'name' => $subcategoryName,
                'url' => "/kategoriler/{$category}/{$subcategory}"
            ];
        }
        
        return $breadcrumb;
    }
    
    public function getTranslation($key) {
        $lang = Language::getInstance();
        return $lang->get($key);
    }
    
    public function getCurrentLang() {
        return $this->currentLang;
    }
    
    // Güncellenmiş kategori bilgilerini getir (dosya sisteminden)
    public function getAllCategoriesWithInfo() {
        $categories = [];
        
        // Kategori listesi (verilen listeye göre)
        $categoryList = [
            'eklem-sagligi' => ['name' => 'Eklem Sağlığı', 'description' => 'Eklem sağlığı için ürünler', 'sort_order' => 1],
            'immunoterapi' => ['name' => 'İmmunoterapi', 'description' => 'Bağışıklık sistemi için ürünler', 'sort_order' => 2],
            'sakinlestirici' => ['name' => 'Sakinleştirici', 'description' => 'Sakinleştirici ürünler', 'sort_order' => 3],
            'uriner-sistem' => ['name' => 'Üriner Sistem', 'description' => 'Üriner sistem sağlığı için ürünler', 'sort_order' => 4],
            'tuy-ve-deri-sagligi' => ['name' => 'Tüy ve Deri Sağlığı', 'description' => 'Tüy ve deri sağlığı için ürünler', 'sort_order' => 5],
            'bobrek-sagligi' => ['name' => 'Böbrek Sağlığı', 'description' => 'Böbrek sağlığı için ürünler', 'sort_order' => 6],
            'sindirim-sistemi' => ['name' => 'Sindirim Sistemi', 'description' => 'Sindirim sistemi sağlığı için ürünler', 'sort_order' => 7],
            'solunum-sistemi' => ['name' => 'Solunum Sistemi', 'description' => 'Solunum sistemi sağlığı için ürünler', 'sort_order' => 8],
            'kemik-sagligi' => ['name' => 'Kemik Sağlığı', 'description' => 'Kemik sağlığı için ürünler', 'sort_order' => 9],
            'gebelik-ve-emzirme-sagligi' => ['name' => 'Gebelik ve Emzirme Sağlığı', 'description' => 'Gebelik ve emzirme dönemi için ürünler', 'sort_order' => 10],
            'diski-yeme' => ['name' => 'Dışkı Yeme', 'description' => 'Dışkı yeme davranışı için ürünler', 'sort_order' => 11],
            'soguk-alginligi' => ['name' => 'Soğuk Algınlığı', 'description' => 'Soğuk algınlığı için ürünler', 'sort_order' => 12],
            'agiz-ve-dis-sagligi' => ['name' => 'Ağız ve Diş Sağlığı', 'description' => 'Ağız ve diş sağlığı için ürünler', 'sort_order' => 13]
        ];
        
        foreach ($categoryList as $slug => $info) {
            // Kategori için ürün sayısını hesapla
            $products = $this->getProductsByCategory($slug);
            $productCount = count($products);
            
            $categories[$slug] = [
                'name' => $info['name'],
                'description' => $info['description'],
                'subcategories' => [], // Şimdilik boş
                'url' => "/kategoriler/{$slug}",
                'image_count' => $productCount,
                'product_count' => $productCount
            ];
        }
        
        // Sort order'a göre sırala
        $sortedCategories = [];
        foreach ($categoryList as $slug => $info) {
            if (isset($categories[$slug])) {
                $sortedCategories[$slug] = $categories[$slug];
            }
        }
        
        return $sortedCategories;
        
        return $categories;
    }
    
    public function searchProducts($query) {
        $results = [];
        $categories = $this->getCategories();
        
        foreach ($categories as $category) {
            $products = $this->getProductsByCategory($category);
            foreach ($products as $productName => $productInfo) {
                if (stripos($productInfo['name'], $query) !== false || 
                    stripos($productInfo['description'], $query) !== false) {
                    $results[] = [
                        'category' => $category,
                        'product' => $productInfo
                    ];
                }
            }
        }
        
        return $results;
    }
    
    // Yeni metodlar
    public function getProductVariants($productSlug) {
        $variants = $this->db->fetchAll("
            SELECT id, name, description, price, weight, is_active, sort_order
            FROM product_variants pv
            JOIN products p ON pv.product_id = p.id
            WHERE p.slug = ? AND pv.is_active = 1
            ORDER BY pv.sort_order
        ", [$productSlug]);
        
        return $variants;
    }
    
    public function getProductCategories($productSlug) {
        $categories = $this->db->fetchAll("
            SELECT c.name, c.slug, c.description
            FROM categories c
            JOIN product_categories pc ON c.id = pc.category_id
            JOIN products p ON pc.product_id = p.id
            WHERE p.slug = ? AND c.is_active = 1
            ORDER BY c.sort_order
        ", [$productSlug]);
        
        return $categories;
    }
    
    public function getProductIndications($productSlug) {
        $indications = $this->db->fetchAll("
            SELECT i.name, i.slug, i.description, i.symptoms
            FROM indications i
            JOIN product_indications pi ON i.id = pi.indication_id
            JOIN products p ON pi.product_id = p.id
            WHERE p.slug = ? AND i.is_active = 1
            ORDER BY i.name
        ", [$productSlug]);
        
        return $indications;
    }
    
    public function getProductSpecies($productSlug) {
        $species = $this->db->fetchAll("
            SELECT s.name, s.slug, s.description
            FROM species s
            JOIN product_species ps ON s.id = ps.species_id
            JOIN products p ON ps.product_id = p.id
            WHERE p.slug = ? AND s.is_active = 1
            ORDER BY s.name
        ", [$productSlug]);
        
        $lang = Language::getInstance();
        
        // Dil paketinden çevirileri uygula
        foreach ($species as &$specie) {
            $translatedName = $lang->get("pet_types.{$specie['slug']}");
            if ($translatedName && $translatedName !== "pet_types.{$specie['slug']}") {
                $specie['name'] = $translatedName;
            }
        }
        
        return $species;
    }
    
    public function getProductBySlug($productSlug) {
        // Ürün slug'ını dosya sistemindeki formata çevir
        $productPath = str_replace('-', '_', $productSlug);
        
        // Dil paketinden çevirileri uygula
        $lang = Language::getInstance();
        
        // Ürün ismi için çeviri dene
        $translatedName = $lang->get("products.{$productSlug}.name");
        if ($translatedName && $translatedName !== "products.{$productSlug}.name") {
            $productName = $translatedName;
        } else {
            // Çeviri yoksa slug'dan ürün ismi oluştur
            $productName = ucwords(str_replace(['-', '_'], ' ', $productSlug));
        }
        
        // Ürün açıklaması için çeviri dene
        $translatedDesc = $lang->get("products.{$productSlug}.description");
        if ($translatedDesc && $translatedDesc !== "products.{$productSlug}.description") {
            $productDesc = $translatedDesc;
        } else {
            $productDesc = "Bu ürün evcil hayvanlarınızın sağlığı için özel olarak formüle edilmiştir.";
        }
        
        // Kategori bilgisini belirle (ürün slug'ına göre)
        $categoryMap = [
            'cartilagoflex' => 'eklem-sagligi',
            'canivir' => 'immunoterapi',
            'felovir' => 'immunoterapi',
            'petimmun' => 'immunoterapi',
            'ease-off' => 'sakinlestirici',
            'bladder-control' => 'uriner-sistem',
            'uticare' => 'uriner-sistem',
            'renacure' => 'bobrek-sagligi',
            'salmonoil' => 'tuy-ve-deri-sagligi',
            'retino-a' => 'tuy-ve-deri-sagligi',
            'phytospan' => 'solunum-sistemi',
            'multivit' => 'eklem-sagligi',
            'm-b-care' => 'gebelik-ve-emzirme-sagligi',
            'dermacumin' => 'tuy-ve-deri-sagligi',
            'derma-zn' => 'tuy-ve-deri-sagligi',
            'derma-hairball' => 'tuy-ve-deri-sagligi',
            'dental-care' => 'agiz-ve-dis-sagligi',
            'coprophagia' => 'diski-yeme',
            'o2-care' => 'solunum-sistemi'
        ];
        
        $category = $categoryMap[$productSlug] ?? 'genel';
        
        // Varsayılan fiyat ve diğer bilgiler
        $product = [
            'name' => $productName,
            'description' => $productDesc,
            'price' => 150.00,
            'old_price' => 180.00,
            'slug' => $productSlug,
            'sku' => strtoupper($productSlug),
            'weight' => '100ml',
            'form' => 'Tablet',
            'shelf_life' => '24 ay',
            'storage' => 'Serin ve kuru yerde saklayınız',
            'dosage' => 'Her 5 kg vücut ağırlığı için 1 ml',
            'frequency' => 'Günde 2 kez, yemekle birlikte',
            'category' => $category,
            'benefits' => [
                'Doğal içerikler',
                'Veteriner onaylı',
                'Kolay kullanım',
                'Etkili sonuçlar'
            ],
            'indications' => [
                ['name' => 'Genel sağlık desteği', 'description' => 'Evcil hayvanlarınızın genel sağlığını destekler']
            ],
            'warnings' => [
                'Veteriner kontrolünde kullanınız',
                'Çocukların ulaşamayacağı yerde saklayınız'
            ],
            'ingredients' => [
                ['name' => 'Vitamin C', 'function' => 'Bağışıklık sistemi desteği'],
                ['name' => 'Vitamin E', 'function' => 'Antioksidan etki'],
                ['name' => 'Omega-3', 'function' => 'Cilt ve tüy sağlığı']
            ]
        ];
        
        return $product;
    }
    

    
    public function getProductWarnings($productSlug) {
        $warnings = $this->db->fetchAll("
            SELECT w.warning_text
            FROM product_warnings w
            JOIN products p ON w.product_id = p.id
            WHERE p.slug = ? AND w.is_active = 1
            ORDER BY w.sort_order
        ", [$productSlug]);
        
        $result = [];
        foreach ($warnings as $warning) {
            $result[] = $warning['warning_text'];
        }
        
        return $result;
    }
    
    public function getProductBenefits($productSlug) {
        $benefits = $this->db->fetchAll("
            SELECT b.benefit_text
            FROM product_benefits b
            JOIN products p ON b.product_id = p.id
            WHERE p.slug = ? AND b.is_active = 1
            ORDER BY b.sort_order
        ", [$productSlug]);
        
        $result = [];
        foreach ($benefits as $benefit) {
            $result[] = $benefit['benefit_text'];
        }
        
        return $result;
    }
    
    public function getProductIngredients($productSlug) {
        $ingredients = $this->db->fetchAll("
            SELECT i.ingredient_name as name, i.function_description as function
            FROM product_ingredients i
            JOIN products p ON i.product_id = p.id
            WHERE p.slug = ? AND i.is_active = 1
            ORDER BY i.sort_order
        ", [$productSlug]);
        
        return $ingredients;
    }
    
    public function getRelatedProducts($productSlug, $categorySlug, $limit = 4) {
        $related = $this->db->fetchAll("
            SELECT p.id, p.name, p.price, p.slug, pi.image_url as image
            FROM products p
            JOIN product_categories pc ON p.id = pc.product_id
            JOIN categories c ON pc.category_id = c.id
            LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.sort_order = 1
            WHERE c.slug = ? AND p.slug != ? AND p.is_active = 1
            ORDER BY RAND()
            LIMIT ?
        ", [$categorySlug, $productSlug, $limit]);
        
        return $related;
    }
}
?>
