<?php
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "Agriculture_Services_Website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Video Upload
if (isset($_POST['upload'])) {
    $title = $_POST['title'];
    $filename = $_FILES['video']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["video"]["name"]);

    if (move_uploaded_file($_FILES["video"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO videos (title, filename) VALUES ('$title', '$filename')";
        $conn->query($sql);
    }
}

// Handle Video Deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM videos WHERE id=$id");
}

// Fetch Videos
$result = $conn->query("SELECT * FROM videos");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Manage Videos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
        }
        input, button {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #bdc3c7;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
        a {
            text-decoration: none;
            color: red;
            font-weight: bold;
        }
        a:hover {
            color: darkred;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Upload Video</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Video Title" required>
        <input type="file" name="video" required>
        <button type="submit" name="upload">Upload</button>
    </form>

    <h2>Manage Videos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Filename</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['filename'] ?></td>
                <td>
                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
