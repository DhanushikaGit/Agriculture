<?php
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "";     // Replace with your database password
$dbname = "Agriculture_Services_Website";
include 'admin_header.php'; 
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add Schedule
if (isset($_POST['add'])) {
    $region = $_POST['region'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "INSERT INTO water_schedule (region, date, time) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $region, $date, $time);

    if ($stmt->execute()) {
        echo "Water schedule added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Update Schedule
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $region = $_POST['region'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "UPDATE water_schedule SET region=?, date=?, time=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $region, $date, $time, $id);

    if ($stmt->execute()) {
        echo "Water schedule updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Delete Schedule
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM water_schedule WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Water schedule deleted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch Schedules
$result = $conn->query("SELECT * FROM water_schedule");

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin - Water Schedule Management</title>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 text-center">Manage Water Schedule</h2>

        <form method="post" class="bg-gray-50 p-4 rounded-lg shadow-md mt-4">
            <label class="block font-medium text-gray-600">Region:</label>
            <input type="text" name="region" class="w-full p-2 border rounded-lg mt-1" required>

            <label class="block font-medium text-gray-600 mt-2">Date:</label>
            <input type="date" name="date" class="w-full p-2 border rounded-lg mt-1" required>

            <label class="block font-medium text-gray-600 mt-2">Time:</label>
            <input type="time" name="time" class="w-full p-2 border rounded-lg mt-1" required>

            <button type="submit" name="add" class="w-full bg-blue-500 text-white p-2 mt-4 rounded-lg hover:bg-blue-600">Add Schedule</button>
        </form>

        <h2 class="text-2xl font-bold text-gray-800 text-center mt-6">Water Schedule List</h2>
        <div class="overflow-x-auto">
            <table class="w-full mt-4 bg-white border rounded-lg shadow-md">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 border">ID</th>
                        <th class="p-3 border">Region</th>
                        <th class="p-3 border">Date</th>
                        <th class="p-3 border">Time</th>
                        <th class="p-3 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="text-center">
                        <td class="p-3 border"><?= $row['id']; ?></td>
                        <td class="p-3 border"><?= $row['region']; ?></td>
                        <td class="p-3 border"><?= $row['date']; ?></td>
                        <td class="p-3 border"><?= $row['time']; ?></td>
                        <td class="p-3 border">
                            <a href="?edit=<?= $row['id']; ?>" class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600">Edit</a>
                            <a href="?delete=<?= $row['id']; ?>" onclick="return confirm('Are you sure?');" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 ml-2">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <?php if (isset($_GET['edit'])): ?>
        <h2 class="text-2xl font-bold text-gray-800 text-center mt-6">Edit Water Schedule</h2>
        <form method="post" class="bg-gray-50 p-4 rounded-lg shadow-md mt-4">
            <input type="hidden" name="id" value="<?= $result['id']; ?>">
            <label class="block font-medium text-gray-600">Region:</label>
            <input type="text" name="region" value="<?= $result['region']; ?>" class="w-full p-2 border rounded-lg mt-1" required>

            <label class="block font-medium text-gray-600 mt-2">Date:</label>
            <input type="date" name="date" value="<?= $result['date']; ?>" class="w-full p-2 border rounded-lg mt-1" required>

            <label class="block font-medium text-gray-600 mt-2">Time:</label>
            <input type="time" name="time" value="<?= $result['time']; ?>" class="w-full p-2 border rounded-lg mt-1" required>

            <button type="submit" name="update" class="w-full bg-green-500 text-white p-2 mt-4 rounded-lg hover:bg-green-600">Update Schedule</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
