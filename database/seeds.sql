-- Fokus Markt Seed Data
-- Created: 2024

-- ========================================
-- SPECIES (Türler)
-- ========================================

INSERT INTO species (name, slug, description) VALUES
('Kedi', 'kedi', 'Kedi türü için uygun ürünler'),
('Köpek', 'kopek', 'Köpek türü için uygun ürünler');

-- ========================================
-- CATEGORIES (Ana Kategoriler)
-- ========================================

INSERT INTO categories (name, slug, description, sort_order) VALUES
('Ağız & Diş Sağlığı', 'agiz-dis-sagligi', 'Ağız ve diş sağlığı için ürünler', 1),
('Tüy & Deri Sağlığı', 'tuy-deri-sagligi', 'Tüy ve deri sağlığı için ürünler', 2),
('Üriner Sistem', 'uriner-sistem', 'Üriner sistem sağlığı için ürünler', 3),
('Böbrek Sağlığı', 'bobrek-sagligi', 'Böbrek sağlığı için ürünler', 4),
('Sindirim Sistemi', 'sindirim-sistemi', 'Sindirim sistemi sağlığı için ürünler', 5),
('Solunum & Soğuk Algınlığı', 'solunum-soguk-alginligi', 'Solunum ve soğuk algınlığı için ürünler', 6),
('Eklem & Kemik Sağlığı', 'eklem-kemik-sagligi', 'Eklem ve kemik sağlığı için ürünler', 7),
('Sakinleştirici', 'sakinlestirici', 'Sakinleştirici ürünler', 8),
('Gebelik & Emzirme Sağlığı', 'gebelik-emzirme-sagligi', 'Gebelik ve emzirme dönemi için ürünler', 9),
('İmmünoterapi / Bağışıklık', 'immunoterapi-bagisiklik', 'Bağışıklık sistemi için ürünler', 10),
('Davranış', 'davranis', 'Davranış problemleri için ürünler', 11),
('Multivitamin & Omega', 'multivitamin-omega', 'Multivitamin ve omega ürünleri', 12);

-- ========================================
-- INDICATIONS (Endikasyonlar)
-- ========================================

INSERT INTO indications (name, slug, description, symptoms, support_mechanism) VALUES
('Ağız Kokusu & Plak/Tartar', 'agiz-kokusu-plak-tartar', 'Ağız kokusu ve diş plak/tartar problemleri', 'Ağız kokusu, dişlerde sarı lekeler, diş eti problemleri', 'Diş temizliği ve ağız hijyeni destekleyici bileşenler'),
('Tüy Yumağı (Hairball)', 'tuy-yumagi', 'Kedilerde tüy yumağı problemi', 'Öksürme, kusma, iştahsızlık', 'Tüy yumağını çözen ve sindirim sistemini destekleyen bileşenler'),
('Tüy Dökülmesi', 'tuy-dokulmesi', 'Aşırı tüy dökülmesi problemi', 'Aşırı tüy dökülmesi, mat tüyler', 'Tüy sağlığını destekleyen vitamin ve mineraller'),
('Atopik Dermatit', 'atopik-dermatit', 'Alerjik deri problemleri', 'Kaşıntı, kızarıklık, deri lezyonları', 'Deri bariyerini güçlendiren ve iltihabı azaltan bileşenler'),
('Mantar', 'mantar', 'Deri mantar enfeksiyonları', 'Dairesel lezyonlar, kaşıntı, tüy dökülmesi', 'Antifungal ve bağışıklık destekleyici bileşenler'),
('Feline Acne', 'feline-acne', 'Kedi aknesi', 'Çene altında siyah noktalar, iltihaplı sivilceler', 'Deri temizliği ve antibakteriyel destek'),
('İdrar Yolu Enfeksiyonu', 'idrar-yolu-enfeksiyonu', 'İdrar yolu enfeksiyonları', 'Sık idrara çıkma, idrar yaparken ağrı, kanlı idrar', 'İdrar yolu sağlığını destekleyen bileşenler'),
('İdrar Kaçırma', 'idrar-kacirma', 'İdrar kaçırma problemi', 'İstemsiz idrar kaçırma, ıslak yatak', 'Mesane kontrolünü destekleyen bileşenler'),
('Böbrek Desteği', 'bobrek-destegi', 'Böbrek sağlığı desteği', 'Artmış su içme, sık idrara çıkma, iştahsızlık', 'Böbrek fonksiyonlarını destekleyen bileşenler'),
('Soğuk Algınlığı', 'soguk-alginligi', 'Üst solunum yolu enfeksiyonları', 'Hapşırma, burun akıntısı, öksürük', 'Bağışıklık sistemini güçlendiren ve solunum yollarını destekleyen bileşenler'),
('Üst Solunum', 'ust-solunum', 'Üst solunum yolu problemleri', 'Nefes darlığı, öksürük, burun tıkanıklığı', 'Solunum yollarını açan ve destekleyen bileşenler'),
('Alerjik Rinit', 'alerjik-rinit', 'Alerjik burun iltihabı', 'Hapşırma, burun akıntısı, burun tıkanıklığı', 'Alerji semptomlarını azaltan bileşenler'),
('Alerjik Astım', 'alerjik-astim', 'Alerjik astım', 'Nefes darlığı, hırıltılı solunum, öksürük', 'Solunum yollarını rahatlatan ve alerji semptomlarını azaltan bileşenler'),
('İmmün Destek', 'immun-destek', 'Bağışıklık sistemi desteği', 'Sık hastalanma, yorgunluk, iştahsızlık', 'Bağışıklık sistemini güçlendiren vitamin ve mineraller'),
('Viral Enfeksiyon Desteği', 'viral-enfeksiyon-destegi', 'Viral enfeksiyonlara karşı destek', 'Ateş, iştahsızlık, halsizlik', 'Viral enfeksiyonlara karşı koruyucu ve destekleyici bileşenler'),
('Anksiyete & Stres', 'anksiyete-stres', 'Anksiyete ve stres problemleri', 'Huzursuzluk, aşırı tüylenme, agresif davranış', 'Sakinleştirici ve stres azaltıcı bileşenler'),
('Gebelik & Laktasyon Desteği', 'gebelik-laktasyon-destegi', 'Gebelik ve emzirme dönemi desteği', 'Artmış besin ihtiyacı, yorgunluk', 'Gebelik ve emzirme döneminde gerekli vitamin ve mineraller'),
('Diyabet Desteği', 'diyabet-destegi', 'Diyabet hastaları için destek', 'Artmış su içme, sık idrara çıkma, kilo kaybı', 'Kan şekerini dengeleyen ve diyabet komplikasyonlarını önleyen bileşenler'),
('Eklem Desteği', 'eklem-destegi', 'Eklem sağlığı desteği', 'Topallama, eklem sertliği, aktivite azalması', 'Eklem sağlığını destekleyen glukozamin ve kondroitin'),
('Kemik Gelişimi & Yaşlılık Refahı', 'kemik-gelisimi-yasli-refah', 'Kemik gelişimi ve yaşlılık dönemi refahı', 'Kemik problemleri, yaşlılık belirtileri', 'Kemik sağlığını destekleyen kalsiyum ve D vitamini'),
('Dışkı Yeme', 'diski-yeme', 'Dışkı yeme davranışı', 'Dışkı yeme davranışı', 'Bu davranışı azaltan ve sindirim sistemini destekleyen bileşenler'),
('Sindirim Desteği', 'sindirim-destegi', 'Sindirim sistemi desteği', 'İshal, kabızlık, gaz, kusma', 'Sindirim sistemini destekleyen prebiyotik ve probiyotikler');

-- ========================================
-- PRODUCTS (Ürünler)
-- ========================================

INSERT INTO products (name, slug, description, short_description, active_ingredients, benefits, dosage_instructions, faq, sort_order) VALUES
('Dental Care', 'dental-care', 'Ağız ve diş sağlığı için özel formül', 'Ağız kokusu ve plak/tartar problemlerine karşı etkili', 'Klorofil, nane yağı, kalsiyum karbonat', 'Ağız kokusunu azaltır, plak oluşumunu engeller, diş eti sağlığını destekler', 'Günde 1-2 tablet, yemekle birlikte verilir', 'S: Ne kadar sürede etki gösterir? C: 2-3 hafta içinde etki gösterir', 1),
('Dermacumin', 'dermacumin', 'Deri ve tüy sağlığı için jel formül', 'Atopik dermatit ve deri problemlerine karşı etkili', 'Omega-3, çinko, biotin, A vitamini', 'Deri bariyerini güçlendirir, tüy kalitesini artırır, kaşıntıyı azaltır', 'Günde 1-2 kez, deriye uygulanır', 'S: Ne kadar sürede etki gösterir? C: 1-2 hafta içinde etki gösterir', 2),
('Retino-A', 'retino-a', 'Deri problemleri için retinol formül', 'Feline acne ve deri lezyonlarına karşı etkili', 'Retinol, A vitamini, antioksidanlar', 'Deri yenilenmesini hızlandırır, akne lezyonlarını azaltır', 'Günde 1 kez, temiz deriye uygulanır', 'S: Yan etkisi var mı? C: Hassas derilerde hafif kızarıklık olabilir', 3),
('Derma Zn', 'derma-zn', 'Çinko destekli deri sağlığı formül', 'Çinko eksikliği ve deri problemlerine karşı etkili', 'Çinko, biotin, omega-6', 'Çinko eksikliğini giderir, deri sağlığını destekler', 'Günde 1-2 tablet, yemekle birlikte', 'S: Hangi formları mevcut? C: Malt ve tablet formları mevcuttur', 4),
('Derma Hairball', 'derma-hairball', 'Tüy yumağı problemi için özel formül', 'Tüy yumağı ve sindirim problemlerine karşı etkili', 'Lif, mineral yağ, malt', 'Tüy yumağını çözer, sindirim sistemini destekler', 'Günde 1-2 tablet, yemekle birlikte', 'S: Kediler için uygun mu? C: Evet, özellikle kediler için formüle edilmiştir', 5),
('Salmon Oil', 'salmon-oil', 'Omega-3 destekli somon yağı', 'Tüy sağlığı ve genel sağlık için omega-3 desteği', 'Omega-3, EPA, DHA', 'Tüy kalitesini artırır, deri sağlığını destekler, bağışıklığı güçlendirir', 'Günde 1 tablet, yemekle birlikte', 'S: Balık alerjisi olan hayvanlara verilebilir mi? C: Hayır, balık alerjisi varsa kullanılmamalıdır', 6),
('Bladder Control', 'bladder-control', 'Mesane kontrolü için özel formül', 'İdrar kaçırma problemlerine karşı etkili', 'D-mannoz, kızılcık ekstresi, probiyotikler', 'Mesane sağlığını destekler, idrar kaçırmayı azaltır', 'Günde 1-2 tablet, yemekle birlikte', 'S: Ne kadar sürede etki gösterir? C: 2-4 hafta içinde etki gösterir', 7),
('Uticare', 'uticare', 'İdrar yolu sağlığı için özel formül', 'İdrar yolu enfeksiyonlarına karşı etkili', 'D-mannoz, kızılcık, probiyotikler', 'İdrar yolu sağlığını destekler, enfeksiyonları önler', 'Günde 1-2 tablet, yemekle birlikte', 'S: Hangi formları mevcut? C: Malt ve tablet formları mevcuttur', 8),
('Renacure', 'renacure', 'Böbrek sağlığı için özel formül', 'Böbrek sağlığını destekleyen formül', 'Antioksidanlar, B vitaminleri, omega-3', 'Böbrek fonksiyonlarını destekler, toksinleri azaltır', 'Günde 1-2 tablet, yemekle birlikte', 'S: Böbrek hastalığı olan hayvanlara verilebilir mi? C: Veteriner kontrolünde kullanılmalıdır', 9),
('Canivir', 'canivir', 'Viral enfeksiyonlara karşı destek', 'Viral enfeksiyonlara karşı bağışıklık desteği', 'Lizin, vitamin C, antioksidanlar', 'Viral enfeksiyonlara karşı koruma sağlar, bağışıklığı güçlendirir', 'Günde 1-2 tablet, yemekle birlikte', 'S: Hangi formları mevcut? C: Malt ve tablet formları mevcuttur', 10),
('Cartilagoflex', 'cartilagoflex', 'Eklem sağlığı için glukozamin formül', 'Eklem sağlığını destekleyen formül', 'Glukozamin, kondroitin, MSM', 'Eklem sağlığını destekler, hareketliliği artırır', 'Günde 1-2 tablet, yemekle birlikte', 'S: Ne kadar sürede etki gösterir? C: 4-6 hafta içinde etki gösterir', 11),
('Coprophagia', 'coprophagia', 'Dışkı yeme davranışı için özel formül', 'Dışkı yeme davranışını azaltan formül', 'Enzimler, probiyotikler, vitaminler', 'Dışkı yeme davranışını azaltır, sindirim sistemini destekler', 'Günde 1-2 tablet, yemekle birlikte', 'S: Hangi formları mevcut? C: Malt ve tablet formları mevcuttur', 12),
('Ease Off', 'ease-off', 'Sakinleştirici ve stres azaltıcı', 'Anksiyete ve stres problemlerine karşı etkili', 'L-theanine, triptofan, B vitaminleri', 'Sakinleştirici etki gösterir, stresi azaltır', 'Günde 1-2 tablet, yemekle birlikte', 'S: Yolculuk stresi için kullanılabilir mi? C: Evet, yolculuk öncesi verilebilir', 13),
('M&B Care', 'm-b-care', 'Gebelik ve emzirme dönemi desteği', 'Gebelik ve emzirme döneminde besin desteği', 'Folik asit, demir, kalsiyum, D vitamini', 'Gebelik ve emzirme döneminde gerekli besinleri sağlar', 'Günde 1-2 tablet, yemekle birlikte', 'S: Gebelik boyunca kullanılabilir mi? C: Evet, gebelik boyunca güvenle kullanılabilir', 14),
('Multivit', 'multivit', 'Multivitamin ve mineral desteği', 'Genel sağlık için multivitamin desteği', 'A, D, E, K vitaminleri, B kompleks, mineraller', 'Genel sağlığı destekler, bağışıklığı güçlendirir', 'Günde 1 tablet, yemekle birlikte', 'S: Hangi formları mevcut? C: Malt ve tablet formları mevcuttur', 15),
('O2 Care', 'o2-care', 'Solunum yolu sağlığı için özel formül', 'Solunum yolu problemlerine karşı etkili', 'Okaliptüs, mentol, vitamin C', 'Solunum yollarını açar, nefes almayı kolaylaştırır', 'Günde 1-2 tablet, yemekle birlikte', 'S: Hangi formları mevcut? C: Malt ve tablet formları mevcuttur', 16),
('Phytospan', 'phytospan', 'Bitkisel solunum yolu desteği', 'Soğuk algınlığı ve solunum problemlerine karşı etkili', 'Mürver, propolis, C vitamini', 'Bağışıklığı güçlendirir, solunum yollarını destekler', 'Günde 1-2 tablet, yemekle birlikte', 'S: Hangi formları mevcut? C: Jel, malt ve tablet formları mevcuttur', 17),
('Petimmun', 'petimmun', 'Bağışıklık sistemi desteği', 'Genel bağışıklık sistemi desteği', 'Beta-glukan, vitamin C, çinko', 'Bağışıklık sistemini güçlendirir, hastalıklara karşı koruma sağlar', 'Günde 1-2 tablet, yemekle birlikte', 'S: Hangi formları mevcut? C: Jel, malt ve tablet formları mevcuttur', 18),
('Felovir', 'felovir', 'Kedi viral enfeksiyonları için özel formül', 'Kedi viral enfeksiyonlarına karşı destek', 'Lizin, vitamin C, antioksidanlar', 'Kedi viral enfeksiyonlarına karşı koruma sağlar', 'Günde 1-2 tablet, yemekle birlikte', 'S: Sadece kediler için mi? C: Evet, özellikle kediler için formüle edilmiştir', 19);

-- ========================================
-- PRODUCT VARIANTS (Form varyantları)
-- ========================================

-- Dental Care
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(1, 'Tablet', '30 tablet', 89.90, '30 tablet');

-- Dermacumin
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(2, 'Jel', '50ml jel', 129.90, '50ml');

-- Retino-A
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(3, 'Jel', '30ml jel', 149.90, '30ml');

-- Derma Zn
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(4, 'Malt', '100ml malt', 79.90, '100ml'),
(4, 'Tablet', '30 tablet', 89.90, '30 tablet');

-- Derma Hairball
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(5, 'Tablet', '30 tablet', 99.90, '30 tablet');

-- Salmon Oil
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(6, 'Tablet', '60 tablet', 119.90, '60 tablet');

-- Bladder Control
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(7, 'Malt', '100ml malt', 89.90, '100ml'),
(7, 'Tablet', '30 tablet', 99.90, '30 tablet');

-- Uticare
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(8, 'Malt', '100ml malt', 89.90, '100ml'),
(8, 'Tablet', '30 tablet', 99.90, '30 tablet');

-- Renacure
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(9, 'Malt', '100ml malt', 99.90, '100ml');

-- Canivir
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(10, 'Malt', '100ml malt', 89.90, '100ml'),
(10, 'Tablet', '30 tablet', 99.90, '30 tablet');

-- Cartilagoflex
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(11, 'Malt', '100ml malt', 109.90, '100ml'),
(11, 'Tablet', '30 tablet', 119.90, '30 tablet');

-- Coprophagia
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(12, 'Malt', '100ml malt', 79.90, '100ml'),
(12, 'Tablet', '30 tablet', 89.90, '30 tablet');

-- Ease Off
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(13, 'Malt', '100ml malt', 89.90, '100ml'),
(13, 'Tablet', '30 tablet', 99.90, '30 tablet');

-- M&B Care
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(14, 'Malt', '100ml malt', 99.90, '100ml'),
(14, 'Tablet', '30 tablet', 109.90, '30 tablet');

-- Multivit
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(15, 'Malt', '100ml malt', 79.90, '100ml'),
(15, 'Tablet', '30 tablet', 89.90, '30 tablet');

-- O2 Care
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(16, 'Malt', '100ml malt', 89.90, '100ml'),
(16, 'Tablet', '30 tablet', 99.90, '30 tablet');

-- Phytospan
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(17, 'Jel', '50ml jel', 119.90, '50ml'),
(17, 'Malt', '100ml malt', 99.90, '100ml'),
(17, 'Tablet', '30 tablet', 109.90, '30 tablet');

-- Petimmun
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(18, 'Jel', '50ml jel', 129.90, '50ml'),
(18, 'Malt', '100ml malt', 109.90, '100ml'),
(18, 'Tablet', '30 tablet', 119.90, '30 tablet');

-- Felovir
INSERT INTO product_variants (product_id, name, description, price, weight) VALUES
(19, 'Malt', '100ml malt', 89.90, '100ml');

-- ========================================
-- PRODUCT-CATEGORY RELATIONSHIPS
-- ========================================

-- Ağız & Diş Sağlığı
INSERT INTO product_categories (product_id, category_id) VALUES (1, 1);

-- Tüy & Deri Sağlığı
INSERT INTO product_categories (product_id, category_id) VALUES 
(2, 2), (3, 2), (4, 2), (5, 2), (6, 2);

-- Üriner Sistem
INSERT INTO product_categories (product_id, category_id) VALUES 
(7, 3), (8, 3);

-- Böbrek Sağlığı
INSERT INTO product_categories (product_id, category_id) VALUES (9, 4);

-- Sindirim Sistemi
INSERT INTO product_categories (product_id, category_id) VALUES 
(10, 5), (12, 5), (18, 5), (5, 5);

-- Solunum & Soğuk Algınlığı
INSERT INTO product_categories (product_id, category_id) VALUES 
(16, 6), (17, 6), (18, 6);

-- Eklem & Kemik Sağlığı
INSERT INTO product_categories (product_id, category_id) VALUES 
(11, 7), (15, 7);

-- Sakinleştirici
INSERT INTO product_categories (product_id, category_id) VALUES (13, 8);

-- Gebelik & Emzirme Sağlığı
INSERT INTO product_categories (product_id, category_id) VALUES (14, 9);

-- İmmünoterapi / Bağışıklık
INSERT INTO product_categories (product_id, category_id) VALUES 
(10, 10), (19, 10), (18, 10);

-- Davranış
INSERT INTO product_categories (product_id, category_id) VALUES (12, 11);

-- Multivitamin & Omega
INSERT INTO product_categories (product_id, category_id) VALUES 
(15, 12), (6, 12);

-- ========================================
-- PRODUCT-INDICATION RELATIONSHIPS
-- ========================================

-- Ağız Kokusu & Plak/Tartar
INSERT INTO product_indications (product_id, indication_id) VALUES (1, 1);

-- Tüy Yumağı
INSERT INTO product_indications (product_id, indication_id) VALUES (5, 2);

-- Tüy Dökülmesi
INSERT INTO product_indications (product_id, indication_id) VALUES (6, 3);

-- Atopik Dermatit
INSERT INTO product_indications (product_id, indication_id) VALUES (2, 4);

-- Mantar
INSERT INTO product_indications (product_id, indication_id) VALUES (2, 5);

-- Feline Acne
INSERT INTO product_indications (product_id, indication_id) VALUES (3, 6);

-- İdrar Yolu Enfeksiyonu
INSERT INTO product_indications (product_id, indication_id) VALUES (8, 7);

-- İdrar Kaçırma
INSERT INTO product_indications (product_id, indication_id) VALUES (7, 8);

-- Böbrek Desteği
INSERT INTO product_indications (product_id, indication_id) VALUES (9, 9);

-- Soğuk Algınlığı
INSERT INTO product_indications (product_id, indication_id) VALUES (17, 10);

-- Üst Solunum
INSERT INTO product_indications (product_id, indication_id) VALUES (16, 11);

-- Alerjik Rinit
INSERT INTO product_indications (product_id, indication_id) VALUES (16, 12);

-- Alerjik Astım
INSERT INTO product_indications (product_id, indication_id) VALUES (16, 13);

-- İmmün Destek
INSERT INTO product_indications (product_id, indication_id) VALUES (18, 14);

-- Viral Enfeksiyon Desteği
INSERT INTO product_indications (product_id, indication_id) VALUES 
(10, 15), (19, 15), (18, 15);

-- Anksiyete & Stres
INSERT INTO product_indications (product_id, indication_id) VALUES (13, 16);

-- Gebelik & Laktasyon Desteği
INSERT INTO product_indications (product_id, indication_id) VALUES (14, 17);

-- Eklem Desteği
INSERT INTO product_indications (product_id, indication_id) VALUES (11, 19);

-- Kemik Gelişimi & Yaşlılık Refahı
INSERT INTO product_indications (product_id, indication_id) VALUES (15, 20);

-- Dışkı Yeme
INSERT INTO product_indications (product_id, indication_id) VALUES (12, 21);

-- Sindirim Desteği
INSERT INTO product_indications (product_id, indication_id) VALUES 
(10, 22), (18, 22), (5, 22);

-- ========================================
-- PRODUCT-SPECIES RELATIONSHIPS
-- ========================================

-- Tüm ürünler hem kedi hem köpek için (genel olarak)
INSERT INTO product_species (product_id, species_id) VALUES
(1, 1), (1, 2), (2, 1), (2, 2), (3, 1), (3, 2), (4, 1), (4, 2),
(5, 1), (5, 2), (6, 1), (6, 2), (7, 1), (7, 2), (8, 1), (8, 2),
(9, 1), (9, 2), (10, 1), (10, 2), (11, 1), (11, 2), (12, 1), (12, 2),
(13, 1), (13, 2), (14, 1), (14, 2), (15, 1), (15, 2), (16, 1), (16, 2),
(17, 1), (17, 2), (18, 1), (18, 2);

-- Felovir sadece kedi için
INSERT INTO product_species (product_id, species_id) VALUES (19, 1);
