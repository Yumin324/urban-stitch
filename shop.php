<?php
require_once 'config/database.php';
$pageTitle = 'Shop';
include 'includes/header.php';

$category_filter = isset($_GET['category']) ? intval($_GET['category']) : 0;
$search_query = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$sql = "SELECT p.*, c.name as category_name FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";

if($category_filter > 0) {
    $sql .= " AND p.category_id = $category_filter";
}

if(!empty($search_query)) {
    $sql .= " AND (p.name LIKE '%$search_query%' OR p.description LIKE '%$search_query%')";
}

$sql .= " ORDER BY p.created_at DESC";
$products = mysqli_query($conn, $sql);
?>

<section class="page-header">
    <div class="container">
        <h1>Shop Our Collection</h1>
        <p>Discover authentic Sri Lankan traditional wear</p>
    </div>
</section>

<section class="shop-section">
    <div class="container">
        <div class="shop-controls">
            <div class="search-bar">
                <form method="GET" action="shop.php">
                    <input type="text" name="search" placeholder="Search products..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
            <div class="category-filter">
                <label>Filter by Category:</label>
                <select onchange="window.location.href='shop.php?category=' + this.value + (new URLSearchParams(window.location.search).get('search') ? '&search=' + new URLSearchParams(window.location.search).get('search') : '')">
                    <option value="0">All Categories</option>
                    <?php
                    $cat_query = "SELECT * FROM categories";
                    $categories = mysqli_query($conn, $cat_query);
                    while($cat = mysqli_fetch_assoc($categories)) {
                        $selected = ($category_filter == $cat['id']) ? 'selected' : '';
                        echo "<option value='{$cat['id']}' $selected>" . htmlspecialchars($cat['name']) . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="products-grid">
            <?php
            if(mysqli_num_rows($products) > 0) {
                while($product = mysqli_fetch_assoc($products)) {
            ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <?php if($product['stock'] < 10) { ?>
                            <span class="stock-badge">Only <?php echo $product['stock']; ?> left</span>
                        <?php } ?>
                    </div>
                    <div class="product-info">
                        <span class="product-category"><?php echo htmlspecialchars($product['category_name']); ?></span>
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="product-description"><?php echo htmlspecialchars(substr($product['description'], 0, 100)) . '...'; ?></p>
                        <p class="product-price">LKR <?php echo number_format($product['price'], 2); ?></p>
                        <?php if($product['stock'] > 0) { ?>
                            <button class="btn btn-cart" onclick="addToCart(<?php echo $product['id']; ?>, '<?php echo htmlspecialchars($product['name']); ?>', <?php echo $product['price']; ?>, '<?php echo htmlspecialchars($product['image_url']); ?>')">Add to Cart</button>
                        <?php } else { ?>
                            <button class="btn btn-disabled" disabled>Out of Stock</button>
                        <?php } ?>
                    </div>
                </div>
            <?php
                }
            } else {
                echo "<p class='no-results'>No products found matching your criteria.</p>";
            }
            ?>
        </div>
    </div>
</section>

<?php
mysqli_close($conn);
include 'includes/footer.php';
?>
