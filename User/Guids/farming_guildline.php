<?php
include 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php';

// Define the guidelines sections
$guidelines = [
    "Seed Cultivation" => [
        "icon" => "bi-seed",
        "description" => "Learn about different seed types, their benefits, and the best practices for cultivation.",
        "topics" => [
            "Seed Selection and Quality",
            "Soil Preparation Methods",
            "Planting Techniques",
            "Germination Care"
        ]
    ],
    "Fertilizer Usage" => [
        "icon" => "bi-droplet-fill",
        "description" => "Understand the right fertilizer composition, dosage, and application methods for optimal yield.",
        "topics" => [
            "Types of Fertilizers",
            "Application Timing",
            "Dosage Calculations",
            "Organic Alternatives"
        ]
    ],
    "Crop Management" => [
        "icon" => "bi-plant",
        "description" => "Discover how to efficiently manage crops throughout different growth stages for maximum productivity.",
        "topics" => [
            "Growth Stage Monitoring",
            "Disease Prevention",
            "Pest Control",
            "Harvest Timing"
        ]
    ],
    "Agricultural Technology" => [
        "icon" => "bi-gear",
        "description" => "Explore modern agricultural tools, software, and automation techniques to enhance farming efficiency.",
        "topics" => [
            "Modern Equipment Usage",
            "Smart Irrigation Systems",
            "Data-Driven Farming",
            "Automation Tools"
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farming Guidelines - Department of Agriculture</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        
    </style>
</head>
<body class="bg-gray-50">
    <!-- Hero Section with Background -->
    <div class="relative bg-green-800 text-white py-24 mb-12">
        <div class="absolute inset-0">
            <img src="assets/img/page-title-bg.webp" class="w-full h-full object-cover opacity-30" alt="Agriculture background">
        </div>
        <div class="relative container mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Farming Guidelines</h1>
            <nav class="text-sm">
                <ol class="flex space-x-2">
                    <li><a href="index.html" class="hover:text-green-300">Home</a></li>
                    <li>/</li>
                    <li class="text-green-300">Guidelines</li>
                </ol>
            </nav>
        </div>
    </div>

    <main class="container mx-auto px-4 py-8">
        <!-- Guidelines Grid -->
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <?php foreach ($guidelines as $title => $content): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <i class="bi <?= $content['icon'] ?> text-3xl text-green-600 mr-3"></i>
                        <h2 class="text-2xl font-bold text-gray-800"><?= $title ?></h2>
                    </div>
                    
                    <p class="text-gray-600 mb-6"><?= $content['description'] ?></p>
                    
                    <div class="space-y-3">
                        <?php foreach ($content['topics'] as $topic): ?>
                        <div class="flex items-center text-gray-700">
                            <i class="bi bi-check2-circle text-green-500 mr-2"></i>
                            <span><?= $topic ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-6">
                        <a href="#" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300">
                            Learn More
                            <i class="bi bi-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Additional Resources Section -->
        <section class="bg-white rounded-lg shadow-md p-8 mb-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Additional Resources</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="p-4 border border-gray-200 rounded-lg">
                    <i class="bi bi-file-pdf text-red-500 text-2xl mb-3"></i>
                    <h3 class="font-semibold mb-2">Downloadable Guides</h3>
                    <p class="text-gray-600">Access comprehensive PDF guides for offline reference.</p>
                </div>
                
                <div class="p-4 border border-gray-200 rounded-lg">
                    <i class="bi bi-camera-video text-blue-500 text-2xl mb-3"></i>
                    <h3 class="font-semibold mb-2">Video Tutorials</h3>
                    <p class="text-gray-600">Watch step-by-step video guides on farming techniques.</p>
                </div>
                
                <div class="p-4 border border-gray-200 rounded-lg">
                    <i class="bi bi-people text-green-500 text-2xl mb-3"></i>
                    <h3 class="font-semibold mb-2">Expert Consultation</h3>
                    <p class="text-gray-600">Connect with agricultural experts for personalized advice.</p>
                </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="bg-green-100 rounded-lg p-8 text-center">
            <h2 class="text-2xl font-bold text-green-800 mb-4">Need More Information?</h2>
            <p class="text-gray-700 mb-6">Our agricultural experts are here to help you with any specific questions.</p>
            <a href="contact.php" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-300">
                Contact Us Now
            </a>
        </section>
    </main>

    <?php include 'footer.php'; ?>
</body>
</html>