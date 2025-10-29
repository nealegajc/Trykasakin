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
    <link rel="stylesheet" href="assets/css/login.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tryckasaken</h1>
            <p>Login to your account</p>
        </div>

        <div class="content">
            <?php if ($error): ?>
                <div class="alert"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="btn">Login</button>
            </form>

            <div class="footer-text">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
        </div>
    </div>
</body>
</html>