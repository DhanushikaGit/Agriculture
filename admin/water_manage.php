<?php
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = "";     // Replace with your database password
$dbname = "Agriculture_Services_Website";

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
<html>
<head>
    <title>Admin - Water Schedule Management</title>
</head>
<body>
    <h2>Add Water Schedule</h2>
    <form method="post">
        <label>Region:</label>
        <input type="text" name="region" required><br>
        <label>Date:</label>
        <input type="date" name="date" required><br>
        <label>Time:</label>
        <input type="time" name="time" required><br>
        <button type="submit" name="add">Add Schedule</button>
    </form>

    <h2>Water Schedule List</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Region</th>
            <th>Date</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['region']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['time']; ?></td>
            <td>
                <a href="?edit=<?php echo $row['id']; ?>">Edit</a> | 
                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php if (isset($_GET['edit'])): 
        $id = $_GET['edit'];
        $conn = new mysqli($servername, $username, $password, $dbname);
        $result = $conn->query("SELECT * FROM water_schedule WHERE id=$id")->fetch_assoc();
    ?>
    <h2>Edit Water Schedule</h2>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
        <label>Region:</label>
        <input type="text" name="region" value="<?php echo $result['region']; ?>" required><br>
        <label>Date:</label>
        <input type="date" name="date" value="<?php echo $result['date']; ?>" required><br>
        <label>Time:</label>
        <input type="time" name="time" value="<?php echo $result['time']; ?>" required><br>
        <button type="submit" name="update">Update Schedule</button>
    </form>
    <?php endif; ?>
</body>
</html>
