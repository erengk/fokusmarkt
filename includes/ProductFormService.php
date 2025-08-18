<?php
require_once __DIR__ . '/Language.php';
require_once __DIR__ . '/Database.php';

class ProductFormService {
    private static $instance = null;
    private $db = null;
    private $lang = null;
    private $config = [];
    
    private function __construct() {
        $this->db = Database::getInstance();
        $this->lang = Language::getInstance();
        $this->loadConfig();
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
    
    // Ürün formlarını getir
    public function getProductForms() {
        $forms = [];
        foreach ($this->config['product_forms'] ?? [] as $key => $names) {
            $forms[$key] = $names[$this->lang->getCurrentLang()] ?? $key;
        }
        return $forms;
    }
    
    // Ürün form adını getir
    public function getProductFormName($form) {
        return $this->config['product_forms'][$form][$this->lang->getCurrentLang()] ?? $form;
    }
    
    // Forma göre ürünleri getir
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
}
?>
