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
                    <div class="lang-menu" id="langMenu" style="display: none;">
                        <?php foreach ($lang->getSupportedLanguages() as $langCode): ?>
                        <a href="/language?lang=<?php echo $langCode; ?>&redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="lang-option">
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
                                            <li><a href="/dental-care">Dental Care</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.tuy-ve-deri-sagligi'); ?></h4>
                                        <ul>
                                            <li><a href="/dermacumin">Dermacumin</a></li>
                                            <li><a href="/retino-a">Retino-A</a></li>
                                            <li><a href="/derma-zn">Derma Zn</a></li>
                                            <li><a href="/derma-hairball">Derma Hairball</a></li>
                                            <li><a href="/salmonoil">Salmonoil</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.uriner-sistem'); ?></h4>
                                        <ul>
                                            <li><a href="/bladder-control">Bladder Control</a></li>
                                            <li><a href="/uticare">Uticare</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.bobrek-sagligi'); ?></h4>
                                        <ul>
                                            <li><a href="/renacure">Renacure</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.sindirim-sistemi'); ?></h4>
                                        <ul>
                                            <li><a href="/canivir">Canivir</a></li>
                                            <li><a href="/coprophagia">Coprophagia</a></li>
                                            <li><a href="/petimmun">Petimmun</a></li>
                                            <li><a href="/derma-hairball">Derma Hairball</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.solunum-sistemi'); ?></h4>
                                        <ul>
                                            <li><a href="/o2-care">O2 Care</a></li>
                                            <li><a href="/phytospan">Phytospan</a></li>
                                            <li><a href="/petimmun">Petimmun</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.eklem-sagligi'); ?></h4>
                                        <ul>
                                            <li><a href="/cartilagoflex">Cartilagoflex</a></li>
                                            <li><a href="/multivit">Multivit</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.kemik-sagligi'); ?></h4>
                                        <ul>
                                            <li><a href="/multivit">Multivit</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.sakinlestirici'); ?></h4>
                                        <ul>
                                            <li><a href="/ease-off">Ease Off</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.gebelik-ve-emzirme-sagligi'); ?></h4>
                                        <ul>
                                            <li><a href="/m-b-care">M&B Care</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.immunoterapi'); ?></h4>
                                        <ul>
                                            <li><a href="/canivir">Canivir</a></li>
                                            <li><a href="/felovir">Felovir</a></li>
                                            <li><a href="/petimmun">Petimmun</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.diski-yeme'); ?></h4>
                                        <ul>
                                            <li><a href="/coprophagia">Coprophagia</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown-section">
                                        <h4><?php echo $lang->get('category.soguk-alginligi'); ?></h4>
                                        <ul>
                                            <li><a href="/phytospan">Phytospan</a></li>
                                            <li><a href="/o2-care">O2 Care</a></li>
                                            <li><a href="/petimmun">Petimmun</a></li>
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
                            <a href="/user-submissions" class="nav-link"><?php echo $lang->get('nav.user_submissions'); ?></a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="/about" class="nav-link"><?php echo $lang->get('nav.about'); ?></a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="/contact" class="nav-link"><?php echo $lang->get('nav.contact'); ?></a>
                        </li>
                        
                        <li class="nav-item">
                            <button class="theme-toggle" onclick="toggleTheme()" title="Toggle Dark/Light Mode">
                                <i class="fas fa-moon" id="theme-icon"></i>
                            </button>
                        </li>
                    </ul>
                </nav>
                
                <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>
    
    <script src="/public/js/main.js"></script>
