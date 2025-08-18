<?php
require_once __DIR__ . '/Language.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/NavigationService.php';

class ImageService {
    private static $instance = null;
    private $db = null;
    private $lang = null;
    private $navigationService = null;
    
    private function __construct() {
        $this->db = Database::getInstance();
        $this->lang = Language::getInstance();
        $this->navigationService = NavigationService::getInstance();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    // Kategori/alt kategori/evcil hayvan türüne göre ürün görsellerini getir
    public function getProductImages($category = null, $subcategory = null, $petType = null) {
        $path = $this->navigationService->getProductsPath($category, $subcategory, $petType);
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
}
?>
