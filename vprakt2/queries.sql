-- 1. Удаление пустых групп (категорий без товаров)
DELETE FROM categories
WHERE id NOT IN (SELECT DISTINCT category_id FROM products);

-- 2. Удаление товаров без наличия на складах
DELETE FROM products
WHERE id NOT IN (SELECT DISTINCT product_id FROM availabilities);

-- 3. Удаление складов без товаров
DELETE FROM stocks
WHERE id NOT IN (SELECT DISTINCT stock_id FROM availabilities);