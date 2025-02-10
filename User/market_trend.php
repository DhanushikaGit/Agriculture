<?php
include '../db_connect.php'; // Database connection

// Search functionality
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM market_trends WHERE product_name LIKE ? OR category LIKE ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $searchParam = "%$search%";
    $stmt->bind_param("ss", $searchParam, $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM market_trends ORDER BY created_at DESC";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Trends</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-center mb-6">Market Trends</h1>
        
        <!-- Search Form -->
        <form method="GET" action="" class="mb-6 flex justify-center">
            <input type="text" name="search" placeholder="Search by product or category" 
                   class="p-2 border rounded-l-lg w-1/2" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="bg-blue-500 text-white p-2 rounded-r-lg">Search</button>
        </form>

        <!-- Display Market Trends -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <img src="../<?php echo $row['image_path']; ?>" alt="Market Trend Image" class="w-full h-40 object-cover rounded-lg mb-4">
                    <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($row['product_name']); ?></h2>
                    <p class="text-gray-600">Category: <?php echo htmlspecialchars($row['category']); ?></p>
                    <p class="text-gray-700 font-bold">LKR <?php echo number_format($row['price'], 2); ?></p>
                    <p class="text-gray-700 mt-2"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
