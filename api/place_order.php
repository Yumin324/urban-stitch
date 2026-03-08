<?php
session_start();
require_once '../config/database.php';

header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if(!$data || !isset($data['customer_name']) || !isset($data['items']) || empty($data['items'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid order data']);
    exit;
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$customer_name = mysqli_real_escape_string($conn, $data['customer_name']);
$customer_email = mysqli_real_escape_string($conn, $data['customer_email']);
$customer_phone = mysqli_real_escape_string($conn, $data['customer_phone']);
$customer_address = mysqli_real_escape_string($conn, $data['customer_address']);

$total_amount = 0;
foreach($data['items'] as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}
$total_amount += 500;

mysqli_begin_transaction($conn);

try {
    if($user_id) {
        $order_sql = "INSERT INTO orders (user_id, customer_name, customer_email, customer_phone, customer_address, total_amount, status) 
                      VALUES ($user_id, '$customer_name', '$customer_email', '$customer_phone', '$customer_address', $total_amount, 'Pending')";
    } else {
        $order_sql = "INSERT INTO orders (customer_name, customer_email, customer_phone, customer_address, total_amount, status) 
                      VALUES ('$customer_name', '$customer_email', '$customer_phone', '$customer_address', $total_amount, 'Pending')";
    }
    
    if(!mysqli_query($conn, $order_sql)) {
        throw new Exception('Failed to create order');
    }
    
    $order_id = mysqli_insert_id($conn);
    
    foreach($data['items'] as $item) {
        $product_id = intval($item['id']);
        $quantity = intval($item['quantity']);
        $price = floatval($item['price']);
        
        $item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                     VALUES ($order_id, $product_id, $quantity, $price)";
        
        if(!mysqli_query($conn, $item_sql)) {
            throw new Exception('Failed to add order item');
        }
        
        $update_stock = "UPDATE products SET stock = stock - $quantity WHERE id = $product_id";
        mysqli_query($conn, $update_stock);
    }
    
    mysqli_commit($conn);
    
    echo json_encode(['success' => true, 'order_id' => $order_id]);
    
} catch(Exception $e) {
    mysqli_rollback($conn);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

mysqli_close($conn);
?>
