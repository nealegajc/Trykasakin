<?php
session_start();
require_once '../../config/dbConnection.php';

// Check if user is logged in as passenger
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'passenger') {
    header("Location: ../../pages/auth/login.php");
    exit();
}

$database = new Database();
$conn = $database->getConnection();
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['name'];

// Get user's booking statistics
$stats_query = "SELECT 
    COUNT(*) as total_bookings,
    SUM(CASE WHEN LOWER(status) = 'pending' THEN 1 ELSE 0 END) as pending_bookings,
    SUM(CASE WHEN LOWER(status) = 'accepted' THEN 1 ELSE 0 END) as active_bookings,
    SUM(CASE WHEN LOWER(status) = 'completed' THEN 1 ELSE 0 END) as completed_bookings
FROM tricycle_bookings 
WHERE user_id = ?";

$stmt = $conn->prepare($stats_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TrycKaSaken - Passenger Dashboard</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../public/css/dashboard.css">
</head>
<body>

<nav class="navbar">
  <div class="container">
    <a class="navbar-brand" href="#">TrycKaSaken</a>
    <button class="navbar-toggler" onclick="toggleMenu()"><i class="bi bi-list"></i></button>
    <ul class="navbar-nav" id="navMenu">
      <li class="nav-item"><a class="nav-link" href="../passenger/loginUser.php"><i class="bi bi-house"></i> Dashboard</a></li>
      <li class="nav-item"><a href="../passenger/book.php" class="btn-request"><i class="bi bi-plus-circle"></i> Book Ride</a></li>
      <li class="nav-item"><a href="../passenger/trip_history.php" class="btn-request"><i class="bi bi-clock-history"></i> Trip History</a></li>
      <li class="nav-item"><a href="../../pages/auth/logout.php" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
  </div>
</nav>

<div class="page-content">
  <div class="welcome-section">
    <h2>Welcome Back, <?= htmlspecialchars($user_name); ?>!</h2>
    <p>Ready for your next ride? Book a tricycle and get to your destination safely and quickly.</p>
  </div>

  <!-- Booking Statistics -->
  <div class="stats-section">
    <div class="stat-card">
      <div class="stat-number"><?= $stats['total_bookings']; ?></div>
      <div class="stat-label">Total Bookings</div>
    </div>
    
    <div class="stat-card">
      <div class="stat-number"><?= $stats['pending_bookings']; ?></div>
      <div class="stat-label">Pending</div>
    </div>
    
    <div class="stat-card">
      <div class="stat-number"><?= $stats['active_bookings']; ?></div>
      <div class="stat-label">Active</div>
    </div>
    
    <div class="stat-card">
      <div class="stat-number"><?= $stats['completed_bookings']; ?></div>
      <div class="stat-label">Completed</div>
    </div>
  </div>

  <div class="services-grid">
    <div class="service-card">
      <div class="service-icon"><i class="bi bi-calendar-check"></i></div>
      <h3>Book a Ride</h3>
      <p>Find a tricycle near you and book your ride instantly</p>
      <a href="../passenger/book.php" class="service-btn">Book Now</a>
    </div>

    <div class="service-card">
      <div class="service-icon"><i class="bi bi-clock-history"></i></div>
      <h3>Trip History</h3>
      <p>View your complete booking history and status</p>
      <a href="../passenger/trip_history.php" class="service-btn">View History</a>
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