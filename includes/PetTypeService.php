<?php
require_once __DIR__ . '/Language.php';
require_once __DIR__ . '/Database.php';

class PetTypeService {
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
    
    // Evcil hayvan türlerini getir
    public function getPetTypes() {
        $species = $this->db->fetchAll("
            SELECT slug, name 
            FROM species 
            WHERE is_active = 1 
            ORDER BY id
        ");
        
        $result = [];
        foreach ($species as $type) {
            $result[$type['slug']] = $type['name'];
        }
        
        return $result;
    }
    
    // Evcil hayvan türü adını getir (dil desteği ile)
    public function getPetTypeName($petTypeKey) {
        // Önce dil paketinden çeviri dene
        $translatedName = $this->lang->get("pet_types.{$petTypeKey}");
        
        if ($translatedName && $translatedName !== "pet_types.{$petTypeKey}") {
            return $translatedName;
        }
        
        // Dil paketinde yoksa veritabanından al
        $petTypes = $this->getPetTypes();
        return $petTypes[$petTypeKey] ?? $petTypeKey;
    }
    
    // Evcil hayvan türüne göre ürünleri getir
    public function getProductsByPetType($petType) {
        // Evcil hayvan türüne göre ürün eşleştirmesi
        $petTypeProductMap = [
            'kedi' => ['dental-care', 'dermacumin', 'retino-a', 'derma-zn', 'derma-hairball', 'salmonoil'],
            'kopek' => ['o2-care', 'canivir', 'felovir', 'petimmun', 'cartilagoflex', 'multivit'],
            'birds' => ['multivit', 'petimmun'],
            'fish' => ['multivit'],
            'small_animals' => ['multivit', 'petimmun']
        ];
        
        $productSlugs = $petTypeProductMap[$petType] ?? [];
        $products = [];
        
        foreach ($productSlugs as $slug) {
            $products[] = [
                'slug' => $slug,
                'name' => ucwords(str_replace(['-', '_'], ' ', $slug))
            ];
        }
        
        return $products;
    }
}
?>
