<?php
$current_page = basename($_SERVER['PHP_SELF']);

function isActive($page_name) {
    global $current_page;
    return $current_page == $page_name ? 'class="active"' : '';
}

echo '
<header class="header">
    <div class="container">
        <div class="header-content">
            <!-- Logo -->
            <a href="index.php" class="logo">
                <img src="assets/img/logoo-Recovered.bmp" alt="AgriCulture">
            </a>

            <!-- Main Navigation -->
            <nav class="main-nav">
                <ul class="nav-list">
                    <li><a href="index.php" ' . isActive("index.php") . '>Home</a></li>
                    <li><a href="about.php" ' . isActive("about.php") . '>About</a></li>
                    <li><a href="services.php" ' . isActive("services.php") . '>Services</a></li>
                    <li><a href="projects.php" ' . isActive("projects.php") . '>Projects</a></li>
                    <li><a href="blog.php" ' . isActive("blog.php") . '>Blog</a></li>
                    <li class="has-dropdown">
                        <a href="#" class="dropdown-trigger">Resources <span class="arrow">▼</span></a>
                        <div class="dropdown-menu">
                            <ul>
                                <li><a href="farming-tips.php">Farming Tips</a></li>
                                <li class="has-submenu">
                                    <a href="#" class="submenu-trigger">
                                        Guides
                                        <span class="arrow">▶</span>
                                    </a>
                                    <ul class="submenu">
                                        <li><a href="soil.php">Soil Preparation</a></li>
                                        <li><a href="crop.php">Crop Rotation</a></li>
                                        <li><a href="organic.php">Organic Farming</a></li>
                                        <li><a href="water.php">Water Management</a></li>
                                    </ul>
                                </li>
                                <li><a href="trends.php">Market Trends</a></li>
                                <li><a href="weather.php">Weather Updates</a></li>
                                <li><a href="policies.php">Government Policies</a></li>
                            </ul>
                        </div>
                    </li>
                    <li><a href="contact.php" ' . isActive("contact.php") . '>Contact</a></li>
                </ul>
            </nav>

            <!-- Search -->
            <div class="search-bar">
                <form action="search.php" method="GET">
                    <input type="text" name="query" placeholder="Search...">
                    <button type="submit" class="search-button">
                        <i class="search-icon">🔍</i>
                    </button>
                </form>
            </div>

            <!-- User Actions -->
            <div class="user-actions">
                <?php if (isset($_SESSION["user"])): ?>
                    <a href="logout.php" class="btn-primary">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn-primary">Login</a>
                <?php endif; ?>

                <button class="mobile-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="projects.php">Projects</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li class="mobile-dropdown">
                    <a href="#" class="mobile-dropdown-trigger">Resources</a>
                    <ul class="mobile-submenu">
                        <li><a href="farming-tips.php">Farming Tips</a></li>
                        <li><a href="soil.php">Soil Preparation</a></li>
                        <li><a href="crop.php">Crop Rotation</a></li>
                        <li><a href="organic.php">Organic Farming</a></li>
                        <li><a href="water.php">Water Management</a></li>
                        <li><a href="trends.php">Market Trends</a></li>
                        <li><a href="weather.php">Weather Updates</a></li>
                        <li><a href="policies.php">Government Policies</a></li>
                    </ul>
                </li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </div>
</header>

<style>
/* Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Header */
.header {
    background: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 1000;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 80px;
}

/* Logo */
.logo img {
    height: 50px;
    width: auto;
}

/* Main Navigation */
.main-nav {
    margin-left: 40px;
}

.nav-list {
    display: flex;
    list-style: none;
    gap: 25px;
}

.nav-list a {
    color: #333;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
    transition: color 0.3s;
}

.nav-list a:hover,
.nav-list a.active {
    color: #4CAF50;
}

/* Dropdown */
.has-dropdown {
    position: relative;
}

.dropdown-trigger {
    display: flex;
    align-items: center;
    gap: 5px;
}

.arrow {
    font-size: 12px;
    transition: transform 0.3s;
}

.has-dropdown:hover .arrow {
    transform: rotate(180deg);
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    background: white;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    min-width: 200px;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.3s;
}

.has-dropdown:hover .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-menu ul {
    list-style: none;
    padding: 10px 0;
}

.dropdown-menu a {
    padding: 8px 20px;
    display: block;
}

/* Submenu */
.has-submenu {
    position: relative;
}

.submenu-trigger {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.submenu {
    position: absolute;
    left: 100%;
    top: 0;
    background: white;
    border-radius: 4px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    min-width: 200px;
    opacity: 0;
    visibility: hidden;
    transform: translateX(10px);
    transition: all 0.3s;
}

.has-submenu:hover .submenu {
    opacity: 1;
    visibility: visible;
    transform: translateX(0);
}

/* Search Bar */
.search-bar {
    margin-left: auto;
    margin-right: 20px;
}

.search-bar form {
    position: relative;
}

.search-bar input {
    padding: 8px 35px 8px 15px;
    border: 1px solid #ddd;
    border-radius: 20px;
    font-size: 14px;
    width: 200px;
    transition: width 0.3s;
}

.search-bar input:focus {
    width: 250px;
    outline: none;
    border-color: #4CAF50;
}

.search-button {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    font-size: 16px;
}

/* User Actions */
.user-actions {
    display: flex;
    align-items: center;
    gap: 20px;
}

.btn-primary {
    background: #4CAF50;
    color: white;
    padding: 8px 20px;
    border-radius: 20px;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.3s;
}

.btn-primary:hover {
    background: #45a049;
}

/* Mobile Toggle */
.mobile-toggle {
    display: none;
    flex-direction: column;
    gap: 5px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
}

.mobile-toggle span {
    display: block;
    width: 25px;
    height: 2px;
    background: #333;
    transition: 0.3s;
}

/* Mobile Menu */
.mobile-menu {
    display: none;
    background: white;
    padding: 20px;
    border-top: 1px solid #eee;
}

.mobile-menu ul {
    list-style: none;
}

.mobile-menu a {
    color: #333;
    text-decoration: none;
    display: block;
    padding: 12px 15px;
    font-size: 16px;
    border-bottom: 1px solid #eee;
}

.mobile-menu a:hover {
    color: #4CAF50;
    background: #f5f5f5;
}

.mobile-dropdown-trigger {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.mobile-dropdown-trigger::after {
    content: "▼";
    font-size: 12px;
}

.mobile-submenu {
    display: none;
    background: #f5f5f5;
}

.mobile-submenu a {
    padding-left: 30px;
}

/* Active States */
.mobile-dropdown.active .mobile-submenu {
    display: block;
}

.mobile-dropdown.active .mobile-dropdown-trigger::after {
    transform: rotate(180deg);
}

/* Responsive */
@media (max-width: 1024px) {
    .main-nav,
    .search-bar {
        display: none;
    }

    .mobile-toggle {
        display: flex;
    }

    .mobile-menu.active {
        display: block;
    }

    .mobile-toggle.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .mobile-toggle.active span:nth-child(2) {
        opacity: 0;
    }

    .mobile-toggle.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -6px);
    }
}

@media (max-width: 768px) {
    .header-content {
        height: 70px;
    }

    .logo img {
        height: 40px;
    }

    .btn-primary {
        padding: 6px 15px;
        font-size: 14px;
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Mobile menu toggle
    const mobileToggle = document.querySelector(".mobile-toggle");
    const mobileMenu = document.querySelector(".mobile-menu");
    
    mobileToggle.addEventListener("click", function() {
        this.classList.toggle("active");
        mobileMenu.classList.toggle("active");
    });

    // Mobile dropdowns
    const mobileDropdowns = document.querySelectorAll(".mobile-dropdown");
    
    mobileDropdowns.forEach(dropdown => {
        const trigger = dropdown.querySelector(".mobile-dropdown-trigger");
        
        trigger.addEventListener("click", (e) => {
            e.preventDefault();
            dropdown.classList.toggle("active");
        });
    });
});
</script>';
?>