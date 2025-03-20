<?php
include 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php';

// Handle form submissions
$success_msg = "";

// Add Notice
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_notice'])) {
    $title = $_POST['title'];
    $fertilizer_type = $_POST['fertilizer_type'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "INSERT INTO fertilizer_notices (title, fertilizer_type, description, date, time)
            VALUES ('$title', '$fertilizer_type', '$description', '$date', '$time')";

    if ($conn->query($sql)) {
        $success_msg = "Notice added successfully!";
    } else {
        $success_msg = "Error: " . $conn->error;
    }
}

// Edit Notice
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_notice'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $fertilizer_type = $_POST['fertilizer_type'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "UPDATE fertilizer_notices
            SET title = '$title', fertilizer_type = '$fertilizer_type', description = '$description', date = '$date', time = '$time'
            WHERE id = $id";

    if ($conn->query($sql)) {
        $success_msg = "Notice updated successfully!";
    } else {
        $success_msg = "Error: " . $conn->error;
    }
}

// Delete Notice
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $sql = "DELETE FROM fertilizer_notices WHERE id = $id";

    if ($conn->query($sql)) {
        $success_msg = "Notice deleted successfully!";
    } else {
        $success_msg = "Error: " . $conn->error;
    }
}

// Fetch all notices
$sql_notices = "SELECT * FROM fertilizer_notices ORDER BY date DESC";
$result_notices = $conn->query($sql_notices);

// Fetch all farmers
$sql_farmers = "SELECT * FROM farmers ORDER BY name ASC";
$result_farmers = $conn->query($sql_farmers);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Notices & Farmers</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .success-msg {
            color: green;
            font-weight: bold;
        }
        .error-msg {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Manage Fertilizer Notices</h2>

    <!-- Display Success/Error Messages -->
    <?php if (!empty($success_msg)): ?>
        <p class="success-msg"><?= $success_msg; ?></p>
    <?php endif; ?>

    <!-- Add Notice Form -->
    <h3>Add New Notice</h3>
    <form method="POST" action="">
        <input type="hidden" name="add_notice">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>
        <label>Fertilizer Type:</label><br>
        <input type="text" name="fertilizer_type" required><br><br>
        <label>Description:</label><br>
        <textarea name="description" required></textarea><br><br>
        <label>Date:</label><br>
        <input type="date" name="date" required><br><br>
        <label>Time:</label><br>
        <input type="time" name="time" required><br><br>
        <button type="submit">Add Notice</button>
    </form>

    <!-- Display Notices -->
    <h3>Fertilizer Notices</h3>
    <table>
        <tr>
            <th>Title</th>
            <th>Fertilizer Type</th>
            <th>Description</th>
            <th>Date</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result_notices->fetch_assoc()): ?>
        <tr>
            <td><?= $row['title']; ?></td>
            <td><?= $row['fertilizer_type']; ?></td>
            <td><?= $row['description']; ?></td>
            <td><?= $row['date']; ?></td>
            <td><?= $row['time']; ?></td>
            <td>
                <!-- Edit Notice Form -->
                <form method="POST" action="" style="display: inline;">
                    <input type="hidden" name="edit_notice">
                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                    <button type="submit">Edit</button>
                </form>
                <!-- Delete Notice Link -->
                <a href="?delete_id=<?= $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- Display Registered Farmers -->
    <h2>Registered Farmers</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Society Number</th>
            <th>Land Location</th>
            <th>Land Size</th>
            <th>Cultivated Area</th>
            <th>Crop Type</th>
            <th>Phone</th>
            <th>ID Number</th>
        </tr>
        <?php while ($farmer = $result_farmers->fetch_assoc()): ?>
        <tr>
            <td><?= $farmer['name']; ?></td>
            <td><?= $farmer['address']; ?></td>
            <td><?= $farmer['society_number']; ?></td>
            <td><?= $farmer['land_location']; ?></td>
            <td><?= $farmer['land_size']; ?></td>
            <td><?= $farmer['cultivated_area']; ?></td>
            <td><?= $farmer['crop_type']; ?></td>
            <td><?= $farmer['phone']; ?></td>
            <td><?= $farmer['id_number']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>