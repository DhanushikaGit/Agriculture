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
    <style>
        /* Market Trends - Custom CSS */

:root {
  --primary-color: #2e7d32;
  --secondary-color: #4caf50;
  --accent-color: #ffc107;
  --light-green: #e8f5e9;
  --dark-green: #1b5e20;
  --gray-light: #f9fafb;
  --gray-medium: #e5e7eb;
  --gray-dark: #6b7280;
  --text-dark: #333333;
  --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
  --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.1);
  --shadow-lg: 0 8px 16px rgba(0, 0, 0, 0.1);
}

body {
  background-color: var(--light-green);
  font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
  color: var(--text-dark);
  line-height: 1.6;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
}

/* Header styling */
h1.text-3xl {
  font-size: 2.5rem;
  font-weight: 700;
  color: var(--primary-color);
  margin-bottom: 2rem;
  position: relative;
  padding-bottom: 1rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

h1.text-3xl::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 80px;
  height: 4px;
  background-color: var(--accent-color);
  border-radius: 2px;
}

/* Search form styling */
form.mb-6 {
  margin-bottom: 2rem;
}

.flex.justify-center {
  display: flex;
  justify-content: center;
  margin-bottom: 2.5rem;
}

input[type="text"] {
  padding: 0.75rem 1rem;
  width: 60%;
  max-width: 500px;
  border: 2px solid var(--gray-medium);
  border-right: none;
  border-radius: 8px 0 0 8px;
  font-size: 1rem;
  transition: all 0.3s ease;
  box-shadow: var(--shadow-sm);
}

input[type="text"]:focus {
  outline: none;
  border-color: var(--primary-color);
  box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.2);
}

button[type="submit"] {
  background-color: var(--primary-color);
  color: white;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 0 8px 8px 0;
  cursor: pointer;
  font-weight: 600;
  box-shadow: var(--shadow-sm);
  transition: all 0.3s ease;
}

button[type="submit"]:hover {
  background-color: var(--dark-green);
  transform: translateY(-2px);
  box-shadow: var(--shadow-md);
}

/* Grid layout */
.grid {
  display: grid;
  gap: 1.5rem;
}

.grid-cols-1 {
  grid-template-columns: repeat(1, minmax(0, 1fr));
}

@media (min-width: 768px) {
  .md\:grid-cols-3 {
    grid-template-columns: repeat(3, minmax(0, 1fr));
  }
}

@media (max-width: 768px) {
  .grid {
    gap: 1rem;
  }
  
  input[type="text"] {
    width: 70%;
  }
}

/* Card styling */
.bg-white {
  background-color: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: var(--shadow-md);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border-top: 4px solid var(--primary-color);
}

.bg-white:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
}

.p-4 {
  padding: 1.5rem;
}

.rounded-lg {
  border-radius: 12px;
}

/* Image styling */
.w-full.h-40 {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 8px;
  margin-bottom: 1rem;
  box-shadow: var(--shadow-sm);
  transition: transform 0.3s ease;
}

.bg-white:hover .w-full.h-40 {
  transform: scale(1.03);
}

/* Text styling */
.text-xl {
  font-size: 1.25rem;
  line-height: 1.75rem;
}

.font-semibold {
  font-weight: 600;
}

h2.text-xl {
  color: var(--primary-color);
  margin-bottom: 0.5rem;
  font-weight: 700;
}

.text-gray-600 {
  color: var(--gray-dark);
  font-size: 0.95rem;
  margin-bottom: 0.5rem;
}

.text-gray-700 {
  color: var(--text-dark);
}

.font-bold {
  font-weight: 700;
}

p.text-gray-700.font-bold {
  color: var(--dark-green);
  font-size: 1.25rem;
  margin: 0.75rem 0;
  padding-bottom: 0.75rem;
  border-bottom: 1px solid var(--gray-medium);
}

p.text-gray-700.mt-2 {
  font-size: 0.95rem;
  line-height: 1.6;
  color: #4b5563;
  margin-top: 0.75rem;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Category badge */
p.text-gray-600::before {
  content: "";
  display: inline-block;
  width: 8px;
  height: 8px;
  background-color: var(--accent-color);
  border-radius: 50%;
  margin-right: 8px;
}

/* Price tag styling */
p.text-gray-700.font-bold::before {
  content: "Price: ";
  font-weight: normal;
  color: var(--gray-dark);
  font-size: 0.9rem;
}

/* No results message */
.no-results {
  text-align: center;
  padding: 2rem;
  background-color: white;
  border-radius: 8px;
  box-shadow: var(--shadow-sm);
  grid-column: 1 / -1;
}

/* Responsive tweaks */
@media (max-width: 640px) {
  h1.text-3xl {
    font-size: 2rem;
  }
  
  .p-4 {
    padding: 1rem;
  }
  
  input[type="text"] {
    width: 65%;
  }
  
  button[type="submit"] {
    padding: 0.75rem 1rem;
  }
}

/* Animation effects */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.bg-white {
  animation: fadeIn 0.5s ease-out forwards;
}

.grid > div:nth-child(1) { animation-delay: 0.1s; }
.grid > div:nth-child(2) { animation-delay: 0.2s; }
.grid > div:nth-child(3) { animation-delay: 0.3s; }
.grid > div:nth-child(4) { animation-delay: 0.4s; }
.grid > div:nth-child(5) { animation-delay: 0.5s; }
.grid > div:nth-child(6) { animation-delay: 0.6s; }
    </style>
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
