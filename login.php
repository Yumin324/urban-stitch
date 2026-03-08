<?php
session_start();
require_once 'config/database.php';

if(isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];
    
    if(empty($email) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        
        if($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            if(password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_email'] = $user['email'];
                header('Location: index.php');
                exit;
            } else {
                $error = 'Invalid email or password';
            }
        } else {
            $error = 'Invalid email or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Urban Stitch</title>
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
                    <img src="https://images.pexels.com/photos/8148586/pexels-photo-8148586.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Traditional Wear">
                </div>
            </div>
            <div class="auth-right">
                <div class="auth-form-wrapper">
                    <h2>Welcome Back</h2>
                    <p class="auth-subtitle">Sign in to your account</p>
                    
                    <?php if($error): ?>
                        <div class="alert alert-error"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" action="login.php" class="auth-form">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block btn-auth">Sign In</button>
                    </form>
                    
                    <div class="auth-footer">
                        <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                        <p><a href="index.php">Back to Home</a></p>
                        <p><a href="admin/login.php" style="color: #7f8c8d; font-size: 0.9rem;">Admin Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
