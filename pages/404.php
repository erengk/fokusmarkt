<?php
$lang = Language::getInstance();
?>

<?php include __DIR__ . '/../includes/Header.php'; ?>

<main class="main-content">
    <section class="error-section">
        <div class="container">
            <div class="error-content">
                <div class="error-code">404</div>
                <h1>Sayfa Bulunamadı</h1>
                <p>Aradığınız sayfa mevcut değil veya taşınmış olabilir.</p>
                
                <div class="error-actions">
                    <a href="/" class="btn btn-primary">Ana Sayfaya Dön</a>
                    <a href="/contact" class="btn btn-secondary">Bize Ulaşın</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/Footer.php'; ?>
