CREATE DATABASE IF NOT EXISTS urbanstitch_store;
USE urbanstitch_store;

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT,
    image_url VARCHAR(500),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20),
    customer_address TEXT,
    total_amount DECIMAL(10, 2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50) DEFAULT 'Pending',
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

INSERT INTO categories (name, description) VALUES
('Kandyan Sarees', 'Traditional Kandyan style sarees with authentic Sri Lankan designs'),
('Batik Wear', 'Handcrafted batik clothing with vibrant patterns'),
('Casual Wear', 'Comfortable everyday clothing with Sri Lankan touch'),
('Traditional Wear', 'Authentic Sri Lankan traditional outfits'),
('Accessories', 'Traditional Sri Lankan accessories and jewelry');

INSERT INTO admins (username, password, email) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@urbanstitch.lk');

-- Sri Lankan Sample Products
INSERT INTO products (name, description, price, category_id, image_url, stock) VALUES
-- Kandyan Sarees (category 1)
('Royal Kandyan Silk Saree', 'Exquisite handwoven Kandyan silk saree in deep maroon with intricate gold thread border work, perfect for weddings and special occasions', 15500.00, 1, 'https://images.pexels.com/photos/8148586/pexels-photo-8148586.jpeg?auto=compress&cs=tinysrgb&w=800', 15),
('Traditional Osariya Set', 'Complete traditional Kandyan osariya with matching blouse and accessories, featuring classic Kandyan design motifs', 18500.00, 1, 'https://images.pexels.com/photos/4041279/pexels-photo-4041279.jpeg?auto=compress&cs=tinysrgb&w=800', 20),
('Embroidered Saree Blouse', 'Designer saree blouse with golden thread embroidery inspired by Kandyan temple art', 2500.00, 1, 'https://images.pexels.com/photos/8090193/pexels-photo-8090193.jpeg?auto=compress&cs=tinysrgb&w=800', 35),
('Handloom Cotton Saree', 'Pure handloom cotton saree woven in Kandy with natural dyes and traditional patterns', 12500.00, 1, 'https://images.pexels.com/photos/6077326/pexels-photo-6077326.jpeg?auto=compress&cs=tinysrgb&w=800', 14),
('Traditional Osariya Jacket', 'Matching silk jacket for Kandyan saree ensemble with ornate button detailing', 3800.00, 1, 'https://images.pexels.com/photos/5704849/pexels-photo-5704849.jpeg?auto=compress&cs=tinysrgb&w=800', 20),
('Bridal Kandyan Saree', 'Premium white and gold bridal Kandyan saree with Perahera-inspired motifs and heavy border', 35000.00, 1, 'https://images.pexels.com/photos/2916814/pexels-photo-2916814.jpeg?auto=compress&cs=tinysrgb&w=800', 5),

-- Batik Wear (category 2)
('Peacock Batik Dress', 'Elegant batik dress featuring traditional Sri Lankan peacock motif in vibrant blues and greens', 4500.00, 2, 'https://images.pexels.com/photos/10214719/pexels-photo-10214719.jpeg?auto=compress&cs=tinysrgb&w=800', 30),
('Floral Batik Sarong', 'Comfortable hand-dyed batik sarong with beautiful tropical floral patterns from Matale', 2800.00, 2, 'https://images.pexels.com/photos/5704852/pexels-photo-5704852.jpeg?auto=compress&cs=tinysrgb&w=800', 45),
('Batik Shirt - Mens', 'Stylish batik shirt for men with contemporary Sri Lankan design, perfect for casual outings', 3200.00, 2, 'https://images.pexels.com/photos/4610390/pexels-photo-4610390.jpeg?auto=compress&cs=tinysrgb&w=800', 25),
('Batik Palazzo Pants', 'Comfortable batik palazzo pants handcrafted with wax-resist technique', 3200.00, 2, 'https://images.pexels.com/photos/7679624/pexels-photo-7679624.jpeg?auto=compress&cs=tinysrgb&w=800', 28),
('Batik Maxi Dress', 'Flowing batik maxi dress with Sri Lankan lotus motifs, perfect for tropical weather', 5200.00, 2, 'https://images.pexels.com/photos/9594673/pexels-photo-9594673.jpeg?auto=compress&cs=tinysrgb&w=800', 25),
('Batik Jumpsuit', 'Contemporary batik jumpsuit with modern silhouette and traditional wax patterns', 6800.00, 2, 'https://images.pexels.com/photos/7679669/pexels-photo-7679669.jpeg?auto=compress&cs=tinysrgb&w=800', 16),

-- Casual Wear (category 3)
('Cotton Handloom Dress', 'Soft cotton dress with traditional handloom patterns from Dumbara weaving village', 3500.00, 3, 'https://images.pexels.com/photos/3764119/pexels-photo-3764119.jpeg?auto=compress&cs=tinysrgb&w=800', 40),
('Linen Tunic Top', 'Breathable linen top with ethnic Sri Lankan embroidery along the neckline', 2900.00, 3, 'https://images.pexels.com/photos/7679665/pexels-photo-7679665.jpeg?auto=compress&cs=tinysrgb&w=800', 35),
('Cotton Kurta Set - Mens', 'Traditional cotton kurta with matching bottom in lightweight Sri Lankan cotton', 4800.00, 3, 'https://images.pexels.com/photos/5698855/pexels-photo-5698855.jpeg?auto=compress&cs=tinysrgb&w=800', 22),
('Linen Wrap Skirt', 'Elegant linen wrap skirt with hand-block printed Sri Lankan elephant motifs', 2600.00, 3, 'https://images.pexels.com/photos/6765164/pexels-photo-6765164.jpeg?auto=compress&cs=tinysrgb&w=800', 30),
('Handloom Cotton Shirt', 'Lightweight handloom cotton shirt with subtle Sri Lankan geometric patterns', 2200.00, 3, 'https://images.pexels.com/photos/6626903/pexels-photo-6626903.jpeg?auto=compress&cs=tinysrgb&w=800', 38),
('Casual Batik Tee', 'Casual t-shirt with small batik-print pocket detail, made from organic Sri Lankan cotton', 1800.00, 3, 'https://images.pexels.com/photos/5698852/pexels-photo-5698852.jpeg?auto=compress&cs=tinysrgb&w=800', 50),

-- Traditional Wear (category 4)
('Traditional Nil Diya Set', 'Authentic traditional outfit for cultural events, featuring blue and white Nil Diya design', 8500.00, 4, 'https://images.pexels.com/photos/3775131/pexels-photo-3775131.jpeg?auto=compress&cs=tinysrgb&w=800', 12),
('Wedding Saree Collection', 'Premium silk saree with intricate lacework, ideal for Sinhala and Tamil New Year celebrations', 32000.00, 4, 'https://images.pexels.com/photos/3014853/pexels-photo-3014853.jpeg?auto=compress&cs=tinysrgb&w=800', 8),
('Handwoven Silk Shawl', 'Luxurious handwoven silk shawl in traditional Dumbara patterns', 6500.00, 4, 'https://images.pexels.com/photos/4622231/pexels-photo-4622231.jpeg?auto=compress&cs=tinysrgb&w=800', 15),
('Mens National Costume', 'Complete Sri Lankan national costume with white sarong, shirt, and sash for formal occasions', 7500.00, 4, 'https://images.pexels.com/photos/6626882/pexels-photo-6626882.jpeg?auto=compress&cs=tinysrgb&w=800', 10),
('Vesak Festival Dress', 'Elegant white outfit traditionally worn during Vesak celebrations with lotus embroidery', 5500.00, 4, 'https://images.pexels.com/photos/4622233/pexels-photo-4622233.jpeg?auto=compress&cs=tinysrgb&w=800', 18),
('Avurudu Special Saree', 'Colorful saree designed for Sinhala and Tamil New Year in auspicious red and gold', 14000.00, 4, 'https://images.pexels.com/photos/2220316/pexels-photo-2220316.jpeg?auto=compress&cs=tinysrgb&w=800', 12),

-- Accessories (category 5)
('Handcrafted Silver Jewelry Set', 'Traditional Sri Lankan silver jewelry set with moonstone earrings and necklace from Ratnapura', 5500.00, 5, 'https://images.pexels.com/photos/1454171/pexels-photo-1454171.jpeg?auto=compress&cs=tinysrgb&w=800', 50),
('Beaded Handbag', 'Elegant hand-beaded handbag with traditional Kandyan motifs', 1800.00, 5, 'https://images.pexels.com/photos/2081199/pexels-photo-2081199.jpeg?auto=compress&cs=tinysrgb&w=800', 60),
('Traditional Hair Accessories', 'Set of traditional Kandyan-style hair pins and jasmine flower ornaments', 950.00, 5, 'https://images.pexels.com/photos/3373736/pexels-photo-3373736.jpeg?auto=compress&cs=tinysrgb&w=800', 50),
('Pearl Necklace Set', 'Elegant pearl necklace with matching earrings, inspired by Sri Lankan bridal jewelry', 8900.00, 5, 'https://images.pexels.com/photos/1454172/pexels-photo-1454172.jpeg?auto=compress&cs=tinysrgb&w=800', 18),
('Ethnic Print Scarf', 'Lightweight silk scarf with traditional Sri Lankan temple art prints', 1200.00, 5, 'https://images.pexels.com/photos/8148583/pexels-photo-8148583.jpeg?auto=compress&cs=tinysrgb&w=800', 55),
('Moonstone Bracelet', 'Handcrafted bracelet with genuine Sri Lankan moonstones set in sterling silver', 4200.00, 5, 'https://images.pexels.com/photos/1152077/pexels-photo-1152077.jpeg?auto=compress&cs=tinysrgb&w=800', 40),
('Handwoven Reed Clutch', 'Eco-friendly clutch bag handwoven from Sri Lankan reed with brass clasp', 2400.00, 5, 'https://images.pexels.com/photos/3373727/pexels-photo-3373727.jpeg?auto=compress&cs=tinysrgb&w=800', 35),
('Blue Sapphire Pendant', 'Sterling silver pendant featuring a genuine Ceylon blue sapphire from Ratnapura mines', 12500.00, 5, 'https://images.pexels.com/photos/10983783/pexels-photo-10983783.jpeg?auto=compress&cs=tinysrgb&w=800', 10);

-- Sample Users
INSERT INTO users (full_name, email, password, phone, address) VALUES
('Nimali Fernando', 'nimali@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0771234567', '45 Temple Road, Colombo 07'),
('Sachini Perera', 'sachini@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0769876543', '12 Kandy Road, Peradeniya'),
('Ruwan Silva', 'ruwan@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0751122334', '78 Galle Face, Galle');

-- Sample Orders
INSERT INTO orders (user_id, customer_name, customer_email, customer_phone, customer_address, total_amount, status) VALUES
(1, 'Nimali Fernando', 'nimali@example.com', '0771234567', '45 Temple Road, Colombo 07', 34000.00, 'Delivered'),
(2, 'Sachini Perera', 'sachini@example.com', '0769876543', '12 Kandy Road, Peradeniya', 7300.00, 'Processing'),
(3, 'Ruwan Silva', 'ruwan@example.com', '0751122334', '78 Galle Face, Galle', 18500.00, 'Pending');

-- Sample Order Items
INSERT INTO order_items (order_id, product_id, quantity, price) VALUES
(1, 1, 1, 15500.00),
(1, 2, 1, 18500.00),
(2, 7, 1, 4500.00),
(2, 8, 1, 2800.00),
(3, 2, 1, 18500.00);
