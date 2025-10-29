<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TrycKaSaken - Driver Dashboard</title>
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
      <li class="nav-item"><a href="request.php" class="btn-request">View Requests</a></li>
      <li class="nav-item"><a href="logout.php" class="btn btn-danger btn-sm">Logout</a></li>
    </ul>
  </div>
</nav>

<div class="page-content">
  <div class="welcome-section">
    <h2>Welcome Back, Driver!</h2>
    <p>Start accepting ride requests and earn more today. Your passengers are waiting!</p>
  </div>

  <div class="services-grid">
    <div class="service-card">
      <div class="service-icon">📋</div>
      <h3>View Requests</h3>
      <p>Check available booking requests from passengers</p>
      <a href="request.php" class="service-btn">View Requests</a>
    </div>

    <div class="service-card">
      <div class="service-icon">✅</div>
      <h3>Accept Rides</h3>
      <p>Accept booking requests and start earning</p>
      <a href="request.php" class="service-btn">Go Online</a>
    </div>

    <div class="service-card">
      <div class="service-icon">💰</div>
      <h3>Track Earnings</h3>
      <p>Monitor your daily and monthly earnings</p>
      <a href="#" class="service-btn">Coming Soon</a>
    </div>
  </div>

  <div class="stats-section">
    <div class="stat-card">
      <div class="stat-number">Safe</div>
      <div class="stat-label">Driving Priority</div>
    </div>
    <div class="stat-card">
      <div class="stat-number">24/7</div>
      <div class="stat-label">Earn Anytime</div>
    </div>
    <div class="stat-card">
      <div class="stat-number">Fast</div>
      <div class="stat-label">Payments</div>
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