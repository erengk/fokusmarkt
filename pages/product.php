<?php
$lang = Language::getInstance();
$product = Product::getInstance();

// Get product slug from URL or routing
$productSlug = $productSlug ?? $_GET['slug'] ?? '';

if (empty($productSlug)) {
    header('Location: /404');
    exit;
}

// Get selected form from URL parameter or default to first available form
$selectedForm = $_GET['form'] ?? '';

// Get product details
$productDetails = $product->getProductBySlug($productSlug);
$productForms = $product->getProductForms($productSlug);

if (!$productDetails) {
    header('Location: /404');
    exit;
}

// If no form selected, select the first available form
if (empty($selectedForm) && !empty($productForms)) {
    $selectedForm = $productForms[0]['form_name'];
}

// Get form-specific variant details
$selectedVariant = null;
if ($selectedForm) {
    $selectedVariant = $product->getProductVariantByForm($productSlug, $selectedForm);
}

// Get form-specific images
$productImages = $product->getProductImagesByForm($productSlug, $selectedForm);
$productSpecies = $product->getProductSpecies($productSlug);

// Get related products
$relatedProducts = $product->getRelatedProducts($productSlug, $productDetails['category']);

// Get complementary products (birlikte iyi gider)
try {
    $complementaryProducts = $product->getComplementaryProducts($productSlug, 6);
} catch (Exception $e) {
    $complementaryProducts = [];
    error_log("Complementary products error: " . $e->getMessage());
}

// Prepare JSON data for all forms (for dynamic updates)
$allFormsData = [];
if (!empty($productForms)) {
    foreach ($productForms as $form) {
        $formName = $form['form_name'];
        $variant = $product->getProductVariantByForm($productSlug, $formName);
        $images = $product->getProductImagesByForm($productSlug, $formName);
        
        // Form açıklamalarını dil paketinden al
        $formDescriptions = [
            'jel' => $lang->get('product.form_jel'),
            'malt' => $lang->get('product.form_malt'),
            'tablet' => $lang->get('product.form_tablet')
        ];
        
        $formKey = strtolower($formName);
        $description = $formDescriptions[$formKey] ?? $form['description'] ?? '';
        
        $allFormsData[$formName] = [
            'images' => $images,
            'price' => $variant['price'] ?? $productDetails['price'],
            'old_price' => $variant['old_price'] ?? null,
            'stock' => $variant['stock'] ?? $productDetails['stock'] ?? 0,
            'description' => $description
        ];
    }
}
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

        <!-- Main Product Section -->
        <div class="product-main">
            <div class="product-container">
                <!-- Product Gallery -->
            <div class="product-gallery">
                <div class="product-gallery-main">
                    <div class="main-image-container">
                            <div class="image-slider">
                                <?php if (!empty($productImages)): ?>
                                    <?php foreach ($productImages as $index => $image): ?>
                                        <div class="slide <?php echo $index === 0 ? 'active' : ''; ?>" data-index="<?php echo $index; ?>">
                                            <img src="<?php echo $image['image_path']; ?>" 
                                                 alt="<?php echo $productDetails['name'] . ' - ' . $image['alt_text']; ?>" 
                                                 class="main-product-image" 
                                                 loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>">
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="slide active">
                                        <img src="/assets/images/placeholder.jpg" 
                             alt="<?php echo $productDetails['name']; ?>" 
                                             class="main-product-image">
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Slider Navigation -->
                            <?php if (count($productImages) > 1): ?>
                                <button class="slider-nav prev" onclick="changeSlide(-1)">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="slider-nav next" onclick="changeSlide(1)">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                                
                                <!-- Slider Dots -->
                                <div class="slider-dots">
                                    <?php foreach ($productImages as $index => $image): ?>
                                        <button class="dot <?php echo $index === 0 ? 'active' : ''; ?>" 
                                                onclick="goToSlide(<?php echo $index; ?>)"></button>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="zoom-indicator">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                </div>
                
                <?php if (count($productImages) > 1): ?>
                <div class="product-gallery-thumbs">
                    <?php foreach ($productImages as $index => $image): ?>
                        <div class="thumb-item <?php echo $index === 0 ? 'active' : ''; ?>" 
                                 onclick="goToSlide(<?php echo $index; ?>)">
                            <img src="<?php echo $image['image_path']; ?>" 
                                 alt="<?php echo $productDetails['name'] . ' - ' . $image['alt_text']; ?>" 
                                 loading="lazy">
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

                <!-- Product Info -->
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
                        <span class="rating-text">4.8 (127 değerlendirme)</span>
                    </div>

                    <!-- Product Price -->
                    <div class="product-price">
                        <?php if ($selectedVariant): ?>
                            <span class="current-price" id="productPrice"><?php echo number_format($selectedVariant['price'], 2); ?> ₺</span>
                            <?php if (isset($selectedVariant['old_price']) && $selectedVariant['old_price'] > $selectedVariant['price']): ?>
                                <span class="old-price" id="productOldPrice"><?php echo number_format($selectedVariant['old_price'], 2); ?> ₺</span>
                                <span class="discount-badge">-%<?php echo round((($selectedVariant['old_price'] - $selectedVariant['price']) / $selectedVariant['old_price']) * 100); ?></span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="current-price" id="productPrice"><?php echo number_format($productDetails['price'] ?? 0, 2); ?> ₺</span>
                        <?php endif; ?>
                    </div>

                    <!-- Form Selection -->
                    <?php if (!empty($productForms)): ?>
                    <div class="form-selection">
                        <h4>Form Seçimi</h4>
                        <div class="form-options">
                            <?php foreach ($productForms as $form): ?>
                                <label class="form-option <?php echo $selectedForm === $form['form_name'] ? 'checked' : ''; ?>">
                                    <input type="radio" name="product_form" value="<?php echo $form['form_name']; ?>" 
                                           <?php echo $selectedForm === $form['form_name'] ? 'checked' : ''; ?>>
                                    <div class="form-option-text">
                                        <strong><?php echo $product->getProductFormName($form['form_name']); ?></strong>
                                        <span class="form-description"><?php echo $form['description']; ?></span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Key Benefits -->
                    <?php 
                    $benefits = is_string($productDetails['benefits'] ?? '') ? json_decode($productDetails['benefits'], true) : ($productDetails['benefits'] ?? []);
                    if (!empty($benefits)): 
                    ?>
                    <div class="product-usp">
                        <h3>Temel Faydalar</h3>
                        <ul class="usp-list">
                            <?php foreach ($benefits as $benefit): ?>
                                <li><i class="fas fa-check-circle"></i> <?php echo $benefit; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <!-- Purchase Section -->
                    <div class="product-purchase">
                    <div class="purchase-actions">
                        <div class="quantity-selector">
                                <button class="qty-btn" onclick="changeQuantity(-1)">−</button>
                            <input type="number" value="1" min="1" max="99" id="productQuantity" class="qty-input">
                            <button class="qty-btn" onclick="changeQuantity(1)">+</button>
                        </div>
                        
                            <button class="btn-add-to-cart" onclick="addToCart()">
                            <i class="fas fa-shopping-cart"></i>
                                Sepete Ekle
                        </button>
                    </div>

                    <div class="stock-status">
                        <i class="fas fa-check-circle"></i>
                            <span id="productStock">Stokta Var</span>
                            <span class="stock-quantity">(<?php echo $selectedVariant['stock'] ?? $productDetails['stock'] ?? 0; ?> adet)</span>
                    </div>

                    <div class="payment-options">
                            <span class="payment-text">Güvenli Ödeme Seçenekleri</span>
                        <div class="payment-icons">
                            <i class="fab fa-cc-visa"></i>
                            <i class="fab fa-cc-mastercard"></i>
                            <img src="/assets/iyzico-logo-pack/footer_iyzico_ile_ode/Colored/logo_band_colored@2x.png" alt="iyzico" class="payment-icon">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="product-tabs">
            <div class="tab-navigation">
                <button class="tab-btn active" data-tab="description">
                    Ürün Açıklaması
                </button>
                <button class="tab-btn" data-tab="indications">
                    Endikasyonlar
                </button>
                <button class="tab-btn" data-tab="ingredients">
                    İçerik
                </button>
                <button class="tab-btn" data-tab="usage">
                    Kullanım
                </button>
                <button class="tab-btn" data-tab="specifications">
                    Özellikler
                </button>
                <button class="tab-btn" data-tab="reviews">
                    Değerlendirmeler
                </button>
                <button class="tab-btn" data-tab="faq">
                    Sık Sorulanlar
                </button>
            </div>

            <div class="tab-content">
                <!-- Description Tab -->
                <div class="tab-panel active" id="description">
                    <h3>Ürün Açıklaması</h3>
                    <div class="product-description">
                        <p><?php echo $productDetails['description'] ?? 'Ürün açıklaması güncelleniyor...'; ?></p>
                        
                        <?php if (!empty($productDetails['short_description'])): ?>
                        <div class="short-description">
                            <h4>Kısa Açıklama</h4>
                            <p><?php echo $productDetails['short_description']; ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($productDetails['active_ingredients'])): ?>
                        <div class="active-ingredients">
                            <h4>Aktif İçerikler</h4>
                            <p><?php echo $productDetails['active_ingredients']; ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Indications Tab -->
                <div class="tab-panel" id="indications">
                    <h3>Endikasyonlar</h3>
                    <?php if (!empty($productDetails['indications'])): ?>
                    <ul class="indications-list">
                        <?php foreach ($productDetails['indications'] as $indication): ?>
                            <li><i class="fas fa-chevron-right"></i> <?php echo $indication; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <p>Endikasyon bilgileri güncelleniyor...</p>
                    <?php endif; ?>
                </div>

                <!-- Ingredients Tab -->
                <div class="tab-panel" id="ingredients">
                    <h3>İçerik Bilgileri</h3>
                    <?php if (!empty($productDetails['ingredients'])): ?>
                    <div class="ingredients-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>İçerik</th>
                                    <th>Fonksiyon</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productDetails['ingredients'] as $ingredient): ?>
                                    <tr>
                                        <td><?php echo $ingredient['name']; ?></td>
                                        <td><?php echo $ingredient['function'] ?? '-'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <p>İçerik bilgileri güncelleniyor...</p>
                    <?php endif; ?>
                </div>

                <!-- Usage Tab -->
                <div class="tab-panel" id="usage">
                    <h3>Kullanım Talimatları</h3>
                    <div class="usage-instructions">
                        <div class="dosage-info">
                            <h4>Dozaj</h4>
                            <p><?php echo $productDetails['dosage_instructions'] ?? 'Veteriner hekim tavsiyesi ile kullanınız.'; ?></p>
                        </div>
                        
                        <div class="frequency-info">
                            <h4>Kullanım Sıklığı</h4>
                            <p>Günde 1-2 kez, veteriner hekim önerisi doğrultusunda</p>
                        </div>
                        
                        <?php if (!empty($productDetails['warnings'])): ?>
                        <div class="warnings">
                            <h4>Uyarılar</h4>
                            <ul>
                                <?php foreach ($productDetails['warnings'] as $warning): ?>
                                    <li><?php echo $warning; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Specifications Tab -->
                <div class="tab-panel" id="specifications">
                    <h3>Teknik Özellikler</h3>
                    <div class="specs-grid">
                        <div class="spec-item">
                            <span class="spec-label">Form</span>
                            <span class="spec-value"><?php echo $selectedVariant['name'] ?? 'Belirtilmemiş'; ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Ağırlık</span>
                            <span class="spec-value"><?php echo $selectedVariant['weight'] ?? 'Belirtilmemiş'; ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Raf Ömrü</span>
                            <span class="spec-value">2 yıl</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Saklama</span>
                            <span class="spec-value">Serin ve kuru yerde saklayınız</span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Kategori</span>
                            <span class="spec-value"><?php echo $product->getCategoryName($productDetails['category']); ?></span>
                        </div>
                        <div class="spec-item">
                            <span class="spec-label">Türler</span>
                            <span class="spec-value">
                                <?php 
                                if (!empty($productSpecies)) {
                                    echo implode(', ', array_column($productSpecies, 'name'));
                                } else {
                                    echo 'Kedi ve Köpek';
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-panel" id="reviews">
                    <h3>Müşteri Değerlendirmeleri</h3>
                    <div class="reviews-summary">
                        <div class="overall-rating">
                            <div class="rating-number">4.8</div>
                            <div class="stars">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star filled"></i>
                                <?php endfor; ?>
                            </div>
                            <div class="total-reviews">127 değerlendirme</div>
                        </div>
                    </div>
                    
                    <div class="reviews-list">
                        <!-- Sample reviews -->
                        <div class="review-item">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="/assets/images/avatar1.jpg" alt="User" class="reviewer-avatar" onerror="this.style.display='none'">
                                    <span class="reviewer-name">Ayşe K.</span>
                                </div>
                                <div class="review-rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star filled"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Kedim için aldım ve gerçekten çok etkili oldu. Tavsiye ederim.</p>
                            </div>
                            <div class="review-date">3 gün önce</div>
                        </div>
                        
                        <div class="review-item">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <img src="/assets/images/avatar2.jpg" alt="User" class="reviewer-avatar" onerror="this.style.display='none'">
                                    <span class="reviewer-name">Mehmet T.</span>
                                </div>
                                <div class="review-rating">
                                    <?php for ($i = 1; $i <= 4; $i++): ?>
                                        <i class="fas fa-star filled"></i>
                                    <?php endfor; ?>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>Köpeğim için kullanıyorum. Etkisini görmek biraz zaman aldı ama sonuç olumlu.</p>
                            </div>
                            <div class="review-date">1 hafta önce</div>
                </div>
            </div>
        </div>

                <!-- FAQ Tab -->
                <div class="tab-panel" id="faq">
                    <h3>Sık Sorulan Sorular</h3>
                    <?php 
                    $faq = is_string($productDetails['faq'] ?? '') ? json_decode($productDetails['faq'], true) : ($productDetails['faq'] ?? []);
                    if (!empty($faq)): 
                    ?>
                    <div class="faq-list">
                        <?php foreach ($faq as $faqItem): ?>
                        <div class="faq-item">
                            <div class="faq-question" onclick="toggleFAQ(this)">
                                <span><?php echo $faqItem['question']; ?></span>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p><?php echo $faqItem['answer']; ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <p>FAQ bilgileri güncelleniyor...</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Complementary Products (Birlikte İyi Gider) -->
        <?php if (!empty($complementaryProducts)): ?>
        <div class="complementary-products">
            <h3>🔄 Birlikte İyi Gider</h3>
            <p class="complementary-description">Bu ürünle birlikte kullanılması önerilen tamamlayıcı ürünler</p>
            <div class="complementary-products-grid">
                <?php foreach ($complementaryProducts as $complementaryProduct): ?>
                    <div class="complementary-product-card">
                        <div class="complementary-product-image">
                            <?php if (!empty($complementaryProduct['video_path'])): ?>
                                <video 
                                    src="<?php echo $complementaryProduct['video_path']; ?>" 
                                    type="video/quicktime"
                                    muted 
                                    loop 
                                    playsinline
                                    preload="auto"
                                    onmouseover="this.play()" 
                                    onmouseout="this.pause(); this.currentTime=0;"
                                    onclick="window.location.href='/<?php echo $complementaryProduct['slug']; ?>'"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                </video>
                                <div class="video-play-overlay" onclick="window.location.href='/<?php echo $complementaryProduct['slug']; ?>'" style="display: none;">
                                    <i class="fas fa-play"></i>
                                </div>
                            <?php else: ?>
                                <img src="/assets/images/placeholder.jpg" 
                                     alt="<?php echo $complementaryProduct['name']; ?>" 
                                     loading="lazy"
                                     onclick="window.location.href='/<?php echo $complementaryProduct['slug']; ?>'">
                            <?php endif; ?>
                        </div>
                        <div class="complementary-product-info">
                            <h4><?php echo $complementaryProduct['name']; ?></h4>
                            <div class="complementary-product-price">
                                <?php echo number_format($complementaryProduct['price'] ?? 0, 2); ?> ₺
                            </div>
                            <a href="/<?php echo $complementaryProduct['slug']; ?>" 
                               class="btn btn-primary">
                                İncele
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
// Product data for dynamic updates
const productFormsData = <?php echo json_encode($allFormsData); ?>;

// Global slider variables - will be initialized in DOMContentLoaded
var currentSlide = 0;
var slides = [];
var dots = [];
var thumbItems = [];

// Initialize product page when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize slider variables
    slides = document.querySelectorAll('.slide');
    dots = document.querySelectorAll('.dot');
    thumbItems = document.querySelectorAll('.thumb-item');
    currentSlide = 0;
    

    
    // Add to cart function with stock update
    function addToCart() {
        const selectedForm = document.querySelector('input[name="product_form"]:checked');
        if (!selectedForm) {
            alert('Lütfen bir form seçin');
            return;
        }
        
        const formName = selectedForm.value;
        const formData = productFormsData[formName];
        
        if (!formData || formData.stock <= 0) {
            alert('Bu form stokta yok');
            return;
        }
        
        // Get quantity from input
        const quantityInput = document.querySelector('input[name="quantity"]');
        const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;
        
        if (quantity > formData.stock) {
            alert('Yeterli stok yok. Mevcut stok: ' + formData.stock + ' adet');
        return;
    }
    
        // Update stock in data
        formData.stock -= quantity;
        
        // Update stock display
        const stockQuantityElement = document.querySelector('.stock-quantity');
        if (stockQuantityElement) {
            stockQuantityElement.textContent = formData.stock + ' adet';
        }
        
        // Update stock status
        const stockElement = document.querySelector('.stock-status');
        if (stockElement) {
            if (formData.stock > 0) {
                stockElement.textContent = '✓ Stokta var';
                stockElement.className = 'stock-status';
            } else {
                stockElement.textContent = '✗ Stokta yok';
                stockElement.className = 'stock-status out-of-stock';
            }
        }
        
        // Disable form option if out of stock
        if (formData.stock <= 0) {
            const formOption = document.querySelector(`input[name="product_form"][value="${formName}"]`);
            if (formOption) {
                formOption.disabled = true;
                formOption.closest('.form-option').classList.add('disabled');
            }
        }
        
        // Here you would normally add to cart via AJAX
        // For now, just show a success message
        alert(`${quantity} adet ${formName} sepete eklendi. Kalan stok: ${formData.stock} adet`);
    }
    // Initialize tab navigation
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            console.log('Tab clicked:', tabId);
            
            // Update active tab button
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Update active tab panel
            document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.remove('active'));
            const targetPanel = document.getElementById(tabId);
            if (targetPanel) {
                targetPanel.classList.add('active');
                console.log('Tab panel activated:', tabId);
            } else {
                console.log('Tab panel not found:', tabId);
            }
        });
    });
    
    // Initialize FAQ toggle
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const isActive = this.classList.contains('active');
            
            // Close all FAQ items
            document.querySelectorAll('.faq-question').forEach(q => {
                q.classList.remove('active');
                q.nextElementSibling.classList.remove('active');
            });
            
            // Open clicked item if it wasn't already active
            if (!isActive) {
                this.classList.add('active');
                answer.classList.add('active');
            }
        });
    });
    
    // Initialize first FAQ item as open
    const firstFAQQuestion = document.querySelector('.faq-question');
    if (firstFAQQuestion) {
        firstFAQQuestion.classList.add('active');
        const firstFAQAnswer = firstFAQQuestion.nextElementSibling;
        if (firstFAQAnswer) {
            firstFAQAnswer.classList.add('active');
        }
    }
    
    // Initialize video error handling
    document.querySelectorAll('.complementary-product-image video').forEach(video => {
        video.addEventListener('error', function() {
            console.log('Video error:', this.src);
            this.style.display = 'none';
            const overlay = this.nextElementSibling;
            if (overlay && overlay.classList.contains('video-play-overlay')) {
                overlay.style.display = 'flex';
            }
        });
        
        video.addEventListener('loadeddata', function() {
            console.log('Video loaded successfully:', this.src);
            // Try to play the video after it's loaded
            this.play().catch(function(error) {
                console.log('Video autoplay failed:', error);
            });
        });
        
        video.addEventListener('canplay', function() {
            // Video is ready to play
            console.log('Video can play:', this.src);
        });
    });
    
    // Initialize form selection
    console.log('Initializing form selection...');
    const formInputs = document.querySelectorAll('input[name="product_form"]');
    console.log('Found form inputs:', formInputs.length);
    
    formInputs.forEach(radio => {
        console.log('Adding event listener to:', radio.value);
        radio.addEventListener('change', function() {
            console.log('Form input changed:', this.value, this.checked);
            if (this.checked) {
                console.log('Calling changeProductForm with:', this.value);
                // Update visual state
                document.querySelectorAll('.form-option').forEach(opt => opt.classList.remove('checked'));
                this.closest('.form-option').classList.add('checked');
                
                // Update product data directly here
                const formName = this.value;
                console.log('=== changeProductForm START ===');
                console.log('Form changed to:', formName);
                
                console.log('productFormsData:', productFormsData);
                const formData = productFormsData[formName];
                console.log('Form data for', formName, ':', formData);
                if (!formData) {
                    console.log('No form data found for:', formName);
                    return;
                }
                
                // Update price
                const currentPriceElement = document.querySelector('.current-price');
                if (currentPriceElement && formData.price) {
                    currentPriceElement.textContent = formData.price.toLocaleString('tr-TR', {
            minimumFractionDigits: 2, 
            maximumFractionDigits: 2 
                    }) + ' ₺';
                }
                
                // Update old price if exists
                const oldPriceElement = document.querySelector('.old-price');
                if (oldPriceElement && formData.old_price) {
                    oldPriceElement.textContent = formData.old_price.toLocaleString('tr-TR', {
                minimumFractionDigits: 2, 
                maximumFractionDigits: 2 
                    }) + ' ₺';
                    oldPriceElement.style.display = 'block';
                } else if (oldPriceElement) {
                    oldPriceElement.style.display = 'none';
                }
                
                // Update stock status and quantity
                const stockElement = document.querySelector('#productStock');
                const stockQuantityElement = document.querySelector('.stock-quantity');
                
                if (stockElement) {
                    if (formData.stock > 0) {
                        stockElement.textContent = 'Stokta Var';
                        stockElement.className = '';
                    } else {
                        stockElement.textContent = 'Tükendi';
                        stockElement.className = 'out-of-stock';
                    }
                }
                
                // Update stock quantity display
                if (stockQuantityElement) {
                    if (formData.stock > 0) {
                        stockQuantityElement.textContent = '(' + formData.stock + ' adet)';
    } else {
                        stockQuantityElement.textContent = '';
                    }
                }
                
                // Update images
                console.log('Updating images:', formData.images);
                updateProductImages(formData.images);
            }
        });
    });
});

// Image Slider Functions
// Note: currentSlide, slides, dots, thumbItems are already declared globally above

function changeSlide(direction) {
    const totalSlides = slides.length;
    currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
    updateSlider();
}

function goToSlide(index) {
    currentSlide = index;
    updateSlider();
}

function updateSlider() {
    // Update slides
    slides.forEach((slide, index) => {
        slide.classList.toggle('active', index === currentSlide);
    });
    
    // Update dots
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
    });
    
    // Update thumbnails
    thumbItems.forEach((thumb, index) => {
        thumb.classList.toggle('active', index === currentSlide);
    });
}

// Auto-play slider (optional)
let autoPlayInterval;

function startAutoPlay() {
    autoPlayInterval = setInterval(() => {
        if (slides.length > 1) {
            changeSlide(1);
        }
    }, 5000); // Change slide every 5 seconds
}

function stopAutoPlay() {
    if (autoPlayInterval) {
        clearInterval(autoPlayInterval);
    }
}

// Initialize auto-play when page loads
if (slides.length > 1) {
    startAutoPlay();
    
    // Stop auto-play when user interacts with slider
    const sliderContainer = document.querySelector('.main-image-container');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', stopAutoPlay);
        sliderContainer.addEventListener('mouseleave', startAutoPlay);
    }
}



// Update Product Images Function - Simple approach
function updateProductImages(images) {
    console.log('updateProductImages called with:', images);
    if (!images || images.length === 0) {
        console.log('No images provided');
        return;
    }
    
    // Simply update image sources without recreating elements
    const slideImages = document.querySelectorAll('.slide img');
    const thumbnailImages = document.querySelectorAll('.thumb-item img');
    
    // Update main slider images
    slideImages.forEach((img, index) => {
        if (images[index]) {
            img.src = images[index].image_path;
            img.alt = images[index].alt_text || 'Ürün görseli';
        }
    });
    
    // Update thumbnail images
    thumbnailImages.forEach((img, index) => {
        if (images[index]) {
            img.src = images[index].image_path;
            img.alt = images[index].alt_text || 'Ürün görseli';
        }
    });
    
    // Reset to first slide
    currentSlide = 0;
    updateSlider();
    
    console.log('Images updated successfully');
}

// FAQ Toggle Function
function toggleFAQ(element) {
    const answer = element.nextElementSibling;
    const isActive = element.classList.contains('active');
    
    // Close all FAQ items
    document.querySelectorAll('.faq-question').forEach(q => {
        q.classList.remove('active');
        q.nextElementSibling.classList.remove('active');
    });
    
    // Open clicked item if it wasn't already active
    if (!isActive) {
        element.classList.add('active');
        answer.classList.add('active');
    }
}
</script>

<?php include __DIR__ . '/../includes/Footer.php'; ?>