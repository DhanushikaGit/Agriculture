<?php
// Include the database connection file
include 'C:/xampp/htdocs/The Department of Agriculture Services Website/db_connect.php';

// Start session
session_start();

// Handle form submissions (Signup/Login)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["action"])) {
        $action = $_POST["action"];

        if ($action == "signup") {
            // Signup process
            $name = trim($_POST["name"]);
            $email = trim($_POST["email"]);
            $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Secure password hashing

            // Check if email already exists
            $check_email_sql = "SELECT email FROM users WHERE email = ?";
            $check_stmt = $conn->prepare($check_email_sql);
            $check_stmt->bind_param("s", $email);
            $check_stmt->execute();
            $check_stmt->store_result();

            if ($check_stmt->num_rows > 0) {
                echo "<script>alert('Error: This email is already registered. Please use a different email.');</script>";
            } else {
                // Insert user into database
                $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $name, $email, $password);

                if ($stmt->execute()) {
                    echo "<script>alert('Account created successfully. You can now log in.');</script>";
                } else {
                    echo "<script>alert('Error: " . $stmt->error . "');</script>";
                }

                $stmt->close();
            }

            $check_stmt->close();
        } elseif ($action == "login") {
            // Login process
            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);
        
            // Fetch user from database
            $sql = "SELECT id, name, password FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
        
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $name, $hashed_password);
                $stmt->fetch();
        
                if (password_verify($password, $hashed_password)) {
                    $_SESSION["user_id"] = $id;
                    $_SESSION["user_name"] = $name;
        
                    // Redirect to home page after successful login
                    header("Location: http://localhost/The%20Department%20of%20Agriculture%20Services%20Website/User/home.php"); // Replace "home.php" with your home page URL
                    exit(); // Ensure no further code is executed after the redirect
                } else {
                    echo "<script>alert('Invalid credentials. Please try again.');</script>";
                }
            } else {
                echo "<script>alert('No account found with that email.');</script>";
            }
        
            $stmt->close();
        }
    }
}

// Fetch data from the users table (for display purposes)
$sql = "SELECT id, name, email, reg_date FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Department of Agriculture Services</title>
    <link href="../assets/img/logoo-Recovered.jpg" rel="icon">
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form action="" method="POST">
                <h1>Create Account</h1>
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="hidden" name="action" value="signup">
                <button type="submit">Sign Up</button>
                
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form action="" method="POST">
                <h1>Sign In</h1>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="hidden" name="action" value="login">
                <button type="submit">Log In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>If you already have an account, log in here.</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Farmer!</h1>
                    <p>Join us to access exclusive agriculture services and resources.</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const signUpButton = document.getElementById('signUp');
            const signInButton = document.getElementById('signIn');
            const container = document.getElementById('container');

            if (signUpButton && signInButton) {
                signUpButton.addEventListener('click', () => {
                    container.classList.add('right-panel-active');
                });

                signInButton.addEventListener('click', () => {
                    container.classList.remove('right-panel-active');
                });
            }
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>