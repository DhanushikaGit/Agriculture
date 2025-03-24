<?php
session_start(); // Start the session
require 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php';
include 'admin_header.php';  // Include the database connection file



// Handle post deletion
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $conn->query("DELETE FROM discussion WHERE id = $delete_id");
    echo "<script>alert('Post deleted successfully!'); window.location.href='manage_discussion.php';</script>";
}

// Fetch all discussions
$result = $conn->query("SELECT d.*, u.name FROM discussion d JOIN users u ON d.user_id = u.id ORDER BY d.created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Favicons -->
    <link href="../User/assets/img/logoo-Recovered.jpg" rel="icon">
  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Manage Discussions</title>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 text-center">Manage Discussion Forum</h2>
        <a href="../User/discussion.php" class="text-blue-500 hover:underline block text-center mt-4">Back to Discussion Forum</a>
        <hr class="my-4">

        <h3 class="text-xl font-semibold text-gray-700 mb-4">All Discussions</h3>
        
        <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="bg-gray-50 shadow-md rounded-lg p-4 mb-4">
                <strong class="text-green-600"><?= htmlspecialchars($row['name']) ?></strong>
                <span class="text-gray-500 text-sm"> (<?= $row['created_at'] ?>)</span>
                <p class="text-gray-700 mt-2"><?= htmlspecialchars($row['message']) ?></p>

                <!-- Image -->
                <?php if ($row['photo']) : ?>
                    <img src="<?= $row['photo'] ?>" class="w-full max-w-xs mt-2 rounded-lg shadow-md" alt="Photo">
                <?php endif; ?>

                <!-- Video -->
                <?php if ($row['video']) : ?>
                    <video class="w-full max-w-xs mt-2 rounded-lg" controls>
                        <source src="<?= $row['video'] ?>" type="video/mp4">
                    </video>
                <?php endif; ?>

                <!-- Attachment -->
                <?php if ($row['attachment']) : ?>
                    <a href="<?= $row['attachment'] ?>" download class="block text-blue-600 mt-2 hover:underline">Download Attachment</a>
                <?php endif; ?>

                <!-- Delete Button -->
                <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this post?');" 
                   class="inline-block bg-red-500 text-white px-4 py-2 rounded-lg mt-3 hover:bg-red-600">
                    Delete
                </a>
            </div>
        <?php endwhile; ?>
    </div>

</body>
</html>
