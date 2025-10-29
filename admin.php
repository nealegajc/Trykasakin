<?php
session_start();
require_once 'config/dbConnection.php';

$db = new Database();
$conn = $db->getConnection();

$passengersQuery = "SELECT * FROM users WHERE user_type = 'passenger' ORDER BY user_id DESC";
$passengersResult = $conn->query($passengersQuery);
$passengers = $passengersResult->fetch_all(MYSQLI_ASSOC);

$driversQuery = "SELECT * FROM users WHERE user_type = 'driver' ORDER BY user_id DESC";
$driversResult = $conn->query($driversQuery);
$drivers = $driversResult->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard | TrycKaSaken</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<nav class="navbar">
  <div class="container">
    <a class="navbar-brand" href="#">Admin Panel</a>
    <div class="d-flex">
      <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="admin-container">
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-header">
        <div>
          <div class="stat-number"><?= count($passengers) ?></div>
          <div class="stat-label">Total Passengers</div>
        </div>
        <div class="stat-icon">👥</div>
      </div>
    </div>
    
    <div class="stat-card">
      <div class="stat-header">
        <div>
          <div class="stat-number"><?= count($drivers) ?></div>
          <div class="stat-label">Total Drivers</div>
        </div>
        <div class="stat-icon">🚗</div>
      </div>
    </div>
    
    <div class="stat-card">
      <div class="stat-header">
        <div>
          <div class="stat-number"><?= count($passengers) + count($drivers) ?></div>
          <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-icon">📊</div>
      </div>
    </div>
    
    <div class="stat-card">
      <div class="stat-header">
        <div>
          <div class="stat-number">Active</div>
          <div class="stat-label">System Status</div>
        </div>
        <div class="stat-icon">✅</div>
      </div>
    </div>
  </div>


  <div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">👥 Passengers (<?= count($passengers) ?>)</h5>
    </div>
    <div class="card-body">
      <?php if (count($passengers) > 0): ?>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Registered Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($passengers as $passenger): ?>
                <tr>
                  <td><?= htmlspecialchars($passenger['user_id']) ?></td>
                  <td><?= htmlspecialchars($passenger['name']) ?></td>
                  <td><?= htmlspecialchars($passenger['email']) ?></td>
                  <td><?= htmlspecialchars($passenger['phone']) ?></td>
                  <td>
                    <span class="badge bg-<?= $passenger['status'] == 'active' ? 'success' : ($passenger['status'] == 'inactive' ? 'secondary' : 'warning') ?>">
                      <?= htmlspecialchars($passenger['status']) ?>
                    </span>
                  </td>
                  <td><?= htmlspecialchars($passenger['created_at']) ?></td>
                  <td>
                    <a href="view_user.php?id=<?= $passenger['user_id'] ?>" class="btn btn-sm btn-info">View</a>
                    <a href="edit_user.php?id=<?= $passenger['user_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete_user.php?id=<?= $passenger['user_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p class="text-muted">No passengers registered yet.</p>
      <?php endif; ?>
    </div>
  </div>

  <div class="card shadow-sm mb-4">
    <div class="card-header bg-success text-white">
      <h5 class="mb-0">🚗 Drivers (<?= count($drivers) ?>)</h5>
    </div>
    <div class="card-body">
      <?php if (count($drivers) > 0): ?>
        <div class="table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Registered Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($drivers as $driver): ?>
                <tr>
                  <td><?= htmlspecialchars($driver['user_id']) ?></td>
                  <td><?= htmlspecialchars($driver['name']) ?></td>
                  <td><?= htmlspecialchars($driver['email']) ?></td>
                  <td><?= htmlspecialchars($driver['phone']) ?></td>
                  <td>
                    <span class="badge bg-<?= $driver['status'] == 'active' ? 'success' : ($driver['status'] == 'inactive' ? 'secondary' : 'warning') ?>">
                      <?= htmlspecialchars($driver['status']) ?>
                    </span>
                  </td>
                  <td><?= htmlspecialchars($driver['created_at']) ?></td>
                  <td>
                    <a href="view_user.php?id=<?= $driver['user_id'] ?>" class="btn btn-sm btn-info">View</a>
                    <a href="edit_user.php?id=<?= $driver['user_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete_user.php?id=<?= $driver['user_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p class="text-muted">No drivers registered yet.</p>
      <?php endif; ?>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <h5 class="card-title">📋 Manage Users</h5>
          <p class="card-text">View, edit, or remove registered users.</p>
          <a href="#" class="btn btn-primary">Go</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <h5 class="card-title">⚙️ Site Settings</h5>
          <p class="card-text">Configure website settings and preferences.</p>
          <a href="#" class="btn btn-primary">Go</a>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <h5 class="card-title">📊 Analytics</h5>
          <p class="card-text">View system analytics and reports.</p>
          <a href="#" class="btn btn-primary">Go</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$db->closeConnection();
?>