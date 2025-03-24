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

    <!-- Favicons -->
    <link href="assets/img/logoo-Recovered.jpg" rel="icon">
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

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include 'header.php'; ?>


    <?php include 'chatbot.php'; ?>

    <h1 class="text-3xl font-bold text-center mb-6">Contact Us</h1>
    <main class="container mx-auto px-4 py-8">
        <!-- Contact Info Section -->
        <div class="grid md:grid-cols-3 gap-8 my-12">
            <!-- Address -->
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-map-marker-alt text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Our Address</h3>
                <p class="text-gray-600">Provincial Department of Agriculture, North Central Province, Anuradhapura</p>
            </div>

            <!-- Email -->
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Email Us</h3>
                <p class="text-gray-600">ncpagri@gmail.com</p>
            </div>

            <!-- Phone -->
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-phone text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Call Us</h3>
                <p class="text-gray-600">+94 25 2222 189</p>
            </div>
        </div>

        <!-- Map & Form Section -->
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Map -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="w-full h-96 rounded-lg overflow-hidden">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.9245508418375!2d80.38883847421542!3d8.335802691509184!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3afc2d605b6f6e5f%3A0x8cbb928b8c5c5f0!2sDepartment%20of%20Agriculture%2C%20North%20Central%20Province!5e0!3m2!1sen!2slk!4v1707823456789!5m2!1sen!2slk"
                        class="w-full h-full"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <form action="contact.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" id="name" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" id="email" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" name="phone" id="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500">
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                        <textarea name="message" id="message" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-green-500 focus:border-green-500"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white py-3 px-6 rounded-md hover:bg-green-700 transition duration-300">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>
