CREATE DATABASE IF NOT EXISTS shopdb;
USE shopdb;

-- shopusers table
CREATE TABLE IF NOT EXISTS shopusers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO shopusers (name, email, password)
VALUES ('Drew Hyman', 'test@gmail.com', '$2y$10$MMy4HtQSTVW8MwMqGJ6eoeghdqfo3M3bXS9Y0D33iuVGx/nBXYnO.')
ON DUPLICATE KEY UPDATE email=email;

-- adminusers table
CREATE TABLE IF NOT EXISTS adminusers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO adminusers (name, email, password)
VALUES ('Admin', 'admin@gmail.com', '$2y$10$MMy4HtQSTVW8MwMqGJ6eoeghdqfo3M3bXS9Y0D33iuVGx/nBXYnO.')
ON DUPLICATE KEY UPDATE email=email;

-- products table
CREATE TABLE IF NOT EXISTS products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    image_url VARCHAR(500),
    stock INT NOT NULL
);

-- insert product rows
INSERT INTO products (name, price, category, image_url, stock)
VALUES
('Honey Roast Ham', 24.99, 'meat', 'https://www.cookingclassy.com/wp-content/uploads/2017/12/honey-glazed-ham-4.jpg', 90),
('Roast Turkey', 39.99, 'meat', 'https://www.inspiredtaste.net/wp-content/uploads/2023/11/Roasted-Turkey-Recipe-1-1200.jpg', 100),
('Roast Beef', 24.99, 'meat', 'https://www.tasteofhome.com/wp-content/uploads/2025/01/Herb-Crusted-Roast-Beef_EXPS_FT25_9187_EC_0108_1.jpg', 100),
('Chicken', 19.99, 'meat', 'https://badleysbutchers.co.uk/cdn/shop/products/Whole_Chicken_6a5911ed-47a9-46fc-9bdf-437b968dfade.jpg?v=1577375639', 100),
('Carrots', 1.99, 'veg', 'https://www.closetcooking.com/wp-content/uploads/2023/11/Honey-Balsamic-Roasted-Carrots-1200-1969.jpg', 100),
('Tenderstem Broccoli', 1.99, 'veg', 'https://healthylivingjames.co.uk/wp-content/uploads/2024/07/Air-Fryer-Tenderstem-Broccoli-Square.jpg', 100),
('Brussel Sprouts', 2.50, 'veg', 'https://tinandthyme.uk/wp-content/uploads/2023/01/Cooked-Brussels-Sprouts.jpg', 100),
('Parsnips', 2.20, 'veg', 'https://www.allrecipes.com/thmb/FBpzlDkBGve3sv9KkapC0gTJTw8=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/1221_MW021_jennifer-causey-2000-5776fb1d3586436bb7c4d1453da299f6.jpg', 100),
('Christmas Cake', 14.99, 'bakery', 'https://ichef.bbci.co.uk/food/ic/food_16x9_832/recipes/classic_christmas_cake_04076_16x9.jpg', 100),
('Mince Pies', 3.99, 'bakery', 'https://culinaryginger.com/wp-content/uploads/Christmas-Sweet-Mince-Pies-7.jpg', 100),
('Cinnamon Rolls', 2.99, 'bakery', 'https://horizon.com/wp-content/uploads/recipe-cin-roll-hero.jpg', 100),
('Croissants', 1.99, 'bakery', 'https://sarahsvegankitchen.com/wp-content/uploads/2024/05/Vegan-Croissants-1.jpg', 100),
('Cumberland Sausage', 3.99, 'meat', 'https://farm2table.co.uk/cdn/shop/products/Cumberland_530x.jpg?v=1606671132', 80);

-- orders table
CREATE TABLE IF NOT EXISTS orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    address VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'Pending',
    payment_method VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES shopusers(id)
);

-- order_items table
CREATE TABLE IF NOT EXISTS order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- user_cart table
CREATE TABLE IF NOT EXISTS user_cart (
    cart_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    added_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES shopusers(id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);

-- user_wishlist table
CREATE TABLE IF NOT EXISTS user_wishlist (
    wishlist_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    added_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES shopusers(id),
    FOREIGN KEY (product_id) REFERENCES products(product_id)
);
