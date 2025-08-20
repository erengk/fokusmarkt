<?php
$lang = Language::getInstance();
$product = Product::getInstance();
$categories = $product->getAllCategoriesWithInfo();
?>

<?php include __DIR__ . '/../includes/Header.php'; ?>

<!-- New Banner Slider Section -->
<section class="new-banner-slider">
    <div class="new-slider-container">
        <div class="new-slider-wrapper">
            <div class="new-slide active">
                <video autoplay muted loop class="new-slide-img">
                    <source src="/assets/views/<?php echo $lang->getCurrentLang(); ?>/banner_1.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            
            <div class="new-slide">
                <video autoplay muted loop class="new-slide-img">
                    <source src="/assets/views/<?php echo $lang->getCurrentLang(); ?>/banner_2.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            
            <div class="new-slide">
                <img src="/assets/views/<?php echo $lang->getCurrentLang(); ?>/banner_3.png" alt="Banner 3" class="new-slide-img">
            </div>
        </div>
        
        <div class="new-slider-controls">
            <button class="new-slider-btn prev-btn" onclick="changeNewSlide(-1)">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="new-slider-dots">
                <span class="new-dot active" onclick="currentNewSlide(1)"></span>
                <span class="new-dot" onclick="currentNewSlide(2)"></span>
                <span class="new-dot" onclick="currentNewSlide(3)"></span>
            </div>
            <button class="new-slider-btn next-btn" onclick="changeNewSlide(1)">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<main class="main-content">

    <!-- Pet Types Section -->
    <section class="pet-types-section">
        <div class="container">
    
            
            <div class="pet-types-grid">
                <?php foreach ($product->getPetTypes() as $petTypeKey => $petTypeName): ?>
                    <div class="pet-type-card">
                        <?php if ($petTypeKey === 'kedi'): ?>
                            <div class="pet-type-video">
                                <video autoplay muted loop class="pet-video">
                                    <source src="/assets/views/<?php echo $lang->getCurrentLang(); ?>/banner_5.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        <?php elseif ($petTypeKey === 'kopek'): ?>
                            <div class="pet-type-video">
                                <video autoplay muted loop class="pet-video">
                                    <source src="/assets/views/<?php echo $lang->getCurrentLang(); ?>/banner_6.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        <?php else: ?>
                            <div class="pet-type-icon">
                                <?php
                                $iconMap = [
                                    'birds' => '🐦',
                                    'fish' => '🐠',
                                    'small_animals' => '🐹'
                                ];
                                echo $iconMap[$petTypeKey] ?? '🐾';
                                ?>
                            </div>
                        <?php endif; ?>
                        <div class="pet-type-content">
                            <h3><?php echo $lang->get("pet_types.{$petTypeKey}"); ?></h3>
                            <p><?php echo $lang->get('home.pet_types_subtitle'); ?></p>
                            <a href="/category?category=<?php echo $petTypeKey; ?>" class="btn btn-secondary"><?php echo $lang->get('home.view_products'); ?></a>
                        </div>
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
                                        echo '<img src="' . $image['url'] . '" alt="' . ($image['alt'] ?? 'Ürün görseli') . '" loading="lazy">';
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


</script>

<?php include __DIR__ . '/../includes/Footer.php'; ?>
