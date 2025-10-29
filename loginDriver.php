<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TrycKaSaken - Driver Dashboard</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>

<nav class="navbar">
  <div class="container">
    <a class="navbar-brand" href="#"><i class="bi bi-bicycle"></i> TrycKaSaken</a>
    <button class="navbar-toggler" onclick="toggleMenu()"><i class="bi bi-list"></i></button>
    <ul class="navbar-nav" id="navMenu">
      <li class="nav-item"><a class="nav-link" href="#home"><i class="bi bi-house"></i> Home</a></li>
      <li class="nav-item"><a class="nav-link" href="#about"><i class="bi bi-info-circle"></i> About</a></li>
      <li class="nav-item"><a class="nav-link" href="#services"><i class="bi bi-gear"></i> Services</a></li>
      <li class="nav-item"><a class="nav-link" href="#contact"><i class="bi bi-envelope"></i> Contact</a></li>
      <li class="nav-item"><a href="request.php" class="btn-request"><i class="bi bi-card-list"></i> View Requests</a></li>
      <li class="nav-item"><a href="logout.php" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
  </div>
</nav>

<div class="page-content">
  <div class="welcome-section">
    <h2><i class="bi bi-hand-wave"></i> Welcome Back, Driver!</h2>
    <p>Start accepting ride requests and earn more today. Your passengers are waiting!</p>
  </div>

  <div class="services-grid">
    <div class="service-card">
      <div class="service-icon">📋</div>
      <h3>View Requests</h3>
      <p>Check available booking requests from passengers</p>
      <a href="request.php" class="service-btn"><i class="bi bi-card-list"></i> View Requests</a>
    </div>

    <div class="service-card">
      <div class="service-icon">✅</div>
      <h3>Accept Rides</h3>
      <p>Accept booking requests and start earning</p>
      <a href="request.php" class="service-btn"><i class="bi bi-check-circle"></i> Go Online</a>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleMenu() {
  const menu = document.getElementById('navMenu');
  menu.classList.toggle('show');
}
</script>

</body>
</html>