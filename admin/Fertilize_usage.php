<?php
// Database connection
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

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new record
    if (isset($_POST["add"])) {
        $title = $_POST["title"];
        $description = $_POST["description"];
        $category = $_POST["category"];

        $sql = "INSERT INTO fertilizer_usage (title, description, category)
                VALUES ('$title', '$description', '$category')";
        if ($conn->query($sql)) {
            echo "<p>Record added successfully!</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }

    // Edit record
    if (isset($_POST["edit"])) {
        $id = $_POST["id"];
        $title = $_POST["title"];
        $description = $_POST["description"];
        $category = $_POST["category"];

        $sql = "UPDATE fertilizer_usage
                SET title='$title', description='$description', category='$category'
                WHERE id=$id";
        if ($conn->query($sql)) {
            echo "<p>Record updated successfully!</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }

    // Delete record
    if (isset($_POST["delete"])) {
        $id = $_POST["id"];

        $sql = "DELETE FROM fertilizer_usage WHERE id=$id";
        if ($conn->query($sql)) {
            echo "<p>Record deleted successfully!</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }
}

// Fetch all records for display
$sql = "SELECT * FROM fertilizer_usage";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Fertilizer Usage</title>
    <link href="../User/assets/img/logoo-Recovered.jpg" rel="icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-container {
            margin-bottom: 20px;
        }
        .form-container input, .form-container select, .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Panel - Fertilizer Usage</h1>

        <!-- Add New Record Form -->
        <div class="form-container">
            <h2>Add New Record</h2>
            <form method="POST" action="">
                <input type="text" name="title" placeholder="Title" required>
                <textarea name="description" placeholder="Description" required></textarea>
                <select name="category" required>
                    <option value="Types of Fertilizers">Types of Fertilizers</option>
                    <option value="Application Timing">Application Timing</option>
                    <option value="Dosage Calculations">Dosage Calculations</option>
                    <option value="Organic Alternatives">Organic Alternatives</option>
                </select>
                <button type="submit" name="add">Add Record</button>
            </form>
        </div>

        <!-- Display Records -->
        <h2>Manage Records</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['title']}</td>
                                <td>{$row['description']}</td>
                                <td>{$row['category']}</td>
                                <td>
                                    <form method='POST' action='' style='display:inline;'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <button type='submit' name='delete'>Delete</button>
                                    </form>
                                    <button onclick='editRecord({$row['id']}, \"{$row['title']}\", \"{$row['description']}\", \"{$row['category']}\")'>Edit</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No records found.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Edit Record Form (Hidden by Default) -->
        <div class="form-container" id="editForm" style="display: none;">
            <h2>Edit Record</h2>
            <form method="POST" action="">
                <input type="hidden" name="id" id="editId">
                <input type="text" name="title" id="editTitle" placeholder="Title" required>
                <textarea name="description" id="editDescription" placeholder="Description" required></textarea>
                <select name="category" id="editCategory" required>
                    <option value="Types of Fertilizers">Types of Fertilizers</option>
                    <option value="Application Timing">Application Timing</option>
                    <option value="Dosage Calculations">Dosage Calculations</option>
                    <option value="Organic Alternatives">Organic Alternatives</option>
                </select>
                <button type="submit" name="edit">Update Record</button>
            </form>
        </div>
    </div>

    <script>
        // Function to populate the edit form
        function editRecord(id, title, description, category) {
            document.getElementById('editId').value = id;
            document.getElementById('editTitle').value = title;
            document.getElementById('editDescription').value = description;
            document.getElementById('editCategory').value = category;
            document.getElementById('editForm').style.display = 'block';
        }
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>