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
7627143750-d86bc21e80cb?w=800&q=80', 15),
('Traditional Osariya Set', 'Complete traditional Kandyan osariya with matching blouse and accessories', 18500.00, 1, 'https://images.pexels.com/photos/4041279/pexels-photo-4041279.jpeg?auto=compress&cs=tinysrgb&w=800', 20),
('Peacock Batik Dress', 'Elegant batik dress featuring traditional peacock motif in vibrant colors', 4500.00, 2, 'https://images.pexels.com/photos/10214719/pexels-photo-10214719.jpeg?auto=compress&cs=tinysrgb&w=800', 30),
('Floral Batik Sarong', 'Comfortable batik sarong with beautiful floral patterns', 2800.00, 2, 'https://images.pexels.com/photos/5704852/pexels-photo-5704852.jpeg?auto=compress&cs=tinysrgb&w=800', 45),
('Batik Shirt - Mens', 'Stylish batik shirt for men with contemporary design', 3200.00, 2, 'https://images.pexels.com/photos/4610390/pexels-photo-4610390.jpeg?auto=compress&cs=tinysrgb&w=800', 25),
('Cotton Handloom Dress', 'Soft cotton dress with traditional handloom patterns', 3500.00, 3, 'https://images.pexels.com/photos/3764119/pexels-photo-3764119.jpeg?auto=compress&cs=tinysrgb&w=800', 40),
('Linen Tunic Top', 'Breathable linen top with ethnic embroidery', 2900.00, 3, 'https://images.pexels.com/photos/7679665/pexels-photo-7679665.jpeg?auto=compress&cs=tinysrgb&w=800', 35),
('Traditional Nil Diya Set', 'Authentic traditional outfit for cultural events', 8500.00, 4, 'https://images.pexels.com/photos/3775131/pexels-photo-3775131.jpeg?auto=compress&cs=tinysrgb&w=800', 12),
('Wedding Saree Collection', 'Premium silk saree with intricate lacework', 32000.00, 4, 'https://images.pexels.com/photos/8148586/pexels-photo-8148586.jpeg?auto=compress&cs=tinysrgb&w=800', 8),
('Handcrafted Silver Jewelry', 'Traditional Sri Lankan silver jewelry set', 5500.00, 5, 'https://images.pexels.com/photos/1454171/pexels-photo-1454171.jpeg?auto=compress&cs=tinysrgb&w=800', 50),
('Beaded Handbag', 'Elegant beaded handbag with traditional motifs', 1800.00, 5, 'https://images.pexels.com/photos/2081199/pexels-photo-2081199.jpeg?auto=compress&cs=tinysrgb&w=800', 60),
('Traditional Hair Accessories', 'Set of traditional hair pins and flowers', 950.00, 5, 'https://images.pexels.com/photos/3373736/pexels-photo-3373736.jpeg?auto=compress&cs=tinysrgb&w=800', 50),
('Beaded Handbag', 'Elegant beaded handbag with traditional motifs', 1800.00, 5, 'https://images.pexels.com/photos/1152077/pexels-photo-1152077.jpeg?auto=compress&cs=tinysrgb&w=800', 60),
('Traditional Hair Accessories', 'Set of traditional hair pins and flowers', 950.00, 5, 'https://images.pexels.com/photos/3373727/pexels-photo-3373727.jpeg?auto=compress&cs=tinysrgb&w=800', 80),
('Embroidered Saree Blouse', 'Designer saree blouse with golden thread embroidery', 2500.00, 1, 'https://images.pexels.com/photos/8090193/pexels-photo-8090193.jpeg?auto=compress&cs=tinysrgb&w=800', 35),
('Batik Palazzo Pants', 'Comfortable batik palazzo pants for casual wear', 3200.00, 2, 'https://images.pexels.com/photos/7679624/pexels-photo-7679624.jpeg?auto=compress&cs=tinysrgb&w=800', 28),
('Handwoven Silk Shawl', 'Luxurious handwoven silk shawl in traditional patterns', 6500.00, 4, 'https://images.pexels.com/photos/4622231/pexels-photo-4622231.jpeg?auto=compress&cs=tinysrgb&w=800', 15),
('Cotton Kurta Set - Mens', 'Traditional cotton kurta with matching bottom', 4800.00, 3, 'https://images.pexels.com/photos/5698855/pexels-photo-5698855.jpeg?auto=compress&cs=tinysrgb&w=800', 22),
('Pearl Necklace Set', 'Elegant pearl necklace with matching earrings', 8900.00, 5, 'https://images.pexels.com/photos/1454172/pexels-photo-1454172.jpeg?auto=compress&cs=tinysrgb&w=800', 18),
('Batik Maxi Dress', 'Flowing batik maxi dress perfect for summer', 5200.00, 2, 'https://images.pexels.com/photos/9594673/pexels-photo-9594673.jpeg?auto=compress&cs=tinysrgb&w=800', 25),
('Traditional Osariya Jacket', 'Matching jacket for Kandyan saree ensemble', 3800.00, 1, 'https://images.pexels.com/photos/5704849/pexels-photo-5704849.jpeg?auto=compress&cs=tinysrgb&w=800', 20),
('Ethnic Print Scarf', 'Lightweight scarf with traditional Sri Lankan prints', 1200.00, 5, 'https://images.pexels.com/photos/8148583/pexels-photo-8148583.jpeg?auto=compress&cs=tinysrgb&w=800', 55),
('Handloom Cotton Saree', 'Pure handloom cotton saree in natural colors', 12500.00, 1, 'https://images.pexels.com/photos/6077326/pexels-photo-6077326.jpeg?auto=compress&cs=tinysrgb&w=800', 14),
('Batik Jumpsuit', 'Contemporary batik jumpsuit with modern silhouette', 6800.00, 2, 'https://images.pexels.com/photos/7679669/pexels-photo-7679669.jpeg?auto=compress&cs=tinysrgb&w=800', 16);
