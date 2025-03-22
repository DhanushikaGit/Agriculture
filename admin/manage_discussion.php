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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Manage Discussions</title>
</head>
<body>
    
    <h2>Manage Discussion Forum</h2>
    <a href="discussion.php">Back to Discussion Forum</a>
    <hr>

    <h3>All Discussions</h3>
    <?php while ($row = $result->fetch_assoc()) : ?>
        <div>
            <strong><?= htmlspecialchars($row['name']) ?></strong> (<?= $row['created_at'] ?>)
            <p><?= htmlspecialchars($row['message']) ?></p>
            <?php if ($row['photo']) : ?>
                <img src="<?= $row['photo'] ?>" width="100" alt="Photo">
            <?php endif; ?>
            <?php if ($row['video']) : ?>
                <video width="200" controls>
                    <source src="<?= $row['video'] ?>" type="video/mp4">
                </video>
            <?php endif; ?>
            <?php if ($row['attachment']) : ?>
                <a href="<?= $row['attachment'] ?>" download>Download Attachment</a>
            <?php endif; ?>
            <br>
            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
            <hr>
        </div>
    <?php endwhile; ?>
</body>
</html>
