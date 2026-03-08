<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Instructions - Urban Stitch</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #8B4513;
            margin-bottom: 10px;
            font-size: 2.5rem;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }
        .step {
            background: #f8f9fa;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 10px;
            border-left: 5px solid #8B4513;
        }
        .step h2 {
            color: #8B4513;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .step-number {
            background: #8B4513;
            color: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-weight: bold;
        }
        .code-block {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            margin: 15px 0;
            overflow-x: auto;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 5px solid #28a745;
        }
        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 5px solid #ffc107;
        }
        .links {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }
        .link-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            text-decoration: none;
            text-align: center;
            transition: transform 0.3s;
        }
        .link-card:hover {
            transform: translateY(-5px);
        }
        .link-card h3 {
            margin-bottom: 10px;
        }
        ul {
            margin-left: 20px;
            margin-top: 10px;
        }
        li {
            margin-bottom: 8px;
            line-height: 1.6;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .feature-box {
            background: white;
            border: 2px solid #8B4513;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        .feature-box strong {
            color: #8B4513;
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛍️ Urban Stitch Setup</h1>
        <p class="subtitle">Sri Lankan Traditional Wear E-Commerce Platform</p>
        
        <div class="success">
            ✅ All files have been successfully created! Follow the steps below to set up your website.
        </div>

        <div class="step">
            <h2><span class="step-number">1</span> Start XAMPP Services</h2>
            <ul>
                <li>Open XAMPP Control Panel</li>
                <li>Click "Start" for <strong>Apache</strong></li>
                <li>Click "Start" for <strong>MySQL</strong></li>
                <li>Wait for both services to turn green</li>
            </ul>
        </div>

        <div class="step">
            <h2><span class="step-number">2</span> Create Database</h2>
            <ul>
                <li>Open your browser and go to: <code class="code-block">http://localhost/phpmyadmin</code></li>
                <li>Click on "New" in the left sidebar</li>
                <li>Enter database name: <strong>urbanstitch_store</strong></li>
                <li>Click "Create"</li>
                <li>Select the newly created database</li>
                <li>Click on "Import" tab</li>
                <li>Choose file: <code>database.sql</code> from your project folder</li>
                <li>Click "Go" at the bottom</li>
            </ul>
            <div class="warning">
                ⚠️ Make sure the database name is exactly <strong>urbanstitch_store</strong>
            </div>
        </div>

        <div class="step">
            <h2><span class="step-number">3</span> Verify Database Connection</h2>
            <p>The database configuration is already set up in <code>config/database.php</code> with default XAMPP settings:</p>
            <div class="code-block">
Host: localhost<br>
Username: root<br>
Password: (empty)<br>
Database: urbanstitch_store
            </div>
            <p style="margin-top: 15px;">If your XAMPP uses different credentials, update them in <code>config/database.php</code></p>
        </div>

        <div class="step">
            <h2><span class="step-number">4</span> Access Your Website</h2>
            <p>Your website is now ready! Access it through these URLs:</p>
            <div class="links">
                <a href="index.php" class="link-card" target="_blank">
                    <h3>🏠 Main Website</h3>
                    <p>Customer Shopping Site</p>
                </a>
                <a href="login.php" class="link-card" target="_blank">
                    <h3>👤 User Login</h3>
                    <p>Customer Sign In</p>
                </a>
                <a href="signup.php" class="link-card" target="_blank">
                    <h3>✍️ User SignUp</h3>
                    <p>Create Account</p>
                </a>
                <a href="admin/login.php" class="link-card" target="_blank">
                    <h3>⚙️ Admin Panel</h3>
                    <p>Product Management</p>
                </a>
            </div>
        </div>

        <div class="step">
            <h2><span class="step-number">5</span> Admin Login Credentials</h2>
            <div class="code-block">
Username: admin<br>
Password: admin123
            </div>
            <div class="warning">
                ⚠️ Change the default password after first login for security!
            </div>
        </div>

        <div class="step">
            <h2>✨ Features Included</h2>
            <div class="features">
                <div class="feature-box">
                    <strong>📄 5 Main Pages</strong>
                    <p>Home, Shop, About, Contact, Cart</p>
                </div>
                <div class="feature-box">
                    <strong>� User Authentication</strong>
                    <p>SignUp/Login system</p>
                </div>
                <div class="feature-box">
                    <strong>📊 User Dashboard</strong>
                    <p>Profile & Order History</p>
                </div>
                <div class="feature-box">
                    <strong>�🛒 Shopping Cart</strong>
                    <p>localStorage based cart</p>
                </div>
                <div class="feature-box">
                    <strong>🔍 Search & Filter</strong>
                    <p>Category filtering & search</p>
                </div>
                <div class="feature-box">
                    <strong>⚙️ Admin CRUD</strong>
                    <p>Full product management</p>
                </div>
                <div class="feature-box">
                    <strong>💾 MySQL Database</strong>
                    <p>Complete DML operations</p>
                </div>
                <div class="feature-box">
                    <strong>📱 Responsive Design</strong>
                    <p>Mobile-friendly layout</p>
                </div>
            </div>
        </div>
    <li><strong>User System:</strong> Registration and login for customers</li>
            
        <div class="step">
            <h2>📦 Sample Data</h2>
            <p>The database includes:</p>
            <ul>
                <li><strong>5 Categories:</strong> Kandyan Sarees, Batik Wear, Casual Wear, Traditional Wear, Accessories</li>
                <li><strong>12 Products:</strong> Pre-loaded with Unsplash images and Sri Lankan themed items</li>
                <li><strong>1 Admin User:</strong> Ready to login and manage the store</li>
            </ul>
        </div>

        <div class="success">
            <strong>🎉 Setup Complete!</strong><br>
            Your Urban Stitch e-commerce website is ready to use. Start by browsing the shop or logging into the admin panel to manage products.
        </div>

        <div class="warning">
            <strong>📝 Important Notes:</strong>
            <ul>
                <li>Keep XAMPP Apache and MySQL running while using the website</li>
                <li>All images use Unsplash URLs (requires internet connection)</li>
                <li>Users can register at: <code>signup.php</code></li>
                <li>Admin panel is accessible at: <code>admin/login.php</code></li>
                <li>User and Admin authentication are separate systems
                <li>Admin panel is accessible at: <code>admin/login.php</code></li>
            </ul>
        </div>
    </div>
</body>
</html>
