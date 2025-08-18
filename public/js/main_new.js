// Global variables for sliders - declared only once
let currentNewSlideIndex = 0;
let newSlides = [];
let newDots = [];
let currentSlideIndex = 0;
let slides = [];
let dots = [];

// Category slider variables
const categorySliders = {};
const categoryAutoPlayIntervals = {};

// Main JavaScript for Fokus Markt
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize banner elements
    slides = document.querySelectorAll('.slide');
    dots = document.querySelectorAll('.dot');
    
    // Initialize new banner elements
    newSlides = document.querySelectorAll('.new-slide');
    newDots = document.querySelectorAll('.new-dot');
    
    // Dropdown menu functionality
    const navItems = document.querySelectorAll('.nav-item');
    
    navItems.forEach(item => {
        const dropdown = item.querySelector('.dropdown-menu');
        if (dropdown) {
            // Show dropdown on hover
            item.addEventListener('mouseenter', function() {
                dropdown.classList.add('active');
            });
            
            // Hide dropdown when mouse leaves
            item.addEventListener('mouseleave', function() {
                dropdown.classList.remove('active');
            });
        }
    });
    
    // Language menu functionality
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
        
        // Close language menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!langBtn.contains(e.target) && !langMenu.contains(e.target)) {
                langMenu.style.display = 'none';
            }
        });
    }
    
    // Mobile menu functionality
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const nav = document.querySelector('.nav');
    
    if (mobileMenuBtn && nav) {
        mobileMenuBtn.addEventListener('click', function() {
            nav.classList.toggle('active');
        });
        
        // Close mobile menu when clicking on a link
        const navLinks = nav.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                nav.classList.remove('active');
            });
        });
    }
    
    // Search functionality
    const searchInput = document.querySelector('.search-box input');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query) {
                    // Redirect to search page or perform search
                    window.location.href = `/search?q=${encodeURIComponent(query)}`;
                }
            }
        });
    }
    
    // Smooth scrolling for anchor links
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
    
    // Add loading animation to buttons
    const buttons = document.querySelectorAll('.btn, .cta-button');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (!this.classList.contains('loading')) {
                this.classList.add('loading');
                this.style.pointerEvents = 'none';
                
                // Remove loading state after animation
                setTimeout(() => {
                    this.classList.remove('loading');
                    this.style.pointerEvents = 'auto';
                }, 1000);
            }
        });
    });
    
    // Intersection Observer for animations
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
    
    // Observe elements for animation
    const animateElements = document.querySelectorAll('.category-card, .pet-type-card, .feature-card');
    animateElements.forEach(el => {
        observer.observe(el);
    });
    
    // Banner slider auto-play pause on hover
    const bannerSlider = document.querySelector('.banner-slider');
    let autoPlayInterval;
    
    if (bannerSlider) {
        bannerSlider.addEventListener('mouseenter', function() {
            if (autoPlayInterval) {
                clearInterval(autoPlayInterval);
            }
        });
        
        bannerSlider.addEventListener('mouseleave', function() {
            // Restart auto-play
            autoPlayInterval = setInterval(() => {
                changeSlide(1);
            }, 5000);
        });
    }
    
    // Initialize auto-play
    autoPlayInterval = setInterval(() => {
        changeSlide(1);
    }, 5000);
    
    // Initialize new banner auto-play
    let newBannerAutoPlayInterval = setInterval(() => {
        changeNewSlide(1);
    }, 4000);
    
    // Initialize category sliders auto-play
    const categoryCards = document.querySelectorAll('.category-card');
    categoryCards.forEach(card => {
        const categoryKey = card.getAttribute('data-category');
        if (categoryKey) {
            // Start auto-play
            startCategoryAutoPlay(categoryKey);
            
            // Pause on hover
            card.addEventListener('mouseenter', () => {
                stopCategoryAutoPlay(categoryKey);
            });
            
            // Resume on mouse leave
            card.addEventListener('mouseleave', () => {
                startCategoryAutoPlay(categoryKey);
            });
        }
    });
    
    // Load saved theme on page load
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
            logoText.style.color = '#1B9CFC'; // Dark mode: kurumsal mavi
        }
    } else {
        // Light mode için data-theme attribute'unu set et
        document.body.setAttribute('data-theme', 'light');
        document.documentElement.setAttribute('data-theme', 'light');
    }
});

// Global functions for onclick handlers
function toggleLanguageMenu() {
    const menu = document.getElementById('langMenu');
    if (menu) {
        if (menu.style.display === 'none' || menu.style.display === '') {
            menu.style.display = 'block';
        } else {
            menu.style.display = 'none';
        }
    }
}

function toggleMobileMenu() {
    const nav = document.querySelector('.nav');
    if (nav) {
        nav.classList.toggle('active');
    }
}

// New Banner Slider Functions (Global scope for onclick handlers)
function showNewSlide(index) {
    // Hide all slides
    newSlides.forEach(slide => slide.classList.remove('active'));
    newDots.forEach(dot => dot.classList.remove('active'));
    
    // Show current slide
    if (newSlides[index]) {
        newSlides[index].classList.add('active');
        newDots[index].classList.add('active');
    }
}

function changeNewSlide(direction) {
    currentNewSlideIndex += direction;
    
    if (currentNewSlideIndex >= newSlides.length) {
        currentNewSlideIndex = 0;
    } else if (currentNewSlideIndex < 0) {
        currentNewSlideIndex = newSlides.length - 1;
    }
    
    showNewSlide(currentNewSlideIndex);
}

function currentNewSlide(index) {
    currentNewSlideIndex = index - 1;
    showNewSlide(currentNewSlideIndex);
}

// Banner Slider Functions (Global scope for onclick handlers)
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

// Category Slider Functions
function changeCategorySlide(categoryKey, direction) {
    if (!categorySliders[categoryKey]) {
        categorySliders[categoryKey] = 0;
    }
    
    const slider = document.querySelector(`[data-category="${categoryKey}"]`);
    if (!slider) return;
    
    const items = slider.querySelectorAll('.slider-item');
    const dots = slider.querySelectorAll('.dot');
    
    if (items.length === 0) return;
    
    // Hide current slide
    items[categorySliders[categoryKey]].classList.remove('active');
    if (dots[categorySliders[categoryKey]]) {
        dots[categorySliders[categoryKey]].classList.remove('active');
    }
    
    // Show new slide
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
}

function goToCategorySlide(categoryKey, index) {
    const slider = document.querySelector(`[data-category="${categoryKey}"]`);
    if (!slider) return;
    
    const items = slider.querySelectorAll('.slider-item');
    const dots = slider.querySelectorAll('.dot');
    
    if (items.length === 0 || index >= items.length) return;
    
    // Hide current slide
    const currentIndex = categorySliders[categoryKey] || 0;
    items[currentIndex].classList.remove('active');
    if (dots[currentIndex]) {
        dots[currentIndex].classList.remove('active');
    }
    
    // Show new slide
    categorySliders[categoryKey] = index;
    items[index].classList.add('active');
    if (dots[index]) {
        dots[index].classList.add('active');
    }
}

function startCategoryAutoPlay(categoryKey) {
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
    // Recalculate any layout-dependent elements
    const dropdowns = document.querySelectorAll('.dropdown-menu');
    dropdowns.forEach(dropdown => {
        dropdown.classList.remove('active');
    });
}, 250));

// Theme Toggle System
function toggleTheme() {
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
            logoText.style.color = '#2C3A47'; // Light mode: %60 Ana renk (Lacivert)
        }
        localStorage.setItem('theme', 'light');
    } else {
        body.setAttribute('data-theme', 'dark');
        html.setAttribute('data-theme', 'dark');
        themeIcon.className = 'fas fa-sun';
        if (logoText) {
            logoText.style.color = '#1B9CFC'; // Dark mode: %30 İkincil renk (Mavi)
        }
        localStorage.setItem('theme', 'dark');
    }
}
