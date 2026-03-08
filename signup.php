<?php
session_start();
require_once 'config/database.php';

$error = '';
$success = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $address = mysqli_real_escape_string($conn, trim($_POST['address']));
    
    if(empty($full_name) || empty($email) || empty($password)) {
        $error = 'Please fill in all required fields';
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } elseif(strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } elseif($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } else {
        $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
        if(mysqli_num_rows($check_email) > 0) {
            $error = 'Email already registered';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (full_name, email, password, phone, address) 
                    VALUES ('$full_name', '$email', '$hashed_password', '$phone', '$address')";
            
            if(mysqli_query($conn, $sql)) {
                $success = 'Registration successful! You can now login.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Urban Stitch</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="auth-page">
        <div class="auth-container">
            <div class="auth-left">
                <div class="auth-brand">
                    <h1>Urban Stitch</h1>
                    <p>Traditional Sri Lankan Elegance</p>
                </div>
                <div class="auth-image">
                    <img src="https://images.pexels.com/photos/4041279/pexels-photo-4041279.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Traditional Wear">
                </div>
            </div>
            <div class="auth-right">
                <div class="auth-form-wrapper">
                    <h2>Create Account</h2>
                    <p class="auth-subtitle">Join us to explore authentic Sri Lankan wear</p>
                    
                    <?php if($error): ?>
                        <div class="alert alert-error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <?php if($success): ?>
                        <div class="alert alert-success">
                            <?php echo $success; ?>
                            <a href="login.php" class="alert-link">Click here to login</a>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="signup.php" class="auth-form">
                        <div class="form-group">
                            <label for="full_name">Full Name *</label>
                            <input type="text" id="full_name" name="full_name" required 
                                   value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone"
                                   value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password *</label>
                            <input type="password" id="password" name="password" required minlength="6">
                            <small>Minimum 6 characters</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password *</label>
                            <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" rows="2"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block btn-auth">Create Account</button>
                    </form>
                    
                    <div class="auth-footer">
                        <p>Already have an account? <a href="login.php">Sign In</a></p>
                        <p><a href="index.php">Back to Home</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
