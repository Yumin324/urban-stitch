<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config/database.php';
$pageTitle = 'My Profile';

$message = '';
$message_type = '';

$user_id = $_SESSION['user_id'];
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($user_query);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
    $address = mysqli_real_escape_string($conn, trim($_POST['address']));
    
    $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email' AND id != $user_id");
    if(mysqli_num_rows($check_email) > 0) {
        $message = 'Email already in use by another account';
        $message_type = 'error';
    } else {
        $sql = "UPDATE users SET full_name='$full_name', email='$email', phone='$phone', address='$address' WHERE id=$user_id";
        if(mysqli_query($conn, $sql)) {
            $_SESSION['user_name'] = $full_name;
            $_SESSION['user_email'] = $email;
            $message = 'Profile updated successfully';
            $message_type = 'success';
            $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id"));
        } else {
            $message = 'Error updating profile';
            $message_type = 'error';
        }
    }
    
    if(!empty($_POST['new_password'])) {
        if($_POST['new_password'] === $_POST['confirm_password']) {
            $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE users SET password='$new_password' WHERE id=$user_id");
            $message = 'Profile and password updated successfully';
        } else {
            $message = 'Passwords do not match';
            $message_type = 'error';
        }
    }
}

include 'includes/header.php';
?>

<section class="page-header">
    <div class="container">
        <h1>My Profile</h1>
        <p>Manage your account information</p>
    </div>
</section>

<section class="profile-section">
    <div class="container">
        <?php if($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="profile-container">
            <div class="profile-sidebar">
                <div class="profile-avatar">
                    <div class="avatar-circle">
                        <?php echo strtoupper(substr($user['full_name'], 0, 1)); ?>
                    </div>
                    <h3><?php echo htmlspecialchars($user['full_name']); ?></h3>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
                <div class="profile-menu">
                    <a href="profile.php" class="active">Profile Settings</a>
                    <a href="my-orders.php">My Orders</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
            
            <div class="profile-content">
                <h2>Profile Information</h2>
                <form method="POST" action="profile.php" class="profile-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="full_name">Full Name *</label>
                            <input type="text" id="full_name" name="full_name" required 
                                   value="<?php echo htmlspecialchars($user['full_name']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required
                                   value="<?php echo htmlspecialchars($user['email']); ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone"
                                   value="<?php echo htmlspecialchars($user['phone']); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="created_at">Member Since</label>
                            <input type="text" value="<?php echo date('M d, Y', strtotime($user['created_at'])); ?>" disabled>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($user['address']); ?></textarea>
                    </div>
                    
                    <hr style="margin: 30px 0;">
                    
                    <h3>Change Password</h3>
                    <p style="color: #7f8c8d; margin-bottom: 20px;">Leave blank if you don't want to change password</p>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" id="new_password" name="new_password" minlength="6">
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" minlength="6">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
mysqli_close($conn);
include 'includes/footer.php';
?>
