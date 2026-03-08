<?php
require_once 'auth.php';
require_once '../config/database.php';
$pageTitle = 'Manage Orders';

$message = '';
$message_type = '';

if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $delete = mysqli_query($conn, "DELETE FROM orders WHERE id = $id");
    if($delete) {
        $message = 'Order deleted successfully';
        $message_type = 'success';
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $sql = "UPDATE orders SET status='$status' WHERE id=$order_id";
    if(mysqli_query($conn, $sql)) {
        $message = 'Order status updated successfully';
        $message_type = 'success';
    }
}

$orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_date DESC");

include 'includes/header.php';
?>

<?php if($message): ?>
    <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
<?php endif; ?>

<table class="admin-table">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Total Amount</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($order = mysqli_fetch_assoc($orders)): ?>
        <tr>
            <td>#<?php echo $order['id']; ?></td>
            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
            <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
            <td><?php echo htmlspecialchars($order['customer_phone']); ?></td>
            <td>LKR <?php echo number_format($order['total_amount'], 2); ?></td>
            <td><?php echo date('M d, Y H:i', strtotime($order['order_date'])); ?></td>
            <td>
                <form method="POST" action="orders.php" style="display: inline;">
                    <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                    <select name="status" onchange="this.form.submit()" class="status-select">
                        <option value="Pending" <?php echo $order['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Processing" <?php echo $order['status'] == 'Processing' ? 'selected' : ''; ?>>Processing</option>
                        <option value="Shipped" <?php echo $order['status'] == 'Shipped' ? 'selected' : ''; ?>>Shipped</option>
                        <option value="Delivered" <?php echo $order['status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                        <option value="Cancelled" <?php echo $order['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                    <input type="hidden" name="update_status" value="1">
                </form>
            </td>
            <td>
                <button class="btn btn-sm btn-view" onclick='viewOrder(<?php echo $order['id']; ?>)'>View Details</button>
                <a href="orders.php?delete=<?php echo $order['id']; ?>" class="btn btn-sm btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div id="orderModal" class="modal">
    <div class="modal-content">
        <span class="modal-close" onclick="closeModal()">&times;</span>
        <h2>Order Details</h2>
        <div id="orderDetails"></div>
    </div>
</div>

<script>
function viewOrder(orderId) {
    document.getElementById('orderModal').style.display = 'flex';
    
    fetch('get_order_details.php?id=' + orderId)
        .then(response => response.json())
        .then(data => {
            let html = '<div class="order-info">';
            html += '<p><strong>Order ID:</strong> #' + data.order.id + '</p>';
            html += '<p><strong>Customer:</strong> ' + data.order.customer_name + '</p>';
            html += '<p><strong>Email:</strong> ' + data.order.customer_email + '</p>';
            html += '<p><strong>Phone:</strong> ' + data.order.customer_phone + '</p>';
            html += '<p><strong>Address:</strong> ' + data.order.customer_address + '</p>';
            html += '<p><strong>Status:</strong> ' + data.order.status + '</p>';
            html += '</div>';
            
            html += '<h3>Order Items</h3>';
            html += '<table class="admin-table">';
            html += '<thead><tr><th>Product</th><th>Quantity</th><th>Price</th><th>Total</th></tr></thead>';
            html += '<tbody>';
            
            data.items.forEach(item => {
                html += '<tr>';
                html += '<td>' + item.product_name + '</td>';
                html += '<td>' + item.quantity + '</td>';
                html += '<td>LKR ' + parseFloat(item.price).toFixed(2) + '</td>';
                html += '<td>LKR ' + (item.quantity * item.price).toFixed(2) + '</td>';
                html += '</tr>';
            });
            
            html += '</tbody></table>';
            html += '<div class="order-total"><strong>Total: LKR ' + parseFloat(data.order.total_amount).toFixed(2) + '</strong></div>';
            
            document.getElementById('orderDetails').innerHTML = html;
        });
}

function closeModal() {
    document.getElementById('orderModal').style.display = 'none';
}

window.onclick = function(event) {
    const modal = document.getElementById('orderModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>

<?php
mysqli_close($conn);
include 'includes/footer.php';
?>
