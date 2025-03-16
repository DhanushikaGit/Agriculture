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
        /* Agriculture Weather Updates - Enhanced CSS */

/* Main color variables */
:root {
  --primary-green: #2e7d32;
  --light-green: #81c784;
  --medium-green: #4caf50;
  --dark-green: #1b5e20;
  --accent-yellow: #ffc107;
  --light-bg: #f1f8e9;
  --text-dark: #333333;
  --text-light: #ffffff;
  --border-light: #e0e0e0;
  --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
  --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.1);
  --shadow-lg: 0 8px 16px rgba(0, 0, 0, 0.15);
  --radius-sm: 4px;
  --radius-md: 8px;
  --radius-lg: 12px;
}

/* Base styles */
body {
  background: linear-gradient(135deg, var(--light-bg), #ffffff);
  color: var(--text-dark);
  font-family: 'Open Sans', sans-serif;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 15px;
}

/* Header styles */
.text-4xl {
  font-size: 2.25rem;
  line-height: 2.5rem;
  color: var(--primary-green);
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

.text-center {
  text-align: center;
}

/* Form and search area */
.bg-white {
  background-color: #ffffff;
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-md);
  border-top: 4px solid var(--primary-green);
}

.p-6 {
  padding: 1.5rem;
}

.rounded-lg {
  border-radius: var(--radius-md);
}

.shadow-card {
  box-shadow: var(--shadow-md);
}

.mb-6, .mb-8 {
  margin-bottom: 1.5rem;
}

.mb-4 {
  margin-bottom: 1rem;
}

.space-y-4 > * + * {
  margin-top: 1rem;
}

.grid {
  display: grid;
}

.grid-cols-1 {
  grid-template-columns: repeat(1, minmax(0, 1fr));
}

@media (min-width: 768px) {
  .md\:grid-cols-4 {
    grid-template-columns: repeat(4, minmax(0, 1fr));
  }
}

.gap-4 {
  gap: 1rem;
}

/* Form elements styling */
.block {
  display: block;
}

.text-sm {
  font-size: 0.875rem;
}

.font-semibold {
  font-weight: 600;
}

.text-gray-700 {
  color: #4a5568;
}

.mb-1 {
  margin-bottom: 0.25rem;
}

.w-full {
  width: 100%;
}

input[type="text"],
input[type="date"],
select {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid var(--border-light);
  border-radius: var(--radius-sm);
  font-size: 0.95rem;
  transition: all 0.3s ease;
}

input[type="text"]:focus,
input[type="date"]:focus,
select:focus {
  outline: none;
  border-color: var(--medium-green);
  box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
}

.datepicker {
  background-color: #ffffff;
}

/* Button styling */
.flex {
  display: flex;
}

.justify-between {
  justify-content: space-between;
}

.mt-4 {
  margin-top: 1rem;
}

button[type="submit"],
.bg-blue-500 {
  background-color: var(--primary-green);
  color: var(--text-light);
  font-weight: 600;
  padding: 10px 20px;
  border: none;
  border-radius: var(--radius-sm);
  cursor: pointer;
  transition: all 0.3s ease;
}

button[type="submit"]:hover,
.bg-blue-500:hover {
  background-color: var(--dark-green);
  transform: translateY(-2px);
  box-shadow: var(--shadow-sm);
}

.bg-gray-500 {
  background-color: #6b7280;
  color: var(--text-light);
  padding: 10px 20px;
  border: none;
  border-radius: var(--radius-sm);
  cursor: pointer;
  transition: all 0.3s ease;
}

.bg-gray-500:hover {
  background-color: #4b5563;
  transform: translateY(-2px);
  box-shadow: var(--shadow-sm);
}

/* Table styling */
table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
  border-radius: var(--radius-sm);
  overflow: hidden;
  box-shadow: var(--shadow-sm);
}

.min-w-full {
  min-width: 100%;
}

.bg-gray-200 {
  background-color: var(--primary-green);
}

th {
  background-color: var(--primary-green);
  color: var(--text-light);
  font-weight: 600;
  text-align: left;
  padding: 12px 16px;
  text-transform: uppercase;
  font-size: 0.85rem;
  letter-spacing: 0.05em;
}

td {
  padding: 12px 16px;
  border-bottom: 1px solid var(--border-light);
}

tr:last-child td {
  border-bottom: none;
}

.border {
  border-width: 1px;
  border-color: var(--border-light);
}

.hover-highlight:hover {
  background-color: #f9fafb;
  transition: background-color 0.2s ease;
}

/* Text styling within table */
.text-center {
  text-align: center;
}

.font-medium {
  font-weight: 500;
}

.text-blue-600 {
  color: #2563eb;
}

.font-bold {
  font-weight: 700;
}

/* Weather-specific styling */
.temperature-cold {
  color: #0ea5e9; /* Light blue for cold */
}

.temperature-mild {
  color: #16a34a; /* Green for mild */
}

.temperature-warm {
  color: #f59e0b; /* Yellow/orange for warm */
}

.temperature-hot {
  color: #dc2626; /* Red for hot */
}

/* Download link styling */
a.text-blue-500 {
  color: var(--primary-green);
  text-decoration: none;
  font-weight: 500;
  transition: color 0.2s ease;
  display: inline-flex;
  align-items: center;
}

a.text-blue-500:hover {
  color: var(--dark-green);
  text-decoration: underline;
}

a.text-blue-500::before {
  content: "\f019"; /* Download icon in FontAwesome */
  font-family: "bootstrap-icons";
  margin-right: 5px;
}

.text-gray-500 {
  color: #6b7280;
}

/* Pagination styling */
.pagination {
  display: flex;
  justify-content: center;
  margin-top: 2rem;
  gap: 0.5rem;
}

.pagination a {
  padding: 8px 12px;
  background-color: #ffffff;
  border: 1px solid var(--border-light);
  color: var(--text-dark);
  border-radius: var(--radius-sm);
  text-decoration: none;
  transition: all 0.2s ease;
}

.pagination a.active,
.pagination a:hover {
  background-color: var(--primary-green);
  color: var(--text-light);
  border-color: var(--primary-green);
}

/* Responsive table */
@media screen and (max-width: 768px) {
  .overflow-x-auto {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }
  
  table {
    min-width: 800px;
  }
}

/* Weather icons styling */
.weather-icon {
  font-size: 1.5rem;
  margin-right: 0.5rem;
  vertical-align: middle;
}

.sunny { color: #fbbf24; }
.cloudy { color: #9ca3af; }
.rainy { color: #60a5fa; }
.stormy { color: #6366f1; }
.snowy { color: #e5e7eb; }

/* Enhancement for filter result info */
.results-info {
  background-color: rgba(46, 125, 50, 0.1);
  border-left: 4px solid var(--primary-green);
  padding: 10px 16px;
  border-radius: var(--radius-sm);
  font-size: 0.9rem;
  margin-bottom: 1rem;
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
