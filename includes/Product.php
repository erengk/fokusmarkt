<?php
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
        
        // Ürün slug'ını dosya yoluna çevir (örn: dental-care -> dental_care)
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
                        // Sadece ürün görsellerini al, rehber dosyalarını alma
                        if (!str_contains(strtolower($file), 'rehber')) {
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
        
        // Maksimum 5 görsel göster (performans için)
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
    
    // Kategoriye göre ürünleri getir
    public function getProductsByCategory($category) {
        $products = $this->db->fetchAll("
            SELECT p.id, p.name, p.slug, p.description, p.short_description
            FROM products p
            JOIN product_categories pc ON p.id = pc.product_id
            JOIN categories c ON pc.category_id = c.id
            WHERE c.slug = ? AND p.is_active = 1
            ORDER BY p.sort_order, p.name
        ", [$category]);
        
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
    
    // Güncellenmiş kategori bilgilerini getir
    public function getAllCategoriesWithInfo() {
        $categories = [];
        $dbCategories = $this->db->fetchAll("
            SELECT c.slug, c.name, c.description, c.sort_order,
                   COUNT(pc.product_id) as product_count
            FROM categories c
            LEFT JOIN product_categories pc ON c.id = pc.category_id
            WHERE c.is_active = 1
            GROUP BY c.id, c.slug, c.name, c.description, c.sort_order
            ORDER BY c.sort_order
        ");
        
        foreach ($dbCategories as $category) {
            $categories[$category['slug']] = [
                'name' => $category['name'],
                'description' => $category['description'],
                'subcategories' => [], // Şimdilik boş
                'url' => "/kategoriler/{$category['slug']}",
                'image_count' => $category['product_count'],
                'product_count' => $category['product_count']
            ];
        }
        
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
}
?>
