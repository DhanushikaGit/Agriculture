<?php
include 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php'; 


// Ensure that the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for adding farming tips
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_tip'])) {
    $title = $_POST['title'];
    $introduction = $_POST['introduction'];
    
    // Use prepared statement to insert data securely
    $stmt = $conn->prepare("INSERT INTO farming_tips (title, introduction) VALUES (?, ?)");
    $stmt->bind_param("ss", $title, $introduction);

    if ($stmt->execute()) {
        $success_message = "Farming tip added successfully!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Handle editing of farming tips
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_tip'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $introduction = $_POST['introduction'];

    // Update query with prepared statement
    $stmt = $conn->prepare("UPDATE farming_tips SET title=?, introduction=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $introduction, $id);
    
    if ($stmt->execute()) {
        $success_message = "Farming tip updated successfully!";
    } else {
        $error_message = "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

// Handle deletion of farming tips
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_tip'])) {
    $delete_id = $_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM farming_tips WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        $success_message = "Farming tip deleted successfully!";
    } else {
        $error_message = "Error deleting record: " . $stmt->error;
    }

    $stmt->close();
}

// Fetch farming tips from the database
$sql = "SELECT id, title, introduction FROM farming_tips";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Farming Tips</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function editTip(id, title, introduction) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_introduction').value = introduction;
            document.getElementById('editForm').style.display = 'block';
        }
    </script>
    <?php include 'admin_header.php'; ?>
</head>
<body class="bg-gray-100">
    
    <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
        <main class="w-full flex-grow p-6">
            <h1 class="text-3xl text-black pb-6">Manage Farming Tips</h1>

            <!-- Add Farming Tip Form -->
            <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h2 class="text-2xl font-bold mb-4">Add New Farming Tip</h2>
                <form action="farming_tips.php" method="POST">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                        <input type="text" id="title" name="title" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div class="mb-4">
                        <label for="introduction" class="block text-gray-700 text-sm font-bold mb-2">Introduction</label>
                        <textarea id="introduction" name="introduction" class="w-full px-3 py-2 border rounded-lg" required></textarea>
                    </div>
                    <button type="submit" name="add_tip" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Add Tip</button>
                </form>
            </div>

            <!-- Edit Farming Tip Form -->
            <div id="editForm" class="bg-white p-6 rounded-lg shadow-md mb-6" style="display:none;">
                <h2 class="text-2xl font-bold mb-4">Edit Farming Tip</h2>
                <form action="farming_tips.php" method="POST">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-4">
                        <label for="edit_title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                        <input type="text" id="edit_title" name="title" class="w-full px-3 py-2 border rounded-lg" required>
                    </div>
                    <div class="mb-4">
                        <label for="edit_introduction" class="block text-gray-700 text-sm font-bold mb-2">Introduction</label>
                        <textarea id="edit_introduction" name="introduction" class="w-full px-3 py-2 border rounded-lg" required></textarea>
                    </div>
                    <button type="submit" name="edit_tip" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Update Tip</button>
                </form>
            </div>

            <!-- Display Farming Tips in a Table -->
            <div class="bg-white overflow-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">Title</th>
                            <th class="w-3/4 text-left py-3 px-4 uppercase font-semibold text-sm">Introduction</th>
                            <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="w-1/4 text-left py-3 px-4"><?php echo $row['title']; ?></td>
                                <td class="w-3/4 text-left py-3 px-4"><?php echo $row['introduction']; ?></td>
                                <td class="w-1/4 text-left py-3 px-4">
                                    <button onclick="editTip(<?php echo $row['id']; ?>, '<?php echo addslashes($row['title']); ?>', '<?php echo addslashes($row['introduction']); ?>')" class="text-blue-500 hover:text-blue-700">Edit</button>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="delete_tip" class="text-red-500 hover:text-red-700">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>

<?php
$conn->close();
?>
