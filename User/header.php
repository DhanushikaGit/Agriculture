<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriCulture</title>

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
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

/* Header background with subtle farm pattern or gradient */
.header {
  background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
              url('assets/img/farm-pattern-bg.jpg');
  background-size: cover;
  border-bottom: 3px solid #4a7c59;
  padding: 15px 0;
  box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

/* Logo styling */
.logo img {
  max-height: 100px;
  transition: all 0.3s ease;
}

.logo:hover img {
  transform: scale(1.05);
}

.sitename {
  color: #2e5d34;
  font-family: 'Marcellus', serif;
  font-weight: 700;
  margin-left: 10px;
}

/* Navigation menu styling */
.navmenu ul {
  display: flex;
  list-style: none;
  align-items: center;
  margin: 0;
  padding: 0;
}

.navmenu a {
  color: #2e5d34;
  font-family: 'Open Sans', sans-serif;
  font-weight: 600;
  font-size: 22px;
  padding: 10px 15px;
  transition: all 0.3s ease;
  position: relative;
}

/* Hover effect with growth element - like a plant growing */
.navmenu a:hover, 
.navmenu a.active {
  color: #6b9a50;
}

.navmenu a:after {
  content: '';
  position: absolute;
  width: 0;
  height: 2px;
  background: #6b9a50;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  transition: width 0.3s ease;
}

.navmenu a:hover:after,
.navmenu a.active:after {
  width: 70%;
}

/* Dropdown styling with leaf-like elements */
.navmenu .dropdown ul {
  display: block;
  position: absolute;
  background: #fff;
  min-width: 200px;
  box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
  border-radius: 4px;
  border-top: 3px solid #6b9a50;
  opacity: 0;
  visibility: hidden;
  transform: translateY(10px);
  transition: all 0.3s ease;
  padding: 10px 0;
  z-index: 99;
}

.navmenu .dropdown:hover > ul {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

.navmenu .dropdown ul li {
  min-width: 200px;
  position: relative;
}

.navmenu .dropdown ul a {
  padding: 10px 20px;
  font-size: 15px;
  color: #2e5d34;
  border-left: 2px solid transparent;
}

.navmenu .dropdown ul a:hover {
  color: #6b9a50;
  background: rgba(107, 154, 80, 0.05);
  border-left: 2px solid #6b9a50;
}

/* Mobile nav toggle - stylized like a farm tool */
.mobile-nav-toggle {
  font-size: 28px;
  cursor: pointer;
  color: #2e5d34;
  transition: 0.3s;
}

.mobile-nav-toggle:hover {
  color: #6b9a50;
  transform: rotate(90deg);
}

/* SEARCH FEATURE STYLING */
.search-container {
  position: relative;
  margin-left: 15px;
}

.search-form {
  display: flex;
  align-items: center;
}

.search-input {
  width: 0;
  border: none;
  background: transparent;
  border-bottom: 2px solid #4a7c59;
  padding: 8px 0;
  font-family: 'Open Sans', sans-serif;
  font-size: 15px;
  color: #2e5d34;
  transition: all 0.3s ease;
  opacity: 0;
}

.search-container.active .search-input {
  width: 200px;
  opacity: 1;
  padding-right: 30px;
}

.search-btn {
  background: none;
  border: none;
  color: #2e5d34;
  font-size: 20px;
  cursor: pointer;
  transition: all 0.3s ease;
  position: absolute;
  right: 0;
  top: 50%;
  transform: translateY(-50%);
}

.search-btn:hover {
  color: #6b9a50;
}

.search-container.active .search-btn {
  color: #6b9a50;
}

/* Responsive styles */
@media (max-width: 1280px) {
  .navmenu {
    padding: 0 15px;
  }
  
  .search-container.active .search-input {
    width: 150px;
  }
}

@media (max-width: 991px) {
  .navmenu ul {
    display: none;
  }
  
  .mobile-nav-active {
    overflow: hidden;
  }
  
  .mobile-nav-active .mobile-nav-toggle {
    position: fixed;
    right: 15px;
    top: 15px;
    z-index: 9999;
    color: #2e5d34;
  }
  
  .mobile-nav-active .navmenu {
    position: fixed;
    overflow: hidden;
    inset: 0;
    background: rgba(255, 255, 255, 0.95);
    transition: 0.3s;
    z-index: 9998;
    padding: 70px 0 0 0;
  }
  
  .mobile-nav-active .navmenu ul {
    display: block;
    position: absolute;
    top: 70px;
    right: 15px;
    left: 15px;
    padding: 10px 0;
    background: #fff;
    overflow-y: auto;
    transition: 0.3s;
    border-radius: 8px;
    box-shadow: 0 5px 25px rgba(74, 124, 89, 0.15);
  }
  
  .search-container {
    position: absolute;
    top: 80px;
    left: 15px;
    right: 15px;
    margin: 0;
  }
  
  .search-input, .search-container.active .search-input {
    width: calc(100% - 40px);
    opacity: 1;
    background: #fff;
    padding: 10px 40px 10px 15px;
    border-radius: 8px;
    border: 2px solid #4a7c59;
  }
}
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
                    <a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="#">Dropdown 1</a></li>
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
                        <li><a href="./farming_tips.php">Farming Tips</a></li>
                        <li><a href="#">Dropdown 3</a></li>
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