<?php
require_once __DIR__ . '/Language.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/CategoryService.php';

class SearchService {
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
    
    // Ürün arama
    public function searchProducts($query) {
        $results = [];
        $categories = $this->categoryService->getCategories();
        
        foreach ($categories as $category) {
            $products = $this->categoryService->getProductsByCategory($category);
            foreach ($products as $product) {
                if (stripos($product['name'], $query) !== false || 
                    stripos($product['description'] ?? '', $query) !== false) {
                    $results[] = [
                        'category' => $category,
                        'product' => $product
                    ];
                }
            }
        }
        
        return $results;
    }
    
    // Kategoriye göre ürün arama
    public function searchProductsByCategory($query, $category) {
        $results = [];
        $products = $this->categoryService->getProductsByCategory($category);
        
        foreach ($products as $product) {
            if (stripos($product['name'], $query) !== false || 
                stripos($product['description'] ?? '', $query) !== false) {
                $results[] = $product;
            }
        }
        
        return $results;
    }
}
?>
