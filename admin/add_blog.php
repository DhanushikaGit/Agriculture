<?php

include 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $tags = $_POST['tags'];

    // Image Upload Handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // Insert into database
    $sql = "INSERT INTO blogs (title, author, image, content, category, tags) 
            VALUES ('$title', '$author', '$target_file', '$content', '$category', '$tags')";

    if (mysqli_query($conn, $sql)) {
        echo "Blog post added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<form method="POST" enctype="multipart/form-data">
    Title: <input type="text" name="title" required><br>
    Author: <input type="text" name="author" required><br>
    Image: <input type="file" name="image" required><br>
    Content: <textarea name="content" required></textarea><br>
    Category: <input type="text" name="category"><br>
    Tags: <input type="text" name="tags"><br>
    <button type="submit">Add Blog</button>
</form>
