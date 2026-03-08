<?php
require_once 'config/database.php';
$pageTitle = 'Home';
include 'includes/header.php';
?>

<section class="hero">
    <div class="hero-content">
        <h2>Discover Sri Lankan Elegance</h2>
        <p>Authentic Kandyan Sarees, Batik Wear & Traditional Clothing</p>
        <a href="shop.php" class="btn btn-primary">Shop Now</a>
    </div>
</section>

<section class="featured-categories">
    <div class="container">
        <h2 class="section-title">Our Collections</h2>
        <div class="categories-grid">
            <?php
            $cat_query = "SELECT * FROM categories LIMIT 4";
            $cat_result = mysqli_query($conn, $cat_query);
            
            $cat_images = [
                'https://images.pexels.com/photos/4041279/pexels-photo-4041279.jpeg?auto=compress&cs=tinysrgb&w=600',
                'https://images.pexels.com/photos/10214719/pexels-photo-10214719.jpeg?auto=compress&cs=tinysrgb&w=600',
                'https://images.pexels.com/photos/3764119/pexels-photo-3764119.jpeg?auto=compress&cs=tinysrgb&w=600',
                'https://images.pexels.com/photos/3775131/pexels-photo-3775131.jpeg?auto=compress&cs=tinysrgb&w=600'
            ];
            
            $index = 0;
            while($category = mysqli_fetch_assoc($cat_result)) {
            ?>
                <div class="category-card">
                    <img src="<?php echo $cat_images[$index]; ?>" alt="<?php echo htmlspecialchars($category['name']); ?>">
                    <div class="category-info">
                        <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                        <p><?php echo htmlspecialchars($category['description']); ?></p>
                        <a href="shop.php?category=<?php echo $category['id']; ?>" class="btn btn-secondary">Browse</a>
                    </div>
                </div>
            <?php
                $index++;
            }
            ?>
        </div>
    </div>
</section>

<section class="featured-products">
    <div class="container">
        <h2 class="section-title">Featured Products</h2>
        <div class="products-grid">
            <?php
            $prod_query = "SELECT p.*, c.name as category_name FROM products p 
                          LEFT JOIN categories c ON p.category_id = c.id 
                          ORDER BY p.created_at DESC LIMIT 8";
            $prod_result = mysqli_query($conn, $prod_query);
            
            while($product = mysqli_fetch_assoc($prod_result)) {
            ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    </div>
                    <div class="product-info">
                        <span class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></span>
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="product-price">LKR <?php echo number_format($product['price'], 2); ?></p>
                        <button class="btn btn-cart" onclick="addToCart(<?php echo $product['id']; ?>, '<?php echo htmlspecialchars($product['name']); ?>', <?php echo $product['price']; ?>, '<?php echo htmlspecialchars($product['image_url']); ?>')">Add to Cart</button>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>

<section class="about-preview">
    <div class="container">
        <div class="about-content">
            <div class="about-text">
                <h2>About Urban Stitch</h2>
                <p>Urban Stitch is your premier destination for authentic Sri Lankan traditional wear. From exquisite Kandyan sarees to vibrant batik collections, we celebrate the rich heritage of Sri Lankan craftsmanship.</p>
                <p>Each piece in our collection tells a story of generations of artisans who have perfected their craft, bringing you clothing that combines traditional elegance with contemporary style.</p>
                <a href="about.php" class="btn btn-primary">Learn More</a>
            </div>
            <div class="about-image">
                <img src="https://images.pexels.com/photos/3775131/pexels-photo-3775131.jpeg?auto=compress&cs=tinysrgb&w=700" alt="Traditional Sri Lankan Wear">
            </div>
        </div>
    </div>
</section>

<section class="features-section">
    <div class="container">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🚚</div>
                <h3>Free Delivery</h3>
                <p>Free shipping on orders over Rs. 5,000</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">✨</div>
                <h3>Quality Guaranteed</h3>
                <p>100% authentic handcrafted products</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h3>Secure Payment</h3>
                <p>Safe and secure payment options</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">↩️</div>
                <h3>Easy Returns</h3>
                <p>7-day return policy for your peace of mind</p>
            </div>
        </div>
    </div>
</section>

<section class="testimonials-section">
    <div class="container">
        <h2 class="section-title">What Our Customers Say</h2>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="stars">⭐⭐⭐⭐⭐</div>
                <p>"Absolutely stunning quality! The Kandyan saree I purchased was exactly as described. The craftsmanship is exceptional and I received so many compliments at my brother's wedding."</p>
                <div class="testimonial-author">
                    <h4>Nimali Fernando</h4>
                    <span>Colombo</span>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">⭐⭐⭐⭐⭐</div>
                <p>"Urban Stitch is my go-to place for traditional wear. The batik collection is beautiful and the clothing fits perfectly. Fast delivery and excellent customer service!"</p>
                <div class="testimonial-author">
                    <h4>Sachini Perera</h4>
                    <span>Kandy</span>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">⭐⭐⭐⭐⭐</div>
                <p>"I was looking for authentic traditional wear for a cultural event and found the perfect outfit here. The attention to detail and quality is outstanding. Highly recommended!"</p>
                <div class="testimonial-author">
                    <h4>Ruwan Silva</h4>
                    <span>Galle</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-content">
            <div class="newsletter-text">
                <h2>Stay Updated</h2>
                <p>Subscribe to our newsletter and get exclusive offers, new arrivals, and style tips delivered to your inbox.</p>
            </div>
            <form class="newsletter-form" id="newsletterForm">
                <input type="email" placeholder="Enter your email address" required>
                <button type="submit" class="btn btn-primary">Subscribe</button>
            </form>
        </div>
    </div>
</section>

<?php
mysqli_close($conn);
include 'includes/footer.php';
?>
