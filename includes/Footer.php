    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?php echo SITE_NAME; ?></h3>
                    <p><?php echo $lang->get('home.subtitle'); ?></p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h4><?php echo $lang->get('footer.cats'); ?></h4>
                    <ul>
                        <li><a href="/cats/food"><?php echo $lang->get('nav.food'); ?></a></li>
                        <li><a href="/cats/toys"><?php echo $lang->get('nav.toys'); ?></a></li>
                        <li><a href="/cats/accessories"><?php echo $lang->get('nav.accessories'); ?></a></li>
                        <li><a href="/cats/health"><?php echo $lang->get('nav.cat_health'); ?></a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4><?php echo $lang->get('footer.dogs'); ?></h4>
                    <ul>
                        <li><a href="/dogs/food"><?php echo $lang->get('nav.food'); ?></a></li>
                        <li><a href="/dogs/toys"><?php echo $lang->get('nav.toys'); ?></a></li>
                        <li><a href="/dogs/accessories"><?php echo $lang->get('nav.accessories'); ?></a></li>
                        <li><a href="/dogs/health"><?php echo $lang->get('nav.dog_health'); ?></a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4><?php echo $lang->get('footer.articles'); ?></h4>
                    <ul>
                        <li><a href="/articles/pet-care"><?php echo $lang->get('home.pet_care_title'); ?></a></li>
                        <li><a href="/articles/nutrition"><?php echo $lang->get('nav.dog_nutrition'); ?></a></li>
                        <li><a href="/articles/training"><?php echo $lang->get('nav.dog_training'); ?></a></li>
                        <li><a href="/articles/health"><?php echo $lang->get('nav.dog_health'); ?></a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4><?php echo $lang->get('footer.about'); ?></h4>
                    <ul>
                        <li><a href="/about"><?php echo $lang->get('nav.about'); ?></a></li>
                        <li><a href="/contact"><?php echo $lang->get('footer.contact_form'); ?></a></li>
                        <li><a href="/privacy"><?php echo $lang->get('footer.privacy_policy'); ?></a></li>
                        <li><a href="/terms"><?php echo $lang->get('footer.terms_conditions'); ?></a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. <?php echo $lang->get('footer.all_rights_reserved'); ?></p>
                    <div class="payment-methods">
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <i class="fab fa-cc-paypal"></i>
                        <i class="fab fa-bitcoin"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="/public/js/main.js"></script>
</body>
</html>
