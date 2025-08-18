<?php
require_once __DIR__ . '/Language.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/CategoryService.php';

class NavigationService {
    private static $instance = null;
    private $db = null;
    private $lang = null;
    private $categoryService = null;
    
    private function __construct() {
        $this->db = Database::getInstance();
        $this->lang = Language::getInstance();
        $this->categoryService = CategoryService::getInstance();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    // Breadcrumb oluştur
    public function getCategoryBreadcrumb($category, $subcategory = null) {
        $breadcrumb = [];
        
        // Ana sayfa
        $breadcrumb[] = [
            'name' => $this->getTranslation('home'),
            'url' => '/'
        ];
        
        // Kategori
        if ($category) {
            $categoryInfo = $this->categoryService->getCategoryInfo($category);
            $breadcrumb[] = [
                'name' => $categoryInfo['name'] ?? $category,
                'url' => "/kategoriler/{$category}"
            ];
        }
        
        // Alt kategori
        if ($subcategory) {
            $subcategories = $this->categoryService->getSubcategories($category);
            $subcategoryName = $subcategories[$subcategory] ?? $subcategory;
            $breadcrumb[] = [
                'name' => $subcategoryName,
                'url' => "/kategoriler/{$category}/{$subcategory}"
            ];
        }
        
        return $breadcrumb;
    }
    
    // Ürün path'i oluştur
    public function getProductsPath($category = null, $subcategory = null, $petType = null) {
        $path = "assets/products/{$this->lang->getCurrentLang()}";
        
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
    
    // Çeviri getir
    public function getTranslation($key) {
        return $this->lang->get($key);
    }
}
?>
