<?php
$lang = Language::getInstance();
$product = Product::getInstance();

$category = $_GET['category'] ?? '';
$subcategory = $_GET['subcategory'] ?? '';

if (!$category) {
    header('Location: /');
    exit;
}

$categoryInfo = $product->getCategoryInfo($category);
if (!$categoryInfo) {
    include __DIR__ . '/404.php';
    exit;
}

$products = $product->getProductsByCategory($category);
$subcategories = $product->getSubcategories($category);
$breadcrumb = $product->getCategoryBreadcrumb($category, $subcategory);
?>

<?php include __DIR__ . '/../includes/Header.php'; ?>

<main class="main-content">
    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="container">
            <nav class="breadcrumb">
                <?php foreach ($breadcrumb as $index => $item): ?>
                    <?php if ($index > 0): ?>
                        <span class="breadcrumb-separator">/</span>
                    <?php endif; ?>
                    <a href="<?php echo $item['url']; ?>"><?php echo $item['name']; ?></a>
                <?php endforeach; ?>
            </nav>
        </div>
    </section>

    <!-- Category Header -->
    <section class="category-header">
        <div class="container">
            <div class="category-header-content">
                <div class="category-info">
                    <h1><?php echo $categoryInfo['name']; ?></h1>
                    <p><?php echo $categoryInfo['description']; ?></p>
                </div>
                
                <div class="category-stats">
                    <div class="stat">
                        <span class="stat-number"><?php echo count($products); ?></span>
                        <span class="stat-label">Ürün</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number"><?php echo count($subcategories); ?></span>
                        <span class="stat-label">Alt Kategori</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters and Products -->
    <section class="products-section">
        <div class="container">
            <div class="products-layout">
                <!-- Sidebar Filters -->
                <aside class="filters-sidebar">
                    <div class="filter-group">
                        <h3>Alt Kategoriler</h3>
                        <ul class="subcategory-list">
                            <li class="<?php echo !$subcategory ? 'active' : ''; ?>">
                                <a href="/category/<?php echo $category; ?>">Tümü</a>
                            </li>
                            <?php foreach ($subcategories as $subKey => $subName): ?>
                                <li class="<?php echo $subcategory === $subKey ? 'active' : ''; ?>">
                                    <a href="/category/<?php echo $category; ?>/<?php echo $subKey; ?>">
                                        <?php echo $subName; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Ürün Formları</h3>
                        <ul class="form-list">
                            <?php foreach ($product->getProductForms() as $formKey => $formName): ?>
                                <li>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="form[]" value="<?php echo $formKey; ?>">
                                        <span class="checkmark"></span>
                                        <?php echo $formName; ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="filter-group">
                        <h3>Evcil Hayvan Türü</h3>
                        <ul class="pet-type-list">
                            <?php foreach ($product->getPetTypes() as $petTypeKey => $petTypeName): ?>
                                <li>
                                    <label class="checkbox-label">
                                        <input type="checkbox" name="pet_type[]" value="<?php echo $petTypeKey; ?>">
                                        <span class="checkmark"></span>
                                        <?php echo $petTypeName; ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </aside>

                <!-- Products Grid -->
                <div class="products-content">
                    <div class="products-header">
                        <div class="products-count">
                            <span><?php echo count($products); ?> ürün bulundu</span>
                        </div>
                        
                        <div class="products-sort">
                            <select name="sort" id="sort-select">
                                <option value="name">İsme Göre</option>
                                <option value="popularity">Popülerliğe Göre</option>
                                <option value="newest">En Yeni</option>
                            </select>
                        </div>
                    </div>

                    <div class="products-grid">
                        <?php if (empty($products)): ?>
                            <div class="no-products">
                                <i class="fas fa-box-open"></i>
                                <h3>Bu kategoride henüz ürün bulunmuyor</h3>
                                <p>Yakında yeni ürünler eklenecektir.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($products as $productName => $productInfo): ?>
                                <div class="product-card" data-product-id="<?php echo $productName; ?>">
                                    <div class="product-image">
                                        <?php 
                                        $images = $product->getProductImages($category, $productName);
                                        if (!empty($images)) {
                                            echo '<img src="' . $images[0]['url'] . '" alt="' . $productName . '">';
                                        } else {
                                            echo '<div class="placeholder-image">' . substr($productName, 0, 2) . '</div>';
                                        }
                                        ?>
                                    </div>
                                    
                                    <div class="product-info">
                                        <h3 class="product-title"><?php echo $productName; ?></h3>
                                        
                                        <div class="product-forms">
                                            <?php foreach ($productInfo['forms'] as $form): ?>
                                                <span class="form-badge"><?php echo $product->getProductFormName($form); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                        
                                        <div class="product-categories">
                                            <?php foreach ($productInfo['categories'] as $cat): ?>
                                                <span class="category-badge"><?php echo $product->getCategoryName($cat); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                        
                                        <div class="product-actions">
                                            <button class="btn btn-primary add-to-cart">Sepete Ekle</button>
                                            <button class="btn btn-secondary product-details">Detaylar</button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/Footer.php'; ?>
