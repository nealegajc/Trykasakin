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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
    $destination = trim($_POST['destination']);

    if (empty($name) || empty($location) || empty($destination)) {
        $_SESSION['error_message'] = 'Please fill in all fields!';
        header("Location: book.php");
        exit;
    }

    // Insert booking with user_id
    $stmt = $conn->prepare("INSERT INTO tricycle_bookings (user_id, name, location, destination, status) VALUES (?, ?, ?, ?, 'Pending')");
    $stmt->bind_param("isss", $user_id, $name, $location, $destination);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Booking successful!';
        header("Location: book.php");
    } else {
        $_SESSION['error_message'] = 'Booking failed. Please try again.';
        header("Location: book.php");
    }

    $stmt->close();
    exit;
}

// Fetch ONLY the current user's bookings
$stmt = $conn->prepare("SELECT * FROM tricycle_bookings WHERE user_id = ? ORDER BY booking_time DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Get latest booking for status check
$latestBooking = !empty($bookings) ? $bookings[0] : null;

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Book a Tricycle | TrycKaSaken</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../../public/css/book.css">
</head>
<body>

<div class="container" style="max-width: 900px; margin: 0 auto; padding: 40px 20px;">
  <a href="../passenger/loginUser.php" class="back-link" style="display: inline-flex; align-items: center; gap: 8px; color: #37517e; text-decoration: none; font-weight: 600; margin-bottom: 24px;">
    <i class="bi bi-arrow-left"></i> Back to Dashboard
  </a>

  <div class="page-header">
    <h1>🛺 Book a Tricycle</h1>
    <p>Your reliable tricycle booking service</p>
  </div>

  <?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
      <i class="bi bi-check-circle-fill"></i> <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show">
      <i class="bi bi-exclamation-triangle-fill"></i> <?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <?php
  // Show form only if no active booking (pending or accepted)
  $hasActiveBooking = $latestBooking && (
      strtolower($latestBooking['status']) === 'pending' || 
      strtolower($latestBooking['status']) === 'accepted'
  );
  
  if (!$hasActiveBooking):
  ?>
    <section class="form-section">
      <h3><i class="bi bi-plus-circle"></i> Create New Booking</h3>
      <form method="post">
        <div class="mb-3">
          <label for="name" class="form-label">Full Name</label>
          <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($user_name); ?>" required>
        </div>
        <div class="mb-3">
          <label for="location" class="form-label">Pickup Location</label>
          <input type="text" class="form-control" name="location" placeholder="Where should we pick you up?" required>
        </div>
        <div class="mb-3">
          <label for="destination" class="form-label">Destination</label>
          <input type="text" class="form-control" name="destination" placeholder="Where are you going?" required>
        </div>
        <div class="text-center">
          <button type="submit" class="btn-book">
            <i class="bi bi-calendar-check"></i> Book Now
          </button>
        </div>
      </form>
    </section>
  <?php else: ?>
    <div class="alert alert-warning border-0 shadow-sm">
      <div class="d-flex align-items-center">
        <i class="bi bi-exclamation-triangle-fill" style="font-size: 24px; margin-right: 15px;"></i>
        <div>
          <strong>Active Booking in Progress</strong>
          <p class="mb-0">You already have an active booking. Please wait for it to be completed before creating a new one.</p>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <?php if ($latestBooking): ?>
  <section class="booking-status-section" style="margin-top: 30px;">
    <h4><i class="bi bi-card-text"></i> Current Booking Status</h4>
    <div class="card border-0 shadow-sm">
      <div class="card-body p-4">
        <div class="row align-items-center">
          <div class="col-md-8">
            <h5 class="mb-3">Booking #<?= htmlspecialchars($latestBooking['id']); ?></h5>
            <p class="mb-2"><i class="bi bi-geo-alt text-danger"></i> <strong>Pickup:</strong> <?= htmlspecialchars($latestBooking['location']); ?></p>
            <p class="mb-2"><i class="bi bi-geo-alt-fill text-success"></i> <strong>Destination:</strong> <?= htmlspecialchars($latestBooking['destination']); ?></p>
            <p class="mb-0 text-muted"><i class="bi bi-clock"></i> <?= date('M d, Y h:i A', strtotime($latestBooking['booking_time'])); ?></p>
          </div>
          <div class="col-md-4 text-center">
            <?php 
            $status = strtolower($latestBooking['status']);
            $badge_class = '';
            $icon = '';
            
            if ($status == 'pending') {
                $badge_class = 'bg-warning text-dark';
                $icon = '<i class="bi bi-clock-fill"></i>';
            } elseif ($status == 'accepted') {
                $badge_class = 'bg-info text-white';
                $icon = '<i class="bi bi-check-circle-fill"></i>';
            } elseif ($status == 'completed') {
                $badge_class = 'bg-success text-white';
                $icon = '<i class="bi bi-check-circle-fill"></i>';
            }
            ?>
            <span class="badge <?= $badge_class; ?>" style="font-size: 18px; padding: 12px 20px; border-radius: 50px;">
              <?= $icon; ?> <?= htmlspecialchars(ucfirst($latestBooking['status'])); ?>
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php $database->closeConnection(); ?>
