<?php
include 'C:/xampp/htdocs/The Department of Agriculture Services Website/db_connect.php'; // Database connection file

// Fetch all records from the agricultural_technology table
$sql = "SELECT * FROM agricultural_technology ORDER BY id DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching agricultural technology records: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agricultural Technology</title>
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
        <h1 class="text-3xl font-bold text-center mb-6">Agricultural Technology</h1>

        <?php if ($result->num_rows > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="bg-white border border-gray-200 rounded-lg shadow-md p-4">
                        <h2 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($row['title']); ?></h2>
                        <p class="text-gray-700 mb-4"><?php echo htmlspecialchars($row['description']); ?></p>
                        <span class="inline-block bg-blue-500 text-white text-sm px-3 py-1 rounded">
                            <?php echo htmlspecialchars($row['category']); ?>
                        </span>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-500">No agricultural technology records found.</p>
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