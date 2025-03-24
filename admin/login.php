<?php
session_start();
include '../db_connect.php'; // Include database connection

$error_message = ""; // Variable to store error messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input fields
    if (empty($email) || empty($password)) {
        $error_message = "All fields are required!";
    } else {
        // Get admin details
        $sql = "SELECT id, name, password FROM admin WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $name, $hashed_password);
            $stmt->fetch();

            // Debugging: Output the hashed password and input password
            echo "Hashed Password from DB: " . $hashed_password . "<br>";
            echo "Input Password: " . $password . "<br>";

            if (password_verify($password, $hashed_password)) {
                $_SESSION['admin_id'] = $id;
                $_SESSION['admin_name'] = $name;
                
                // Redirect to dashboard
                header("Location: dashbord.php"); // Corrected URL
                exit();
            } else {
                $error_message = "Invalid password!";
            }
        } else {
            $error_message = "Admin not found!";
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 350px;
        }
        .btn-login {
            width: 100%;
            background-color: #28a745;
            border: none;
        }
        .btn-login:hover {
            background-color: #218838;
        }
        .error-alert {
            color: #d9534f;
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2 class="text-center mb-3">Admin Login</h2>

    <?php if (!empty($error_message)) { ?>
        <div class="alert alert-danger error-alert"><?php echo $error_message; ?></div>
    <?php } ?>

    <form action="" method="post">
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-success btn-login">Login</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>