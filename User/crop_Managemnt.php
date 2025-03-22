<?php
include 'C:/xampp/htdocs/The Department of Agriculture Services Website/db_connect.php'; // Database connection file

// First, get all unique categories
$categorySql = "SELECT DISTINCT category FROM crop_management ORDER BY category";
$categoryResult = $conn->query($categorySql);

if (!$categoryResult) {
    die("Error fetching categories: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop Management</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <?php
    // Include the header file
    $headerPath = 'C:/xampp/htdocs/The Department of Agriculture Services Website/User/header.php';
    if (file_exists($headerPath)) {
        include $headerPath;
    } else {
        echo "<p style='color: red; text-align: center;'>Header file not found.</p>";
    }
    ?>

    <div class="container mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold text-center mb-8">Crop Management</h1>

        <?php if ($categoryResult->num_rows > 0): ?>
            <?php while ($categoryRow = $categoryResult->fetch_assoc()): 
                $currentCategory = $categoryRow['category'];
                
                // Fetch all records for this category
                $cropSql = "SELECT * FROM crop_management WHERE category = ? ORDER BY id DESC";
                $stmt = $conn->prepare($cropSql);
                $stmt->bind_param("s", $currentCategory);
                $stmt->execute();
                $cropResult = $stmt->get_result();
            ?>
                <div class="mb-10">
                    <h2 class="text-2xl font-bold text-green-700 mb-4 pb-2 border-b-2 border-green-500">
                        <?php echo htmlspecialchars($currentCategory); ?>
                    </h2>
                    
                    <?php if ($cropResult->num_rows > 0): ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php while ($crop = $cropResult->fetch_assoc()): ?>
                                <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4 hover:shadow-lg transition duration-300">
                                    <h3 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($crop['title']); ?></h3>
                                    <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($crop['description']); ?></p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-center text-gray-500">No crops found in this category.</p>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center text-gray-500">No categories found.</p>
        <?php endif; ?>
    </div>

    <?php
    // Include the footer file
    $footerPath = 'C:/xampp/htdocs/The Department of Agriculture Services Website/User/footer.php';
    if (file_exists($footerPath)) {
        include $footerPath;
    } else {
        echo "<p style='color: red; text-align: center;'>Footer file not found.</p>";
    }
    ?>
</body>

</html>

<?php 
// Close the database connection
$conn->close(); 
?>