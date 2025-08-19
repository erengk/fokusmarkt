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
    <!-- Breadcrumb Section -->
    <section class="breadcrumb-section">
        <div class="container">
            <nav class="breadcrumb" aria-label="breadcrumb">
                <ol class="breadcrumb-list d-flex align-center">
                    <li class="breadcrumb-item">
                        <a href="/"><?php echo $lang->get('nav.home'); ?></a>
                    </li>
                    <?php foreach ($breadcrumb as $index => $item): ?>
                        <li class="breadcrumb-item <?php echo $index === count($breadcrumb) - 1 ? 'active' : ''; ?>" <?php echo $index === count($breadcrumb) - 1 ? 'aria-current="page"' : ''; ?>>
                            <a href="<?php echo $item['url']; ?>"><?php echo $item['name']; ?></a>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Category Header Section -->
    <section class="category-header-section">
        <div class="container">
            <div class="category-header-content">
                <div class="category-info">
                    <h1 class="category-title"><?php echo $categoryInfo['name']; ?></h1>
                    <p class="category-description"><?php echo $categoryInfo['description']; ?></p>
                </div>
                
                <div class="category-stats">
                    <div class="stat-card">
                        <span class="stat-number"><?php echo count($products); ?></span>
                        <span class="stat-label"><?php echo $lang->get('category.products'); ?></span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number"><?php echo count($subcategories); ?></span>
                        <span class="stat-label"><?php echo $lang->get('category.subcategories'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section">
        <div class="container">
            <div class="products-layout">
                <!-- Sidebar Filters -->
                <aside class="filters-sidebar">
                    <div class="filter-group card">
                        <h3 class="filter-title"><?php echo $lang->get('category.subcategories'); ?></h3>
                        <ul class="subcategory-list">
                            <li class="<?php echo !$subcategory ? 'active' : ''; ?>">
                                <a href="/category?category=<?php echo $category; ?>"><?php echo $lang->get('filter.all'); ?></a>
                            </li>
                            <?php foreach ($subcategories as $subKey => $subName): ?>
                                <li class="<?php echo $subcategory === $subKey ? 'active' : ''; ?>">
                                    <a href="/category?category=<?php echo $category; ?>&subcategory=<?php echo $subKey; ?>">
                                        <?php echo $subName; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="filter-group card">
                        <h3 class="filter-title"><?php echo $lang->get('product.form'); ?></h3>
                        <ul class="form-list">
                            <?php foreach ($product->getProductFormTypes() as $formKey => $formName): ?>
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
                    
                    <div class="filter-group card">
                        <h3 class="filter-title"><?php echo $lang->get('filter.pet_type_label'); ?></h3>
                        <ul class="pet-type-list">
                            <li>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="pet_type[]" value="all" checked>
                                    <span class="checkmark"></span>
                                    <?php echo $lang->get('filter.all'); ?>
                                </label>
                            </li>
                            <li>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="pet_type[]" value="kedi">
                                    <span class="checkmark"></span>
                                    <?php echo $lang->get('filter.cat'); ?>
                                </label>
                            </li>
                            <li>
                                <label class="checkbox-label">
                                    <input type="checkbox" name="pet_type[]" value="kopek">
                                    <span class="checkmark"></span>
                                    <?php echo $lang->get('filter.dog'); ?>
                                </label>
                            </li>
                        </ul>
                    </div>
                </aside>

                <!-- Products Grid -->
                <div class="products-content">
                    <div class="products-header">
                        <div class="products-count">
                            <span><?php echo count($products); ?> <?php echo $lang->get('category.products'); ?></span>
                        </div>
                        <div class="products-sort">
                            <select class="sort-select">
                                <option value="name"><?php echo $lang->get('product.name'); ?></option>
                                <option value="price"><?php echo $lang->get('product.price'); ?></option>
                                <option value="newest"><?php echo $lang->get('nav.new_products'); ?></option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="products-grid">
                        <?php foreach ($products as $productSlug => $productData): ?>
                            <div class="product-card card" data-category="<?php echo $category; ?>" data-pet-types="<?php echo implode(' ', $productData['pet_types'] ?? []); ?>">
                                <div class="product-image">
                                    <a href="/<?php echo $productSlug; ?>">
                                        <img src="<?php echo $productData['image'] ?? '/assets/images/placeholder.jpg'; ?>" 
                                             alt="<?php echo $productData['name']; ?>" 
                                             loading="lazy">
                                    </a>
                                </div>
                                <div class="product-info">
                                    <h3 class="product-title">
                                        <a href="/<?php echo $productSlug; ?>"><?php echo $productData['name']; ?></a>
                                    </h3>
                                    <div class="product-meta">
                                        <span class="product-brand"><?php echo $productData['brand'] ?? ''; ?></span>
                                        <span class="product-category"><?php echo $productData['category'] ?? ''; ?></span>
                                    </div>
                                    <div class="product-price">
                                        <span class="current-price"><?php echo number_format($productData['price'], 2); ?> ₺</span>
                                        <?php if (isset($productData['old_price']) && $productData['old_price'] > $productData['price']): ?>
                                            <span class="old-price"><?php echo number_format($productData['old_price'], 2); ?> ₺</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="product-actions">
                                        <a href="/<?php echo $productSlug; ?>" class="btn btn-primary"><?php echo $lang->get('product.view_details'); ?></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/Footer.php'; ?>
