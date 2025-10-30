<?php
// Get count of available drivers
require_once 'includes/get_available_drivers.php';
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
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-icon">🛺</div>
        <h1>TrycKaSaken</h1>
        <p>Your trusted platform for fast, safe, and convenient tricycle rides. Book a ride or become a driver today!</p>
        
        <!-- Available Drivers Badge -->
        <div class="drivers-badge">
            <div class="badge-content">
                <div class="badge-number"><?php echo $available_drivers; ?></div>
                <div class="badge-text">Available Drivers Ready to Serve</div>
            </div>
        </div>
        
        <div class="cta-buttons">
            <a href="login.php" class="btn btn-primary">
                <i class="bi bi-rocket-takeoff"></i> Get Started
            </a>
            <a href="register.php" class="btn btn-secondary">
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
