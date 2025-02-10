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
