// Fokus Markt JavaScript - Clean Version
(function() {
    'use strict';
    
    // Global variables for sliders
    let currentNewSlideIndex = 0;
    let newSlides = [];
    let newDots = [];
    let currentSlideIndex = 0;
    let slides = [];
    let dots = [];
    
    // Category slider variables
    const categorySliders = {};
    const categoryAutoPlayIntervals = {};
    
    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initializeApp();
    });
    
    function initializeApp() {
        // Initialize banner elements
        slides = document.querySelectorAll('.slide');
        dots = document.querySelectorAll('.dot');
        newSlides = document.querySelectorAll('.new-slide');
        newDots = document.querySelectorAll('.new-dot');
        
        // Initialize all functionality
        initDropdowns();
        initLanguageMenu();
        initMobileMenu();
        initSearch();
        initSmoothScrolling();
        initButtonAnimations();
        initIntersectionObserver();
        initBannerSliders();
        initCategorySliders();
        initTheme();
    }
    
    function initDropdowns() {
        const navItems = document.querySelectorAll('.nav-item');
        
        navItems.forEach(item => {
            const dropdown = item.querySelector('.dropdown-menu');
            if (dropdown) {
                item.addEventListener('mouseenter', function() {
                    dropdown.classList.add('active');
                });
                
                item.addEventListener('mouseleave', function() {
                    dropdown.classList.remove('active');
                });
            }
        });
    }
    
    function initLanguageMenu() {
        const langBtn = document.querySelector('.lang-btn');
        const langMenu = document.getElementById('langMenu');
        
        if (langBtn && langMenu) {
            langBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (langMenu.style.display === 'none' || langMenu.style.display === '') {
                    langMenu.style.display = 'block';
                } else {
                    langMenu.style.display = 'none';
                }
            });
            
            document.addEventListener('click', function(e) {
                if (!langBtn.contains(e.target) && !langMenu.contains(e.target)) {
                    langMenu.style.display = 'none';
                }
            });
        }
    }
    
    function initMobileMenu() {
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const nav = document.querySelector('.nav');
        
        if (mobileMenuBtn && nav) {
            mobileMenuBtn.addEventListener('click', function() {
                nav.classList.toggle('active');
            });
            
            const navLinks = nav.querySelectorAll('a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    nav.classList.remove('active');
                });
            });
        }
    }
    
    function initSearch() {
        const searchInput = document.querySelector('.search-box input');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const query = this.value.trim();
                    if (query) {
                        window.location.href = `/search?q=${encodeURIComponent(query)}`;
                    }
                }
            });
        }
    }
    
    function initSmoothScrolling() {
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        anchorLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }
    
    function initButtonAnimations() {
        const buttons = document.querySelectorAll('.btn, .cta-button');
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                if (!this.classList.contains('loading')) {
                    this.classList.add('loading');
                    this.style.pointerEvents = 'none';
                    
                    setTimeout(() => {
                        this.classList.remove('loading');
                        this.style.pointerEvents = 'auto';
                    }, 1000);
                }
            });
        });
    }
    
    function initIntersectionObserver() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);
        
        const animateElements = document.querySelectorAll('.category-card, .pet-type-card, .feature-card');
        animateElements.forEach(el => {
            observer.observe(el);
        });
    }
    
    function initBannerSliders() {
        // Banner slider auto-play
        let autoPlayInterval = setInterval(() => {
            changeSlide(1);
        }, 5000);
        
        // New banner auto-play
        let newBannerAutoPlayInterval = setInterval(() => {
            changeNewSlide(1);
        }, 4000);
        
        // Pause on hover
        const bannerSlider = document.querySelector('.banner-slider');
        if (bannerSlider) {
            bannerSlider.addEventListener('mouseenter', function() {
                if (autoPlayInterval) {
                    clearInterval(autoPlayInterval);
                }
            });
            
            bannerSlider.addEventListener('mouseleave', function() {
                autoPlayInterval = setInterval(() => {
                    changeSlide(1);
                }, 5000);
            });
        }
    }
    
    function initCategorySliders() {
        const categoryCards = document.querySelectorAll('.category-card');
        categoryCards.forEach(card => {
            const categoryKey = card.getAttribute('data-category');
            if (categoryKey) {
                startCategoryAutoPlay(categoryKey);
                
                card.addEventListener('mouseenter', () => {
                    stopCategoryAutoPlay(categoryKey);
                });
                
                card.addEventListener('mouseleave', () => {
                    startCategoryAutoPlay(categoryKey);
                });
            }
        });
    }
    
    function initTheme() {
        const savedTheme = localStorage.getItem('theme');
        const themeIcon = document.getElementById('theme-icon');
        const logoText = document.getElementById('logo-text');
        
        if (savedTheme === 'dark') {
            document.body.setAttribute('data-theme', 'dark');
            document.documentElement.setAttribute('data-theme', 'dark');
            if (themeIcon) {
                themeIcon.className = 'fas fa-sun';
            }
            if (logoText) {
                logoText.style.color = '#1B9CFC';
            }
        } else {
            document.body.setAttribute('data-theme', 'light');
            document.documentElement.setAttribute('data-theme', 'light');
        }
    }
    
    // Global functions for onclick handlers
    window.toggleLanguageMenu = function() {
        const menu = document.getElementById('langMenu');
        if (menu) {
            if (menu.style.display === 'none' || menu.style.display === '') {
                menu.style.display = 'block';
            } else {
                menu.style.display = 'none';
            }
        }
    };
    
    window.toggleMobileMenu = function() {
        const nav = document.querySelector('.nav');
        if (nav) {
            nav.classList.toggle('active');
        }
    };
    
    // New Banner Slider Functions
    window.showNewSlide = function(index) {
        newSlides.forEach(slide => slide.classList.remove('active'));
        newDots.forEach(dot => dot.classList.remove('active'));
        
        if (newSlides[index]) {
            newSlides[index].classList.add('active');
            newDots[index].classList.add('active');
        }
    };
    
    window.changeNewSlide = function(direction) {
        currentNewSlideIndex += direction;
        
        if (currentNewSlideIndex >= newSlides.length) {
            currentNewSlideIndex = 0;
        } else if (currentNewSlideIndex < 0) {
            currentNewSlideIndex = newSlides.length - 1;
        }
        
        showNewSlide(currentNewSlideIndex);
    };
    
    window.currentNewSlide = function(index) {
        currentNewSlideIndex = index - 1;
        showNewSlide(currentNewSlideIndex);
    };
    
    // Banner Slider Functions
    window.showSlide = function(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        
        if (slides[index]) {
            slides[index].classList.add('active');
            dots[index].classList.add('active');
        }
    };
    
    window.changeSlide = function(direction) {
        currentSlideIndex += direction;
        
        if (currentSlideIndex >= slides.length) {
            currentSlideIndex = 0;
        } else if (currentSlideIndex < 0) {
            currentSlideIndex = slides.length - 1;
        }
        
        showSlide(currentSlideIndex);
    };
    
    window.currentSlide = function(index) {
        currentSlideIndex = index - 1;
        showSlide(currentSlideIndex);
    };
    
    // Category Slider Functions
    window.changeCategorySlide = function(categoryKey, direction) {
        if (!categorySliders[categoryKey]) {
            categorySliders[categoryKey] = 0;
        }
        
        // Narrow selector to the actual slider container inside the card
        const slider = document.querySelector(`.category-card[data-category="${categoryKey}"] .product-slider[data-category="${categoryKey}"]`);
        if (!slider) return;
        
        const items = slider.querySelectorAll('.slider-item');
        const dots = slider.querySelectorAll('.dot');
        
        if (items.length === 0) return;
        
        items[categorySliders[categoryKey]].classList.remove('active');
        if (dots[categorySliders[categoryKey]]) {
            dots[categorySliders[categoryKey]].classList.remove('active');
        }
        
        categorySliders[categoryKey] += direction;
        
        if (categorySliders[categoryKey] >= items.length) {
            categorySliders[categoryKey] = 0;
        } else if (categorySliders[categoryKey] < 0) {
            categorySliders[categoryKey] = items.length - 1;
        }
        
        items[categorySliders[categoryKey]].classList.add('active');
        if (dots[categorySliders[categoryKey]]) {
            dots[categorySliders[categoryKey]].classList.add('active');
        }
    };
    
    window.goToCategorySlide = function(categoryKey, index) {
        // Narrow selector to the actual slider container inside the card
        const slider = document.querySelector(`.category-card[data-category="${categoryKey}"] .product-slider[data-category="${categoryKey}"]`);
        if (!slider) return;
        
        const items = slider.querySelectorAll('.slider-item');
        const dots = slider.querySelectorAll('.dot');
        
        if (items.length === 0 || index >= items.length) return;
        
        const currentIndex = categorySliders[categoryKey] || 0;
        items[currentIndex].classList.remove('active');
        if (dots[currentIndex]) {
            dots[currentIndex].classList.remove('active');
        }
        
        categorySliders[categoryKey] = index;
        items[index].classList.add('active');
        if (dots[index]) {
            dots[index].classList.add('active');
        }
    };
    
    function startCategoryAutoPlay(categoryKey) {
        const slider = document.querySelector(`.category-card[data-category="${categoryKey}"] .product-slider[data-category="${categoryKey}"]`);
        if (!slider) return;
        const items = slider.querySelectorAll('.slider-item');
        // Do not start autoplay if there is less than 2 slides
        if (!items || items.length < 2) return;

        if (categoryAutoPlayIntervals[categoryKey]) {
            clearInterval(categoryAutoPlayIntervals[categoryKey]);
        }
        
        categoryAutoPlayIntervals[categoryKey] = setInterval(() => {
            changeCategorySlide(categoryKey, 1);
        }, 3000);
    }
    
    function stopCategoryAutoPlay(categoryKey) {
        if (categoryAutoPlayIntervals[categoryKey]) {
            clearInterval(categoryAutoPlayIntervals[categoryKey]);
            categoryAutoPlayIntervals[categoryKey] = null;
        }
    }
    
    // Theme Toggle System
    window.toggleTheme = function() {
        const html = document.documentElement;
        const body = document.body;
        const themeIcon = document.getElementById('theme-icon');
        const logoText = document.getElementById('logo-text');
        const currentTheme = body.getAttribute('data-theme');
        
        if (currentTheme === 'dark') {
            body.setAttribute('data-theme', 'light');
            html.setAttribute('data-theme', 'light');
            themeIcon.className = 'fas fa-moon';
            if (logoText) {
                logoText.style.color = '#2C3A47';
            }
            localStorage.setItem('theme', 'light');
        } else {
            body.setAttribute('data-theme', 'dark');
            html.setAttribute('data-theme', 'dark');
            themeIcon.className = 'fas fa-sun';
            if (logoText) {
                logoText.style.color = '#1B9CFC';
            }
            localStorage.setItem('theme', 'dark');
        }
    };
    
    // Utility functions
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Handle window resize
    window.addEventListener('resize', debounce(function() {
        const dropdowns = document.querySelectorAll('.dropdown-menu');
        dropdowns.forEach(dropdown => {
            dropdown.classList.remove('active');
        });
    }, 250));
    
})();

// Categories Dropdown Menu Control
document.addEventListener('DOMContentLoaded', function() {
    const categoriesLink = document.querySelector('.nav-link[href="/kategoriler"]');
    const dropdownMenu = document.querySelector('.dropdown-menu');
    
    if (categoriesLink && dropdownMenu) {
        let isMenuOpen = false;
        let timeoutId = null;
        
        // Kategoriler linkine hover yapıldığında menüyü aç
        categoriesLink.addEventListener('mouseenter', function() {
            clearTimeout(timeoutId);
            dropdownMenu.style.opacity = '1';
            dropdownMenu.style.visibility = 'visible';
            dropdownMenu.style.transform = 'translateX(-50%) translateY(0)';
            isMenuOpen = true;
        });
        
        // Dropdown menüye hover yapıldığında menüyü açık tut
        dropdownMenu.addEventListener('mouseenter', function() {
            clearTimeout(timeoutId);
            isMenuOpen = true;
        });
        
        // Kategoriler linkinden çıkıldığında
        categoriesLink.addEventListener('mouseleave', function() {
            timeoutId = setTimeout(function() {
                if (!isMenuOpen) {
                    dropdownMenu.style.opacity = '0';
                    dropdownMenu.style.visibility = 'hidden';
                    dropdownMenu.style.transform = 'translateX(-50%) translateY(-8px)';
                }
            }, 100);
        });
        
        // Dropdown menüden çıkıldığında menüyü kapat
        dropdownMenu.addEventListener('mouseleave', function() {
            isMenuOpen = false;
            dropdownMenu.style.opacity = '0';
            dropdownMenu.style.visibility = 'hidden';
            dropdownMenu.style.transform = 'translateX(-50%) translateY(-8px)';
        });
    }
});

// Language Menu Toggle
function toggleLanguageMenu() {
    const langMenu = document.getElementById('langMenu');
    if (langMenu) {
        langMenu.style.display = langMenu.style.display === 'none' ? 'block' : 'none';
    }
}

// Theme Toggle
function toggleTheme() {
    const body = document.body;
    const themeIcon = document.getElementById('theme-icon');
    
    if (body.getAttribute('data-theme') === 'dark') {
        body.removeAttribute('data-theme');
        themeIcon.className = 'fas fa-moon';
        localStorage.setItem('theme', 'light');
    } else {
        body.setAttribute('data-theme', 'dark');
        themeIcon.className = 'fas fa-sun';
        localStorage.setItem('theme', 'dark');
    }
}

// Load saved theme
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');
    const themeIcon = document.getElementById('theme-icon');
    
    if (savedTheme === 'dark') {
        document.body.setAttribute('data-theme', 'dark');
        if (themeIcon) {
            themeIcon.className = 'fas fa-sun';
        }
    }
});

// Product Page Functions
// Product Gallery
function changeMainImage(imageSrc, thumbElement) {
    const mainImage = document.getElementById('mainProductImage');
    if (mainImage) {
        mainImage.src = imageSrc;
    }
    
    // Update active thumb
    document.querySelectorAll('.thumb-item').forEach(thumb => {
        thumb.classList.remove('active');
    });
    if (thumbElement) {
        thumbElement.classList.add('active');
    }
}

// Form Selection with Dynamic Updates
function changeProductForm(formName) {
    // Check if productFormsData exists (defined in product.php)
    if (typeof productFormsData === 'undefined' || !productFormsData[formName]) {
        console.error('Form data not found:', formName);
        return;
    }
    
    const formData = productFormsData[formName];
    
    // Update main image
    if (formData.images && formData.images.length > 0) {
        const mainImage = document.getElementById('mainProductImage');
        if (mainImage) {
            mainImage.src = formData.images[0].image_path;
            mainImage.alt = formData.images[0].alt_text || '';
        }
    }
    
    // Update thumbnail gallery
    updateThumbnailGallery(formData.images);
    
    // Update price
    updatePrice(formData.price, formData.old_price);
    
    // Update stock information
    updateStockInfo(formData.stock);
    
    // Update URL without page reload
    const currentUrl = new URL(window.location);
    currentUrl.searchParams.set('form', formName);
    window.history.pushState({}, '', currentUrl.toString());
    
    // Update form radio button
    document.querySelectorAll('input[name="product_form"]').forEach(radio => {
        radio.checked = radio.value === formName;
    });
}

// Update thumbnail gallery
function updateThumbnailGallery(images) {
    const thumbsContainer = document.querySelector('.product-gallery-thumbs');
    if (!thumbsContainer || !images || images.length <= 1) {
        return;
    }
    
    thumbsContainer.innerHTML = '';
    
    images.forEach((image, index) => {
        const thumbItem = document.createElement('div');
        thumbItem.className = `thumb-item ${index === 0 ? 'active' : ''}`;
        thumbItem.onclick = () => changeMainImage(image.image_path, thumbItem);
        
        const thumbImg = document.createElement('img');
        thumbImg.src = image.image_path;
        thumbImg.alt = image.alt_text || '';
        thumbImg.loading = 'lazy';
        
        thumbItem.appendChild(thumbImg);
        thumbsContainer.appendChild(thumbItem);
    });
}

// Update price display
function updatePrice(price, oldPrice) {
    const priceElement = document.getElementById('productPrice');
    const oldPriceElement = document.getElementById('productOldPrice');
    const discountBadge = document.querySelector('.discount-badge');
    
    if (priceElement && price !== undefined) {
        priceElement.textContent = new Intl.NumberFormat('tr-TR', { 
            minimumFractionDigits: 2, 
            maximumFractionDigits: 2 
        }).format(price) + ' ₺';
    }
    
    if (oldPrice && oldPrice > price) {
        if (oldPriceElement) {
            oldPriceElement.textContent = new Intl.NumberFormat('tr-TR', { 
                minimumFractionDigits: 2, 
                maximumFractionDigits: 2 
            }).format(oldPrice) + ' ₺';
            oldPriceElement.style.display = 'inline';
        }
        
        if (discountBadge) {
            const discountPercent = Math.round(((oldPrice - price) / oldPrice) * 100);
            discountBadge.textContent = '-%' + discountPercent;
            discountBadge.style.display = 'inline';
        }
    } else {
        if (oldPriceElement) oldPriceElement.style.display = 'none';
        if (discountBadge) discountBadge.style.display = 'none';
    }
}

// Update stock information
function updateStockInfo(stock) {
    const stockElement = document.getElementById('productStock');
    if (stockElement && stock !== undefined) {
        if (stock > 0) {
            stockElement.textContent = 'Stokta var (' + stock + ' adet)';
            stockElement.className = 'stock-status in-stock';
        } else {
            stockElement.textContent = 'Stokta yok';
            stockElement.className = 'stock-status out-of-stock';
        }
    }
}

// Quantity Selector
function changeQuantity(delta) {
    const input = document.getElementById('productQuantity');
    if (input) {
        const newValue = Math.max(1, Math.min(99, parseInt(input.value) + delta));
        input.value = newValue;
    }
}

// Add to Cart
function addToCart(productSlug) {
    const quantity = document.getElementById('productQuantity');
    const selectedForm = document.querySelector('input[name="product_form"]:checked');
    
    const qty = quantity ? quantity.value : 1;
    const form = selectedForm ? selectedForm.value : '';
    
    // Add to cart logic here
    console.log('Adding to cart:', productSlug, 'Form:', form, 'Quantity:', qty);
    
    // Show success message
    alert('Ürün sepete eklendi!');
}

// Tab Navigation
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            
            // Update active tab button
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Update active tab panel
            document.querySelectorAll('.tab-panel').forEach(panel => panel.classList.remove('active'));
            const targetPanel = document.getElementById(tabId);
            if (targetPanel) {
                targetPanel.classList.add('active');
            }
        });
    });
});

// FAQ Toggle
function toggleFAQ(questionElement) {
    const answerElement = questionElement.nextElementSibling;
    const icon = questionElement.querySelector('i');
    
    if (answerElement && icon) {
        if (answerElement.style.display === 'block') {
            answerElement.style.display = 'none';
            icon.className = 'fas fa-chevron-down';
        } else {
            answerElement.style.display = 'block';
            icon.className = 'fas fa-chevron-up';
        }
    }
}
