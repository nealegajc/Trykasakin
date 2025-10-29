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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #37517e; color: #fff; padding-top: 80px; }
    .form-section, .booking-list {
      background: #fff; color: #000; border-radius: 10px;
      padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.2);
      max-width: 600px; margin: 30px auto;
    }
    .btn-book { background-color: #47b2e4; border: none; color: #fff; border-radius: 30px; padding: 10px 20px; }
    .btn-book:hover { background-color: #31a9db; }
    .Pending { color: orange; font-weight: bold; }
    .Accepted { color: green; font-weight: bold; }
    .Completed { color: gray; font-weight: bold; }
  </style>
</head>
<body>

<?php
if (!$booking || strtolower($booking['status']) === 'completed' || strtolower($booking['status']) === 'declined') :
?>
  <section class="form-section">
    <h3 class="text-center" style="color:#37517e;">Book a Tricycle</h3>
    <form method="post">
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" name="name" required>
      </div>
      <div class="mb-3">
        <label for="location" class="form-label">Pickup Location</label>
        <input type="text" class="form-control" name="location" required>
      </div>
      <div class="mb-3">
        <label for="destination" class="form-label">Destination</label>
        <input type="text" class="form-control" name="destination" required>
      </div>
      <div class="text-center">
        <button type="submit" class="btn-book">Book Now</button>
      </div>
    </form>
  </section>
<?php endif; ?>

<section class="booking-list">
  <h4 class="text-center" style="color:#37517e;">Latest Booking Status</h4>
  <table class="table table-bordered text-center">
    <thead>
      <tr><th>Name</th><th>Pickup</th><th>Destination</th><th>Status</th></tr>
    </thead>
    <tbody>
      <?php if ($booking): ?>
        <tr>
          <td><?= htmlspecialchars($booking['name']); ?></td>
          <td><?= htmlspecialchars($booking['location']); ?></td>
          <td><?= htmlspecialchars($booking['destination']); ?></td>
          <td class="<?= htmlspecialchars($booking['status']); ?>">
            <?= htmlspecialchars($booking['status']); ?>
          </td>
        </tr>
      <?php else: ?>
        <tr><td colspan="4">No bookings yet.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</section>

</body>
</html>

<?php $database->closeConnection(); ?>
