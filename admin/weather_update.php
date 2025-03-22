<?php
include 'C:/xampp/htdocs/The Department of Agriculture Services Website/db_connect.php'; 
include 'admin_header.php'; // Include database connection

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = $_POST["location"];
    $temperature = $_POST["temperature"];
    $conditions = $_POST["conditions"];

    $filePath = "";
    if (isset($_FILES["pdf"]) && $_FILES["pdf"]["error"] == 0) {
        // Handle file upload
        $fileTmpName = $_FILES["pdf"]["tmp_name"];
        $fileName = basename($_FILES["pdf"]["name"]);
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        // Check if PDF is uploaded
        if (strtolower($fileExt) == 'pdf') {
            $newFileName = uniqid() . ".pdf";
            $uploadDir = "C:/xampp/htdocs/The Department of Agriculture Services Website/uploads/";
            $filePath = $uploadDir . $newFileName;

            // Move the uploaded PDF to the desired directory
            if (!move_uploaded_file($fileTmpName, $filePath)) {
                echo "Failed to move uploaded file.";
                exit;
            }
        } else {
            echo "Invalid file type. Only PDF is allowed.";
            exit;
        }
    }

    if (isset($_POST["id"]) && !empty($_POST["id"])) {
        // Update existing weather update
        $id = $_POST["id"];
        $sql = "UPDATE weather_updates SET location=?, temperature=?, conditions=?, pdf_path=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $location, $temperature, $conditions, $filePath, $id);
    } else {
        // Insert new weather update
        $sql = "INSERT INTO weather_updates (location, temperature, conditions, pdf_path) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $location, $temperature, $conditions, $filePath);
    }

    if ($stmt->execute()) {
        header("Location: weather_update.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Delete Weather Update
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM weather_updates WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: weather_update.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch Weather Updates
$sql = "SELECT * FROM weather_updates ORDER BY update_time DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Weather Updates</title>
    <?php include 'header.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 1200px;
            margin: auto;
        }
    </style>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-center mb-6">Manage Weather Updates</h1>

        <!-- Add / Edit Weather Update Form -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4">Add / Edit Weather Update</h2>
            <form action="" method="POST" id="weatherForm" enctype="multipart/form-data">
                <input type="hidden" name="id" id="weather_id">

                <label class="block mb-2">Location</label>
                <input type="text" name="location" id="location" class="w-full p-2 border rounded-lg mb-2" required>

                <label class="block mb-2">Temperature</label>
                <input type="text" name="temperature" id="temperature" class="w-full p-2 border rounded-lg mb-2" required>

                <label class="block mb-2">Conditions</label>
                <textarea name="conditions" id="conditions" class="w-full p-2 border rounded-lg mb-2" rows="4" required></textarea>

                <label class="block mb-2">Upload PDF (optional)</label>
                <input type="file" name="pdf" id="pdf" class="w-full p-2 border rounded-lg mb-2">

                <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg">Save Update</button>
            </form>
        </div>

        <!-- Display Weather Updates in Table -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Weather Updates List</h2>
            
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">ID</th>
                        <th class="border p-2">Location</th>
                        <th class="border p-2">Temperature</th>
                        <th class="border p-2">Conditions</th>
                        <th class="border p-2">File</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="border">
                            <td class="border p-2 text-center"><?php echo $row['id']; ?></td>
                            <td class="border p-2"><?php echo htmlspecialchars($row['location']); ?></td>
                            <td class="border p-2"><?php echo htmlspecialchars($row['temperature']); ?></td>
                            <td class="border p-2"><?php echo nl2br(htmlspecialchars($row['conditions'])); ?></td>
                            <td class="border p-2">
                                <?php if (!empty($row['pdf_path'])): ?>
                                    <a href="/The Department of Agriculture Services Website/uploads/<?php echo basename($row['pdf_path']); ?>" target="_blank" class="text-blue-500">Download PDF</a>
                                <?php else: ?>
                                    No PDF uploaded
                                <?php endif; ?>
                            </td>
                            <td class="border p-2 text-center">
                                <button onclick="editWeatherUpdate(<?php echo $row['id']; ?>, '<?php echo addslashes($row['location']); ?>', '<?php echo addslashes($row['temperature']); ?>', '<?php echo addslashes($row['conditions']); ?>')" class="bg-yellow-500 text-white p-2 rounded">Edit</button>
                                <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="bg-red-500 text-white p-2 rounded">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Edit weather update function to populate the form with data
        function editWeatherUpdate(id, location, temperature, conditions) {
            document.getElementById("weather_id").value = id;
            document.getElementById("location").value = location;
            document.getElementById("temperature").value = temperature;
            document.getElementById("conditions").value = conditions;
        }
    </script>

</body>
</html>

<?php $conn->close(); ?>
