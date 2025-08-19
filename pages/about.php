<?php
$lang = Language::getInstance();
?>

<?php include __DIR__ . '/../includes/Header.php'; ?>

<main class="main-content">
    <!-- About Header Section -->
    <section class="about-header-section">
        <div class="container">
            <div class="about-header-content">
                <h1 class="about-title"><?php echo $lang->get('about.title'); ?></h1>
                <p class="about-subtitle"><?php echo $lang->get('about.subtitle'); ?></p>
            </div>
        </div>
    </section>

    <!-- About Content Section -->
    <section class="about-content-section">
        <div class="container">
            <div class="about-content-grid">
                <div class="about-text-content">
                    <div class="about-company card">
                        <h2 class="about-company-title"><?php echo $lang->get('about.company_name'); ?></h2>
                        <p class="about-company-description"><?php echo $lang->get('about.description'); ?></p>
                    </div>
                    
                    <div class="about-mission card">
                        <h3 class="about-section-title"><?php echo $lang->get('about.mission_title'); ?></h3>
                        <p class="about-section-text"><?php echo $lang->get('about.mission'); ?></p>
                    </div>
                    
                    <div class="about-vision card">
                        <h3 class="about-section-title"><?php echo $lang->get('about.vision_title'); ?></h3>
                        <p class="about-section-text"><?php echo $lang->get('about.vision'); ?></p>
                    </div>
                    
                    <div class="about-values card">
                        <h3 class="about-section-title"><?php echo $lang->get('about.values_title'); ?></h3>
                        <ul class="about-values-list">
                            <?php foreach ($lang->get('about.values') as $value): ?>
                                <li class="about-value-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span><?php echo $value; ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                
                <div class="about-stats-content">
                    <div class="about-stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="stat-number">1000+</div>
                            <div class="stat-label"><?php echo $lang->get('about.stats.products'); ?></div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="stat-number">50+</div>
                            <div class="stat-label"><?php echo $lang->get('about.stats.brands'); ?></div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="stat-number">24/7</div>
                            <div class="stat-label"><?php echo $lang->get('about.stats.support'); ?></div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="stat-number">%99</div>
                            <div class="stat-label"><?php echo $lang->get('about.stats.satisfaction'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/Footer.php'; ?>
