<?php
session_start();
require 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php';

if (!isset($_SESSION['user_id'])) {
    if (!isset($_SESSION['redirected'])) {
        $_SESSION['redirected'] = true;
        echo "<script>
            alert('You need to log in or register to access the discussion forum.');
            window.location.href = 'http://localhost/The%20Department%20of%20Agriculture%20Services%20Website/User/login_Signup%20_Page/login.php';
        </script>";
        exit();
    }
} else {
    unset($_SESSION['redirected']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $user_id = $_SESSION['user_id'];
    $message = $conn->real_escape_string(trim($_POST['message']));
    
    // Create uploads directory if it doesn't exist
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // File handling with unique names
    $photo = null;
    $video = null;
    $attachment = null;

    if ($_FILES['photo']['name']) {
        $photo = $uploadDir . uniqid() . '_' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }
    if ($_FILES['video']['name']) {
        $video = $uploadDir . uniqid() . '_' . basename($_FILES['video']['name']);
        move_uploaded_file($_FILES['video']['tmp_name'], $video);
    }
    if ($_FILES['attachment']['name']) {
        $attachment = $uploadDir . uniqid() . '_' . basename($_FILES['attachment']['name']);
        move_uploaded_file($_FILES['attachment']['tmp_name'], $attachment);
    }

    $stmt = $conn->prepare("INSERT INTO discussion (user_id, message, photo, video, attachment) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $message, $photo, $video, $attachment);
    
    if ($stmt->execute()) {
        header("Location: discussion.php");
        exit();
    }
    $stmt->close();
}

$result = $conn->query("SELECT d.*, u.name FROM discussion d JOIN users u ON d.user_id = u.id ORDER BY d.created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agricultural Discussion Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include 'header.php'; ?>

    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-green-800 mb-8 text-center">Agricultural Discussion Forum</h1>

            <!-- Post Message Form -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Start a Discussion</h2>
                <form action="discussion.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <textarea 
                            name="message" 
                            required 
                            placeholder="Share your agricultural knowledge or ask a question..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 h-32"
                        ></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="relative">
                            <input type="file" name="photo" accept="image/*" class="hidden" id="photo-upload">
                            <label for="photo-upload" class="cursor-pointer block text-center p-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500">
                                <i class="fas fa-image text-gray-400 mb-2"></i>
                                <span class="block text-sm text-gray-600">Add Photo</span>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="file" name="video" accept="video/*" class="hidden" id="video-upload">
                            <label for="video-upload" class="cursor-pointer block text-center p-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500">
                                <i class="fas fa-video text-gray-400 mb-2"></i>
                                <span class="block text-sm text-gray-600">Add Video</span>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="file" name="attachment" class="hidden" id="file-upload">
                            <label for="file-upload" class="cursor-pointer block text-center p-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500">
                                <i class="fas fa-paperclip text-gray-400 mb-2"></i>
                                <span class="block text-sm text-gray-600">Add Attachment</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-300">
                        Post Discussion
                    </button>
                </form>
            </div>

            <!-- Discussion Posts -->
            <div class="space-y-6">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-green-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="font-semibold text-gray-800"><?= htmlspecialchars($row['name']) ?></h3>
                                    <p class="text-sm text-gray-500"><?= date('F j, Y g:i a', strtotime($row['created_at'])) ?></p>
                                </div>
                            </div>
                        </div>

                        <p class="text-gray-700 mb-4"><?= nl2br(htmlspecialchars($row['message'])) ?></p>

                        <?php if ($row['photo']) : ?>
                            <div class="mb-4">
                                <img src="<?= htmlspecialchars($row['photo']) ?>" class="rounded-lg max-w-full h-auto" alt="Posted photo">
                            </div>
                        <?php endif; ?>

                        <?php if ($row['video']) : ?>
                            <div class="mb-4">
                                <video class="rounded-lg w-full" controls>
                                    <source src="<?= htmlspecialchars($row['video']) ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        <?php endif; ?>

                        <?php if ($row['attachment']) : ?>
                            <div class="flex items-center text-blue-600 hover:text-blue-800">
                                <i class="fas fa-paperclip mr-2"></i>
                                <a href="<?= htmlspecialchars($row['attachment']) ?>" download class="text-sm">
                                    Download Attachment
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script>
        // Preview file names when selected
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const label = this.nextElementSibling;
                const fileName = this.files[0]?.name;
                if (fileName) {
                    label.querySelector('span').textContent = fileName;
                }
            });
        });
    </script>
</body>
</html>