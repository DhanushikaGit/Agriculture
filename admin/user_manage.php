<?php
// Database connection
$servername = "localhost";
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "Agriculture_Services_Website"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Sanitize the input
    $delete_sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    if ($stmt) {
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            echo "<p style='color: green;'>User deleted successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error deleting user: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color: red;'>Error preparing statement: " . $conn->error . "</p>";
    }
}

// SQL query to select all users from the correct table
$sql = "SELECT * FROM users"; // Replace 'users' with the correct table name if different
$result = $conn->query($sql);

// Check if the query was successful
if (!$result) {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file if needed -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        thead {
            background-color: #007BFF;
            color: #fff;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            font-size: 16px;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td {
            font-size: 14px;
            color: #333;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .delete-button {
            color: white;
            background-color: red;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .delete-button:hover {
            background-color: darkred;
        }

        .edit-button {
            color: white;
            background-color: #28a745;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .edit-button:hover {
            background-color: #218838;
        }

        .no-users {
            text-align: center;
            color: #666;
            font-size: 16px;
            padding: 20px;
        }
    </style>
</head>
<body>

    <h1>User List</h1>
    
    <!-- Table to display users' data -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Registration Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are any results
            if ($result->num_rows > 0) {
                // Output data for each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["password"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["reg_date"]) . "</td>";
                    echo "<td class='actions'>
                           
                            <a href='?delete_id=" . $row["id"] . "' class='delete-button' onclick='return confirm(\"Are you sure you want to delete this user?\");'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='no-users'>No users found</td></tr>";
            }

            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>
    
</body>
</html>
</html>