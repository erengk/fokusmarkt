<?php
require_once __DIR__ . '/Language.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/ProductService.php';
require_once __DIR__ . '/CategoryService.php';
require_once __DIR__ . '/PetTypeService.php';
require_once __DIR__ . '/SearchService.php';
require_once __DIR__ . '/NavigationService.php';
require_once __DIR__ . '/ProductDetailService.php';
require_once __DIR__ . '/ProductFormService.php';
require_once __DIR__ . '/ProductListService.php';
require_once __DIR__ . '/ImageService.php';

class Product {
    private static $instance = null;
    private $productService = null;
    private $categoryService = null;
    private $petTypeService = null;
    private $searchService = null;
    private $navigationService = null;
    private $productDetailService = null;
    private $productFormService = null;
    private $productListService = null;
    private $imageService = null;
    
    private function __construct() {
        $this->productService = ProductService::getInstance();
        $this->categoryService = CategoryService::getInstance();
        $this->petTypeService = PetTypeService::getInstance();
        $this->searchService = SearchService::getInstance();
        $this->navigationService = NavigationService::getInstance();
        $this->productDetailService = ProductDetailService::getInstance();
        $this->productFormService = ProductFormService::getInstance();
        $this->productListService = ProductListService::getInstance();
        $this->imageService = ImageService::getInstance();
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    // Kategori işlemleri - CategoryService'e yönlendir
    public function getCategories() {
        return $this->categoryService->getCategories();
    }
    
    public function getCategoryInfo($category) {
        return $this->categoryService->getCategoryInfo($category);
    }
    
    public function getCategoryName($category) {
        return $this->categoryService->getCategoryName($category);
    }
    
    public function getCategoryDescription($category) {
        return $this->categoryService->getCategoryDescription($category);
    }
    
    public function getSubcategories($category) {
        return $this->categoryService->getSubcategories($category);
    }
    
    public function getPetTypes() {
        return $this->petTypeService->getPetTypes();
    }
    
    public function getPetTypeName($type) {
        return $this->petTypeService->getPetTypeName($type);
    }
    
    public function getProductsPath($category = null, $subcategory = null, $petType = null) {
        return $this->navigationService->getProductsPath($category, $subcategory, $petType);
    }
    
    public function getProductImages($category = null, $subcategory = null, $petType = null) {
        return $this->imageService->getProductImages($category, $subcategory, $petType);
    }
    

    
    // Ürün slug'ına göre görselleri getir
    public function getProductImagesBySlug($productSlug) {
        return $this->productService->getProductImagesBySlug($productSlug);
    }
    
    // Kategori görsel işlemleri - CategoryService'e yönlendir
    public function getCategoryMainImage($categorySlug) {
        $images = $this->categoryService->getCategoryImages($categorySlug);
        return !empty($images) ? $images[0] : null;
    }
    
    public function getCategoryImages($categorySlug) {
        return $this->categoryService->getCategoryImages($categorySlug);
    }
    
    public function getProductFormTypes() {
        return $this->productFormService->getProductForms();
    }
    
    public function getProductFormName($form) {
        return $this->productFormService->getProductFormName($form);
    }
    
    // Ürün listesi metodları - ProductListService'e yönlendir
    public function getProducts() {
        return $this->productListService->getProducts();
    }
    
    public function getProductInfo($productName) {
        return $this->productListService->getProductInfo($productName);
    }
    
    public function getProductsByCategory($category) {
        return $this->categoryService->getProductsByCategory($category);
    }
    
    public function getProductsByForm($form) {
        return $this->productFormService->getProductsByForm($form);
    }
    
    public function getCategoryBreadcrumb($category, $subcategory = null) {
        return $this->navigationService->getCategoryBreadcrumb($category, $subcategory);
    }
    
    public function getTranslation($key) {
        return $this->navigationService->getTranslation($key);
    }
    
    public function getCurrentLang() {
        return $this->lang->getCurrentLang();
    }
    
    public function getAllCategoriesWithInfo() {
        return $this->categoryService->getAllCategoriesWithInfo();
    }
    
    public function searchProducts($query) {
        return $this->searchService->searchProducts($query);
    }
    
    // Ürün detay metodları - ProductDetailService'e yönlendir
    public function getProductVariants($productSlug) {
        return $this->productDetailService->getProductVariants($productSlug);
    }
    
    public function getProductForms($productSlug) {
        return $this->productDetailService->getProductForms($productSlug);
    }
    
    public function getProductVariantByForm($productSlug, $formName) {
        return $this->productDetailService->getProductVariantByForm($productSlug, $formName);
    }
    
    public function getProductImagesByForm($productSlug, $formName = null) {
        return $this->productDetailService->getProductImagesByForm($productSlug, $formName);
    }
    
    public function getProductCategories($productSlug) {
        return $this->productDetailService->getProductCategories($productSlug);
    }
    
    public function getProductIndications($productSlug) {
        return $this->productDetailService->getProductIndications($productSlug);
    }
    
    public function getProductSpecies($productSlug) {
        return $this->productDetailService->getProductSpecies($productSlug);
    }
    
    public function getProductBySlug($productSlug) {
        return $this->productService->getProductBySlug($productSlug);
    }
    

    
    public function getProductWarnings($productSlug) {
        return $this->productDetailService->getProductWarnings($productSlug);
    }
    
    public function getProductBenefits($productSlug) {
        return $this->productDetailService->getProductBenefits($productSlug);
    }
    
    public function getProductIngredients($productSlug) {
        return $this->productDetailService->getProductIngredients($productSlug);
    }
    
    public function getRelatedProducts($productSlug, $categorySlug, $limit = 4) {
        return $this->productDetailService->getRelatedProducts($productSlug, $categorySlug, $limit);
    }
    
    public function getComplementaryProducts($productSlug, $limit = 6) {
        return $this->productService->getComplementaryProducts($productSlug, $limit);
    }
}
?>
