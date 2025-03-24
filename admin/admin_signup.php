<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login & Sign Up</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom CSS */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
            transition: all 0.3s ease-in-out;
        }
        .form-container h2 {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .form-container .text-center {
            text-align: center;
        }
        .error-message {
            color: #d9534f;
            text-align: center;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .success-message {
            color: #5bc0de;
            text-align: center;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .toggle-link {
            color: #0275d8;
            text-decoration: none;
            font-size: 14px;
        }
        .toggle-link:hover {
            text-decoration: underline;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

    <!-- Login Form -->
    <div id="login-form" class="form-container">
        <h2>Admin Login</h2>

        <?php if (!empty($error_message)) { ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php } ?>

        <?php if (!empty($success_message)) { ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php } ?>

        <form action="./dashbord.php" method="post">
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="login">Login</button>
        </form>

        <div class="text-center">
            <a href="javascript:void(0)" onclick="toggleForms()" class="toggle-link">Don't have an account? Sign Up</a>
        </div>
    </div>

    <!-- Sign Up Form -->
    <div id="signup-form" class="form-container hidden">
        <h2>Admin Sign Up</h2>

        <?php if (!empty($error_message)) { ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php } ?>

        <?php if (!empty($success_message)) { ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php } ?>

        <form action="admin_signup.php" method="post">
            <input type="text" name="name" placeholder="Full Name" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="signup">Sign Up</button>
        </form>

        <div class="text-center">
            <a href="javascript:void(0)" onclick="toggleForms()" class="toggle-link">Already have an account? Login</a>
        </div>
    </div>

    <script>
        // Function to toggle between login and signup forms
        function toggleForms() {
            var loginForm = document.getElementById('login-form');
            var signupForm = document.getElementById('signup-form');
            loginForm.classList.toggle('hidden');
            signupForm.classList.toggle('hidden');
        }
    </script>

</body>
</html>