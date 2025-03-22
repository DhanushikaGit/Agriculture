<?php
include '../db_connect.php';
include 'admin_header.php'; 

// Handle Adding a Section
if (isset($_POST['add_section'])) {
    $section_name = $_POST['section_name'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $added_by = "Admin";

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        exit;
    }

    if (file_exists($target_file)) {
        echo "File already exists.";
        exit;
    }

    if ($_FILES["image"]["size"] > 5000000) {
        echo "File is too large.";
        exit;
    }

    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
        exit;
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO CultivationSections (section_name, title, description, image, added_by)
                VALUES ('$section_name', '$title', '$description', '$target_file', '$added_by')";

        if ($conn->query($sql)) {
            echo "Section added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading file.";
    }
}

// Handle Editing a Section
if (isset($_GET['edit_id'])) {
    $id = $_GET['edit_id'];
    $sql = "SELECT * FROM CultivationSections WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if (isset($_POST['update_section'])) {
    $id = $_POST['id'];
    $section_name = $_POST['section_name'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $existing_image = $_POST['existing_image'];

    // Check if a new image is uploaded
    if ($_FILES["image"]["name"]) {
        $target_file = "uploads/" . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image = $target_file;
    } else {
        $image = $existing_image; // Keep existing image
    }

    $sql = "UPDATE CultivationSections 
            SET section_name='$section_name', title='$title', description='$description', image='$image' 
            WHERE id=$id";
    
    if ($conn->query($sql)) {
        echo "Section updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Deleting a Section
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM CultivationSections WHERE id = $id";
    if ($conn->query($sql)) {
        echo "Section deleted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch all sections
$sql = "SELECT * FROM CultivationSections";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cultivation Sections</title>
</head>
<body>
    <h1>Add New Section</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Section Name:</label>
        <select name="section_name" required>
            <option value="Seed Selection and Quality">Seed Selection and Quality</option>
            <option value="Soil Preparation Methods">Soil Preparation Methods</option>
            <option value="Planting Techniques">Planting Techniques</option>
            <option value="Germination Care">Germination Care</option>
        </select><br><br>

        <label>Title:</label>
        <input type="text" name="title" required><br><br>

        <label>Description:</label>
        <textarea name="description" required></textarea><br><br>

        <label>Upload Image:</label>
        <input type="file" name="image" accept="image/*" required><br><br>

        <input type="submit" name="add_section" value="Add Section">
    </form>
    
    <h1>View Sections</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Section Name</th>
            <th>Title</th>
            <th>Description</th>
            <th>Image</th>
            <th>Added By</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['section_name'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['description'] ?></td>
                <td><img src="<?= $row['image'] ?>" alt="" width="100"></td>
                <td><?= $row['added_by'] ?></td>
                <td>
                    <a href="?edit_id=<?= $row['id'] ?>">Edit</a>
                    <a href="?delete_id=<?= $row['id'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    
    <?php if (isset($_GET['edit_id'])): ?>
    <h1>Edit Section</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <input type="hidden" name="existing_image" value="<?= $row['image'] ?>">
        
        <label>Section Name:</label>
        <select name="section_name" required>
            <option value="Seed Selection and Quality" <?= ($row['section_name'] == "Seed Selection and Quality") ? "selected" : "" ?>>Seed Selection and Quality</option>
            <option value="Soil Preparation Methods" <?= ($row['section_name'] == "Soil Preparation Methods") ? "selected" : "" ?>>Soil Preparation Methods</option>
            <option value="Planting Techniques" <?= ($row['section_name'] == "Planting Techniques") ? "selected" : "" ?>>Planting Techniques</option>
            <option value="Germination Care" <?= ($row['section_name'] == "Germination Care") ? "selected" : "" ?>>Germination Care</option>
        </select><br><br>
        
        <label>Title:</label>
        <input type="text" name="title" value="<?= $row['title'] ?>" required><br><br>

        <label>Description:</label>
        <textarea name="description" required><?= $row['description'] ?></textarea><br><br>

        <label>Current Image:</label><br>
        <img src="<?= $row['image'] ?>" width="100"><br><br>

        <label>Upload New Image (optional):</label>
        <input type="file" name="image" accept="image/*"><br><br>

        <input type="submit" name="update_section" value="Update Section">
    </form>
    <?php endif; ?>
</body>
</html>
