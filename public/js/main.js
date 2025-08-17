// Main JavaScript for Fokus Markt
document.addEventListener('DOMContentLoaded', function() {
    
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
            langMenu.classList.toggle('active');
        });
        
        // Close language menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!langBtn.contains(e.target) && !langMenu.contains(e.target)) {
                langMenu.classList.remove('active');
            }
        });
    }
    
    // Global function for onclick
    window.toggleLanguageMenu = function() {
        const langMenu = document.getElementById('langMenu');
        if (langMenu) {
            langMenu.classList.toggle('active');
        }
    };
    
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
});

// Global functions for onclick handlers
function toggleLanguageMenu() {
    const menu = document.getElementById('langMenu');
    if (menu) {
        menu.classList.toggle('active');
    }
}

function toggleMobileMenu() {
    const nav = document.querySelector('.nav');
    if (nav) {
        nav.classList.toggle('active');
    }
}

// Banner Slider Functions (Global scope for onclick handlers)
let currentSlideIndex = 0;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');

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
const categorySliders = {};

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
    
    // Calculate new index
    categorySliders[categoryKey] += direction;
    
    if (categorySliders[categoryKey] >= items.length) {
        categorySliders[categoryKey] = 0;
    } else if (categorySliders[categoryKey] < 0) {
        categorySliders[categoryKey] = items.length - 1;
    }
    
    // Show new slide
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
        body.removeAttribute('data-theme');
        html.removeAttribute('data-theme');
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

// Load saved theme on page load
document.addEventListener('DOMContentLoaded', function() {
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
    }
});
