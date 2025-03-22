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

        $sql = "INSERT INTO seed_cultivation (title, description, category)
                VALUES ('$title', '$description', '$category')";
        if ($conn->query($sql)) {
            echo "<p class='text-green-600'>Record added successfully!</p>";
        } else {
            echo "<p class='text-red-600'>Error: " . $conn->error . "</p>";
        }
    }

    // Edit record
    if (isset($_POST["edit"])) {
        $id = $_POST["id"];
        $title = $_POST["title"];
        $description = $_POST["description"];
        $category = $_POST["category"];

        $sql = "UPDATE seed_cultivation
                SET title='$title', description='$description', category='$category'
                WHERE id=$id";
        if ($conn->query($sql)) {
            echo "<p class='text-green-600'>Record updated successfully!</p>";
        } else {
            echo "<p class='text-red-600'>Error: " . $conn->error . "</p>";
        }
    }

    // Delete record
    if (isset($_POST["delete"])) {
        $id = $_POST["id"];

        $sql = "DELETE FROM seed_cultivation WHERE id=$id";
        if ($conn->query($sql)) {
            echo "<p class='text-green-600'>Record deleted successfully!</p>";
        } else {
            echo "<p class='text-red-600'>Error: " . $conn->error . "</p>";
        }
    }
}

// Fetch all records for display
$sql = "SELECT * FROM seed_cultivation";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Seed Cultivation</title>
    <!-- Tailwind CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
        .bg-sidebar { background: #3d68ff; }
        .cta-btn { color: #3d68ff; }
        .upgrade-btn { background: #1947ee; }
        .upgrade-btn:hover { background: #0038fd; }
        .active-nav-link { background: #1947ee; }
        .nav-item:hover { background: #1947ee; }
        .account-link:hover { background: #3d68ff; }
    </style>
</head>
<body class="bg-gray-100 font-family-karla flex">
    <div class="relative w-full flex flex-col h-screen overflow-y-hidden">
        <!-- Main Content -->
        <div class="w-full h-screen overflow-x-hidden border-t flex flex-col">
            <main class="w-full flex-grow p-6">
                <h1 class="w-full text-3xl text-black pb-6">Admin Panel - Seed Cultivation</h1>

                <!-- Add New Record Form -->
                <div class="w-full lg:w-1/2 my-6 pr-0 lg:pr-2">
                    <p class="text-xl pb-6 flex items-center">
                        <i class="fas fa-plus mr-3"></i> Add New Record
                    </p>
                    <div class="leading-loose">
                        <form method="POST" action="" class="p-10 bg-white rounded shadow-xl">
                            <div class="">
                                <label class="block text-sm text-gray-600" for="title">Title</label>
                                <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="title" name="title" type="text" required placeholder="Title">
                            </div>
                            <div class="mt-2">
                                <label class="block text-sm text-gray-600" for="description">Description</label>
                                <textarea class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded" id="description" name="description" rows="6" required placeholder="Description"></textarea>
                            </div>
                            <div class="mt-2">
                                <label class="block text-sm text-gray-600" for="category">Category</label>
                                <select class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="category" name="category" required>
                                    <option value="Seed Selection">Seed Selection</option>
                                    <option value="Soil Preparation">Soil Preparation</option>
                                    <option value="Planting Techniques">Planting Techniques</option>
                                    <option value="Germination Care">Germination Care</option>
                                </select>
                            </div>
                            <div class="mt-6">
                                <button class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded" type="submit" name="add">Add Record</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Display Records -->
                <div class="w-full mt-6">
                    <p class="text-xl pb-6 flex items-center">
                        <i class="fas fa-list mr-3"></i> Manage Records
                    </p>
                    <div class="bg-white rounded shadow-xl">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-600">ID</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-600">Title</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-600">Description</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-600">Category</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm font-semibold text-gray-600">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                                <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>{$row['id']}</td>
                                                <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>{$row['title']}</td>
                                                <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>{$row['description']}</td>
                                                <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>{$row['category']}</td>
                                                <td class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>
                                                    <button class='px-4 py-1 text-white bg-yellow-500 rounded hover:bg-yellow-600' onclick='editRecord({$row['id']}, \"{$row['title']}\", \"{$row['description']}\", \"{$row['category']}\")'>Edit</button>
                                                    <form method='POST' action='' style='display:inline;'>
                                                        <input type='hidden' name='id' value='{$row['id']}'>
                                                        <button type='submit' name='delete' class='px-4 py-1 text-white bg-red-500 rounded hover:bg-red-600'>Delete</button>
                                                    </form>
                                                </td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='px-5 py-5 border-b border-gray-200 bg-white text-sm'>No records found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Edit Record Form (Hidden by Default) -->
                <div class="w-full lg:w-1/2 mt-6 pr-0 lg:pr-2" id="editForm" style="display: none;">
                    <p class="text-xl pb-6 flex items-center">
                        <i class="fas fa-edit mr-3"></i> Edit Record
                    </p>
                    <div class="leading-loose">
                        <form method="POST" action="" class="p-10 bg-white rounded shadow-xl">
                            <input type="hidden" name="id" id="editId">
                            <div class="">
                                <label class="block text-sm text-gray-600" for="editTitle">Title</label>
                                <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="editTitle" name="title" type="text" required placeholder="Title">
                            </div>
                            <div class="mt-2">
                                <label class="block text-sm text-gray-600" for="editDescription">Description</label>
                                <textarea class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded" id="editDescription" name="description" rows="6" required placeholder="Description"></textarea>
                            </div>
                            <div class="mt-2">
                                <label class="block text-sm text-gray-600" for="editCategory">Category</label>
                                <select class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="editCategory" name="category" required>
                                    <option value="Seed Selection">Seed Selection</option>
                                    <option value="Soil Preparation">Soil Preparation</option>
                                    <option value="Planting Techniques">Planting Techniques</option>
                                    <option value="Germination Care">Germination Care</option>
                                </select>
                            </div>
                            <div class="mt-6">
                                <button class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded" type="submit" name="edit">Update Record</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
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

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>