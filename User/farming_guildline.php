<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farming Guidelines - Department of Agriculture</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <<?php include 'header.php'; ?>

    <main class="container mx-auto px-4 py-8">
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <i class="bi bi-seed text-3xl text-green-600 mr-3"></i>
                        <h2 class="text-2xl font-bold text-gray-800">Seed Cultivation</h2>
                    </div>
                    <p class="text-gray-600 mb-6">Learn about different seed types, their benefits, and the best practices for cultivation.</p>
                    <ul class="list-disc pl-6 text-gray-700">
                        <li>Seed Selection and Quality</li>
                        <li>Soil Preparation Methods</li>
                        <li>Planting Techniques</li>
                        <li>Germination Care</li>
                    </ul>
                    <a href="./seed-cultivation.php" class="mt-6 inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Learn More</a>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <i class="bi bi-droplet-fill text-3xl text-green-600 mr-3"></i>
                        <h2 class="text-2xl font-bold text-gray-800">Fertilizer Usage</h2>
                    </div>
                    <p class="text-gray-600 mb-6">Understand the right fertilizer composition, dosage, and application methods for optimal yield.</p>
                    <ul class="list-disc pl-6 text-gray-700">
                        <li>Types of Fertilizers</li>
                        <li>Application Timing</li>
                        <li>Dosage Calculations</li>
                        <li>Organic Alternatives</li>
                    </ul>
                    <a href="./fertilizer_usage.php" class="mt-6 inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Learn More</a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <i class="bi bi-plant text-3xl text-green-600 mr-3"></i>
                        <h2 class="text-2xl font-bold text-gray-800">Crop Management</h2>
                    </div>
                    <p class="text-gray-600 mb-6">Discover how to efficiently manage crops throughout different growth stages for maximum productivity.</p>
                    <ul class="list-disc pl-6 text-gray-700">
                        <li>Growth Stage Monitoring</li>
                        <li>Disease Prevention</li>
                        <li>Pest Control</li>
                        <li>Harvest Timing</li>
                    </ul>
                    <a href="./crop_Managemnt.php" class="mt-6 inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Learn More</a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <i class="bi bi-gear text-3xl text-green-600 mr-3"></i>
                        <h2 class="text-2xl font-bold text-gray-800">Agricultural Technology</h2>
                    </div>
                    <p class="text-gray-600 mb-6">Explore modern agricultural tools, software, and automation techniques to enhance farming efficiency.</p>
                    <ul class="list-disc pl-6 text-gray-700">
                        <li>Modern Equipment Usage</li>
                        <li>Smart Irrigation Systems</li>
                        <li>Data-Driven Farming</li>
                        <li>Automation Tools</li>
                    </ul>
                    <a href="./technology.php" class="mt-6 inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Learn More</a>
                </div>
            </div>
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
            <a href="./contact.php" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition duration-300">
                Contact Us Now
            </a>
        </section>
    </main>

    <?php include 'footer.php'; ?>
   
</body>
</html>