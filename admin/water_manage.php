<?php
include('C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php'); // Database connection file

// Fetch updates from database
$sql = "SELECT * FROM updates ORDER BY created_at DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Manage Updates</title>
</head>
<body>
    <h2>Welcome, Admin</h2>
    <a href="add_update.php">Add New Update</a> |
    <a href="manage_requests.php">Manage Requests</a>
    <h3>Recent Updates</h3>
    <table border="1">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td>
                <a href="edit_update.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete_update.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
