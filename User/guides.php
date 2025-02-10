<?php
include 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Predefined categories with images
$categories = [
    "Vision" => ["vision1.jpg", "vision2.jpg", "vision3.jpg", "vision4.jpg"],
    "Mission" => ["mission1.jpg", "mission2.jpg", "mission3.jpg", "mission4.jpg"],
    "Objectives" => ["obj1.jpg", "obj2.jpg", "obj3.jpg", "obj4.jpg"]
];

// Create structured content for each section
$guides = [
    "Vision" => [
        [
            'title' => 'Our Vision',
            'content' => 'To create a prosperous province with a satisfied and prosperous farming community.',
            'file_path' => ''
        ]
    ],
    "Mission" => [
        [
            'title' => 'Our Mission',
            'content' => 'To develop food security, environmentally friendly agriculture, commercial agriculture and agribusiness through the use of new appropriate agricultural technology and agricultural infrastructure, with the full cooperation and transparency of all stakeholders.',
            'file_path' => ''
        ]
    ],
    "Objectives" => [
        [
            'title' => 'Our Key Objectives',
            'content' => "• Popularizing new and appropriate agricultural technology in the North Central Province.\n
• Promoting the production of quality seeds and planting materials. Creating food security.\n
• Promoting environmentally friendly agriculture.\n
• Promoting commercial agriculture and agribusiness.",
            'file_path' => ''
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Department of Agriculture</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
        function scrollToCategory(category) {
            let categorySection = document.getElementById('category-' + category.replace(/\s+/g, ''));
            categorySection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    </script>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-center mb-6 text-green-800">About The Department of Agriculture</h1>

        <!-- Category Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <?php foreach ($categories as $category => $images): ?>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold text-center mb-2 text-green-700"><?php echo htmlspecialchars($category); ?></h2>
                    <div class="grid grid-cols-2 gap-2">
                        <?php foreach ($images as $image): ?>
                            <img src="images/<?php echo $image; ?>" class="w-full h-24 object-cover rounded-lg shadow-sm" alt="<?php echo htmlspecialchars($category); ?>">
                        <?php endforeach; ?>
                    </div>
                    <button onclick="scrollToCategory('<?php echo addslashes($category); ?>')" 
                            class="mt-2 bg-green-600 hover:bg-green-700 text-white w-full py-2 rounded-lg transition duration-300">
                        View Details
                    </button>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Detailed Sections -->
        <?php foreach ($categories as $category => $images): ?>
            <div id="category-<?php echo str_replace(' ', '', htmlspecialchars($category)); ?>" 
                 class="bg-white p-6 rounded-lg shadow-md mb-6">
                <h2 class="text-2xl font-semibold text-center mb-4 text-green-800"><?php echo htmlspecialchars($category); ?></h2>
                <div class="space-y-4">
                    <?php if (!empty($guides[$category])): ?>
                        <?php foreach ($guides[$category] as $guide): ?>
                            <div class="p-4 border rounded-lg">
                                <h3 class="text-lg font-semibold mb-2 text-green-700"><?php echo htmlspecialchars($guide['title']); ?></h3>
                                <p class="text-gray-700 mb-2"><?php echo nl2br(htmlspecialchars($guide['content'])); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-500 text-center">No information available for this section.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Get In Touch Section -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <div class="text-center">
                <a href="contact.php" class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                    GET IN TOUCH
                </a>
            </div>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>