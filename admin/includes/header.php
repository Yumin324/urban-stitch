<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Admin Panel - Urban Stitch</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="admin-logo">
                <h2>Urban Stitch</h2>
                <p>Admin Panel</p>
            </div>
            <nav class="admin-nav">
                <ul>
                    <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Dashboard</a></li>
                    <li><a href="products.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'products.php' ? 'active' : ''; ?>">Products</a></li>
                    <li><a href="categories.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'categories.php' ? 'active' : ''; ?>">Categories</a></li>
                    <li><a href="orders.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'active' : ''; ?>">Orders</a></li>
                    <li><a href="../index.php" target="_blank">View Website</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </aside>
        <main class="admin-main">
            <div class="admin-header">
                <h1><?php echo $pageTitle ?? 'Dashboard'; ?></h1>
                <div class="admin-user">
                    Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>
                </div>
            </div>
            <div class="admin-content">
