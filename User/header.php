<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriCulture</title>

    <!-- Favicons -->
    <link href="assets/img/logoo-Recovered.jpg" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

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
    <style>
        /* Agriculture-themed header styling */
        .header {
            background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
                        url('assets/img/farm-pattern-bg.jpg');
            background-size: cover;
            border-bottom: 3px solid #4a7c59;
            padding: 15px 0;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        /* Chatbot icon styling */
        .chatbot-icon {
            cursor: pointer;
            margin-left: 20px;
            transition: transform 0.3s ease;
        }

        .chatbot-icon img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .chatbot-icon:hover {
            transform: scale(1.1);
        }

        /* Other styles remain the same */
    </style>
</head>
<body>

   <!-- Header Section -->
<header id="header" class="header d-flex align-items-center position-relative">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="index.html" class="logo d-flex align-items-center">
            <img src="assets/img/logoo-Recovered.jpg" alt="AgriCulture">
            <!-- <h1 class="sitename">AgriCulture</h1> -->
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="./index.php" class="active">Home</a></li>
                <li><a href="./about.php">About Us</a></li>
                <li><a href="./services.php">Our Services</a></li>
                <li><a href="./discussion.php">Discussion</a></li>
                <li><a href="./blog.php">Blog</a></li>
                <li class="dropdown">
                    <a href="#"><span>Farming & Markets</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        
                        <li class="dropdown">
                            <a href="./farming_guildline.php"><span>Farming Guidelines</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="./crop_Managemnt.php">Crop Management</a></li>
                                <li><a href="./seed-cultivation.php">Seed Cultivation</a></li>
                                <li><a href="./fertilizer_usage.php">Fertilizer Usage</a></li>
                                <li><a href="./technology.php">Agricultural Technology</a></li>
                                <li><a href="./farming_tips.php">Farming Tips</a></li>
                            </ul>
                        </li>
                       
                      
                        <li><a href="./market_trend.php">Market Trends</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#"><span>Resources</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="./weather.php">Weather</a></li>
                        <li><a href="./water.php">Water Management</a></li>
                        <li><a href="./view_Fertilizer.php">Fertilizer</a></li>
                    </ul>
                </li>
                <li><a href="./contact.php">Contact</a></li>
                
                <!-- Search Feature -->
                <li class="search-container" id="searchContainer">
                    <form action="search.php" method="GET" class="search-form">
                        <input type="text" name="query" placeholder="Search..." class="search-input" id="searchInput">
                        <button type="button" class="search-btn" id="searchToggle">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </li>

                <!-- Chatbot Icon -->
                <li class="chatbot-icon">
                    <img src="assets/img/chatbot.jpg" alt="Chatbot" onclick="window.location.href='http://localhost/The%20Department%20of%20Agriculture%20Services%20Website/User/chatbot/index.html';">
                </li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

    </div>
</header>

<!-- JavaScript for Search Functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchContainer = document.getElementById('searchContainer');
        const searchToggle = document.getElementById('searchToggle');
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.querySelector('.search-form');
        
        // Toggle search box visibility
        searchToggle.addEventListener('click', function() {
            searchContainer.classList.toggle('active');
            
            if (searchContainer.classList.contains('active')) {
                searchInput.focus();
            }
        });
        
        // Submit search when pressing Enter
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchForm.submit();
            }
        });
        
        // Close search when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchContainer.contains(e.target)) {
                searchContainer.classList.remove('active');
            }
        });
        
        // Change icon when search is active
        searchToggle.addEventListener('mouseover', function() {
            if (searchContainer.classList.contains('active')) {
                this.innerHTML = '<i class="bi bi-x"></i>';
            }
        });
        
        searchToggle.addEventListener('mouseout', function() {
            if (searchContainer.classList.contains('active')) {
                this.innerHTML = '<i class="bi bi-search"></i>';
            }
        });
    });
</script>
</body>
</html>