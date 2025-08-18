<?php
require_once __DIR__ . '/Language.php';
require_once __DIR__ . '/Database.php';

class ProductListService {
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
    
    // Tüm ürünleri getir
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
    
    // Ürün bilgilerini getir
    public function getProductInfo($productName) {
        $product = $this->db->fetchOne("
            SELECT id, name, slug, description, short_description, active_ingredients, benefits, dosage_instructions, faq
            FROM products 
            WHERE slug = ? AND is_active = 1
        ", [$productName]);
        
        return $product;
    }
}
?>
