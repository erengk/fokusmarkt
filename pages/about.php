<?php
$lang = Language::getInstance();
?>

<?php include __DIR__ . '/../includes/Header.php'; ?>

<main class="main-content">
    <section class="about-section">
        <div class="container">
            <div class="about-content">
                <h1 class="section-title"><?php echo $lang->get('about.title'); ?></h1>
                
                <div class="about-grid">
                    <div class="about-text">
                        <h2><?php echo $lang->get('about.company_name'); ?></h2>
                        <p><?php echo $lang->get('about.description'); ?></p>
                        
                        <h3><?php echo $lang->get('about.mission_title'); ?></h3>
                        <p><?php echo $lang->get('about.mission'); ?></p>
                        
                        <h3><?php echo $lang->get('about.vision_title'); ?></h3>
                        <p><?php echo $lang->get('about.vision'); ?></p>
                        
                        <h3><?php echo $lang->get('about.values_title'); ?></h3>
                        <ul>
                            <?php foreach ($lang->get('about.values') as $value): ?>
                                <li><?php echo $value; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="about-stats">
                        <div class="stat-card">
                            <div class="stat-number">1000+</div>
                            <div class="stat-label"><?php echo $lang->get('about.stats.products'); ?></div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-number">50+</div>
                            <div class="stat-label"><?php echo $lang->get('about.stats.brands'); ?></div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-number">24/7</div>
                            <div class="stat-label"><?php echo $lang->get('about.stats.support'); ?></div>
                        </div>
                        
                        <div class="stat-card">
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
