<?php
include 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php'; 
include 'admin_header.php'; // Include database connection

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST["category"];
    $title = $_POST["title"];
    $content = $_POST["content"];

    $filePath = "";
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        // Handle file upload
        $fileTmpName = $_FILES["file"]["tmp_name"];
        $fileName = basename($_FILES["file"]["name"]);
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'];

        // Check if file extension is allowed
        if (in_array(strtolower($fileExt), $allowedExts)) {
            // Generate a unique name to avoid filename conflicts
            $newFileName = uniqid() . "." . $fileExt;
            $uploadDir = "C:/xampp/htdocs/The Department of Agriculture Services Website/uploads/";
            $filePath = $uploadDir . $newFileName;

            // Move the uploaded file to the desired directory
            if (!move_uploaded_file($fileTmpName, $filePath)) {
                echo "Failed to move uploaded file.";
                exit;
            }
        } else {
            echo "Invalid file type. Only JPG, PNG, GIF, PDF, DOC, and DOCX are allowed.";
            exit;
        }
    }

    if (isset($_POST["id"]) && !empty($_POST["id"])) {
        // Update existing guide
        $id = $_POST["id"];
        $sql = "UPDATE farming_guides SET category=?, title=?, content=?, file_path=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $category, $title, $content, $filePath, $id);
    } else {
        // Insert new guide
        $sql = "INSERT INTO farming_guides (category, title, content, file_path) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $category, $title, $content, $filePath);
    }

    if ($stmt->execute()) {
        header("Location: Guides.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Delete Guide
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM farming_guides WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: Guides.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch All Guides
$sql = "SELECT * FROM farming_guides ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Farming Guides</title>
 
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-center mb-6">Manage Farming Guides</h1>

        <!-- Add / Edit Guide Form -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4">Add / Edit Farming Guide</h2>
            <form action="" method="POST" id="guideForm" enctype="multipart/form-data">
                <input type="hidden" name="id" id="guide_id">

                <label class="block mb-2">Category</label>
                <select name="category" id="category" class="w-full p-2 border rounded-lg mb-2">
                    <option value="Soil Preparation">Soil Preparation</option>
                    <option value="Crop Rotation">Crop Rotation</option>
                    <option value="Organic Farming">Organic Farming</option>
                    <option value="Water Management">Water Management</option>
                    <option value="Pest Control">Pest Control</option>
                </select>

                <label class="block mb-2">Title</label>
                <input type="text" name="title" id="title" class="w-full p-2 border rounded-lg mb-2" required>

                <label class="block mb-2">Content</label>
                <textarea name="content" id="content" class="w-full p-2 border rounded-lg mb-2" rows="4" required></textarea>

                <label class="block mb-2">Upload File (optional)</label>
                <input type="file" name="file" id="file" class="w-full p-2 border rounded-lg mb-2">

                <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg">Save Guide</button>
            </form>
        </div>

        <!-- Display Guides in Table -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Farming Guides List</h2>
            
            <!-- PDF Download Button -->
           

            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">ID</th>
                        <th class="border p-2">Category</th>
                        <th class="border p-2">Title</th>
                        <th class="border p-2">Content</th>
                        <th class="border p-2">File</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="border">
                            <td class="border p-2 text-center"><?php echo $row['id']; ?></td>
                            <td class="border p-2"><?php echo htmlspecialchars($row['category']); ?></td>
                            <td class="border p-2"><?php echo htmlspecialchars($row['title']); ?></td>
                            <td class="border p-2"><?php echo nl2br(htmlspecialchars($row['content'])); ?></td>
                            <td class="border p-2">
                                <?php if (!empty($row['file_path'])): ?>
                                    <a href="/The Department of Agriculture Services Website/uploads/<?php echo basename($row['file_path']); ?>" target="_blank" class="text-blue-500">Download File</a>

                                <?php else: ?>
                                    No file uploaded
                                <?php endif; ?>
                            </td>
                            <td class="border p-2 text-center">
                                <button onclick="editGuide(<?php echo $row['id']; ?>, '<?php echo addslashes($row['category']); ?>', '<?php echo addslashes($row['title']); ?>', '<?php echo addslashes($row['content']); ?>')" class="bg-yellow-500 text-white p-2 rounded">Edit</button>
                                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="bg-red-500 text-white p-2 rounded">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function editGuide(id, category, title, content) {
            document.getElementById("guide_id").value = id;
            document.getElementById("category").value = category;
            document.getElementById("title").value = title;
            document.getElementById("content").value = content;
        }
    </script>

</body>
</html>

<?php $conn->close(); ?>