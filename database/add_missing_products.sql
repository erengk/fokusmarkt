-- Fokus Markt - Eksik Ürün Ekleme
-- Created: 2024

-- DIACURE ürününü ekle
INSERT INTO products (name, slug, description, short_description, active_ingredients, benefits, dosage_instructions, faq, sort_order) VALUES
('Diacure', 'diacure', 'Diyabet hastaları için özel formül', 'Diyabet hastaları için kan şekeri desteği', 'Krom, çinko, B vitaminleri, antioksidanlar', 'Kan şekerini dengeler, diyabet komplikasyonlarını önler, enerji seviyesini artırır', 'Günde 1-2 tablet, yemekle birlikte', 'S: Diyabet hastası hayvanlara verilebilir mi? C: Veteriner kontrolünde kullanılmalıdır', 20);

-- DIACURE varyantlarını ekle
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(20, 'Tablet', '30 tablet', 129.90, '30 tablet'),
(20, 'Malt', '100ml malt', 119.90, '100ml');

-- DIACURE'yi Sindirim Sistemi kategorisine ekle
INSERT INTO product_categories (product_id, category_id) 
SELECT p.id, c.id FROM products p, categories c 
WHERE p.slug = 'diacure' AND c.slug = 'sindirim-sistemi';

-- DIACURE'yi hem kedi hem köpek için uygun yap
INSERT INTO product_species (product_id, species_id) VALUES (20, 1), (20, 2);

-- DIACURE'yi Diyabet Desteği endikasyonuna ekle
INSERT INTO product_indications (product_id, indication_id) 
SELECT p.id, i.id FROM products p, indications i 
WHERE p.slug = 'diacure' AND i.slug = 'diyabet-destegi';
