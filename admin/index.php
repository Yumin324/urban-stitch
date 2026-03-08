<?php
require_once 'auth.php';
require_once '../config/database.php';
$pageTitle = 'Dashboard';
include 'includes/header.php';

$total_products = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products"))['count'];
$total_categories = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM categories"))['count'];
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM orders"))['count'];
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) as total FROM orders"))['total'] ?? 0;
?>

<div class="dashboard-stats">
    <div class="stat-card">
        <h3>Total Products</h3>
        <p class="stat-number"><?php echo $total_products; ?></p>
    </div>
    <div class="stat-card">
        <h3>Categories</h3>
        <p class="stat-number"><?php echo $total_categories; ?></p>
    </div>
    <div class="stat-card">
        <h3>Total Orders</h3>
        <p class="stat-number"><?php echo $total_orders; ?></p>
    </div>
    <div class="stat-card">
        <h3>Total Revenue</h3>
        <p class="stat-number">LKR <?php echo number_format($total_revenue, 2); ?></p>
    </div>
</div>

<div class="dashboard-section">
    <h2>Recent Orders</h2>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_date DESC LIMIT 5");
            while($order = mysqli_fetch_assoc($orders)) {
            ?>
            <tr>
                <td>#<?php echo $order['id']; ?></td>
                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                <td>LKR <?php echo number_format($order['total_amount'], 2); ?></td>
                <td><?php echo date('M d, Y', strtotime($order['order_date'])); ?></td>
                <td><span class="status-badge"><?php echo $order['status']; ?></span></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="dashboard-section">
    <h2>Low Stock Products</h2>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $low_stock = mysqli_query($conn, "SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.stock < 20 ORDER BY p.stock ASC LIMIT 5");
            while($product = mysqli_fetch_assoc($low_stock)) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                <td><span class="stock-warning"><?php echo $product['stock']; ?></span></td>
                <td>LKR <?php echo number_format($product['price'], 2); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
mysqli_close($conn);
include 'includes/footer.php';
?>
