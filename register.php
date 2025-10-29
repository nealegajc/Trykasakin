<?php
session_start();
require_once 'config/dbConnection.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $database = new Database();
    $conn = $database->getConnection();

    if ($conn) {
        $user_type = $_POST['user_type'];
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

    
        if ($password !== $confirm_password) {
            $error = "Passwords do not match!";
        } else {
            $check_sql = "SELECT email FROM users WHERE email = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("s", $email);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                $error = "Email already registered!";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO users (user_type, name, email, phone, password) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssss", $user_type, $name, $email, $phone, $hashed_password);

                if ($stmt->execute()) {
                    $user_id = $conn->insert_id;

                    if ($user_type == 'driver') {
                        $upload_dir = 'assets/uploads/';
                        
                        if (!file_exists($upload_dir . 'or_cr/')) mkdir($upload_dir . 'or_cr/', 0777, true);
                        if (!file_exists($upload_dir . 'licenses/')) mkdir($upload_dir . 'licenses/', 0777, true);
                        if (!file_exists($upload_dir . 'pictures/')) mkdir($upload_dir . 'pictures/', 0777, true);

                        $or_cr_name = time() . '_' . $_FILES['or_cr']['name'];
                        $or_cr_path = $upload_dir . 'or_cr/' . $or_cr_name;
                        move_uploaded_file($_FILES['or_cr']['tmp_name'], $or_cr_path);

                        $license_name = time() . '_' . $_FILES['license']['name'];
                        $license_path = $upload_dir . 'licenses/' . $license_name;
                        move_uploaded_file($_FILES['license']['tmp_name'], $license_path);

                        $picture_name = time() . '_' . $_FILES['driver_picture']['name'];
                        $picture_path = $upload_dir . 'pictures/' . $picture_name;
                        move_uploaded_file($_FILES['driver_picture']['tmp_name'], $picture_path);

                        $driver_sql = "INSERT INTO drivers (user_id, or_cr_path, license_path, picture_path) VALUES (?, ?, ?, ?)";
                        $driver_stmt = $conn->prepare($driver_sql);
                        $driver_stmt->bind_param("isss", $user_id, $or_cr_path, $license_path, $picture_path);
                        $driver_stmt->execute();
                        $driver_stmt->close();
                    }

                    $success = "Registration successful! You can now login.";
                    header("refresh:2;url=login.php");
                } else {
                    $error = "Registration failed. Please try again.";
                }

                $stmt->close();
            }
            $check_stmt->close();
        }
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RideShare - Register</title>
    <link rel="stylesheet" href="assets/css/register.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Tryckasaken</h1>
            <p>Create your account to get started</p>
        </div>

        <div class="content">
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form action="register.php" method="POST" enctype="multipart/form-data">
                <div class="user-type-selector">
                    <label class="user-type">
                        <input type="radio" id="passenger" name="user_type" value="passenger" checked hidden onchange="toggleDriverFields()">
                        <div class="user-type-icon">👤</div>
                        <div class="user-type-label">Passenger</div>
                    </label>
                    <label class="user-type">
                        <input type="radio" id="driver" name="user_type" value="driver" hidden onchange="toggleDriverFields()">
                        <div class="user-type-icon">🚕</div>
                        <div class="user-type-label">Become a Driver</div>
                    </label>
                </div>

                <div class="form-group">
                    <label for="registerName">Full Name</label>
                    <input type="text" id="registerName" name="name" placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="registerEmail">Email Address</label>
                    <input type="email" id="registerEmail" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="registerPhone">Phone Number</label>
                    <input type="tel" id="registerPhone" name="phone" placeholder="Enter your phone number" required>
                </div>

                <div class="form-group">
                    <label for="registerPassword">Password</label>
                    <input type="password" id="registerPassword" name="password" placeholder="Create a password (min 6 characters)" required minlength="6">
                </div>

                <div class="form-group">
                    <label for="registerConfirmPassword">Confirm Password</label>
                    <input type="password" id="registerConfirmPassword" name="confirm_password" placeholder="Re-enter your password" required>
                </div>

                <div id="driverFields">
                    <div class="section-divider">
                        <span class="section-title">Driver Information</span>
                    </div>
                    
                    <div class="form-group">
                        <label for="orCr">OR/CR (Official Receipt/Certificate of Registration) 📄</label>
                        <div class="file-upload-wrapper">
                            <input type="file" id="orCr" name="or_cr" accept="image/*,.pdf">
                            <div class="file-info">Upload a clear photo or PDF of your vehicle's OR/CR</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="license">Driver's License 🪪</label>
                        <div class="file-upload-wrapper">
                            <input type="file" id="license" name="license" accept="image/*,.pdf">
                            <div class="file-info">Upload a clear photo or PDF of your driver's license</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="driverPicture">Profile Picture 📸</label>
                        <div class="file-upload-wrapper">
                            <input type="file" id="driverPicture" name="driver_picture" accept="image/*">
                            <div class="file-info">Upload a recent photo of yourself</div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn">Create Account</button>
            </form>

            <div class="footer-text">
                Already have an account? <a href="login.php">Login here</a>
            </div>
        </div>
    </div>

    <script>
        function toggleDriverFields() {
            const driverFields = document.getElementById('driverFields');
            const isDriver = document.getElementById('driver').checked;
            
            if (isDriver) {
                driverFields.classList.add('show');
                document.getElementById('orCr').required = true;
                document.getElementById('license').required = true;
                document.getElementById('driverPicture').required = true;
            } else {
                driverFields.classList.remove('show');
                document.getElementById('orCr').required = false;
                document.getElementById('license').required = false;
                document.getElementById('driverPicture').required = false;
            }
        }
    </script>
</body>
</html>