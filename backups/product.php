<?php
$lang = Language::getInstance();
$product = Product::getInstance();

// Get product slug from URL
$productSlug = $_GET['slug'] ?? $productSlug ?? '';

if (empty($productSlug)) {
    header('Location: /404');
    exit;
}

// Get product details
$productDetails = $product->getProductBySlug($productSlug);
$productImages = $product->getProductImagesBySlug($productSlug);
$productSpecies = $product->getProductSpecies($productSlug);

if (!$productDetails) {
    header('Location: /404');
    exit;
}

// Get related products
$relatedProducts = $product->getRelatedProducts($productSlug, $productDetails['category']);
?>

<?php include __DIR__ . '/../includes/Header.php'; ?>

<main class="product-detail-page">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb" aria-label="breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item">
                    <a href="/"><?php echo $lang->get('nav.home'); ?></a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/category?category=<?php echo $productDetails['category']; ?>">
                        <?php echo $product->getCategoryName($productDetails['category']); ?>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <?php echo $productDetails['name']; ?>
                </li>
            </ol>
        </nav>

        <!-- Product Main Section -->
        <div class="product-main">
            <div class="product-gallery">
                <div class="product-gallery-main">
                    <div class="main-image-container">
                        <img src="<?php echo !empty($productImages) ? $productImages[0]['url'] : '/assets/images/placeholder.jpg'; ?>" 
                             alt="<?php echo $productDetails['name']; ?>" 
                             class="main-product-image" 
                             id="mainProductImage">
                    </div>
                </div>
                
                <?php if (count($productImages) > 1): ?>
                <div class="product-gallery-thumbs">
                    <?php foreach ($productImages as $index => $image): ?>
                        <div class="thumb-item <?php echo $index === 0 ? 'active' : ''; ?>" 
                             onclick="changeMainImage('<?php echo $image['url']; ?>', this)">
                            <img src="<?php echo $image['url']; ?>" 
                                 alt="<?php echo $productDetails['name'] . ' - ' . $image['form']; ?>" 
                                 loading="lazy">
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="product-info">
                <!-- Product Title -->
                <h1 class="product-title"><?php echo $productDetails['name']; ?></h1>
                
                <!-- Product Rating -->
                <div class="product-rating">
                    <div class="stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?php echo $i <= 4 ? 'filled' : ''; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <span class="rating-text">4.8/5 (<?php echo $lang->get('product.reviews_count'); ?>)</span>
                </div>

                <!-- Short Description (USP) -->
                <div class="product-usp">
                    <h3><?php echo $lang->get('product.key_benefits'); ?></h3>
                    <ul class="usp-list">
                        <?php foreach ($productDetails['benefits'] ?? [] as $benefit): ?>
                            <li><i class="fas fa-check"></i> <?php echo $benefit; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Price and Purchase Area -->
                <div class="product-purchase">
                    <div class="product-price">
                        <?php if (isset($productDetails['old_price']) && $productDetails['old_price'] > $productDetails['price']): ?>
                            <span class="old-price"><?php echo number_format($productDetails['old_price'], 2); ?> ₺</span>
                            <span class="discount-badge">-%<?php echo round((($productDetails['old_price'] - $productDetails['price']) / $productDetails['old_price']) * 100); ?></span>
                        <?php endif; ?>
                        <span class="current-price"><?php echo number_format($productDetails['price'], 2); ?> ₺</span>
                    </div>

                    <div class="purchase-actions">
                        <div class="quantity-selector">
                            <button class="qty-btn" onclick="changeQuantity(-1)">-</button>
                            <input type="number" value="1" min="1" max="99" id="productQuantity" class="qty-input">
                            <button class="qty-btn" onclick="changeQuantity(1)">+</button>
                        </div>
                        
                        <button class="btn btn-primary btn-add-to-cart" onclick="addToCart('<?php echo $productSlug; ?>')">
                            <i class="fas fa-shopping-cart"></i>
                            <?php echo $lang->get('product.add_to_cart'); ?>
                        </button>
                    </div>

                    <div class="stock-status">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo $lang->get('product.in_stock'); ?></span>
                    </div>

                    <div class="payment-options">
                        <span class="payment-text"><?php echo $lang->get('product.payment_options'); ?></span>
                        <div class="payment-icons">
                            <i class="fab fa-cc-visa"></i>
                            <i class="fab fa-cc-mastercard"></i>
                            <img src="/assets/iyzico-logo-pack/footer_iyzico_ile_ode/Colored/logo_band_colored@2x.png" alt="iyzico" class="payment-icon">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="product-tabs">
            <div class="tab-navigation">
                <button class="tab-btn active" data-tab="indications">
                    <?php echo $lang->get('product.indications'); ?>
                </button>
                <button class="tab-btn" data-tab="ingredients">
                    <?php echo $lang->get('product.ingredients'); ?>
                </button>
                <button class="tab-btn" data-tab="usage">
                    <?php echo $lang->get('product.usage'); ?>
                </button>
                <button class="tab-btn" data-tab="specifications">
                    <?php echo $lang->get('product.specifications'); ?>
                </button>
                <button class="tab-btn" data-tab="reviews">
                    <?php echo $lang->get('product.reviews'); ?>
                </button>
            </div>

            <div class="tab-content">
                <!-- Indications Tab -->
                <div class="tab-panel active" id="indications">
                    <h3><?php echo $lang->get('product.indications_title'); ?></h3>
                    <ul class="indications-list">
                        <?php foreach ($productDetails['indications'] ?? [] as $indication): ?>
                            <li><i class="fas fa-arrow-right"></i> <?php echo $indication; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Ingredients Tab -->
                <div class="tab-panel" id="ingredients">
                    <h3><?php echo $lang->get('product.ingredients_title'); ?></h3>
                    <div class="ingredients-table">
                        <table>
                            <thead>
                                <tr>
                                    <th><?php echo $lang->get('product.ingredient'); ?></th>
                                    <th><?php echo $lang->get('product.function'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productDetails['ingredients'] ?? [] as $ingredient): ?>
                                    <tr>
                                        <td><?php echo $ingredient['name']; ?></td>
                                        <td><?php echo $ingredient['function']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Usage Tab -->
                <div class="tab-panel" id="usage">
                    <h3><?php echo $lang->get('product.usage_title'); ?></h3>
                    <div class="usage-instructions">
                        <div class="dosage-info">
                            <h4><?php echo $lang->get('product.dosage'); ?></h4>
                            <p><?php echo $productDetails['dosage'] ?? $lang->get('product.dosage_default'); ?></p>
                        </div>
                        
                        <div class="frequency-info">
                            <h4><?php echo $lang->get('product.frequency'); ?></h4>
                            <p><?php echo $productDetails['frequency'] ?? $lang->get('product.frequency_default'); ?></p>
                        </div>
                        
                        <div class="warnings">
                            <h4><?php echo $lang->get('product.warnings'); ?></h4>
                            <ul>
                                <?php foreach ($productDetails['warnings'] ?? [] as $warning): ?>
                                    <li><?php echo $warning; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Specifications Tab -->
                <div class="tab-panel" id="specifications">
                    <h3><?php echo $lang->get('product.specifications_title'); ?></h3>
                    <div class="specs-grid">
                        <div class="spec-item">
                            <span class="spec-label"><?php echo $lang->get('product.form'); ?></span>
                            <span class="spec-value"><?php echo $productDetails['form'] ?? ''; ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label"><?php echo $lang->get('product.weight'); ?></span>
                            <span class="spec-value"><?php echo $productDetails['weight'] ?? ''; ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label"><?php echo $lang->get('product.shelf_life'); ?></span>
                            <span class="spec-value"><?php echo $productDetails['shelf_life'] ?? ''; ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label"><?php echo $lang->get('product.storage'); ?></span>
                            <span class="spec-value"><?php echo $productDetails['storage'] ?? ''; ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label"><?php echo $lang->get('product.category'); ?></span>
                            <span class="spec-value"><?php echo $lang->get("category.{$productDetails['category']}"); ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label"><?php echo $lang->get('product.sku'); ?></span>
                            <span class="spec-value"><?php echo $productDetails['sku'] ?? ''; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-panel" id="reviews">
                    <h3><?php echo $lang->get('product.reviews_title'); ?></h3>
                    <div class="reviews-summary">
                        <div class="overall-rating">
                            <div class="rating-number">4.8</div>
                            <div class="stars">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star filled"></i>
                                <?php endfor; ?>
                            </div>
                            <div class="total-reviews"><?php echo $lang->get('product.total_reviews'); ?></div>
                        </div>
                    </div>
                    
                    <div class="reviews-list">
                        <!-- Sample reviews - in real app, these would come from database -->
                        <div class="review-item">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="/assets/images/avatar1.jpg" alt="User" class="reviewer-avatar">
                                    <span class="reviewer-name">Ahmet Y.</span>
                                </div>
                                <div class="review-rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star filled"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Çok etkili bir ürün. Kedim için kullanıyorum ve gerçekten işe yarıyor.</p>
                            </div>
                            <div class="review-date">2 gün önce</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="product-faq">
            <h3><?php echo $lang->get('product.faq_title'); ?></h3>
            <div class="faq-list">
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span><?php echo $lang->get('product.faq_side_effects'); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo $lang->get('product.faq_side_effects_answer'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span><?php echo $lang->get('product.faq_effect_time'); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo $lang->get('product.faq_effect_time_answer'); ?></p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFAQ(this)">
                        <span><?php echo $lang->get('product.faq_cats_dogs'); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo $lang->get('product.faq_cats_dogs_answer'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <?php if (!empty($relatedProducts)): ?>
        <div class="related-products">
            <h3><?php echo $lang->get('product.related_products'); ?></h3>
            <div class="related-products-grid">
                <?php foreach ($relatedProducts as $relatedProduct): ?>
                    <div class="related-product-card">
                        <div class="related-product-image">
                            <img src="<?php echo $relatedProduct['image'] ?? '/assets/images/placeholder.jpg'; ?>" 
                                 alt="<?php echo $relatedProduct['name']; ?>" 
                                 loading="lazy">
                        </div>
                        <div class="related-product-info">
                            <h4><?php echo $relatedProduct['name']; ?></h4>
                            <div class="related-product-price">
                                <?php echo number_format($relatedProduct['price'], 2); ?> ₺
                            </div>
                            <a href="/product?slug=<?php echo $relatedProduct['slug']; ?>" 
                               class="btn btn-secondary">
                                <?php echo $lang->get('product.view_details'); ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<script>
// Product Gallery
function changeMainImage(imageSrc, thumbElement) {
    document.getElementById('mainProductImage').src = imageSrc;
    
    // Update active thumb
    document.querySelectorAll('.thumb-item').forEach(thumb => {
        thumb.classList.remove('active');
    });
    thumbElement.classList.add('active');
}

// Quantity Selector
function changeQuantity(delta) {
    const input = document.getElementById('productQuantity');
    const newValue = Math.max(1, Math.min(99, parseInt(input.value) + delta));
    input.value = newValue;
}

// Add to Cart
function addToCart(productSlug) {
    const quantity = document.getElementById('productQuantity').value;
    
    // Add to cart logic here
    console.log('Adding to cart:', productSlug, 'Quantity:', quantity);
    
    // Show success message
    alert('<?php echo $lang->get("product.added_to_cart"); ?>');
}

// Tab Navigation
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const tabId = this.getAttribute('data-tab');
        
        // Update active tab button
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        // Update active tab panel
        document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
    });
});

// FAQ Toggle
function toggleFAQ(questionElement) {
    const answerElement = questionElement.nextElementSibling;
    const icon = questionElement.querySelector('i');
    
    if (answerElement.style.display === 'block') {
        answerElement.style.display = 'none';
        icon.className = 'fas fa-chevron-down';
    } else {
        answerElement.style.display = 'block';
        icon.className = 'fas fa-chevron-up';
    }
}
</script>

<?php include __DIR__ . '/../includes/Footer.php'; ?>
