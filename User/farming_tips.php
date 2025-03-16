<?php
include 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php'; // Include database connection

// Check if connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch farming tips from the database
$sql = "SELECT id, title, introduction FROM farming_tips ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farming Tips</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function scrollToDetails(id) {
            let detailSection = document.getElementById('details-' + id);
            detailSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    </script>
    <style>
        /* Farming Tips - Custom CSS Styles */

:root {
  --primary-color: #2e7d32;
  --secondary-color: #4caf50;
  --accent-color: #f9a825;
  --light-green: #e8f5e9;
  --dark-green: #1b5e20;
  --light-brown: #d7ccc8;
  --dark-brown: #5d4037;
  --gray-light: #f9fafb;
  --gray-medium: #e5e7eb;
  --gray-dark: #6b7280;
  --text-dark: #333333;
  --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.05);
  --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
  --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
}

body {
  background: linear-gradient(135deg, var(--light-green), #ffffff);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: var(--text-dark);
  line-height: 1.6;
  padding: 2rem 1rem;
}

.container {
  max-width: 1000px;
  margin: 0 auto;
}

/* Header styling */
h1.text-3xl {
  font-size: 2.25rem;
  font-weight: 800;
  color: var(--dark-green);
  text-align: center;
  margin-bottom: 1.5rem;
  position: relative;
  padding-bottom: 0.75rem;
}

h1.text-3xl::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 120px;
  height: 4px;
  background-color: var(--accent-color);
  border-radius: 4px;
}

/* Featured image */
.mx-auto.mb-4 {
  display: block;
  margin: 0 auto 1.5rem;
  border-radius: 12px;
  box-shadow: var(--shadow-lg);
  max-width: 100%;
  height: auto;
  border: 3px solid white;
  transition: transform 0.3s ease;
}

.mx-auto.mb-4:hover {
  transform: scale(1.02);
}

/* Introduction paragraph */
p.text-gray-700.text-center {
  font-size: 1.1rem;
  line-height: 1.7;
  max-width: 800px;
  margin: 0 auto 2rem;
  color: var(--dark-brown);
  text-align: center;
  background-color: rgba(255, 255, 255, 0.7);
  padding: 1.5rem;
  border-radius: 12px;
  box-shadow: var(--shadow-sm);
  border-left: 4px solid var(--accent-color);
  border-right: 4px solid var(--accent-color);
}

/* Titles list section */
.bg-white {
  background-color: white;
  border-radius: 12px;
  box-shadow: var(--shadow-md);
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.bg-white:hover {
  box-shadow: var(--shadow-lg);
}

.p-4 {
  padding: 1.5rem;
}

.mb-6 {
  margin-bottom: 1.5rem;
}

h2.text-xl {
  font-size: 1.5rem;
  font-weight: 600;
  color: var(--dark-green);
  margin-bottom: 1rem;
  text-align: center;
  padding-bottom: 0.75rem;
  border-bottom: 2px dashed var(--light-green);
}

/* List styling */
ul.list-disc {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

.space-y-2 > * + * {
  margin-top: 0.5rem;
}

ul.list-disc li {
  position: relative;
  padding-left: 2rem;
  padding: 0.75rem 1rem 0.75rem 2rem;
  border-bottom: 1px solid var(--gray-medium);
  transition: background-color 0.2s ease;
}

ul.list-disc li:last-child {
  border-bottom: none;
}

ul.list-disc li:hover {
  background-color: var(--light-green);
}

ul.list-disc li::before {
  content: "🌱";
  position: absolute;
  left: 0.5rem;
  color: var(--secondary-color);
  font-size: 1rem;
}

/* Button styling */
button.text-blue-600 {
  background: none;
  border: none;
  color: var(--dark-green);
  font-weight: 600;
  cursor: pointer;
  font-size: 1.1rem;
  text-align: left;
  padding: 0;
  width: 100%;
  transition: color 0.2s ease;
}

button.text-blue-600:hover {
  color: var(--primary-color);
  text-decoration: underline;
}

/* Details section */
.space-y-6 > * + * {
  margin-top: 1.5rem;
}

#details-section .bg-white {
  border-left: 5px solid var(--primary-color);
  padding: 1.5rem;
}

/* Individual detail items */
div[id^="details-"] {
  opacity: 0;
  transform: translateY(20px);
  animation: fadeIn 0.5s ease forwards;
  border-top: 4px solid var(--primary-color);
}

div[id^="details-"] h2 {
  color: var(--dark-green);
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 1rem;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid var(--gray-medium);
}

div[id^="details-"] p {
  font-size: 1.05rem;
  line-height: 1.7;
  color: var(--text-dark);
}

/* Scrolled to detail highlight effect */
div[id^="details-"]:target {
  box-shadow: 0 0 0 3px var(--accent-color);
  animation: highlight 1.5s ease;
}

/* Animations */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes highlight {
  0% {
    background-color: rgba(249, 168, 37, 0.2);
  }
  100% {
    background-color: white;
  }
}

/* Back to top button */
.back-to-top {
  position: fixed;
  bottom: 30px;
  right: 30px;
  background-color: var(--primary-color);
  color: white;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  box-shadow: var(--shadow-md);
  cursor: pointer;
  opacity: 0;
  transition: opacity 0.3s, transform 0.3s;
  z-index: 100;
}

.back-to-top:hover {
  transform: translateY(-5px);
}

.back-to-top.visible {
  opacity: 1;
}

/* Responsive styles */
@media (max-width: 768px) {
  body {
    padding: 1rem;
  }
  
  h1.text-3xl {
    font-size: 1.8rem;
  }
  
  p.text-gray-700.text-center {
    font-size: 1rem;
    padding: 1rem;
  }
  
  .p-4 {
    padding: 1rem;
  }
  
  button.text-blue-600 {
    font-size: 1rem;
  }
  
  div[id^="details-"] h2 {
    font-size: 1.3rem;
  }
  
  div[id^="details-"] p {
    font-size: 1rem;
  }
}

/* Add a nice print-friendly layout */
@media print {
  body {
    background: white;
    font-size: 12pt;
  }
  
  .container {
    max-width: 100%;
  }
  
  h1.text-3xl {
    font-size: 24pt;
    color: black;
  }
  
  .bg-white {
    box-shadow: none;
    border: 1px solid #ddd;
    break-inside: avoid;
  }
  
  button.text-blue-600 {
    color: black;
    text-decoration: none;
  }
  
  div[id^="details-"] {
    page-break-inside: avoid;
    margin-top: 1cm;
  }
}
    </style>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-center mb-6">Quick and Useful Tips for Successful Farming</h1>
        <img src="image.png" class="mx-auto mb-4 rounded-lg shadow-md" alt="Tips for successful farming" width="500">

        <p class="text-gray-700 text-center mb-6">
            Farming may feel overwhelming at first, especially without proper planning. It's best to start small and learn gradually. 
            Here are five quick and useful farming tips to help you succeed.
        </p>

        <!-- Titles List -->
        <div class="bg-white p-4 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold text-center mb-4">Click on a title to see details</h2>
            <ul class="list-disc list-inside space-y-2">
                <?php 
                $details = [];
                while ($row = $result->fetch_assoc()):
                    $details[] = $row;
                ?>
                    <li>
                        <button class="text-blue-600 hover:underline"
                                onclick="scrollToDetails(<?php echo $row['id']; ?>)">
                            <?php echo htmlspecialchars($row['title']); ?>
                        </button>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Details Section -->
        <div class="space-y-6">
            <?php foreach ($details as $row): ?>
                <div id="details-<?php echo $row['id']; ?>" class="bg-white p-4 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($row['introduction'])); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</body>
</html>

<?php $conn->close(); ?>
