<?php
/**
 * Auto-setup database if not exists
 * Silent setup - creates database in background without showing setup page
 */
require_once __DIR__ . '/database/schema.php';

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'tric_db';

try {
    $conn = new mysqli($db_host, $db_user, $db_pass);
    
    if ($conn->connect_error) {
        die("⚠️ MySQL Connection Failed. Please start XAMPP/LAMPP.");
    }
    
    // Check if database exists
    $db_check = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'");
    
    if ($db_check->num_rows == 0) {
        // Database doesn't exist - create it silently
        $conn->query("CREATE DATABASE $db_name CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
        $conn->select_db($db_name);
        DatabaseSchema::createSchema($conn, true);
    } else {
        // Database exists, verify schema
        $conn->select_db($db_name);
        
        if (!DatabaseSchema::schemaExists($conn)) {
            // Tables don't exist - create them silently
            DatabaseSchema::createSchema($conn, true);
        }
    }
    
    $conn->close();
} catch (Exception $e) {
    die("⚠️ Database setup failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TrycKaSaken - Your Trusted Tricycle Booking Platform</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="public/css/index.css">
</head>
<body>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-icon">🛺</div>
        <h1>TrycKaSaken</h1>
        <p>Your trusted platform for tricycle rides. Book a ride or become a driver today!</p>
        
        <div class="cta-buttons">
            <a href="pages/auth/login.php" class="btn btn-primary">
                <i class="bi bi-rocket-takeoff"></i> Login
            </a>
            <a href="pages/auth/register.php" class="btn btn-secondary">
                <i class="bi bi-pencil-square"></i> Create Account
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="features-container">
        <h2 class="section-title">Why Choose TrycKaSaken?</h2>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Fast & Reliable</h3>
                <p>Get matched with drivers instantly and reach your destination quickly.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">🛡️</div>
                <h3>Safe & Secure</h3>
                <p>All drivers are verified with proper documentation for your safety.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">💰</div>
                <h3>Affordable Rates</h3>
                <p>Enjoy competitive pricing with transparent fare calculations.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Easy to Use</h3>
                <p>Simple booking process with real-time ride tracking and updates.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3>For Everyone</h3>
                <p>Whether you're a passenger or driver, we've got you covered.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="features">
    <div class="features-container" style="text-align: center;">
        <h2 class="section-title">Ready to Get Started?</h2>
        <p style="font-size: 18px; color: #6B6B6B; margin-bottom: 40px; max-width: 600px; margin-left: auto; margin-right: auto;">
            Join TrycKaSaken for their daily commute. 
            Sign up now and experience the difference!
        </p>
        
        <div class="cta-buttons">
            <a href="register.php?type=passenger" class="btn btn-primary">
                👤 Book as Passenger
            </a>
            <a href="register.php?type=driver" class="btn btn-secondary">
                🚗 Drive with Us
            </a>
        </div>
    </div>
</section>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
