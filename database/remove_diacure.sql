-- Fokus Markt - DIACURE Ürününü Kaldırma
-- Created: 2024

-- DIACURE ürününü ve ilişkilerini kaldır
DELETE FROM product_indications WHERE product_id IN (SELECT id FROM products WHERE slug = 'diacure');
DELETE FROM product_species WHERE product_id IN (SELECT id FROM products WHERE slug = 'diacure');
DELETE FROM product_categories WHERE product_id IN (SELECT id FROM products WHERE slug = 'diacure');
DELETE FROM product_variants WHERE product_id IN (SELECT id FROM products WHERE slug = 'diacure');
DELETE FROM products WHERE slug = 'diacure';

-- Sindirim Sistemi kategorisini güncelle (DIACURE olmadan)
-- CANIVIR, COPROPHAGIA, PETIMMUN, DERMA HAIRBALL kalacak
