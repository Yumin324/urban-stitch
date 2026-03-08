<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config/database.php';
$pageTitle = 'My Orders';
include 'includes/header.php';

$user_id = $_SESSION['user_id'];
$orders = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC");
?>

<section class="page-header">
    <div class="container">
        <h1>My Orders</h1>
        <p>Track your order history</p>
    </div>
</section>

<section class="orders-section">
    <div class="container">
        <?php if(mysqli_num_rows($orders) > 0): ?>
            <div class="orders-grid">
                <?php while($order = mysqli_fetch_assoc($orders)): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <h3>Order #<?php echo $order['id']; ?></h3>
                            <span class="order-status status-<?php echo strtolower($order['status']); ?>">
                                <?php echo $order['status']; ?>
                            </span>
                        </div>
                        <div class="order-details">
                            <p><strong>Date:</strong> <?php echo date('M d, Y H:i', strtotime($order['order_date'])); ?></p>
                            <p><strong>Total:</strong> LKR <?php echo number_format($order['total_amount'], 2); ?></p>
                            <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($order['customer_address']); ?></p>
                        </div>
                        <div class="order-items">
                            <?php
                            $order_id = $order['id'];
                            $items = mysqli_query($conn, "SELECT oi.*, p.name, p.image_url FROM order_items oi 
                                                          LEFT JOIN products p ON oi.product_id = p.id 
                                                          WHERE oi.order_id = $order_id");
                            while($item = mysqli_fetch_assoc($items)):
                            ?>
                                <div class="order-item-preview">
                                    <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                    <div>
                                        <p><?php echo htmlspecialchars($item['name']); ?></p>
                                        <small>Qty: <?php echo $item['quantity']; ?> × LKR <?php echo number_format($item['price'], 2); ?></small>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <h3>No orders yet</h3>
                <p>Start shopping to see your orders here</p>
                <a href="shop.php" class="btn btn-primary">Browse Products</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php
mysqli_close($conn);
include 'includes/footer.php';
?>
