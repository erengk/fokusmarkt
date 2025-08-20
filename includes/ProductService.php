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
        // Veritabanından ürün bilgilerini getir
        $product = $this->db->fetchOne("
            SELECT p.*, 
                   GROUP_CONCAT(DISTINCT c.slug) as categories,
                   GROUP_CONCAT(DISTINCT s.name) as species
            FROM products p
            LEFT JOIN product_categories pc ON p.id = pc.product_id
            LEFT JOIN categories c ON pc.category_id = c.id
            LEFT JOIN product_species ps ON p.id = ps.product_id
            LEFT JOIN species s ON ps.species_id = s.id
            WHERE p.slug = ? AND p.is_active = 1
            GROUP BY p.id
        ", [$productSlug]);
        
        if (!$product) {
            return null;
        }
        
        // Ürün endikasyonlarını getir
        $indications = $this->db->fetchAll("
            SELECT i.name as indication_text
            FROM indications i
            JOIN product_indications pi ON i.id = pi.indication_id
            JOIN products p ON pi.product_id = p.id
            WHERE p.slug = ? AND i.is_active = 1
            ORDER BY i.sort_order
        ", [$productSlug]);
        
        // Ürün faydalarını getir (products tablosundan)
        $benefits = [];
        if (!empty($product['benefits'])) {
            $benefits = is_string($product['benefits']) ? json_decode($product['benefits'], true) : $product['benefits'];
        }
        
        // Ürün uyarılarını getir
        $warnings = $this->db->fetchAll("
            SELECT warning_text
            FROM product_warnings pw
            JOIN products p ON pw.product_id = p.id
            WHERE p.slug = ? AND pw.is_active = 1
            ORDER BY pw.sort_order
        ", [$productSlug]);
        
        // Ürün içeriklerini getir
        $ingredients = $this->db->fetchAll("
            SELECT ingredient_name as name, function_description as `function`
            FROM product_ingredients pi
            JOIN products p ON pi.product_id = p.id
            WHERE p.slug = ? AND pi.is_active = 1
            ORDER BY pi.sort_order
        ", [$productSlug]);
        
        // Veriyi birleştir
        $product['indications'] = array_column($indications, 'indication_text');
        $product['benefits'] = $benefits;
        
        // FAQ verilerini getir (products tablosundan)
        $faq = [];
        if (!empty($product['faq'])) {
            $faq = is_string($product['faq']) ? json_decode($product['faq'], true) : $product['faq'];
        }
        $product['faq'] = $faq;
        
        $product['warnings'] = array_column($warnings, 'warning_text');
        $product['ingredients'] = $ingredients;
        $product['category'] = $product['categories'] ? explode(',', $product['categories'])[0] : '';
        
        return $product;
    }
    
    // Ürün slug'ına göre görselleri getir
    public function getProductImagesBySlug($productSlug) {
        $lang = $this->lang->getCurrentLang();
        
        $images = $this->db->fetchAll("
            SELECT pi.image_path, pi.alt_text, pi.sort_order
            FROM product_images pi
            JOIN products p ON pi.product_id = p.id
            WHERE p.slug = ? AND pi.language = ? AND pi.is_active = 1
            ORDER BY pi.sort_order
        ", [$productSlug, $lang]);
        
        return $images;
    }
    
    // Tüm ürünleri getir
    public function getAllProducts() {
        $products = $this->db->fetchAll("
            SELECT p.*, 
                   GROUP_CONCAT(DISTINCT c.name) as category_names,
                   GROUP_CONCAT(DISTINCT s.name) as species_names
            FROM products p
            LEFT JOIN product_categories pc ON p.id = pc.product_id
            LEFT JOIN categories c ON pc.category_id = c.id
            LEFT JOIN product_species ps ON p.id = ps.product_id
            LEFT JOIN species s ON ps.species_id = s.id
            WHERE p.is_active = 1
            GROUP BY p.id
            ORDER BY p.sort_order, p.name
        ");
        
        return $products;
    }
    
    // Kategoriye göre ürünleri getir
    public function getProductsByCategory($categorySlug) {
        $products = $this->db->fetchAll("
            SELECT p.*, 
                   GROUP_CONCAT(DISTINCT c.name) as category_names,
                   GROUP_CONCAT(DISTINCT s.name) as species_names,
                   MIN(pv.price) as price
            FROM products p
            JOIN product_categories pc ON p.id = pc.product_id
            JOIN categories c ON pc.category_id = c.id
            LEFT JOIN product_species ps ON p.id = ps.product_id
            LEFT JOIN species s ON ps.species_id = s.id
            LEFT JOIN product_variants pv ON p.id = pv.product_id AND pv.is_active = 1
            WHERE c.slug = ? AND p.is_active = 1
            GROUP BY p.id
            ORDER BY p.sort_order, p.name
        ", [$categorySlug]);
        
        return $products;
    }
    
    // Tür'e göre ürünleri getir
    public function getProductsBySpecies($speciesSlug) {
        $products = $this->db->fetchAll("
            SELECT p.*, 
                   GROUP_CONCAT(DISTINCT c.name) as category_names,
                   GROUP_CONCAT(DISTINCT s.name) as species_names
            FROM products p
            JOIN product_species ps ON p.id = ps.product_id
            JOIN species s ON ps.species_id = s.id
            LEFT JOIN product_categories pc ON p.id = pc.product_id
            LEFT JOIN categories c ON pc.category_id = c.id
            WHERE s.slug = ? AND p.is_active = 1
            GROUP BY p.id
            ORDER BY p.sort_order, p.name
        ", [$speciesSlug]);
        
        return $products;
    }
    
    // Ürün arama
    public function searchProducts($query) {
        $searchTerm = '%' . $query . '%';
        
        $products = $this->db->fetchAll("
            SELECT p.*, 
                   GROUP_CONCAT(DISTINCT c.name) as category_names,
                   GROUP_CONCAT(DISTINCT s.name) as species_names
            FROM products p
            LEFT JOIN product_categories pc ON p.id = pc.product_id
            LEFT JOIN categories c ON pc.category_id = c.id
            LEFT JOIN product_species ps ON p.id = ps.product_id
            LEFT JOIN species s ON ps.species_id = s.id
            WHERE (p.name LIKE ? OR p.description LIKE ? OR p.short_description LIKE ?) 
                  AND p.is_active = 1
            GROUP BY p.id
            ORDER BY p.sort_order, p.name
        ", [$searchTerm, $searchTerm, $searchTerm]);
        
        return $products;
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
    
    // Ürün varyantlarını getir
    public function getProductVariants($productSlug) {
        $variants = $this->db->fetchAll("
            SELECT pv.id, pv.name, pv.description, pv.price, pv.weight, pv.is_active, pv.sort_order
            FROM product_variants pv
            JOIN products p ON pv.product_id = p.id
            WHERE p.slug = ? AND pv.is_active = 1
            ORDER BY pv.sort_order
        ", [$productSlug]);
        
        return $variants;
    }
    
    // Ürün görsellerini getir
    public function getProductImages($productSlug) {
        $lang = $this->lang->getCurrentLang();
        
        $images = $this->db->fetchAll("
            SELECT pi.image_path, pi.alt_text, pi.form_type, pi.sort_order
            FROM product_images pi
            JOIN products p ON pi.product_id = p.id
            WHERE p.slug = ? AND pi.language = ? AND pi.is_active = 1
            ORDER BY pi.sort_order
        ", [$productSlug, $lang]);
        
        return $images;
    }
    
    // Ürün video yolunu getir
    public function getProductVideo($productSlug, $lang = 'tr') {
        // Video dosya adını oluştur
        $videoFileName = $this->generateVideoFileName($productSlug);
        if (!$videoFileName) {
            return null;
        }
        
        $videoPath = "/assets/reels/{$lang}/{$videoFileName}";
        
        // Video dosyasının var olup olmadığını kontrol et
        $fullPath = __DIR__ . "/../assets/reels/{$lang}/{$videoFileName}";
        if (file_exists($fullPath)) {
            return $videoPath;
        }
        
        return null;
    }
    
    // Birlikte iyi gider ürünlerini getir
    public function getComplementaryProducts($productSlug, $limit = 6) {
        $limit = (int)$limit;
        
        // Ana sorgu - temel bilgiler
        $sql = "SELECT p.id, p.name, p.slug, p.short_description, p.video_path
                FROM products p
                JOIN complementary_products cp ON p.id = cp.complementary_product_id
                JOIN products main_product ON cp.main_product_id = main_product.id
                WHERE main_product.slug = ? AND p.is_active = 1 AND cp.is_active = 1
                ORDER BY cp.sort_order, p.name
                LIMIT " . $limit;
        
        $complementary = $this->db->fetchAll($sql, [$productSlug]);
        
        // Fiyat bilgisini ayrı sorgu ile ekle
        foreach ($complementary as &$product) {
            $priceResult = $this->db->fetchOne("
                SELECT MIN(price) as min_price 
                FROM product_variants 
                WHERE product_id = ? AND is_active = 1
            ", [$product['id']]);
            
            $product['price'] = $priceResult['min_price'] ?? 0;
        }
        
        return $complementary;
    }
    
    // Video dosya adını oluştur
    private function generateVideoFileName($productSlug) {
        // Ürün slug'ını video dosya adına çevir
        $videoMap = [
            'dental-care' => '26_Dental_Care_Tablet.mov',
            'dermacumin' => '2_Dermacumin_Plus_Jel.mov',
            'retino-a' => '29_Retino_A_Jel.mov',
            'derma-zn' => '16_Derma_Zn_Tablet.mov',
            'derma-hairball' => '27_Derma_Hairball_Tablet.mov',
            'phytospan' => '7_Phytospan_Tablet.mov',
            'bladder-control' => '3_Bladder_Control_Malt.mov',
            'o2-care' => '1_O2_Care_Plus_Malt.mov',
            'cartilagoflex' => '5_Cartilagoflex_Tablet.mov',
            'coprophagia' => '13_Coprophagia_Tablet.mov',
            'canivir' => '11_Canivir_Tablet.mov',
            'uticare' => '9_Uticare_Tablet.mov',
            'ease-off' => '17_Ease_Off_Tablet.mov',
            'm-b-care' => '19_M_B_Care_Tablet.mov',
            'multivit' => '21_Multivit_Tablet.mov',
            'petimmun' => '23_Petimmun_Malt.mov',
            'renacure' => '24_Renacure_Malt.mov',
            'felovir' => '25_Felovir_Malt.mov',
            'salmon-oil' => '28_Salmonoil_Tablet.mov',
            'salmonoil' => '28_Salmonoil_Tablet.mov'
        ];
        
        return $videoMap[$productSlug] ?? null;
    }
}
?>
