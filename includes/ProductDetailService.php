<?php
require_once __DIR__ . '/Language.php';
require_once __DIR__ . '/Database.php';

class ProductDetailService {
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
    
    // Ürün varyantlarını getir
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
    
    // Ürün kategorilerini getir
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
    
    // Ürün endikasyonlarını getir
    public function getProductIndications($productSlug) {
        $indications = $this->db->fetchAll("
            SELECT i.indication_text
            FROM product_indications i
            JOIN products p ON i.product_id = p.id
            WHERE p.slug = ? AND i.is_active = 1
            ORDER BY i.sort_order
        ", [$productSlug]);
        
        return $indications;
    }
    
    // Ürün türlerini getir
    public function getProductSpecies($productSlug) {
        $species = $this->db->fetchAll("
            SELECT s.name, s.slug
            FROM species s
            JOIN product_species ps ON s.id = ps.species_id
            JOIN products p ON ps.product_id = p.id
            WHERE p.slug = ? AND s.is_active = 1
            ORDER BY s.name
        ", [$productSlug]);
        
        return $species;
    }
    
    // Ürün uyarılarını getir
    public function getProductWarnings($productSlug) {
        $warnings = $this->db->fetchAll("
            SELECT w.warning_text
            FROM product_warnings w
            JOIN products p ON w.product_id = p.id
            WHERE p.slug = ? AND w.is_active = 1
            ORDER BY w.sort_order
        ", [$productSlug]);
        
        return $warnings;
    }
    
    // Ürün faydalarını getir
    public function getProductBenefits($productSlug) {
        $benefits = $this->db->fetchAll("
            SELECT b.benefit_text
            FROM product_benefits b
            JOIN products p ON b.product_id = p.id
            WHERE p.slug = ? AND b.is_active = 1
            ORDER BY b.sort_order
        ", [$productSlug]);
        
        return $benefits;
    }
    
    // Ürün içeriklerini getir
    public function getProductIngredients($productSlug) {
        $ingredients = $this->db->fetchAll("
            SELECT i.ingredient_name, i.function_description
            FROM product_ingredients i
            JOIN products p ON i.product_id = p.id
            WHERE p.slug = ? AND i.is_active = 1
            ORDER BY i.sort_order
        ", [$productSlug]);
        
        return $ingredients;
    }
    
    // İlgili ürünleri getir
    public function getRelatedProducts($productSlug, $categorySlug, $limit = 4) {
        $related = $this->db->fetchAll("
            SELECT p.id, p.name, p.slug, p.description, p.short_description
            FROM products p
            JOIN product_categories pc ON p.id = pc.product_id
            JOIN categories c ON pc.category_id = c.id
            WHERE c.slug = ? AND p.slug != ? AND p.is_active = 1
            ORDER BY p.sort_order
            LIMIT ?
        ", [$categorySlug, $productSlug, $limit]);
        
        return $related;
    }
}
?>
