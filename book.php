<?php
session_start();
require_once 'config/dbConnection.php';

$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = trim($_POST['name']);
  $location = trim($_POST['location']);
  $destination = trim($_POST['destination']);

  if (empty($name) || empty($location) || empty($destination)) {
    echo "<script>alert('Please fill in all fields!'); window.history.back();</script>";
    exit;
  }

  $stmt = $conn->prepare("INSERT INTO tricycle_bookings (name, location, destination, status) VALUES (?, ?, ?, 'Pending')");
  $stmt->bind_param("sss", $name, $location, $destination);

  if ($stmt->execute()) {
    echo "<script>alert('Booking successful!'); window.location.href='book.php';</script>";
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
  exit;
}

$latestBooking = $conn->query("SELECT * FROM tricycle_bookings ORDER BY booking_time DESC LIMIT 1");
$booking = $latestBooking->fetch_assoc();

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Book a Tricycle | TrycKaSaken</title>
  <link rel="stylesheet" href="assets/css/book.css">
</head>
<body>

<div class="page-header">
  <h1>🛺 TrycKaSaken</h1>
  <p>Your reliable tricycle booking service</p>
</div>

<?php
if (!$booking || strtolower($booking['status']) === 'completed' || strtolower($booking['status']) === 'declined') :
?>
  <section class="form-section">
    <h3>Book a Tricycle</h3>
    <form method="post">
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" name="name" placeholder="Enter your full name" required>
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
        <button type="submit" class="btn-book">Book Now</button>
      </div>
    </form>
  </section>
<?php endif; ?>

<section class="booking-list">
  <h4>Latest Booking Status</h4>
  <?php if ($booking): ?>
    <table class="table table-bordered">
      <thead>
        <tr><th>Name</th><th>Pickup</th><th>Destination</th><th>Status</th></tr>
      </thead>
      <tbody>
        <tr>
          <td><?= htmlspecialchars($booking['name']); ?></td>
          <td><?= htmlspecialchars($booking['location']); ?></td>
          <td><?= htmlspecialchars($booking['destination']); ?></td>
          <td>
            <span class="<?= htmlspecialchars($booking['status']); ?>">
              <?= htmlspecialchars($booking['status']); ?>
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  <?php else: ?>
    <div class="empty-state">
      <div class="empty-state-icon">📭</div>
      <div class="empty-state-text">No bookings yet. Start your journey now!</div>
    </div>
  <?php endif; ?>
</section>

</body>
</html>

<?php $database->closeConnection(); ?>
