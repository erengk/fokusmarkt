<?php
$lang = Language::getInstance();
$currentLang = $lang->getCurrentLang();
?>
<!DOCTYPE html>
<html lang="<?php echo $currentLang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="language-selector">
                    <button class="lang-btn" onclick="toggleLanguageMenu()">
                        <i class="fas fa-globe"></i>
                        <span><?php echo strtoupper($currentLang); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="lang-menu" id="langMenu">
                        <?php foreach ($lang->getSupportedLanguages() as $langCode): ?>
                            <a href="?lang=<?php echo $langCode; ?>" class="lang-option">
                                <span class="lang-flag"><?php echo $lang->getLanguageFlag($langCode); ?></span>
                                <span class="lang-name"><?php echo $lang->getLanguageName($langCode); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="top-actions">
                    <div class="search-container">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="<?php echo $lang->get('common.search'); ?>">
                        </div>
                    </div>
                    
                    <div class="user-actions">
                        <a href="/cart" class="action-btn cart-btn">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-count">0</span>
                        </a>
                        <a href="/login" class="action-btn login-btn">
                            <i class="fas fa-user"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="/">
                        <h1 class="logo-text" id="logo-text">Fokus Markt</h1>
                    </a>
                </div>
                
                <nav class="nav">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="/kategoriler" class="nav-link"><?php echo $lang->get('nav.categories'); ?></a>
                            <div class="dropdown-menu">
                                <div class="dropdown-content">
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.agiz-ve-dis-sagligi'); ?></h4>
                                        <ul>
                                            <li><a href="/urun/dental-care">DENTAL CARE (Tablet)</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.tuy-ve-deri-sagligi'); ?></h4>
                                        <ul>
                                            <li><a href="/urun/dermacumin">DERMACUMIN (Jel)</a></li>
                                            <li><a href="/urun/retino-a">RETINO-A (Jel)</a></li>
                                            <li><a href="/urun/derma-zn">DERMA Zn (Malt/Tablet)</a></li>
                                            <li><a href="/urun/derma-hairball">DERMA HAIRBALL (Tablet)</a></li>
                                            <li><a href="/urun/salmon-oil">SALMON OIL (Tablet)</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.uriner-sistem'); ?></h4>
                                        <ul>
                                            <li><a href="/urun/bladder-control">BLADDER CONTROL (Malt/Tablet)</a></li>
                                            <li><a href="/urun/uticare">UTICARE (Malt/Tablet)</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.bobrek-sagligi'); ?></h4>
                                        <ul>
                                            <li><a href="/urun/renacure">RENACURE (Malt)</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.sindirim-sistemi'); ?></h4>
                                        <ul>
                                            <li><a href="/urun/canivir">CANIVIR (Malt/Tablet)</a></li>
                                            <li><a href="/urun/coprophagia">COPROPHAGIA (Malt/Tablet)</a></li>
                                            <li><a href="/urun/petimmun">PETIMMUN (Jel/Malt/Tablet)</a></li>
                                            <li><a href="/urun/derma-hairball">DERMA HAIRBALL (Tablet)</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.solunum-sistemi'); ?></h4>
                                        <ul>
                                            <li><a href="/urun/o2-care">O2 CARE (Malt/Tablet)</a></li>
                                            <li><a href="/urun/phytospan">PHYTOSPAN (Jel/Malt/Tablet)</a></li>
                                            <li><a href="/urun/petimmun">PETIMMUN (Jel/Malt/Tablet)</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.eklem-sagligi'); ?></h4>
                                        <ul>
                                            <li><a href="/urun/cartilagoflex">CARTILAGOFLEX (Malt/Tablet)</a></li>
                                            <li><a href="/urun/multivit">MULTIVIT (Malt/Tablet)</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.sakinlestirici'); ?></h4>
                                        <ul>
                                            <li><a href="/urun/ease-off">EASE OFF (Malt/Tablet)</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.gebelik-ve-emzirme-sagligi'); ?></h4>
                                        <ul>
                                            <li><a href="/urun/m-b-care">M&B CARE (Malt/Tablet)</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.immunoterapi'); ?></h4>
                                        <ul>
                                            <li><a href="/urun/canivir">CANIVIR (Malt/Tablet)</a></li>
                                            <li><a href="/urun/felovir">FELOVIR (Malt)</a></li>
                                            <li><a href="/urun/petimmun">PETIMMUN (Jel/Malt/Tablet)</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.diski-yeme'); ?></h4>
                                        <ul>
                                            <li><a href="/urun/coprophagia">COPROPHAGIA (Malt/Tablet)</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.soguk-alginligi'); ?></h4>
                                        <ul>
                                            <li><a href="/urun/phytospan">PHYTOSPAN (Jel/Malt/Tablet)</a></li>
                                            <li><a href="/urun/o2-care">O2 CARE (Malt/Tablet)</a></li>
                                            <li><a href="/urun/petimmun">PETIMMUN (Jel/Malt/Tablet)</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        
                        <li class="nav-item">
                            <a href="/endikasyonlar" class="nav-link"><?php echo $lang->get('nav.indications'); ?></a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="/makaleler" class="nav-link"><?php echo $lang->get('nav.articles'); ?></a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="/where-to-buy" class="nav-link"><?php echo $lang->get('nav.where_to_buy'); ?></a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="/subscribe" class="nav-link"><?php echo $lang->get('nav.subscribe'); ?></a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="/about" class="nav-link"><?php echo $lang->get('nav.about'); ?></a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="/contact" class="nav-link"><?php echo $lang->get('nav.contact'); ?></a>
                        </li>
                    </ul>
                </nav>
                
                <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>
    
    <!-- Theme Toggle Button -->
    <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark/Light Mode">
        <i class="fas fa-moon" id="theme-icon"></i>
    </button>
    
    <script src="/public/js/main.js"></script>
