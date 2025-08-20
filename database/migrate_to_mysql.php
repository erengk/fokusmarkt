<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/Database.php';

echo "🚀 Fokus Markt SQLite to MySQL Migration\n";
echo "========================================\n\n";

try {
    // SQLite bağlantısı
    $sqliteDb = new PDO('sqlite:' . DB_PATH);
    $sqliteDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // MySQL bağlantısı
    $mysqlDb = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);
    $mysqlDb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "📊 Migrating data from SQLite to MySQL...\n\n";
    
    // Categories
    echo "📁 Migrating categories...\n";
    $categories = $sqliteDb->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($categories as $category) {
        $stmt = $mysqlDb->prepare("
            INSERT INTO categories (id, name, slug, description, image, parent_id, sort_order, is_active, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $category['id'],
            $category['name'],
            $category['slug'],
            $category['description'],
            $category['image'],
            $category['parent_id'],
            $category['sort_order'],
            $category['is_active'],
            $category['created_at'],
            $category['updated_at']
        ]);
    }
    echo "✅ Categories migrated: " . count($categories) . " records\n";
    
    // Species
    echo "🐕 Migrating species...\n";
    $species = $sqliteDb->query("SELECT * FROM species")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($species as $specie) {
        $stmt = $mysqlDb->prepare("
            INSERT INTO species (id, name, slug, description, is_active, created_at)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $specie['id'],
            $specie['name'],
            $specie['slug'],
            $specie['description'],
            $specie['is_active'],
            $specie['created_at']
        ]);
    }
    echo "✅ Species migrated: " . count($species) . " records\n";
    
    // Indications
    echo "🏥 Migrating indications...\n";
    $indications = $sqliteDb->query("SELECT * FROM indications")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($indications as $indication) {
        $stmt = $mysqlDb->prepare("
            INSERT INTO indications (id, name, slug, description, symptoms, support_mechanism, image, is_active, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $indication['id'],
            $indication['name'],
            $indication['slug'],
            $indication['description'],
            $indication['symptoms'],
            $indication['support_mechanism'],
            $indication['image'],
            $indication['is_active'],
            $indication['created_at'],
            $indication['updated_at']
        ]);
    }
    echo "✅ Indications migrated: " . count($indications) . " records\n";
    
    // Products
    echo "📦 Migrating products...\n";
    $products = $sqliteDb->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($products as $product) {
        $stmt = $mysqlDb->prepare("
            INSERT INTO products (id, name, slug, description, short_description, active_ingredients, benefits, dosage_instructions, faq, image, is_active, sort_order, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $product['id'],
            $product['name'],
            $product['slug'],
            $product['description'],
            $product['short_description'],
            $product['active_ingredients'],
            $product['benefits'],
            $product['dosage_instructions'],
            $product['faq'],
            $product['image'],
            $product['is_active'],
            $product['sort_order'],
            $product['created_at'],
            $product['updated_at']
        ]);
    }
    echo "✅ Products migrated: " . count($products) . " records\n";
    
    // Product Variants
    echo "🔄 Migrating product variants...\n";
    $variants = $sqliteDb->query("SELECT * FROM product_variants")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($variants as $variant) {
        $stmt = $mysqlDb->prepare("
            INSERT INTO product_variants (id, product_id, name, description, price, weight, is_active, sort_order, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $variant['id'],
            $variant['product_id'],
            $variant['name'],
            $variant['description'],
            $variant['price'],
            $variant['weight'],
            $variant['is_active'],
            $variant['sort_order'],
            $variant['created_at']
        ]);
    }
    echo "✅ Product variants migrated: " . count($variants) . " records\n";
    
    // Product Images
    echo "🖼️  Migrating product images...\n";
    $images = $sqliteDb->query("SELECT * FROM product_images")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($images as $image) {
        $stmt = $mysqlDb->prepare("
            INSERT INTO product_images (id, product_id, image_path, alt_text, form_type, language, sort_order, is_active, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $image['id'],
            $image['product_id'],
            $image['image_path'],
            $image['alt_text'],
            $image['form_type'],
            $image['language'],
            $image['sort_order'],
            $image['is_active'],
            $image['created_at']
        ]);
    }
    echo "✅ Product images migrated: " . count($images) . " records\n";
    
    // Product Categories
    echo "🔗 Migrating product categories...\n";
    $productCategories = $sqliteDb->query("SELECT * FROM product_categories")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($productCategories as $pc) {
        $stmt = $mysqlDb->prepare("
            INSERT INTO product_categories (product_id, category_id)
            VALUES (?, ?)
        ");
        $stmt->execute([$pc['product_id'], $pc['category_id']]);
    }
    echo "✅ Product categories migrated: " . count($productCategories) . " records\n";
    
    // Product Indications
    echo "🔗 Migrating product indications...\n";
    $productIndications = $sqliteDb->query("SELECT * FROM product_indications")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($productIndications as $pi) {
        $stmt = $mysqlDb->prepare("
            INSERT INTO product_indications (product_id, indication_id)
            VALUES (?, ?)
        ");
        $stmt->execute([$pi['product_id'], $pi['indication_id']]);
    }
    echo "✅ Product indications migrated: " . count($productIndications) . " records\n";
    
    // Product Species
    echo "🔗 Migrating product species...\n";
    $productSpecies = $sqliteDb->query("SELECT * FROM product_species")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($productSpecies as $ps) {
        $stmt = $mysqlDb->prepare("
            INSERT INTO product_species (product_id, species_id)
            VALUES (?, ?)
        ");
        $stmt->execute([$ps['product_id'], $ps['species_id']]);
    }
    echo "✅ Product species migrated: " . count($productSpecies) . " records\n";
    
    // Product Benefits
    echo "💪 Migrating product benefits...\n";
    $benefits = $sqliteDb->query("SELECT * FROM product_benefits")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($benefits as $benefit) {
        $stmt = $mysqlDb->prepare("
            INSERT INTO product_benefits (id, product_id, benefit_text, sort_order, is_active, created_at)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $benefit['id'],
            $benefit['product_id'],
            $benefit['benefit_text'],
            $benefit['sort_order'],
            $benefit['is_active'],
            $benefit['created_at']
        ]);
    }
    echo "✅ Product benefits migrated: " . count($benefits) . " records\n";
    
    // Product Warnings
    echo "⚠️  Migrating product warnings...\n";
    $warnings = $sqliteDb->query("SELECT * FROM product_warnings")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($warnings as $warning) {
        $stmt = $mysqlDb->prepare("
            INSERT INTO product_warnings (id, product_id, warning_text, sort_order, is_active, created_at)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $warning['id'],
            $warning['product_id'],
            $warning['warning_text'],
            $warning['sort_order'],
            $warning['is_active'],
            $warning['created_at']
        ]);
    }
    echo "✅ Product warnings migrated: " . count($warnings) . " records\n";
    
    // Product Ingredients
    echo "🧪 Migrating product ingredients...\n";
    $ingredients = $sqliteDb->query("SELECT * FROM product_ingredients")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($ingredients as $ingredient) {
        $stmt = $mysqlDb->prepare("
            INSERT INTO product_ingredients (id, product_id, ingredient_name, function_description, sort_order, is_active, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $ingredient['id'],
            $ingredient['product_id'],
            $ingredient['ingredient_name'],
            $ingredient['function_description'],
            $ingredient['sort_order'],
            $ingredient['is_active'],
            $ingredient['created_at']
        ]);
    }
    echo "✅ Product ingredients migrated: " . count($ingredients) . " records\n";
    
    echo "\n🎉 Migration completed successfully!\n";
    echo "🌐 You can now use MySQL database.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
?>
