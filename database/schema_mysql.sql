-- Fokus Markt MySQL Database Schema
-- Created: 2024

-- Enable foreign key constraints
SET FOREIGN_KEY_CHECKS = 1;

-- ========================================
-- CORE TABLES
-- ========================================

-- Categories (Ana Kategoriler)
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    image VARCHAR(255),
    parent_id INT DEFAULT NULL,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Indications (Endikasyonlar/Hastalıklar)
CREATE TABLE indications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    symptoms TEXT,
    support_mechanism TEXT,
    image VARCHAR(255),
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Species (Türler: Kedi/Köpek)
CREATE TABLE species (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    slug VARCHAR(50) UNIQUE NOT NULL,
    description TEXT,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products (Ürünler)
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    short_description TEXT,
    active_ingredients TEXT,
    benefits TEXT,
    dosage_instructions TEXT,
    faq TEXT,
    image VARCHAR(255),
    is_active BOOLEAN DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Product Variants (Form varyantları: Malt/Tablet/Jel)
CREATE TABLE product_variants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    name VARCHAR(100) NOT NULL, -- "Malt", "Tablet", "Jel", "Plus"
    description TEXT,
    price DECIMAL(10,2),
    weight VARCHAR(50),
    is_active BOOLEAN DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Product Images (Ürün görselleri)
CREATE TABLE product_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255),
    form_type VARCHAR(50), -- "malt", "tablet", "jel"
    language VARCHAR(10) DEFAULT 'tr', -- "tr", "en", "de"
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Articles (Makaleler)
CREATE TABLE articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    excerpt TEXT,
    image VARCHAR(255),
    author VARCHAR(100),
    is_published BOOLEAN DEFAULT 0,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ========================================
-- RELATIONSHIP TABLES
-- ========================================

-- Product-Category Relationship (Çoklu kategori)
CREATE TABLE product_categories (
    product_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (product_id, category_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Product-Indication Relationship (Çoklu endikasyon)
CREATE TABLE product_indications (
    product_id INT NOT NULL,
    indication_id INT NOT NULL,
    PRIMARY KEY (product_id, indication_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (indication_id) REFERENCES indications(id) ON DELETE CASCADE
);

-- Product-Species Relationship (Kedi/Köpek uyumluluğu)
CREATE TABLE product_species (
    product_id INT NOT NULL,
    species_id INT NOT NULL,
    PRIMARY KEY (product_id, species_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (species_id) REFERENCES species(id) ON DELETE CASCADE
);

-- Article-Product Relationship (Makale-ürün bağlantısı)
CREATE TABLE article_products (
    article_id INT NOT NULL,
    product_id INT NOT NULL,
    PRIMARY KEY (article_id, product_id),
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- ========================================
-- DETAIL TABLES
-- ========================================

-- Product Benefits (Ürün faydaları)
CREATE TABLE product_benefits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    benefit_text TEXT NOT NULL,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Product Warnings (Ürün uyarıları)
CREATE TABLE product_warnings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    warning_text TEXT NOT NULL,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Product Ingredients (Ürün içerikleri)
CREATE TABLE product_ingredients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    ingredient_name VARCHAR(255) NOT NULL,
    function_description TEXT,
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- ========================================
-- INDEXES
-- ========================================

-- Performance indexes
CREATE INDEX idx_products_slug ON products(slug);
CREATE INDEX idx_products_active ON products(is_active);
CREATE INDEX idx_products_sort ON products(sort_order);
CREATE INDEX idx_categories_slug ON categories(slug);
CREATE INDEX idx_categories_active ON categories(is_active);
CREATE INDEX idx_product_variants_product ON product_variants(product_id);
CREATE INDEX idx_product_variants_active ON product_variants(is_active);
CREATE INDEX idx_product_images_product ON product_images(product_id);
CREATE INDEX idx_product_images_language ON product_images(language);
CREATE INDEX idx_product_images_form ON product_images(form_type);
