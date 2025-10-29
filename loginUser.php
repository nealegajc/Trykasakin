<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TrycKaSaken</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #37517e;
    }
    .navbar {
      background-color: #37517e !important;
    }
    .navbar-brand {
      color: #fff;
      font-weight: 600;
      letter-spacing: 1px;
    }
    .navbar-nav .nav-link {
      color: #fff;
      margin-right: 15px;
    }
    .navbar-nav .nav-link:hover {
      color: #47b2e4;
    }
    .btn-get-started,
    .btn-request {
      border-radius: 50px;
      padding: 8px 20px;
      font-weight: 500;
      text-decoration: none;
      color: #fff;
    }
    .btn-get-started {
      background-color: #47b2e4;
    }
    .btn-get-started:hover {
      background-color: #31a9db;
    }
    .btn-request {
      background-color: #1acc8d;
      margin-left: 10px;
    }
    .btn-request:hover {
      background-color: #17a97a;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">TrycKaSaken</a>
    <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <?php
          $pages = [
            "Home" => "#home",
            "About" => "#about",
            "Services" => "#services",
            "Team" => "#team",
            "Contact" => "#contact"
          ];

          foreach ($pages as $name => $link) {
            echo "<li class='nav-item'><a class='nav-link' href='$link'>$name</a></li>";
          }
        ?>
        <li class="nav-item">
          <a href="book.php" class="btn-request">Book</a>
        </li>
        <li class="nav-item">
          <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>