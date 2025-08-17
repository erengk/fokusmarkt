<?php
$lang = Language::getInstance();
$product = Product::getInstance();
$categories = $product->getAllCategoriesWithInfo();
?>

<?php include __DIR__ . '/../includes/Header.php'; ?>

<!-- Banner Slider Section -->
<section class="banner-slider">
    <div class="slider-container">
        <div class="slider-wrapper">
            <div class="slide active">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1><?php echo $lang->get('home.hero_title_1'); ?></h1>
                        <p><?php echo $lang->get('home.hero_subtitle_1'); ?></p>
                        <a href="#products" class="cta-button"><?php echo $lang->get('home.hero_cta_1'); ?></a>
                    </div>
                    <div class="slide-image">
                        <video autoplay muted loop class="slide-img">
                            <source src="/assets/views/<?php echo $lang->getCurrentLang(); ?>/banner_1.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
            
            <div class="slide">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1><?php echo $lang->get('home.hero_title_2'); ?></h1>
                        <p><?php echo $lang->get('home.hero_subtitle_2'); ?></p>
                        <a href="#products" class="cta-button"><?php echo $lang->get('home.hero_cta_2'); ?></a>
                    </div>
                    <div class="slide-image">
                        <video autoplay muted loop class="slide-img">
                            <source src="/assets/views/<?php echo $lang->getCurrentLang(); ?>/banner_2.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
            
            <div class="slide">
                <div class="slide-content">
                    <div class="slide-text">
                        <h1><?php echo $lang->get('home.hero_title_3'); ?></h1>
                        <p><?php echo $lang->get('home.hero_subtitle_3'); ?></p>
                        <a href="#categories" class="cta-button"><?php echo $lang->get('home.hero_cta_3'); ?></a>
                    </div>
                    <div class="slide-image">
                        <img src="/assets/views/<?php echo $lang->getCurrentLang(); ?>/banner_3.png" alt="Quality Products" class="slide-img">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="slider-controls">
            <button class="slider-btn prev-btn" onclick="changeSlide(-1)">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="slider-dots">
                <span class="dot active" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
            </div>
            <button class="slider-btn next-btn" onclick="changeSlide(1)">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<main class="main-content">

    <!-- Pet Types Section -->
    <section class="pet-types-section">
        <div class="container">
            <h2 class="section-title text-center mb-2"><?php echo $lang->get('home.pet_types_title'); ?></h2>
            
            <div class="pet-types-grid">
                <?php foreach ($product->getPetTypes() as $petTypeKey => $petTypeName): ?>
                    <div class="pet-type-card">
                        <div class="pet-type-icon">
                            <?php
                            $iconMap = [
                                'kedi' => '🐱',
                                'kopek' => '🐕',
                                'birds' => '🐦',
                                'fish' => '🐠',
                                'small_animals' => '🐹'
                            ];
                            echo $iconMap[$petTypeKey] ?? '🐾';
                            ?>
                        </div>
                        <h3><?php echo $lang->get("pet_types.{$petTypeKey}"); ?></h3>
                        <p><?php echo $lang->get('home.pet_types_subtitle'); ?></p>
                        <a href="/category?pet_type=<?php echo $petTypeKey; ?>" class="btn btn-secondary"><?php echo $lang->get('home.view_products'); ?></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section id="categories" class="categories-section">
        <div class="container">
            <h2 class="section-title text-center mb-2"><?php echo $lang->get('home.featured_products'); ?></h2>
            
            <div class="categories-grid">
                <?php foreach ($categories as $categoryKey => $categoryInfo): ?>
                    <?php 
                    // Kategori için ürünleri al ve tür bilgilerini çek
                    $categoryProducts = $product->getProductsByCategory($categoryKey);
                    $speciesInfo = [];
                    
                    foreach ($categoryProducts as $productSlug => $productData) {
                        $productSpecies = $product->getProductSpecies($productSlug);
                        foreach ($productSpecies as $species) {
                            $speciesInfo[$species['slug']] = $species['name'];
                        }
                    }
                    
                    $speciesClasses = implode(' ', array_keys($speciesInfo));
                    $speciesText = implode(', ', array_values($speciesInfo));
                    ?>
                    <div class="category-card" data-species="<?php echo $speciesClasses; ?>" data-category="<?php echo $categoryKey; ?>">
                        <div class="category-image">
                            <div class="product-slider" data-category="<?php echo $categoryKey; ?>">
                                <?php 
                                // Kategori için ürün görsellerini al
                                $productImages = $product->getCategoryImages($categoryKey);
                                if (!empty($productImages)) {
                                    foreach ($productImages as $index => $image) {
                                        $activeClass = $index === 0 ? 'active' : '';
                                        echo '<div class="slider-item ' . $activeClass . '">';
                                        echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '" loading="lazy">';
                                        echo '</div>';
                                    }
                                } else {
                                    // Fallback: Kategori adının ilk harfi
                                    echo '<div class="placeholder-image">' . substr($categoryInfo['name'], 0, 1) . '</div>';
                                }
                                ?>
                                <?php if (count($productImages) > 1): ?>
                                    <div class="slider-controls">
                                        <button class="slider-prev" onclick="changeCategorySlide('<?php echo $categoryKey; ?>', -1)">‹</button>
                                        <button class="slider-next" onclick="changeCategorySlide('<?php echo $categoryKey; ?>', 1)">›</button>
                                    </div>
                                    <div class="slider-dots">
                                        <?php for ($i = 0; $i < count($productImages); $i++): ?>
                                            <span class="dot <?php echo $i === 0 ? 'active' : ''; ?>" onclick="goToCategorySlide('<?php echo $categoryKey; ?>', <?php echo $i; ?>)"></span>
                                        <?php endfor; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="category-info">
                            <h3><?php echo $lang->get("category.{$categoryKey}"); ?></h3>
                            <p><?php echo $lang->get("category.{$categoryKey}-desc"); ?></p>
                            <div class="category-stats">
                                <span><?php echo $categoryInfo['image_count']; ?> <?php echo $lang->get('category.products'); ?></span>
                                <?php if (!empty($speciesText)): ?>
                                    <span class="species-info"><?php echo $speciesText; ?></span>
                                <?php endif; ?>
                            </div>
                            <a href="<?php echo $categoryInfo['url']; ?>" class="btn btn-primary"><?php echo $lang->get('category.discover'); ?></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3><?php echo $lang->get('home.fast_delivery_title'); ?></h3>
                    <p><?php echo $lang->get('home.fast_delivery_desc'); ?></p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3><?php echo $lang->get('home.secure_shopping_title'); ?></h3>
                    <p><?php echo $lang->get('home.secure_shopping_desc'); ?></p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h3><?php echo $lang->get('home.quality_guarantee_title'); ?></h3>
                    <p><?php echo $lang->get('home.quality_guarantee_desc'); ?></p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3><?php echo $lang->get('home.support_24_7_title'); ?></h3>
                    <p><?php echo $lang->get('home.support_24_7_desc'); ?></p>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
// Category Filter System
let currentFilter = 'all';

function filterCategories(filter) {
    currentFilter = filter;
    
    // Update filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`[data-filter="${filter}"]`).classList.add('active');
    
    // Filter category cards
    const categoryCards = document.querySelectorAll('.category-card');
    let visibleCount = 0;
    
    categoryCards.forEach(card => {
        const speciesData = card.getAttribute('data-species');
        
        if (filter === 'all' || speciesData.includes(filter)) {
            card.classList.remove('filtered-out');
            visibleCount++;
        } else {
            card.classList.add('filtered-out');
        }
    });
    
    // Update stats
    updateFilterStats(filter, visibleCount, categoryCards.length);
}

function updateFilterStats(filter, visibleCount, totalCount) {
    const statsElement = document.getElementById('filterStats');
    let statsText = '';
    
    // Dil paketlerinden çevirileri al
    const translations = {
        'tr': {
            'all': `Tüm kategoriler gösteriliyor (${totalCount} kategori)`,
            'kedi': `Kedi ürünleri gösteriliyor (${visibleCount} kategori)`,
            'kopek': `Köpek ürünleri gösteriliyor (${visibleCount} kategori)`
        },
        'en': {
            'all': `All categories showing (${totalCount} categories)`,
            'kedi': `Cat products showing (${visibleCount} categories)`,
            'kopek': `Dog products showing (${visibleCount} categories)`
        },
        'de': {
            'all': `Alle Kategorien werden angezeigt (${totalCount} Kategorien)`,
            'kedi': `Katzenprodukte werden angezeigt (${visibleCount} Kategorien)`,
            'kopek': `Hundeprodukte werden angezeigt (${visibleCount} Kategorien)`
        }
    };
    
    // Mevcut dili al (URL'den veya localStorage'dan)
    const currentLang = window.location.search.includes('lang=') 
        ? new URLSearchParams(window.location.search).get('lang') 
        : 'tr';
    
    const langTranslations = translations[currentLang] || translations['tr'];
    statsText = langTranslations[filter] || langTranslations['all'];
    
    statsElement.textContent = statsText;
}

// Banner Slider JavaScript
let currentSlideIndex = 0;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');

function showSlide(index) {
    // Hide all slides
    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));
    
    // Show current slide
    if (slides[index]) {
        slides[index].classList.add('active');
        dots[index].classList.add('active');
    }
}

function changeSlide(direction) {
    currentSlideIndex += direction;
    
    if (currentSlideIndex >= slides.length) {
        currentSlideIndex = 0;
    } else if (currentSlideIndex < 0) {
        currentSlideIndex = slides.length - 1;
    }
    
    showSlide(currentSlideIndex);
}

function currentSlide(index) {
    currentSlideIndex = index - 1;
    showSlide(currentSlideIndex);
}

// Auto slide every 5 seconds
setInterval(() => {
    changeSlide(1);
}, 5000);
</script>

<?php include __DIR__ . '/../includes/Footer.php'; ?>
