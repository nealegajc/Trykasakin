<?php
session_start();
require_once 'config/dbConnection.php';

$database = new Database();
$conn = $database->getConnection();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'driver') {
    header("Location: login.php");
    exit();
}

$driver_id = $_SESSION['user_id'];

if (isset($_POST['accept_ride'])) {
    $id = intval($_POST['booking_id']);

    // Accept only if pending
    $update_sql = "UPDATE tricycle_bookings 
                   SET driver_id = ?, status = 'accepted' 
                   WHERE id = ? AND (status = 'pending' OR status = 'Pending')";
    $stmt = $conn->prepare($update_sql);

    if (!$stmt) die("SQL Error: " . $conn->error);

    $stmt->bind_param("ii", $driver_id, $id);
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $_SESSION['success_message'] = "Ride accepted successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to accept ride or ride already taken.";
    }

    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['complete_ride'])) {
    $id = intval($_POST['booking_id']);

    $complete_sql = "UPDATE tricycle_bookings 
                     SET status = 'completed' 
                     WHERE id = ? AND driver_id = ? AND (status = 'accepted' OR status = 'Accepted')";
    $stmt = $conn->prepare($complete_sql);

    if (!$stmt) die("SQL Error: " . $conn->error);

    $stmt->bind_param("ii", $id, $driver_id);
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $_SESSION['success_message'] = "Ride completed successfully!";
    } else {
        $_SESSION['error_message'] = "Failed to complete ride.";
    }

    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$sql = "SELECT * FROM tricycle_bookings 
        WHERE (LOWER(TRIM(status)) = 'pending') 
           OR (LOWER(TRIM(status)) = 'accepted' AND driver_id = ?)
        ORDER BY booking_time DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Driver Requests | TrycKaSaken</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/request.css">
</head>
<body>

<div class="container">
  <a href="loginDriver.php" class="back-link"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
  
  <div class="page-header">
    <h2><i class="bi bi-card-checklist"></i> Driver Ride Requests</h2>
    <p>Accept and manage your ride bookings</p>
  </div>

  <?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
      <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
      <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">×</button>
    </div>
  <?php endif; ?>

  <?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger">
      <?= $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
      <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">×</button>
    </div>
  <?php endif; ?>

  <?php if ($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
      <?php $status = strtolower(trim($row['status'])); ?>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($row['name']); ?></h5>
          <p class="card-text"><strong>Pickup:</strong> <?= htmlspecialchars($row['location']); ?></p>
          <p class="card-text"><strong>Destination:</strong> <?= htmlspecialchars($row['destination']); ?></p>
          <p class="text-muted">Booked: <?= htmlspecialchars($row['booking_time']); ?></p>
          <p class="card-text"><strong>Status:</strong> 
             <span class="badge 
               <?= ($status == 'pending') ? 'bg-secondary' : (($status == 'accepted') ? 'bg-info' : 'bg-success'); ?>">
               <?= ucfirst($status); ?>
             </span>
          </p>

          <div class="action-buttons">
            <?php if ($status == 'pending'): ?>
              <form method="POST" action="">
                <input type="hidden" name="booking_id" value="<?= $row['id']; ?>">
                <button type="submit" name="accept_ride" class="btn-accept" onclick="return confirm('Accept this ride?')">
                  Accept Ride
                </button>
              </form>
            <?php elseif ($status == 'accepted' && $row['driver_id'] == $driver_id): ?>
              <button type="button" class="btn-accepted" disabled>Accepted</button>
              <form method="POST" action="">
                <input type="hidden" name="booking_id" value="<?= $row['id']; ?>">
                <button type="submit" name="complete_ride" class="btn-complete" onclick="return confirm('Mark this ride as completed?')">
                  Complete Ride
                </button>
              </form>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="empty-state">
      <div class="empty-state-icon">📭</div>
      <div class="empty-state-text">
        No ride requests available at the moment.<br>
        Check back soon for new booking opportunities!
      </div>
    </div>
  <?php endif; ?>

</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
