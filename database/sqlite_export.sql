PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    image VARCHAR(255),
    parent_id INTEGER DEFAULT NULL,
    sort_order INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
);
INSERT INTO categories VALUES(1,'Ağız & Diş Sağlığı','agiz-dis-sagligi','Ağız ve diş sağlığı için ürünler',NULL,NULL,1,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO categories VALUES(2,'Tüy & Deri Sağlığı','tuy-deri-sagligi','Tüy ve deri sağlığı için ürünler',NULL,NULL,2,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO categories VALUES(3,'Üriner Sistem','uriner-sistem','Üriner sistem sağlığı için ürünler',NULL,NULL,3,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO categories VALUES(4,'Böbrek Sağlığı','bobrek-sagligi','Böbrek sağlığı için ürünler',NULL,NULL,4,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO categories VALUES(5,'Sindirim Sistemi','sindirim-sistemi','Sindirim sistemi sağlığı için ürünler',NULL,NULL,5,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO categories VALUES(6,'Solunum & Soğuk Algınlığı','solunum-soguk-alginligi','Solunum ve soğuk algınlığı için ürünler',NULL,NULL,6,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO categories VALUES(7,'Eklem & Kemik Sağlığı','eklem-kemik-sagligi','Eklem ve kemik sağlığı için ürünler',NULL,NULL,7,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO categories VALUES(8,'Sakinleştirici','sakinlestirici','Sakinleştirici ürünler',NULL,NULL,8,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO categories VALUES(9,'Gebelik & Emzirme Sağlığı','gebelik-emzirme-sagligi','Gebelik ve emzirme dönemi için ürünler',NULL,NULL,9,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO categories VALUES(10,'İmmünoterapi / Bağışıklık','immunoterapi-bagisiklik','Bağışıklık sistemi için ürünler',NULL,NULL,10,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO categories VALUES(11,'Davranış','davranis','Davranış problemleri için ürünler',NULL,NULL,11,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO categories VALUES(12,'Multivitamin & Omega','multivitamin-omega','Multivitamin ve omega ürünleri',NULL,NULL,12,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
CREATE TABLE indications (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    symptoms TEXT,
    support_mechanism TEXT,
    image VARCHAR(255),
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO indications VALUES(1,'Ağız Kokusu & Plak/Tartar','agiz-kokusu-plak-tartar','Ağız kokusu ve diş plak/tartar problemleri','Ağız kokusu, dişlerde sarı lekeler, diş eti problemleri','Diş temizliği ve ağız hijyeni destekleyici bileşenler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(2,'Tüy Yumağı (Hairball)','tuy-yumagi','Kedilerde tüy yumağı problemi','Öksürme, kusma, iştahsızlık','Tüy yumağını çözen ve sindirim sistemini destekleyen bileşenler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(3,'Tüy Dökülmesi','tuy-dokulmesi','Aşırı tüy dökülmesi problemi','Aşırı tüy dökülmesi, mat tüyler','Tüy sağlığını destekleyen vitamin ve mineraller',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(4,'Atopik Dermatit','atopik-dermatit','Alerjik deri problemleri','Kaşıntı, kızarıklık, deri lezyonları','Deri bariyerini güçlendiren ve iltihabı azaltan bileşenler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(5,'Mantar','mantar','Deri mantar enfeksiyonları','Dairesel lezyonlar, kaşıntı, tüy dökülmesi','Antifungal ve bağışıklık destekleyici bileşenler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(6,'Feline Acne','feline-acne','Kedi aknesi','Çene altında siyah noktalar, iltihaplı sivilceler','Deri temizliği ve antibakteriyel destek',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(7,'İdrar Yolu Enfeksiyonu','idrar-yolu-enfeksiyonu','İdrar yolu enfeksiyonları','Sık idrara çıkma, idrar yaparken ağrı, kanlı idrar','İdrar yolu sağlığını destekleyen bileşenler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(8,'İdrar Kaçırma','idrar-kacirma','İdrar kaçırma problemi','İstemsiz idrar kaçırma, ıslak yatak','Mesane kontrolünü destekleyen bileşenler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(9,'Böbrek Desteği','bobrek-destegi','Böbrek sağlığı desteği','Artmış su içme, sık idrara çıkma, iştahsızlık','Böbrek fonksiyonlarını destekleyen bileşenler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(10,'Soğuk Algınlığı','soguk-alginligi','Üst solunum yolu enfeksiyonları','Hapşırma, burun akıntısı, öksürük','Bağışıklık sistemini güçlendiren ve solunum yollarını destekleyen bileşenler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(11,'Üst Solunum','ust-solunum','Üst solunum yolu problemleri','Nefes darlığı, öksürük, burun tıkanıklığı','Solunum yollarını açan ve destekleyen bileşenler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(12,'Alerjik Rinit','alerjik-rinit','Alerjik burun iltihabı','Hapşırma, burun akıntısı, burun tıkanıklığı','Alerji semptomlarını azaltan bileşenler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(13,'Alerjik Astım','alerjik-astim','Alerjik astım','Nefes darlığı, hırıltılı solunum, öksürük','Solunum yollarını rahatlatan ve alerji semptomlarını azaltan bileşenler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(14,'İmmün Destek','immun-destek','Bağışıklık sistemi desteği','Sık hastalanma, yorgunluk, iştahsızlık','Bağışıklık sistemini güçlendiren vitamin ve mineraller',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(15,'Viral Enfeksiyon Desteği','viral-enfeksiyon-destegi','Viral enfeksiyonlara karşı destek','Ateş, iştahsızlık, halsizlik','Viral enfeksiyonlara karşı koruyucu ve destekleyici bileşenler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(16,'Anksiyete & Stres','anksiyete-stres','Anksiyete ve stres problemleri','Huzursuzluk, aşırı tüylenme, agresif davranış','Sakinleştirici ve stres azaltıcı bileşenler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(17,'Gebelik & Laktasyon Desteği','gebelik-laktasyon-destegi','Gebelik ve emzirme dönemi desteği','Artmış besin ihtiyacı, yorgunluk','Gebelik ve emzirme döneminde gerekli vitamin ve mineraller',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(18,'Diyabet Desteği','diyabet-destegi','Diyabet hastaları için destek','Artmış su içme, sık idrara çıkma, kilo kaybı','Kan şekerini dengeleyen ve diyabet komplikasyonlarını önleyen bileşenler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(19,'Eklem Desteği','eklem-destegi','Eklem sağlığı desteği','Topallama, eklem sertliği, aktivite azalması','Eklem sağlığını destekleyen glukozamin ve kondroitin',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(20,'Kemik Gelişimi & Yaşlılık Refahı','kemik-gelisimi-yasli-refah','Kemik gelişimi ve yaşlılık dönemi refahı','Kemik problemleri, yaşlılık belirtileri','Kemik sağlığını destekleyen kalsiyum ve D vitamini',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(21,'Dışkı Yeme','diski-yeme','Dışkı yeme davranışı','Dışkı yeme davranışı','Bu davranışı azaltan ve sindirim sistemini destekleyen bileşenler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO indications VALUES(22,'Sindirim Desteği','sindirim-destegi','Sindirim sistemi desteği','İshal, kabızlık, gaz, kusma','Sindirim sistemini destekleyen prebiyotik ve probiyotikler',NULL,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
CREATE TABLE species (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(50) NOT NULL,
    slug VARCHAR(50) UNIQUE NOT NULL,
    description TEXT,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO species VALUES(1,'Kedi','kedi','Kedi türü için uygun ürünler',1,'2025-08-19 18:23:07');
INSERT INTO species VALUES(2,'Köpek','kopek','Köpek türü için uygun ürünler',1,'2025-08-19 18:23:07');
CREATE TABLE products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
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
    sort_order INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO products VALUES(1,'Dental Care','dental-care','Ağız ve diş sağlığı için özel formül','Ağız kokusu ve plak/tartar problemlerine karşı etkili','Klorofil, nane yağı, kalsiyum karbonat','Ağız kokusunu azaltır, plak oluşumunu engeller, diş eti sağlığını destekler','Günde 1-2 tablet, yemekle birlikte verilir','S: Ne kadar sürede etki gösterir? C: 2-3 hafta içinde etki gösterir',NULL,1,1,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(2,'Dermacumin','dermacumin','Deri ve tüy sağlığı için jel formül','Atopik dermatit ve deri problemlerine karşı etkili','Omega-3, çinko, biotin, A vitamini','Deri bariyerini güçlendirir, tüy kalitesini artırır, kaşıntıyı azaltır','Günde 1-2 kez, deriye uygulanır','S: Ne kadar sürede etki gösterir? C: 1-2 hafta içinde etki gösterir',NULL,1,2,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(3,'Retino-A','retino-a','Deri problemleri için retinol formül','Feline acne ve deri lezyonlarına karşı etkili','Retinol, A vitamini, antioksidanlar','Deri yenilenmesini hızlandırır, akne lezyonlarını azaltır','Günde 1 kez, temiz deriye uygulanır','S: Yan etkisi var mı? C: Hassas derilerde hafif kızarıklık olabilir',NULL,1,3,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(4,'Derma Zn','derma-zn','Çinko destekli deri sağlığı formül','Çinko eksikliği ve deri problemlerine karşı etkili','Çinko, biotin, omega-6','Çinko eksikliğini giderir, deri sağlığını destekler','Günde 1-2 tablet, yemekle birlikte','S: Hangi formları mevcut? C: Malt ve tablet formları mevcuttur',NULL,1,4,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(5,'Derma Hairball','derma-hairball','Tüy yumağı problemi için özel formül','Tüy yumağı ve sindirim problemlerine karşı etkili','Lif, mineral yağ, malt','Tüy yumağını çözer, sindirim sistemini destekler','Günde 1-2 tablet, yemekle birlikte','S: Kediler için uygun mu? C: Evet, özellikle kediler için formüle edilmiştir',NULL,1,5,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(6,'Salmon Oil','salmon-oil','Omega-3 destekli somon yağı','Tüy sağlığı ve genel sağlık için omega-3 desteği','Omega-3, EPA, DHA','Tüy kalitesini artırır, deri sağlığını destekler, bağışıklığı güçlendirir','Günde 1 tablet, yemekle birlikte','S: Balık alerjisi olan hayvanlara verilebilir mi? C: Hayır, balık alerjisi varsa kullanılmamalıdır',NULL,1,6,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(7,'Bladder Control','bladder-control','Mesane kontrolü için özel formül','İdrar kaçırma problemlerine karşı etkili','D-mannoz, kızılcık ekstresi, probiyotikler','Mesane sağlığını destekler, idrar kaçırmayı azaltır','Günde 1-2 tablet, yemekle birlikte','S: Ne kadar sürede etki gösterir? C: 2-4 hafta içinde etki gösterir',NULL,1,7,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(8,'Uticare','uticare','İdrar yolu sağlığı için özel formül','İdrar yolu enfeksiyonlarına karşı etkili','D-mannoz, kızılcık, probiyotikler','İdrar yolu sağlığını destekler, enfeksiyonları önler','Günde 1-2 tablet, yemekle birlikte','S: Hangi formları mevcut? C: Malt ve tablet formları mevcuttur',NULL,1,8,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(9,'Renacure','renacure','Böbrek sağlığı için özel formül','Böbrek sağlığını destekleyen formül','Antioksidanlar, B vitaminleri, omega-3','Böbrek fonksiyonlarını destekler, toksinleri azaltır','Günde 1-2 tablet, yemekle birlikte','S: Böbrek hastalığı olan hayvanlara verilebilir mi? C: Veteriner kontrolünde kullanılmalıdır',NULL,1,9,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(10,'Canivir','canivir','Viral enfeksiyonlara karşı destek','Viral enfeksiyonlara karşı bağışıklık desteği','Lizin, vitamin C, antioksidanlar','Viral enfeksiyonlara karşı koruma sağlar, bağışıklığı güçlendirir','Günde 1-2 tablet, yemekle birlikte','S: Hangi formları mevcut? C: Malt ve tablet formları mevcuttur',NULL,1,10,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(11,'Cartilagoflex','cartilagoflex','Eklem sağlığı için glukozamin formül','Eklem sağlığını destekleyen formül','Glukozamin, kondroitin, MSM','Eklem sağlığını destekler, hareketliliği artırır','Günde 1-2 tablet, yemekle birlikte','S: Ne kadar sürede etki gösterir? C: 4-6 hafta içinde etki gösterir',NULL,1,11,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(12,'Coprophagia','coprophagia','Dışkı yeme davranışı için özel formül','Dışkı yeme davranışını azaltan formül','Enzimler, probiyotikler, vitaminler','Dışkı yeme davranışını azaltır, sindirim sistemini destekler','Günde 1-2 tablet, yemekle birlikte','S: Hangi formları mevcut? C: Malt ve tablet formları mevcuttur',NULL,1,12,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(13,'Ease Off','ease-off','Sakinleştirici ve stres azaltıcı','Anksiyete ve stres problemlerine karşı etkili','L-theanine, triptofan, B vitaminleri','Sakinleştirici etki gösterir, stresi azaltır','Günde 1-2 tablet, yemekle birlikte','S: Yolculuk stresi için kullanılabilir mi? C: Evet, yolculuk öncesi verilebilir',NULL,1,13,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(14,'M&B Care','m-b-care','Gebelik ve emzirme dönemi desteği','Gebelik ve emzirme döneminde besin desteği','Folik asit, demir, kalsiyum, D vitamini','Gebelik ve emzirme döneminde gerekli besinleri sağlar','Günde 1-2 tablet, yemekle birlikte','S: Gebelik boyunca kullanılabilir mi? C: Evet, gebelik boyunca güvenle kullanılabilir',NULL,1,14,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(15,'Multivit','multivit','Multivitamin ve mineral desteği','Genel sağlık için multivitamin desteği','A, D, E, K vitaminleri, B kompleks, mineraller','Genel sağlığı destekler, bağışıklığı güçlendirir','Günde 1 tablet, yemekle birlikte','S: Hangi formları mevcut? C: Malt ve tablet formları mevcuttur',NULL,1,15,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(16,'O2 Care','o2-care','Solunum yolu sağlığı için özel formül','Solunum yolu problemlerine karşı etkili','Okaliptüs, mentol, vitamin C','Solunum yollarını açar, nefes almayı kolaylaştırır','Günde 1-2 tablet, yemekle birlikte','S: Hangi formları mevcut? C: Malt ve tablet formları mevcuttur',NULL,1,16,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(17,'Phytospan','phytospan','Bitkisel solunum yolu desteği','Soğuk algınlığı ve solunum problemlerine karşı etkili','Mürver, propolis, C vitamini','Bağışıklığı güçlendirir, solunum yollarını destekler','Günde 1-2 tablet, yemekle birlikte','S: Hangi formları mevcut? C: Jel, malt ve tablet formları mevcuttur',NULL,1,17,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(18,'Petimmun','petimmun','Bağışıklık sistemi desteği','Genel bağışıklık sistemi desteği','Beta-glukan, vitamin C, çinko','Bağışıklık sistemini güçlendirir, hastalıklara karşı koruma sağlar','Günde 1-2 tablet, yemekle birlikte','S: Hangi formları mevcut? C: Jel, malt ve tablet formları mevcuttur',NULL,1,18,'2025-08-19 18:23:07','2025-08-19 18:23:07');
INSERT INTO products VALUES(19,'Felovir','felovir','Kedi viral enfeksiyonları için özel formül','Kedi viral enfeksiyonlarına karşı destek','Lizin, vitamin C, antioksidanlar','Kedi viral enfeksiyonlarına karşı koruma sağlar','Günde 1-2 tablet, yemekle birlikte','S: Sadece kediler için mi? C: Evet, özellikle kediler için formüle edilmiştir',NULL,1,19,'2025-08-19 18:23:07','2025-08-19 18:23:07');
CREATE TABLE product_variants (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    product_id INTEGER NOT NULL,
    name VARCHAR(100) NOT NULL, -- "Malt", "Tablet", "Jel", "Plus"
    description TEXT,
    price DECIMAL(10,2),
    weight VARCHAR(50),
    is_active BOOLEAN DEFAULT 1,
    sort_order INTEGER DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
INSERT INTO product_variants VALUES(1,1,'Tablet','30 tablet',89.90000000000000569,'30 tablet',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(2,2,'Jel','50ml jel',129.9000000000000056,'50ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(3,3,'Jel','30ml jel',149.9000000000000056,'30ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(4,4,'Malt','100ml malt',79.90000000000000569,'100ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(5,4,'Tablet','30 tablet',89.90000000000000569,'30 tablet',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(6,5,'Tablet','30 tablet',99.9000000000000056,'30 tablet',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(7,6,'Tablet','60 tablet',119.9000000000000056,'60 tablet',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(8,7,'Malt','100ml malt',89.90000000000000569,'100ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(9,7,'Tablet','30 tablet',99.9000000000000056,'30 tablet',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(10,8,'Malt','100ml malt',89.90000000000000569,'100ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(11,8,'Tablet','30 tablet',99.9000000000000056,'30 tablet',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(12,9,'Malt','100ml malt',99.9000000000000056,'100ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(13,10,'Malt','100ml malt',89.90000000000000569,'100ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(14,10,'Tablet','30 tablet',99.9000000000000056,'30 tablet',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(15,11,'Malt','100ml malt',109.9000000000000056,'100ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(16,11,'Tablet','30 tablet',119.9000000000000056,'30 tablet',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(17,12,'Malt','100ml malt',79.90000000000000569,'100ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(18,12,'Tablet','30 tablet',89.90000000000000569,'30 tablet',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(19,13,'Malt','100ml malt',89.90000000000000569,'100ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(20,13,'Tablet','30 tablet',99.9000000000000056,'30 tablet',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(21,14,'Malt','100ml malt',99.9000000000000056,'100ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(22,14,'Tablet','30 tablet',109.9000000000000056,'30 tablet',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(23,15,'Malt','100ml malt',79.90000000000000569,'100ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(24,15,'Tablet','30 tablet',89.90000000000000569,'30 tablet',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(25,16,'Malt','100ml malt',89.90000000000000569,'100ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(26,16,'Tablet','30 tablet',99.9000000000000056,'30 tablet',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(27,17,'Jel','50ml jel',119.9000000000000056,'50ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(28,17,'Malt','100ml malt',99.9000000000000056,'100ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(29,17,'Tablet','30 tablet',109.9000000000000056,'30 tablet',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(30,18,'Jel','50ml jel',129.9000000000000056,'50ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(31,18,'Malt','100ml malt',109.9000000000000056,'100ml',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(32,18,'Tablet','30 tablet',119.9000000000000056,'30 tablet',1,0,'2025-08-19 18:23:07');
INSERT INTO product_variants VALUES(33,19,'Malt','100ml malt',89.90000000000000569,'100ml',1,0,'2025-08-19 18:23:07');
CREATE TABLE product_images (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    product_id INTEGER NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255),
    form_type VARCHAR(50), -- "malt", "tablet", "jel"
    language VARCHAR(10) DEFAULT 'tr', -- "tr", "en", "de"
    sort_order INTEGER DEFAULT 0,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
CREATE TABLE articles (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    excerpt TEXT,
    image VARCHAR(255),
    author VARCHAR(100),
    is_published BOOLEAN DEFAULT 0,
    published_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE product_categories (
    product_id INTEGER NOT NULL,
    category_id INTEGER NOT NULL,
    PRIMARY KEY (product_id, category_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
INSERT INTO product_categories VALUES(1,1);
INSERT INTO product_categories VALUES(2,2);
INSERT INTO product_categories VALUES(3,2);
INSERT INTO product_categories VALUES(4,2);
INSERT INTO product_categories VALUES(5,2);
INSERT INTO product_categories VALUES(6,2);
INSERT INTO product_categories VALUES(7,3);
INSERT INTO product_categories VALUES(8,3);
INSERT INTO product_categories VALUES(9,4);
INSERT INTO product_categories VALUES(10,5);
INSERT INTO product_categories VALUES(12,5);
INSERT INTO product_categories VALUES(18,5);
INSERT INTO product_categories VALUES(5,5);
INSERT INTO product_categories VALUES(16,6);
INSERT INTO product_categories VALUES(17,6);
INSERT INTO product_categories VALUES(18,6);
INSERT INTO product_categories VALUES(11,7);
INSERT INTO product_categories VALUES(15,7);
INSERT INTO product_categories VALUES(13,8);
INSERT INTO product_categories VALUES(14,9);
INSERT INTO product_categories VALUES(10,10);
INSERT INTO product_categories VALUES(19,10);
INSERT INTO product_categories VALUES(18,10);
INSERT INTO product_categories VALUES(12,11);
INSERT INTO product_categories VALUES(15,12);
INSERT INTO product_categories VALUES(6,12);
CREATE TABLE product_indications (
    product_id INTEGER NOT NULL,
    indication_id INTEGER NOT NULL,
    PRIMARY KEY (product_id, indication_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (indication_id) REFERENCES indications(id) ON DELETE CASCADE
);
INSERT INTO product_indications VALUES(1,1);
INSERT INTO product_indications VALUES(5,2);
INSERT INTO product_indications VALUES(6,3);
INSERT INTO product_indications VALUES(2,4);
INSERT INTO product_indications VALUES(2,5);
INSERT INTO product_indications VALUES(3,6);
INSERT INTO product_indications VALUES(8,7);
INSERT INTO product_indications VALUES(7,8);
INSERT INTO product_indications VALUES(9,9);
INSERT INTO product_indications VALUES(17,10);
INSERT INTO product_indications VALUES(16,11);
INSERT INTO product_indications VALUES(16,12);
INSERT INTO product_indications VALUES(16,13);
INSERT INTO product_indications VALUES(18,14);
INSERT INTO product_indications VALUES(10,15);
INSERT INTO product_indications VALUES(19,15);
INSERT INTO product_indications VALUES(18,15);
INSERT INTO product_indications VALUES(13,16);
INSERT INTO product_indications VALUES(14,17);
INSERT INTO product_indications VALUES(11,19);
INSERT INTO product_indications VALUES(15,20);
INSERT INTO product_indications VALUES(12,21);
INSERT INTO product_indications VALUES(10,22);
INSERT INTO product_indications VALUES(18,22);
INSERT INTO product_indications VALUES(5,22);
CREATE TABLE product_species (
    product_id INTEGER NOT NULL,
    species_id INTEGER NOT NULL,
    PRIMARY KEY (product_id, species_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (species_id) REFERENCES species(id) ON DELETE CASCADE
);
INSERT INTO product_species VALUES(1,1);
INSERT INTO product_species VALUES(1,2);
INSERT INTO product_species VALUES(2,1);
INSERT INTO product_species VALUES(2,2);
INSERT INTO product_species VALUES(3,1);
INSERT INTO product_species VALUES(3,2);
INSERT INTO product_species VALUES(4,1);
INSERT INTO product_species VALUES(4,2);
INSERT INTO product_species VALUES(5,1);
INSERT INTO product_species VALUES(5,2);
INSERT INTO product_species VALUES(6,1);
INSERT INTO product_species VALUES(6,2);
INSERT INTO product_species VALUES(7,1);
INSERT INTO product_species VALUES(7,2);
INSERT INTO product_species VALUES(8,1);
INSERT INTO product_species VALUES(8,2);
INSERT INTO product_species VALUES(9,1);
INSERT INTO product_species VALUES(9,2);
INSERT INTO product_species VALUES(10,1);
INSERT INTO product_species VALUES(10,2);
INSERT INTO product_species VALUES(11,1);
INSERT INTO product_species VALUES(11,2);
INSERT INTO product_species VALUES(12,1);
INSERT INTO product_species VALUES(12,2);
INSERT INTO product_species VALUES(13,1);
INSERT INTO product_species VALUES(13,2);
INSERT INTO product_species VALUES(14,1);
INSERT INTO product_species VALUES(14,2);
INSERT INTO product_species VALUES(15,1);
INSERT INTO product_species VALUES(15,2);
INSERT INTO product_species VALUES(16,1);
INSERT INTO product_species VALUES(16,2);
INSERT INTO product_species VALUES(17,1);
INSERT INTO product_species VALUES(17,2);
INSERT INTO product_species VALUES(18,1);
INSERT INTO product_species VALUES(18,2);
INSERT INTO product_species VALUES(19,1);
CREATE TABLE article_products (
    article_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,
    PRIMARY KEY (article_id, product_id),
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    is_active BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE orders (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    shipping_address TEXT,
    billing_address TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);
CREATE TABLE order_items (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    order_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,
    variant_id INTEGER,
    quantity INTEGER NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (variant_id) REFERENCES product_variants(id) ON DELETE SET NULL
);
DELETE FROM sqlite_sequence;
INSERT INTO sqlite_sequence VALUES('species',2);
INSERT INTO sqlite_sequence VALUES('categories',12);
INSERT INTO sqlite_sequence VALUES('indications',22);
INSERT INTO sqlite_sequence VALUES('products',19);
INSERT INTO sqlite_sequence VALUES('product_variants',33);
CREATE INDEX idx_products_slug ON products(slug);
CREATE INDEX idx_categories_slug ON categories(slug);
CREATE INDEX idx_indications_slug ON indications(slug);
CREATE INDEX idx_articles_slug ON articles(slug);
CREATE INDEX idx_products_active ON products(is_active);
CREATE INDEX idx_categories_active ON categories(is_active);
CREATE INDEX idx_indications_active ON indications(is_active);
CREATE INDEX idx_articles_published ON articles(is_published);
CREATE INDEX idx_product_categories_product ON product_categories(product_id);
CREATE INDEX idx_product_categories_category ON product_categories(category_id);
CREATE INDEX idx_product_indications_product ON product_indications(product_id);
CREATE INDEX idx_product_indications_indication ON product_indications(indication_id);
CREATE INDEX idx_product_species_product ON product_species(product_id);
CREATE INDEX idx_product_species_species ON product_species(species_id);
CREATE INDEX idx_article_products_article ON article_products(article_id);
CREATE INDEX idx_article_products_product ON article_products(product_id);
CREATE TRIGGER update_products_timestamp 
    AFTER UPDATE ON products
    BEGIN
        UPDATE products SET updated_at = CURRENT_TIMESTAMP WHERE id = NEW.id;
    END;
CREATE TRIGGER update_categories_timestamp 
    AFTER UPDATE ON categories
    BEGIN
        UPDATE categories SET updated_at = CURRENT_TIMESTAMP WHERE id = NEW.id;
    END;
CREATE TRIGGER update_indications_timestamp 
    AFTER UPDATE ON indications
    BEGIN
        UPDATE indications SET updated_at = CURRENT_TIMESTAMP WHERE id = NEW.id;
    END;
CREATE TRIGGER update_articles_timestamp 
    AFTER UPDATE ON articles
    BEGIN
        UPDATE articles SET updated_at = CURRENT_TIMESTAMP WHERE id = NEW.id;
    END;
COMMIT;
