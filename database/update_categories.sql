-- Fokus Markt - Güncel Kategori Güncellemesi
-- Created: 2024

-- Önce mevcut kategorileri temizle
DELETE FROM product_categories;
DELETE FROM categories;

-- Yeni kategorileri ekle
INSERT INTO categories (name, slug, description, sort_order) VALUES
('Eklem Sağlığı', 'eklem-sagligi', 'Eklem sağlığı için ürünler', 1),
('İmmünoterapi', 'immunoterapi', 'Bağışıklık sistemi için ürünler', 2),
('Sakinleştirici', 'sakinlestirici', 'Sakinleştirici ürünler', 3),
('Üriner Sistem', 'uriner-sistem', 'Üriner sistem sağlığı için ürünler', 4),
('Tüy ve Deri Sağlığı', 'tuy-ve-deri-sagligi', 'Tüy ve deri sağlığı için ürünler', 5),
('Böbrek Sağlığı', 'bobrek-sagligi', 'Böbrek sağlığı için ürünler', 6),
('Sindirim Sistemi', 'sindirim-sistemi', 'Sindirim sistemi sağlığı için ürünler', 7),
('Solunum Sistemi', 'solunum-sistemi', 'Solunum sistemi sağlığı için ürünler', 8),
('Kemik Sağlığı', 'kemik-sagligi', 'Kemik sağlığı için ürünler', 9),
('Gebelik ve Emzirme Sağlığı', 'gebelik-ve-emzirme-sagligi', 'Gebelik ve emzirme dönemi için ürünler', 10),
('Dışkı Yeme', 'diski-yeme', 'Dışkı yeme davranışı için ürünler', 11),
('Soğuk Algınlığı', 'soguk-alginligi', 'Soğuk algınlığı için ürünler', 12),
('Ağız ve Diş Sağlığı', 'agiz-ve-dis-sagligi', 'Ağız ve diş sağlığı için ürünler', 13);

-- Ürün-Kategori İlişkilerini Güncelle
-- Eklem Sağlığı: CARTILAGOFLEX
INSERT INTO product_categories (product_id, category_id) 
SELECT p.id, c.id FROM products p, categories c 
WHERE p.slug = 'cartilagoflex' AND c.slug = 'eklem-sagligi';

-- İmmünoterapi: CANIVIR, FELOVIR, PETIMMUN
INSERT INTO product_categories (product_id, category_id) 
SELECT p.id, c.id FROM products p, categories c 
WHERE p.slug IN ('canivir', 'felovir', 'petimmun') AND c.slug = 'immunoterapi';

-- Sakinleştirici: EASE OFF
INSERT INTO product_categories (product_id, category_id) 
SELECT p.id, c.id FROM products p, categories c 
WHERE p.slug = 'ease-off' AND c.slug = 'sakinlestirici';

-- Üriner Sistem: BLADDER CONTROL, UTICARE
INSERT INTO product_categories (product_id, category_id) 
SELECT p.id, c.id FROM products p, categories c 
WHERE p.slug IN ('bladder-control', 'uticare') AND c.slug = 'uriner-sistem';

-- Tüy ve Deri Sağlığı: DERMACUMIN, RETINO-A, DERMA Zn, DERMA HAIRBALL, SALMONOIL
INSERT INTO product_categories (product_id, category_id) 
SELECT p.id, c.id FROM products p, categories c 
WHERE p.slug IN ('dermacumin', 'retino-a', 'derma-zn', 'derma-hairball', 'salmon-oil') AND c.slug = 'tuy-ve-deri-sagligi';

-- Böbrek Sağlığı: RENACURE
INSERT INTO product_categories (product_id, category_id) 
SELECT p.id, c.id FROM products p, categories c 
WHERE p.slug = 'renacure' AND c.slug = 'bobrek-sagligi';

-- Sindirim Sistemi: CANIVIR, DIACURE, COPROPHAGIA, PETIMMUN, DERMA HAIRBALL
INSERT INTO product_categories (product_id, category_id) 
SELECT p.id, c.id FROM products p, categories c 
WHERE p.slug IN ('canivir', 'coprophagia', 'petimmun', 'derma-hairball') AND c.slug = 'sindirim-sistemi';

-- Solunum Sistemi: O2 CARE, PHYTOSPAN
INSERT INTO product_categories (product_id, category_id) 
SELECT p.id, c.id FROM products p, categories c 
WHERE p.slug IN ('o2-care', 'phytospan') AND c.slug = 'solunum-sistemi';

-- Kemik Sağlığı: MULTIVIT
INSERT INTO product_categories (product_id, category_id) 
SELECT p.id, c.id FROM products p, categories c 
WHERE p.slug = 'multivit' AND c.slug = 'kemik-sagligi';

-- Gebelik ve Emzirme Sağlığı: M&B CARE
INSERT INTO product_categories (product_id, category_id) 
SELECT p.id, c.id FROM products p, categories c 
WHERE p.slug = 'm-b-care' AND c.slug = 'gebelik-ve-emzirme-sagligi';

-- Dışkı Yeme: COPROPHAGIA
INSERT INTO product_categories (product_id, category_id) 
SELECT p.id, c.id FROM products p, categories c 
WHERE p.slug = 'coprophagia' AND c.slug = 'diski-yeme';

-- Soğuk Algınlığı: PHYTOSPAN, PETIMMUN, O2 CARE
INSERT INTO product_categories (product_id, category_id) 
SELECT p.id, c.id FROM products p, categories c 
WHERE p.slug IN ('phytospan', 'petimmun', 'o2-care') AND c.slug = 'soguk-alginligi';

-- Ağız ve Diş Sağlığı: DENTAL CARE
INSERT INTO product_categories (product_id, category_id) 
SELECT p.id, c.id FROM products p, categories c 
WHERE p.slug = 'dental-care' AND c.slug = 'agiz-ve-dis-sagligi';
