<?php
session_start();
include 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php';

$successMessage = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $contact_no = $_POST["phone"];
    $message = $_POST["message"];

    $filePath = "";
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        $fileTmpName = $_FILES["file"]["tmp_name"];
        $fileName = basename($_FILES["file"]["name"]);
        $uploadDir = "uploads/";
        $filePath = $uploadDir . uniqid() . "_" . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!move_uploaded_file($fileTmpName, $filePath)) {
            $_SESSION['error'] = "Error uploading file.";
            header("Location: contact.php");
            exit;
        }
    }

    $sql = "INSERT INTO user_queries (name, email, contact_no, message, file_path) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssss", $name, $email, $contact_no, $message, $filePath);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Your query has been submitted successfully.";
        } else {
            $_SESSION['error'] = "Database error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Failed to prepare statement.";
    }
    header("Location: contact.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Department of Agriculture Services</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Add FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include 'header.php'; ?>

    <main class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-green-800 mb-4">Contact Us</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Have questions about agricultural services? We're here to help! Reach out to us using any of the methods below.</p>
        </div>

        <!-- Contact Information Cards -->
        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <!-- Address Card -->
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-map-marker-alt text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Our Address</h3>
                <p class="text-gray-600">A108 Adam Street, New York, NY 535022</p>
            </div>

            <!-- Email Card -->
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Email Us</h3>
                <p class="text-gray-600">info@example.com</p>
            </div>

            <!-- Phone Card -->
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-phone text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Call Us</h3>
                <p class="text-gray-600">+1 5589 55488 55</p>
            </div>
        </div>

        <!-- Map and Form Section -->
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Map Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="w-full h-96 rounded-lg overflow-hidden">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=..."
                        class="w-full h-full"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                    </div>
                <?php endif; ?>

                <form action="contact.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" id="name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" id="email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                        <input type="tel" name="phone" id="phone" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea name="message" id="message" rows="4" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"></textarea>
                    </div>

                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Attach File (optional)</label>
                        <input type="file" name="file" id="file"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>

                    <button type="submit"
                        class="w-full bg-green-600 text-white py-3 px-6 rounded-md hover:bg-green-700 transition duration-300">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>