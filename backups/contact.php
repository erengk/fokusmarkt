<?php
$lang = Language::getInstance();
?>

<?php include __DIR__ . '/../includes/Header.php'; ?>

<main class="main-content">
    <section class="contact-section">
        <div class="container">
            <h1 class="section-title"><?php echo $lang->get('contact.title'); ?></h1>
            
            <div class="contact-grid">
                <div class="contact-info">
                    <h2><?php echo $lang->get('contact.title'); ?></h2>
                    
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h3><?php echo $lang->get('contact.address_title'); ?></h3>
                            <p><?php echo $lang->get('contact.address'); ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h3><?php echo $lang->get('contact.phone_title'); ?></h3>
                            <p><?php echo $lang->get('contact.phone'); ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h3><?php echo $lang->get('contact.email_title'); ?></h3>
                            <p><?php echo $lang->get('contact.email'); ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <h3><?php echo $lang->get('contact.hours_title'); ?></h3>
                            <p><?php echo $lang->get('contact.hours'); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <h2><?php echo $lang->get('contact.form_title'); ?></h2>
                    
                    <form action="/contact" method="POST">
                        <div class="form-group">
                            <label for="name"><?php echo $lang->get('contact.name_label'); ?> *</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email"><?php echo $lang->get('contact.email_label'); ?> *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject"><?php echo $lang->get('contact.subject_label'); ?> *</label>
                            <select id="subject" name="subject" required>
                                <option value="">Seçiniz</option>
                                <option value="general">Genel Bilgi</option>
                                <option value="order">Sipariş Hakkında</option>
                                <option value="product">Ürün Bilgisi</option>
                                <option value="complaint">Şikayet</option>
                                <option value="suggestion">Öneri</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message"><?php echo $lang->get('contact.message_label'); ?> *</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary"><?php echo $lang->get('contact.send_button'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/../includes/Footer.php'; ?>
