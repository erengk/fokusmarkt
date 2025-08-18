<?php
require_once __DIR__ . '/Language.php';
require_once __DIR__ . '/Database.php';

class CategoryService {
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
    
    // Kategori listesini getir
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
    
    // Kategori bilgilerini getir
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
    
    // Kategori adını getir (dil desteği ile)
    public function getCategoryName($category) {
        // Önce dil paketinden çeviri dene
        $translatedName = $this->lang->get("category.{$category}");
        
        if ($translatedName && $translatedName !== "category.{$category}") {
            return $translatedName;
        }
        
        // Dil paketinde yoksa veritabanından al
        $info = $this->getCategoryInfo($category);
        return $info['name'] ?? $category;
    }
    
    // Kategori açıklamasını getir
    public function getCategoryDescription($category) {
        $info = $this->getCategoryInfo($category);
        return $info['description'] ?? '';
    }
    
    // Alt kategorileri getir
    public function getSubcategories($category) {
        // Şimdilik boş döndür, alt kategoriler yok
        return [];
    }
    
    // Kategoriye göre ürünleri getir
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
        $products = [];
        
        foreach ($productSlugs as $slug) {
            $products[] = [
                'slug' => $slug,
                'name' => ucwords(str_replace(['-', '_'], ' ', $slug))
            ];
        }
        
        return $products;
    }
    
    // Kategori görsellerini getir
    public function getCategoryImages($category) {
        $allImages = [];
        $products = $this->getProductsByCategory($category);
        
        foreach ($products as $product) {
            $productSlug = $product['slug'];
            $fileSystemSlug = str_replace(['-', '_'], '_', $productSlug);
            $basePath = "assets/products/{$this->lang->getCurrentLang()}/{$fileSystemSlug}";
            
            if (is_dir($basePath)) {
                $subFolders = scandir($basePath);
                foreach ($subFolders as $subFolder) {
                    if ($subFolder === '.' || $subFolder === '..') continue;
                    
                    $fullPath = $basePath . '/' . $subFolder;
                    if (is_dir($fullPath)) {
                        $files = scandir($fullPath);
                        foreach ($files as $file) {
                            if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                $allImages[] = [
                                    'filename' => $file,
                                    'path' => $fullPath . '/' . $file,
                                    'url' => '/' . $fullPath . '/' . $file,
                                    'alt' => $product['name'] . ' - ' . $subFolder,
                                    'product' => $productSlug,
                                    'form' => $subFolder
                                ];
                            }
                        }
                    }
                }
            }
        }
        
        // Maksimum 5 görsel göster (performans için)
        shuffle($allImages);
        return array_slice($allImages, 0, 5);
    }
    
    // Tüm kategorileri bilgileriyle getir
    public function getAllCategoriesWithInfo() {
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
        
        $categories = [];
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
    }
}
?>
