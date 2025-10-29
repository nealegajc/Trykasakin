<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TrycKaSaken - Passenger Dashboard</title>
  <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

<nav class="navbar">
  <div class="container">
    <a class="navbar-brand" href="#">TrycKaSaken</a>
    <button class="navbar-toggler" onclick="toggleMenu()">☰</button>
    <ul class="navbar-nav" id="navMenu">
      <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
      <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
      <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
      <li class="nav-item"><a href="book.php" class="btn-request">Book Now</a></li>
      <li class="nav-item"><a href="logout.php" class="btn btn-danger btn-sm">Logout</a></li>
    </ul>
  </div>
</nav>

<div class="page-content">
  <div class="welcome-section">
    <h2>Welcome Back, Passenger!</h2>
    <p>Ready for your next ride? Book a tricycle and get to your destination safely and quickly.</p>
  </div>

  <div class="services-grid">
    <div class="service-card">
      <div class="service-icon">🛺</div>
      <h3>Book a Ride</h3>
      <p>Find a tricycle near you and book your ride instantly</p>
      <a href="book.php" class="service-btn">Book Now</a>
    </div>

    <div class="service-card">
      <div class="service-icon">📍</div>
      <h3>Track Your Ride</h3>
      <p>Monitor your booking status in real-time</p>
      <a href="book.php" class="service-btn">View Status</a>
    </div>

    <div class="service-card">
      <div class="service-icon">⭐</div>
      <h3>Rate Drivers</h3>
      <p>Share your experience and help improve our service</p>
      <a href="#" class="service-btn">Coming Soon</a>
    </div>
  </div>

  <div class="stats-section">
    <div class="stat-card">
      <div class="stat-number">24/7</div>
      <div class="stat-label">Available</div>
    </div>
    <div class="stat-card">
      <div class="stat-number">99.9%</div>
      <div class="stat-label">Safety Record</div>
    </div>
    <div class="stat-card">
      <div class="stat-number">Fast</div>
      <div class="stat-label">Response Time</div>
    </div>
  </div>
</div>

<script>
function toggleMenu() {
  const menu = document.getElementById('navMenu');
  menu.classList.toggle('show');
}
</script>

</body>
</html>