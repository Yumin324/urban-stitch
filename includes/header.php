<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?>Urban Stitch - Sri Lankan Traditional Wear</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="promo-banner">
        <div class="container">
            <p>🎉 FREE SHIPPING on orders over Rs. 5,000 | Use code: <strong>TRADITION25</strong> for 25% off on your first order! 🎉</p>
        </div>
    </div>
    <header class="site-header">
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <h1>Urban Stitch</h1>
                    <p>Traditional Sri Lankan Elegance</p>
                </div>
                <ul class="nav-menu">
                    <li><a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="shop.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'shop.php' ? 'active' : ''; ?>">Shop</a></li>
                    <li><a href="about.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>">About</a></li>
                    <li><a href="contact.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>">Contact</a></li>
                    <li><a href="cart.php" class="cart-link <?php echo basename($_SERVER['PHP_SELF']) == 'cart.php' ? 'active' : ''; ?>">🛒 Cart <span class="cart-count">0</span></a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="user-dropdown">
                            <a href="#" class="user-link">👤 <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                            <ul class="dropdown-menu">
                                <li><a href="my-orders.php">My Orders</a></li>
                                <li><a href="profile.php">Profile</a></li>
                                <li><a href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="login.php" class="login-btn">Login</a></li>
                        <li><a href="signup.php" class="signup-btn">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
                <div class="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </nav>
        </div>
    </header>
