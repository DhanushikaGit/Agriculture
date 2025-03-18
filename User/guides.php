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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom CSS */
        :root {
            --primary-color: #2e7d32;
            --secondary-color: #81c784;
            --accent-color: #f9a825;
            --light-bg: #f5f7f9;
            --dark-text: #333333;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-text);
            line-height: 1.6;
        }

        .page-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            padding: 2rem 0;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('images/agriculture-pattern.jpg');
            opacity: 0.1;
            mix-blend-mode: overlay;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .section-title {
            position: relative;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--accent-color);
        }

        .category-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .category-header {
            background-color: var(--primary-color);
            padding: 15px;
            border-bottom: 3px solid var(--accent-color);
        }

        .card-img-container {
            overflow: hidden;
            position: relative;
        }

        .card-img {
            transition: transform 0.5s ease;
        }

        .category-card:hover .card-img {
            transform: scale(1.05);
        }

        .view-details-btn {
            background-color: var(--primary-color);
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .view-details-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.5s ease;
            z-index: -1;
        }

        .view-details-btn:hover::before {
            left: 100%;
        }

        .view-details-btn:hover {
            background-color: #1b5e20;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .detail-section {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            position: relative;
            padding: 2rem;
            margin-top: 2rem;
            border-top: 4px solid var(--primary-color);
        }

        .detail-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('images/light-pattern.png');
            opacity: 0.05;
            pointer-events: none;
        }

        .detail-content {
            position: relative;
            z-index: 1;
        }

        .detail-card {
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .detail-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .detail-title {
            color: var(--primary-color);
            font-weight: 600;
        }

        .get-in-touch {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border-radius: 12px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .get-in-touch::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('images/agriculture-pattern.jpg');
            opacity: 0.1;
            mix-blend-mode: overlay;
        }

        .contact-btn {
            background-color: var(--accent-color);
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .contact-btn:hover {
            background-color: white;
            color: var(--accent-color);
            border-color: var(--accent-color);
            transform: scale(1.05);
        }

        .icon-box {
            display: inline-block;
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            margin-right: 10px;
        }

        .scroll-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .scroll-top.visible {
            opacity: 1;
        }

        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .section-title::after {
                width: 60px;
            }
        }
    </style>
    <script>
        function scrollToCategory(category) {
            let categorySection = document.getElementById('category-' + category.replace(/\s+/g, ''));
            categorySection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Scroll to top button
            const scrollBtn = document.querySelector('.scroll-top');
            
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollBtn.classList.add('visible');
                } else {
                    scrollBtn.classList.remove('visible');
                }
            });
            
            scrollBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
            
            // Add animation to sections
            const sections = document.querySelectorAll('.detail-section');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fadeIn');
                    }
                });
            }, { threshold: 0.1 });
            
            sections.forEach(section => {
                observer.observe(section);
            });
        });
    </script>
</head>
<body>
    <div class="page-header">
        <div class="header-content container mx-auto text-center px-4">
            <h1 class="text-4xl font-bold text-white mb-2">About The Department of Agriculture</h1>
            <p class="text-lg text-gray-100 max-w-2xl mx-auto">Serving our farming community with innovation, sustainability, and excellence</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12">
        <!-- Category Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            <?php foreach ($categories as $category => $images): ?>
                <div class="category-card bg-white shadow-lg">
                    <div class="category-header">
                        <h2 class="text-xl font-semibold text-center text-white"><?php echo htmlspecialchars($category); ?></h2>
                    </div>
                    <div class="grid grid-cols-2 gap-2 p-4">
                        <?php foreach ($images as $image): ?>
                            <div class="card-img-container h-24 rounded-lg overflow-hidden">
                                <img src="images/<?php echo $image; ?>" class="card-img w-full h-full object-cover" alt="<?php echo htmlspecialchars($category); ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="p-4 border-t border-gray-100">
                        <button onclick="scrollToCategory('<?php echo addslashes($category); ?>')" 
                                class="view-details-btn text-white w-full py-3 rounded-lg flex items-center justify-center">
                            <span class="mr-2">View Details</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Detailed Sections -->
        <?php foreach ($categories as $category => $images): ?>
            <div id="category-<?php echo str_replace(' ', '', htmlspecialchars($category)); ?>" 
                 class="detail-section mb-12">
                <div class="detail-content">
                    <h2 class="section-title text-2xl font-bold text-center text-green-800"><?php echo htmlspecialchars($category); ?></h2>
                    
                    <div class="space-y-6">
                        <?php if (!empty($guides[$category])): ?>
                            <?php foreach ($guides[$category] as $guide): ?>
                                <div class="detail-card p-6">
                                    <div class="flex items-start mb-4">
                                        <div class="icon-box">
                                            <?php if ($category == 'Vision'): ?>
                                                <i class="fas fa-eye"></i>
                                            <?php elseif ($category == 'Mission'): ?>
                                                <i class="fas fa-flag"></i>
                                            <?php else: ?>
                                                <i class="fas fa-bullseye"></i>
                                            <?php endif; ?>
                                        </div>
                                        <h3 class="detail-title text-xl"><?php echo htmlspecialchars($guide['title']); ?></h3>
                                    </div>
                                    <div class="text-gray-700 leading-relaxed ml-12">
                                        <?php echo nl2br(htmlspecialchars($guide['content'])); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-gray-500 text-center">No information available for this section.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Get In Touch Section -->
        <div class="get-in-touch text-center mb-12">
            <div class="relative z-10">
                <h2 class="text-2xl font-bold text-white mb-4">Have Questions About Our Agricultural Services?</h2>
                <p class="text-gray-100 mb-6 max-w-xl mx-auto">Our team of agricultural experts is ready to assist you with any questions or concerns you may have.</p>
                <a href="contact.php" class="contact-btn inline-block shadow-lg">
                    Get In Touch
                </a>
            </div>
        </div>
    </div>

    <!-- Scroll to top button -->
    <div class="scroll-top" title="Scroll to top">
        <i class="fas fa-chevron-up"></i>
    </div>

</body>
</html>

<?php $conn->close(); ?>