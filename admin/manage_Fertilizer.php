<?php
include 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php';
include 'admin_header.php'; 

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
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Manage Notices & Farmers</title>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 text-center">Manage Fertilizer Notices</h2>

        <!-- Display Success/Error Messages -->
        <?php if (!empty($success_msg)): ?>
            <p class="text-green-600 font-semibold text-center mt-4"><?= $success_msg; ?></p>
        <?php endif; ?>

        <!-- Add Notice Form -->
        <h3 class="text-xl font-semibold text-gray-700 mt-6">Add New Notice</h3>
        <form method="POST" action="" class="bg-gray-50 p-4 rounded-lg shadow-md mt-4">
            <input type="hidden" name="add_notice">
            <label class="block font-medium text-gray-600">Title:</label>
            <input type="text" name="title" class="w-full p-2 border rounded-lg mt-1" required>

            <label class="block font-medium text-gray-600 mt-2">Fertilizer Type:</label>
            <input type="text" name="fertilizer_type" class="w-full p-2 border rounded-lg mt-1" required>

            <label class="block font-medium text-gray-600 mt-2">Description:</label>
            <textarea name="description" class="w-full p-2 border rounded-lg mt-1" required></textarea>

            <label class="block font-medium text-gray-600 mt-2">Date:</label>
            <input type="date" name="date" class="w-full p-2 border rounded-lg mt-1" required>

            <label class="block font-medium text-gray-600 mt-2">Time:</label>
            <input type="time" name="time" class="w-full p-2 border rounded-lg mt-1" required>

            <button type="submit" class="w-full bg-blue-500 text-white p-2 mt-4 rounded-lg hover:bg-blue-600">Add Notice</button>
        </form>

        <!-- Display Notices -->
        <h3 class="text-xl font-semibold text-gray-700 mt-6">Fertilizer Notices</h3>
        <div class="overflow-x-auto">
            <table class="w-full mt-4 bg-white border rounded-lg shadow-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 border">Title</th>
                        <th class="p-3 border">Fertilizer Type</th>
                        <th class="p-3 border">Description</th>
                        <th class="p-3 border">Date</th>
                        <th class="p-3 border">Time</th>
                        <th class="p-3 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_notices->fetch_assoc()): ?>
                    <tr class="text-center">
                        <td class="p-3 border"><?= $row['title']; ?></td>
                        <td class="p-3 border"><?= $row['fertilizer_type']; ?></td>
                        <td class="p-3 border"><?= $row['description']; ?></td>
                        <td class="p-3 border"><?= $row['date']; ?></td>
                        <td class="p-3 border"><?= $row['time']; ?></td>
                        <td class="p-3 border">
                            <form method="POST" action="" class="inline">
                                <input type="hidden" name="edit_notice">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <button type="submit" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600">Edit</button>
                            </form>
                            <a href="?delete_id=<?= $row['id']; ?>" onclick="return confirm('Are you sure?');" 
                               class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 ml-2">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Display Registered Farmers -->
        <h2 class="text-2xl font-bold text-gray-800 text-center mt-10">Registered Farmers</h2>
        <div class="overflow-x-auto">
            <table class="w-full mt-4 bg-white border rounded-lg shadow-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 border">Name</th>
                        <th class="p-3 border">Address</th>
                        <th class="p-3 border">Society Number</th>
                        <th class="p-3 border">Land Location</th>
                        <th class="p-3 border">Land Size</th>
                        <th class="p-3 border">Cultivated Area</th>
                        <th class="p-3 border">Crop Type</th>
                        <th class="p-3 border">Phone</th>
                        <th class="p-3 border">ID Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($farmer = $result_farmers->fetch_assoc()): ?>
                    <tr class="text-center">
                        <td class="p-3 border"><?= $farmer['name']; ?></td>
                        <td class="p-3 border"><?= $farmer['address']; ?></td>
                        <td class="p-3 border"><?= $farmer['society_number']; ?></td>
                        <td class="p-3 border"><?= $farmer['land_location']; ?></td>
                        <td class="p-3 border"><?= $farmer['land_size']; ?></td>
                        <td class="p-3 border"><?= $farmer['cultivated_area']; ?></td>
                        <td class="p-3 border"><?= $farmer['crop_type']; ?></td>
                        <td class="p-3 border"><?= $farmer['phone']; ?></td>
                        <td class="p-3 border"><?= $farmer['id_number']; ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
