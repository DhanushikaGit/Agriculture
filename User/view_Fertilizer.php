<?php
include 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php'; // Include database connection

$success_msg = ""; // Variable to store success message

// Handle form submission
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $society_number = $_POST['society_number'];
    $land_location = $_POST['land_location'];
    $land_size = $_POST['land_size'];
    $cultivated_area = $_POST['cultivated_area'];
    $crop_type = $_POST['crop_type'];
    $phone = $_POST['phone'];
    $id_number = $_POST['id_number'];

    // Insert data into the farmers table
    $sql = "INSERT INTO farmers (name, address, society_number, land_location, land_size, cultivated_area, crop_type, phone, id_number)
            VALUES ('$name', '$address', '$society_number', '$land_location', $land_size, $cultivated_area, '$crop_type', '$phone', '$id_number')";

    if ($conn->query($sql)) {
        $success_msg = "Registration successful!"; // Set success message
    } else {
        $success_msg = "Error: " . $conn->error; // Set error message
    }
}

// Fetch fertilizer notices
$sql = "SELECT title, fertilizer_type, description, date, time FROM fertilizer_notices ORDER BY date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department of Agriculture Services - Fertilizer Program</title>

     <!-- Favicons -->
     <link href="assets/img/logoo-Recovered.bmp" rel="icon">
    <link href="assets/img/logoo-Recovered.bmp" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <!-- Main CSS -->
    <link href="assets/css/main.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2e7d32;
            --secondary-color: #dcedc8;
            --accent-color: #558b2f;
            --text-color: #333;
            --light-bg: #f9f9f9;
        }
        
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            color: var(--text-color);
            background-color: #f5f5f5;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 5px solid var(--accent-color);
        }
        
        h1, h2, h3 {
            color: var(--primary-color);
        }
        
        .section {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .notice-board {
            border-top: 5px solid var(--primary-color);
        }
        
        .notice {
            background-color: var(--secondary-color);
            border-left: 4px solid var(--primary-color);
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        
        .notice-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        
        .notice-title {
            font-weight: bold;
            font-size: 1.2em;
            color: var(--primary-color);
        }
        
        .notice-date {
            color: #666;
        }
        
        .notice-body {
            margin-bottom: 10px;
        }
        
        .notice-type {
            display: inline-block;
            background-color: var(--accent-color);
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 0.85em;
        }
        
        .form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
        }
        
        .form-row {
            margin-bottom: 15px;
        }
        
        .form-row label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .form-row input, .form-row textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .form-row textarea {
            min-height: 80px;
        }
        
        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: var(--accent-color);
        }
        
        .success-msg {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .error-msg {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        
        .download-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: var(--accent-color);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .download-link:hover {
            background-color: var(--primary-color);
        }
        
        footer {
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

    <div class="container">
        <!-- Fertilizer Notices Section -->
        <section class="section notice-board">
            <h2><i class="icon"></i> Free Fertilizer Distribution Notices</h2>
            <p>The Department of Agriculture is pleased to announce the following fertilizer distribution programs. Eligible registered farmers can collect fertilizers as per the schedule below.</p>
            
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='notice'>
                            <div class='notice-header'>
                                <span class='notice-title'>{$row['title']}</span>
                                <span class='notice-date'>{$row['date']} at {$row['time']}</span>
                            </div>
                            <div class='notice-body'>
                                <p>{$row['description']}</p>
                            </div>
                            <div class='notice-footer'>
                                <span class='notice-type'>{$row['fertilizer_type']}</span>
                            </div>
                          </div>";
                }
            } else {
                echo "<div class='notice'>
                        <div class='notice-header'>
                            <span class='notice-title'>No Current Notices</span>
                        </div>
                        <div class='notice-body'>
                            <p>There are currently no fertilizer distribution notices. Please check back later.</p>
                        </div>
                      </div>";
            }
            ?>

            <div class="notice">
                <div class="notice-header">
                    <span class="notice-title">Important Information</span>
                </div>
                <div class="notice-body">
                    <p>Farmers must bring their ID cards and society membership proof when collecting fertilizers. Distribution is on first-come, first-served basis while stocks last.</p>
                </div>
            </div>
        </section>

        <!-- Display Success or Error Message -->
        <?php if (!empty($success_msg)): ?>
            <div class="<?php echo (strpos($success_msg, 'Error') === false ? 'success-msg' : 'error-msg'); ?>">
                <?php echo $success_msg; ?>
            </div>
        <?php endif; ?>

        <!-- Registration Form -->
        <section class="section">
            <h2>Farmer Registration Form</h2>
            <p>Complete this form to register for the fertilizer subsidy program. All fields are mandatory.</p>
            
            <div class="form-container">
                <form action="" method="POST">
                    <div class="form-row">
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-row">
                        <label for="address">Address:</label>
                        <textarea id="address" name="address" required></textarea>
                    </div>
                    
                    <div class="form-row">
                        <label for="society_number">Society Membership Number:</label>
                        <input type="text" id="society_number" name="society_number" required>
                    </div>
                    
                    <div class="form-row">
                        <label for="land_location">Land Location (Village/Town/District):</label>
                        <textarea id="land_location" name="land_location" required></textarea>
                    </div>
                    
                    <div class="form-row">
                        <label for="land_size">Total Land Size (in acres):</label>
                        <input type="number" id="land_size" name="land_size" step="0.01" required>
                    </div>
                    
                    <div class="form-row">
                        <label for="cultivated_area">Currently Cultivated Area (in acres):</label>
                        <input type="number" id="cultivated_area" name="cultivated_area" step="0.01" required>
                    </div>
                    
                    <div class="form-row">
                        <label for="crop_type">Primary Crop Type:</label>
                        <input type="text" id="crop_type" name="crop_type" required>
                    </div>
                    
                    <div class="form-row">
                        <label for="phone">Contact Number:</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    
                    <div class="form-row">
                        <label for="id_number">National ID Number:</label>
                        <input type="text" id="id_number" name="id_number" required>
                    </div>
                    
                    <button type="submit" name="submit">Submit Registration</button>
                </form>
            </div>
            
            <a href="path_to_your_form.pdf" class="download-link" download="Farmer_Registration_Form.pdf">
                <i class="icon"></i> Download Registration Form (PDF)
            </a>
        </section>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

<?php
$conn->close(); // Close database connection
?>