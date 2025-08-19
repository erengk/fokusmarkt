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
    
    // Ürünün mevcut formlarını getir
    public function getProductForms($productSlug) {
        $configFile = __DIR__ . '/../config/products.json';
        $config = [];
        if (file_exists($configFile)) {
            $config = json_decode(file_get_contents($configFile), true);
        }
        
        // Ürün slug'ını büyük harfe çevir (config'de büyük harf kullanılıyor)
        $productKey = strtoupper(str_replace('-', '_', $productSlug));
        
        // Config'den ürünün mevcut formlarını al
        $availableForms = $config['products'][$productKey]['forms'] ?? [];
        
        if (empty($availableForms)) {
            return [];
        }
        
        // Form açıklamalarını dil paketinden al
        $formDescriptions = [
            'jel' => $this->lang->get('product.form_jel'),
            'malt' => $this->lang->get('product.form_malt'),
            'tablet' => $this->lang->get('product.form_tablet')
        ];
        
        // Form isimlerini büyük harfe çevir (veritabanında büyük harfle)
        $availableFormsUpper = array_map('ucfirst', $availableForms);
        
        // Sadece mevcut formlar için veritabanından bilgileri al
        $placeholders = str_repeat('?,', count($availableFormsUpper) - 1) . '?';
        $forms = $this->db->fetchAll("
            SELECT DISTINCT pv.name as form_name, pv.id, pv.price, pv.weight, pv.description
            FROM product_variants pv
            JOIN products p ON pv.product_id = p.id
            WHERE p.slug = ? AND pv.name IN ($placeholders) AND pv.is_active = 1
            ORDER BY pv.sort_order
        ", array_merge([$productSlug], $availableFormsUpper));
        
        // Form açıklamalarını ekle
        foreach ($forms as &$form) {
            $formKey = strtolower($form['form_name']);
            $form['description'] = $formDescriptions[$formKey] ?? $form['description'];
        }
        
        return $forms;
    }
    
    // Belirli form için ürün varyantını getir
    public function getProductVariantByForm($productSlug, $formName) {
        $variant = $this->db->fetchOne("
            SELECT pv.id, pv.name, pv.description, pv.price, pv.weight, pv.is_active, pv.sort_order
            FROM product_variants pv
            JOIN products p ON pv.product_id = p.id
            WHERE p.slug = ? AND pv.name = ? AND pv.is_active = 1
        ", [$productSlug, $formName]);
        
        return $variant;
    }
    
    // Form seçimine göre ürün görsellerini getir
    public function getProductImagesByForm($productSlug, $formName = null) {
        $lang = $this->lang->getCurrentLang();
        
        // Önce product_images tablosundan kontrol et
        $images = $this->db->fetchAll("
            SELECT pi.image_path, pi.alt_text, pi.sort_order
            FROM product_images pi
            JOIN products p ON pi.product_id = p.id
            WHERE p.slug = ? AND pi.language = ?
            ORDER BY pi.sort_order
        ", [$productSlug, $lang]);
        
        // Eğer product_images tablosunda veri yoksa, eski yöntemi kullan
        if (empty($images)) {
            // Dosya sisteminden görselleri getir
            $productKey = strtoupper(str_replace('-', '_', $productSlug));
            $configFile = __DIR__ . '/../config/products.json';
            $config = [];
            if (file_exists($configFile)) {
                $config = json_decode(file_get_contents($configFile), true);
            }
            
            $availableForms = $config['products'][$productKey]['forms'] ?? [];
            
            // Form adını küçük harfe çevir (config'de küçük harf kullanılıyor)
            $formNameLower = strtolower($formName);
            
            if ($formName && in_array($formNameLower, $availableForms)) {
                // Belirli form için görseller
                $imagePath = "/assets/products/{$lang}/{$productSlug}/{$formNameLower}/";
                $productName = ucfirst($productSlug);
                $formNameCap = ucfirst($formNameLower);
                $images = [
                    [
                        'image_path' => $imagePath . "{$productName}_{$formNameCap}_01.jpg",
                        'alt_text' => "{$productName} {$formNameCap} 1",
                        'sort_order' => 1
                    ],
                    [
                        'image_path' => $imagePath . "{$productName}_{$formNameCap}_02.jpg",
                        'alt_text' => "{$productName} {$formNameCap} 2",
                        'sort_order' => 2
                    ],
                    [
                        'image_path' => $imagePath . "{$productName}_Rehber.jpg",
                        'alt_text' => "{$productName} Rehber",
                        'sort_order' => 3
                    ]
                ];
            } else {
                // İlk mevcut form için görseller
                $firstForm = $availableForms[0] ?? 'tablet';
                $imagePath = "/assets/products/{$lang}/{$productSlug}/{$firstForm}/";
                $productName = ucfirst($productSlug);
                $formNameCap = ucfirst($firstForm);
                $images = [
                    [
                        'image_path' => $imagePath . "{$productName}_{$formNameCap}_01.jpg",
                        'alt_text' => "{$productName} {$formNameCap} 1",
                        'sort_order' => 1
                    ],
                    [
                        'image_path' => $imagePath . "{$productName}_{$formNameCap}_02.jpg",
                        'alt_text' => "{$productName} {$formNameCap} 2", 
                        'sort_order' => 2
                    ],
                    [
                        'image_path' => $imagePath . "{$productName}_Rehber.jpg",
                        'alt_text' => "{$productName} Rehber",
                        'sort_order' => 3
                    ]
                ];
            }
        }
        
        return $images;
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
