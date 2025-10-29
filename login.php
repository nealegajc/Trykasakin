<?php
session_start();
require_once 'config/dbConnection.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $conn = $database->getConnection();
    
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    $sql = "SELECT user_id, user_type, name, email, password, status FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
       
        if (password_verify($password, $user['password'])) {
          
            if ($user['status'] != 'active') {
                $error = "Your account has been suspended or deactivated.";
            } else {
                
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['user_type'] = $user['user_type']; 
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                
                if ($user['user_type'] == 'driver') {
                    $driver_sql = "SELECT verification_status FROM drivers WHERE user_id = ?";
                    $driver_stmt = $conn->prepare($driver_sql);
                    $driver_stmt->bind_param("i", $user['user_id']);
                    $driver_stmt->execute();
                    $driver_result = $driver_stmt->get_result();
                    
                    if ($driver_result->num_rows > 0) {
                        $driver = $driver_result->fetch_assoc();
                        $_SESSION['verification_status'] = $driver['verification_status'];
                    }
                    
                    $driver_stmt->close();
                    header("Location: loginDriver.php");
                } else {
                    
                    header("Location: loginUser.php");
                }
                exit();
            }
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RideShare - Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="bi bi-bicycle"></i> Tryckasaken</h1>
            <p>Login to your account</p>
        </div>

        <div class="content">
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group mb-3">
                    <label for="email" class="form-label"><i class="bi bi-envelope"></i> Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password" class="form-label"><i class="bi bi-lock"></i> Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>