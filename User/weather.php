<?php
include 'C:/xampp/htdocs/The Department of Agriculture Services Website/db_connect.php'; // Include database connection

// Get Search and Filter parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_location = isset($_GET['filter_location']) ? $_GET['filter_location'] : '';

// Build query based on search and filter
$sql = "SELECT * FROM weather_updates WHERE 1=1";

if ($search) {
    $sql .= " AND (location LIKE ? OR conditions LIKE ?)";
}
if ($filter_location) {
    $sql .= " AND location = ?";
}

$sql .= " ORDER BY update_time DESC";

// Prepare statement and execute query
$stmt = $conn->prepare($sql);

if ($search && $filter_location) {
    $search_term = "%" . $search . "%";
    $stmt->bind_param("sss", $search_term, $search_term, $filter_location);
} elseif ($search) {
    $search_term = "%" . $search . "%";
    $stmt->bind_param("ss", $search_term, $search_term);
} elseif ($filter_location) {
    $stmt->bind_param("s", $filter_location);
} else {
    $stmt->execute();
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Weather Updates</title>
  
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
        <h1 class="text-3xl font-bold text-center mb-6">Weather Updates</h1>

        <!-- Search and Filter Form -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <form action="" method="GET">
                <div class="flex mb-4">
                    <!-- Search Field -->
                    <div class="w-1/3 pr-2">
                        <input type="text" name="search" placeholder="Search by Location or Conditions" class="w-full p-2 border rounded-lg" value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <!-- Filter Field -->
                    <div class="w-1/3 pr-2">
                        <select name="filter_location" class="w-full p-2 border rounded-lg">
                            <option value="">All Locations</option>
                            <option value="Location1" <?php echo ($filter_location == 'Location1') ? 'selected' : ''; ?>>Location1</option>
                            <option value="Location2" <?php echo ($filter_location == 'Location2') ? 'selected' : ''; ?>>Location2</option>
                            <option value="Location3" <?php echo ($filter_location == 'Location3') ? 'selected' : ''; ?>>Location3</option>
                            <!-- Add more locations dynamically or manually as needed -->
                        </select>
                    </div>
                    <!-- Submit Button -->
                    <div class="w-1/3">
                        <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg w-full">Search</button>
                    </div>
                </div>
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
                           
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

   
</body>
</html>

