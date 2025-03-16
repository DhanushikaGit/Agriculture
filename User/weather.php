<?php
include 'C:/xampp/htdocs/The Department of Agriculture Services Website/db_connect.php';

// Pagination settings
$results_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $results_per_page;

// Get Search and Filter parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_location = isset($_GET['filter_location']) ? $_GET['filter_location'] : '';
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';

// Build query based on search and filter
$sql = "SELECT * FROM weather_updates WHERE 1=1";
$count_sql = "SELECT COUNT(*) as total FROM weather_updates WHERE 1=1";
$params = [];
$types = "";

if ($search) {
    $sql .= " AND (location LIKE ? OR conditions LIKE ?)";
    $count_sql .= " AND (location LIKE ? OR conditions LIKE ?)";
    $search_term = "%$search%";
    $params[] = $search_term;
    $params[] = $search_term;
    $types .= "ss";
}

if ($filter_location) {
    $sql .= " AND location = ?";
    $count_sql .= " AND location = ?";
    $params[] = $filter_location;
    $types .= "s";
}

if ($date_from && $date_to) {
    $sql .= " AND update_time BETWEEN ? AND ?";
    $count_sql .= " AND update_time BETWEEN ? AND ?";
    $params[] = $date_from;
    $params[] = $date_to;
    $types .= "ss";
}

// Get total records for pagination
$count_stmt = $conn->prepare($count_sql);
if (!empty($params)) {
    $count_stmt->bind_param($types, ...$params);
}
$count_stmt->execute();
$total_records = $count_stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_records / $results_per_page);

// Add pagination to main query
$sql .= " ORDER BY update_time DESC LIMIT ? OFFSET ?";
$params[] = $results_per_page;
$params[] = $offset;
$types .= "ii";

// Prepare and execute main query
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Get unique locations for filter dropdown
$locations_sql = "SELECT DISTINCT location FROM weather_updates ORDER BY location";
$locations_result = $conn->query($locations_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>


 <!-- Fonts -->
 <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Marcellus:wght@400&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Weather Updates</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
        }
        .shadow-card {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .hover-highlight:hover {
            background-color: #f9fafb;
          
        }
    </style>
</head>
<body class="bg-gray-100 p-6">
<?php include 'header.php'; ?>
    <div class="container mx-auto">
        <h1 class="text-4xl font-extrabold text-center text-gray-800 mb-8">Weather Updates</h1>

     

        <div class="bg-white p-6 rounded-lg shadow-card mb-6">
            <form action="" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" placeholder="Search by Location or Conditions" 
                               class="w-full p-3 border rounded-lg focus:ring focus:ring-blue-300" 
                               value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Location</label>
                        <select name="filter_location" class="w-full p-3 border rounded-lg focus:ring focus:ring-blue-300">
                            <option value="">All Locations</option>
                            <?php while ($location = $locations_result->fetch_assoc()): ?>
                                <option value="<?php echo htmlspecialchars($location['location']); ?>"
                                        <?php echo ($filter_location == $location['location']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($location['location']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">From Date</label>
                        <input type="date" name="date_from" class="w-full p-3 border rounded-lg datepicker focus:ring focus:ring-blue-300" 
                               value="<?php echo htmlspecialchars($date_from); ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">To Date</label>
                        <input type="date" name="date_to" class="w-full p-3 border rounded-lg datepicker focus:ring focus:ring-blue-300" 
                               value="<?php echo htmlspecialchars($date_to); ?>">
                    </div>
                </div>
                <div class="flex justify-between mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-5 py-2 rounded-lg hover:bg-blue-600 transition">Search</button>
                    <a href="?" class="bg-gray-500 text-white px-5 py-2 rounded-lg hover:bg-gray-600 transition">Reset Filters</a>
                </div>
            </form>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-card mb-4 text-gray-700">
            <p>Showing <?php echo min($results_per_page, $total_records); ?> of <?php echo $total_records; ?> results</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-card">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700 text-lg">
                            <th class="border p-3">ID</th>
                            <th class="border p-3">Location</th>
                            <th class="border p-3">Temperature</th>
                            <th class="border p-3">Conditions</th>
                            <th class="border p-3">Last Updated</th>
                            <th class="border p-3">File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="border hover-highlight">
                                <td class="border p-3 text-center"><?php echo $row['id']; ?></td>
                                <td class="border p-3 font-medium"><?php echo htmlspecialchars($row['location']); ?></td>
                                <td class="border p-3 text-blue-600 font-bold"><?php echo htmlspecialchars($row['temperature']); ?>°C</td>
                                <td class="border p-3 text-gray-700"><?php echo nl2br(htmlspecialchars($row['conditions'])); ?></td>
                                <td class="border p-3 text-gray-600">
                                    <?php echo date('Y-m-d H:i', strtotime($row['update_time'])); ?>
                                </td>
                                <td class="border p-3">
                                    <?php if (!empty($row['pdf_path'])): ?>
                                        <a href="/The Department of Agriculture Services Website/uploads/<?php echo basename($row['pdf_path']); ?>" 
                                           target="_blank" 
                                           class="text-blue-500 hover:text-blue-700">
                                            Download
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-500">No file</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            allowInput: true
        });
    </script>
</body>
</html>
