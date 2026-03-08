<?php
require_once 'config/database.php';
$pageTitle = 'Contact Us';
include 'includes/header.php';

$message = '';
$message_type = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);
    
    if(!empty($name) && !empty($email) && !empty($msg)) {
        $message = 'Thank you for contacting us! We will get back to you soon.';
        $message_type = 'success';
    } else {
        $message = 'Please fill in all required fields.';
        $message_type = 'error';
    }
}
?>

<section class="page-header">
    <div class="container">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you</p>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <?php if($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="contact-content">
            <div class="contact-form-wrapper">
                <h2>Send Us a Message</h2>
                <form method="POST" action="contact.php" class="contact-form">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject">
                    </div>
                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" rows="6" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>

            <div class="contact-info-wrapper">
                <h2>Contact Information</h2>
                <div class="contact-info">
                    <div class="info-item">
                        <h3>Address</h3>
                        <p>123 Galle Road<br>Colombo 03<br>Sri Lanka</p>
                    </div>
                    <div class="info-item">
                        <h3>Phone</h3>
                        <p>+94 11 234 5678<br>+94 77 123 4567</p>
                    </div>
                    <div class="info-item">
                        <h3>Email</h3>
                        <p>info@urbanstitch.lk<br>support@urbanstitch.lk</p>
                    </div>
                    <div class="info-item">
                        <h3>Business Hours</h3>
                        <p>Monday - Saturday: 9:00 AM - 7:00 PM<br>Sunday: 10:00 AM - 5:00 PM</p>
                    </div>
                </div>

                <div class="map-placeholder">
                    <img src="https://images.pexels.com/photos/1252890/pexels-photo-1252890.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Location Map">
                </div>
            </div>
        </div>
    </div>
</section>

<?php
mysqli_close($conn);
include 'includes/footer.php';
?>
