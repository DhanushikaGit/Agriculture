<?php
include 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php'; // Database connection file

// Get the blog ID from the URL
$blog_id = isset($_GET['id']) ? $_GET['id'] : 1;

// Fetch the blog details from the database
$sql = "SELECT * FROM blogs WHERE id = $blog_id";
$result = mysqli_query($conn, $sql);
$blog = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $blog['title']; ?></title>
</head>
<body>

    <h1><?php echo $blog['title']; ?></h1>
    <p>By <?php echo $blog['author']; ?> | <?php echo date("F j, Y", strtotime($blog['created_at'])); ?></p>
    <img src="<?php echo $blog['image']; ?>" alt="Blog Image">
    <p><?php echo nl2br($blog['content']); ?></p>

    <p><strong>Category:</strong> <?php echo $blog['category']; ?></p>
    <p><strong>Tags:</strong> <?php echo $blog['tags']; ?></p>

</body>
</html>
