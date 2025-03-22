<?php
include '../db_connect.php'; // Database connection
include 'admin_header.php'; 

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST["category"];
    $product_name = $_POST["product_name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $id = isset($_POST["id"]) ? $_POST["id"] : null; // Get the id if editing

    $uploadDir = "../uploads/";

    // Ensure the upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $imagePath = "";
    if (!empty($_FILES["image"]["name"])) {
        $fileTmpName = $_FILES["image"]["tmp_name"];
        $fileName = basename($_FILES["image"]["name"]);
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array(strtolower($fileExt), $allowedExts)) {
            $newFileName = uniqid() . "." . $fileExt;
            $imagePath = "uploads/" . $newFileName; // Store relative path
            $uploadPath = $uploadDir . $newFileName;

            if (!move_uploaded_file($fileTmpName, $uploadPath)) {
                echo "Failed to upload image.";
                exit;
            }
        } else {
            echo "Invalid file type. Only JPG, PNG, and GIF are allowed.";
            exit;
        }
    }

    // Update or Insert based on whether $id is set (edit or add new)
    if ($id) {
        $sql = "UPDATE market_trends SET category=?, product_name=?, price=?, description=?, image_path=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdssi", $category, $product_name, $price, $description, $imagePath, $id);
    } else {
        $sql = "INSERT INTO market_trends (category, product_name, price, description, image_path) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdss", $category, $product_name, $price, $description, $imagePath);
    }

    if ($stmt->execute()) {
        header("Location: market_trend.php?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Delete Market Trend
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM market_trends WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: market_trend.php?delete_success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch Market Trends
$sql = "SELECT * FROM market_trends ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Market Trends</title>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <?php include 'header.php'; ?>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-center mb-6">Manage Market Trends</h1>

        <!-- Add / Edit Market Trend Form -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4">Add / Edit Market Trend</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="trend_id" value=""> <!-- Hidden ID for editing -->
                <label class="block mb-2">Category</label>
                <select name="category" class="w-full p-2 border rounded-lg mb-2" required>
                    <option value="Vegetables">Vegetables</option>
                    <option value="Fruits">Fruits</option>
                    <option value="Grains">Grains</option>
                    <option value="Dairy">Dairy</option>
                </select>

                <label class="block mb-2">Product Name</label>
                <input type="text" name="product_name" class="w-full p-2 border rounded-lg mb-2" required>

                <label class="block mb-2">Price (LKR)</label>
                <input type="number" name="price" step="0.01" class="w-full p-2 border rounded-lg mb-2" required>

                <label class="block mb-2">Description</label>
                <textarea name="description" class="w-full p-2 border rounded-lg mb-2" rows="4" required></textarea>

                <label class="block mb-2">Upload Image</label>
                <input type="file" name="image" class="w-full p-2 border rounded-lg mb-2">

                <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg">Save Trend</button>
            </form>
        </div>

        <!-- Display Market Trends -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Market Trends</h2>
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Category</th>
                        <th class="border p-2">Product Name</th>
                        <th class="border p-2">Price (LKR)</th>
                        <th class="border p-2">Description</th>
                        <th class="border p-2">Image</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="border">
                            <td class="border p-2"><?php echo htmlspecialchars($row['category']); ?></td>
                            <td class="border p-2"><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td class="border p-2">LKR <?php echo number_format($row['price'], 2); ?></td>
                            <td class="border p-2"><?php echo nl2br(htmlspecialchars($row['description'])); ?></td>
                            <td class="border p-2">
                                <?php if ($row['image_path']): ?>
                                    <img src="../<?php echo $row['image_path']; ?>" alt="Market Trend Image" class="w-20 h-20 object-cover">
                                <?php else: ?>
                                    No Image
                                <?php endif; ?>
                            </td>
                            <td class="border p-2">
                                <button onclick="editTrend(<?php echo $row['id']; ?>, '<?php echo addslashes($row['category']); ?>', '<?php echo addslashes($row['product_name']); ?>', <?php echo $row['price']; ?>, '<?php echo addslashes($row['description']); ?>')" class="bg-yellow-500 text-white p-2 rounded">Edit</button>
                                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="bg-red-500 text-white p-2 rounded">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function editTrend(id, category, product_name, price, description) {
            document.getElementById("trend_id").value = id;
            document.querySelector("select[name='category']").value = category;
            document.querySelector("input[name='product_name']").value = product_name;
            document.querySelector("input[name='price']").value = price;
            document.querySelector("textarea[name='description']").value = description;
        }
    </script>

</body>
</html>

<?php $conn->close(); ?>
