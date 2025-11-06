<?php
session_start();
require_once '../../config/dbConnection.php';

// Check if user is logged in as driver
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'driver') {
    header("Location: ../../pages/auth/login.php");
    exit();
}

$database = new Database();
$conn = $database->getConnection();
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['name'];

// Get driver's trip statistics
$stats_query = "SELECT 
    COUNT(*) as total_trips,
    SUM(CASE WHEN LOWER(status) = 'accepted' THEN 1 ELSE 0 END) as active_trips,
    SUM(CASE WHEN LOWER(status) = 'completed' THEN 1 ELSE 0 END) as completed_trips
FROM tricycle_bookings 
WHERE driver_id = ?";

$stmt = $conn->prepare($stats_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Check if driver has an active trip
$active_trip_query = "SELECT COUNT(*) as has_active FROM tricycle_bookings WHERE driver_id = ? AND LOWER(status) = 'accepted'";
$stmt = $conn->prepare($active_trip_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$active_result = $stmt->get_result()->fetch_assoc();
$has_active_trip = $active_result['has_active'] > 0;
$stmt->close();

$conn->close();
?>
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
  <link rel="stylesheet" href="../../public/css/dashboard.css">
</head>
<body>

<nav class="navbar">
  <div class="container">
    <a class="navbar-brand" href="#">TrycKaSaken</a>
    <button class="navbar-toggler" onclick="toggleMenu()"><i class="bi bi-list"></i></button>
    <ul class="navbar-nav" id="navMenu">
      <li class="nav-item"><a class="nav-link" href="../driver/loginDriver.php"><i class="bi bi-house"></i> Dashboard</a></li>
      <li class="nav-item"><a href="../driver/request.php" class="btn-request"><i class="bi bi-card-list"></i> View Requests</a></li>
      <li class="nav-item"><a href="request.php?history=true" class="btn-request"><i class="bi bi-clock-history"></i> Trip History</a></li>
      <li class="nav-item"><a href="../../pages/auth/logout.php" class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
    </ul>
  </div>
</nav>

<div class="page-content">
  <div class="welcome-section">
    <h2>Welcome Back, <?= htmlspecialchars($user_name); ?>!</h2>
    <p>Start accepting ride requests and earn more today. Your passengers are waiting!</p>
    <?php if ($has_active_trip): ?>
      <div class="alert alert-info" style="margin-top: 15px;">
        <i class="bi bi-info-circle-fill"></i> You have an active trip. Please complete it before accepting new requests.
      </div>
    <?php endif; ?>
  </div>

  <!-- Trip Statistics -->
  <div class="stats-section">
    <div class="stat-card">
      <div class="stat-number"><?= $stats['total_trips']; ?></div>
      <div class="stat-label">Total Trips</div>
    </div>
    
    <div class="stat-card">
      <div class="stat-number"><?= $stats['active_trips']; ?></div>
      <div class="stat-label">Active</div>
    </div>
    
    <div class="stat-card">
      <div class="stat-number"><?= $stats['completed_trips']; ?></div>
      <div class="stat-label">Completed</div>
    </div>
  </div>

  <div class="services-grid">
    <div class="service-card">
      <div class="service-icon"><i class="bi bi-card-list"></i></div>
      <h3>View Requests</h3>
      <p>Check available booking requests from passengers</p>
      <a href="../driver/request.php" class="service-btn">View Requests</a>
    </div>

    <div class="service-card">
      <div class="service-icon"><i class="bi bi-clock-history"></i></div>
      <h3>Trip History</h3>
      <p>View your completed and past trips</p>
      <a href="request.php?history=true" class="service-btn">View History</a>
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