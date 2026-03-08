<?php
require_once 'auth.php';
require_once '../config/database.php';

header('Content-Type: application/json');

$order_id = intval($_GET['id']);

$order_query = "SELECT * FROM orders WHERE id = $order_id";
$order_result = mysqli_query($conn, $order_query);
$order = mysqli_fetch_assoc($order_result);

$items_query = "SELECT oi.*, p.name as product_name FROM order_items oi 
                LEFT JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = $order_id";
$items_result = mysqli_query($conn, $items_query);

$items = [];
while($item = mysqli_fetch_assoc($items_result)) {
    $items[] = $item;
}

echo json_encode([
    'order' => $order,
    'items' => $items
]);

mysqli_close($conn);
?>
