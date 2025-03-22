<?php // sidebar.php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --text-light: #ecf0f1;
            --text-dark: #2c3e50;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: var(--text-dark);
        }
        
        /* Header Styles */
        .header {
            width: 100%;
            background: #fff;
            color: var(--text-dark);
            position: fixed;
            top: 0;
            left: 0;
            height: 70px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 99;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }
        
        .header .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .header .logo i {
            font-size: 24px;
            color: var(--primary-color);
        }
        
        .header .search-wrapper {
            position: relative;
            flex: 1;
            max-width: 400px;
            margin: 0 20px;
        }
        
        .header .search-wrapper input {
            width: 100%;
            height: 40px;
            padding: 0 40px 0 15px;
            border: 1px solid #ddd;
            border-radius: 20px;
            background: #f5f7fa;
            outline: none;
            transition: var(--transition);
        }
        
        .header .search-wrapper input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        .header .search-wrapper i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
        }
        
        .header .user-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .header .notifications {
            position: relative;
            cursor: pointer;
        }
        
        .header .notifications .count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--accent-color);
            color: white;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .header .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        
        .header .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid var(--primary-color);
        }
        
        .header .profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .header .sidebar-menu {
            display: flex;
            align-items: center;
            gap: 20px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .header .sidebar-menu li {
            position: relative;
        }
        
        .header .sidebar-menu li a {
            padding: 10px 15px;
            display: flex;
            align-items: center;
            color: var(--text-dark);
            text-decoration: none;
            font-size: 16px;
            transition: var(--transition);
            border-left: 3px solid transparent;
        }
        
        .header .sidebar-menu li a:hover {
            background: rgba(52, 152, 219, 0.1);
            border-left: 3px solid var(--primary-color);
        }
        
        .header .sidebar-menu li a.active {
            background: rgba(52, 152, 219, 0.2);
            border-left: 3px solid var(--primary-color);
        }
        
        .header .sidebar-menu i {
            margin-right: 10px;
            font-size: 18px;
            width: 20px;
            text-align: center;
        }
        
        .header .submenu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: #fff;
            box-shadow: var(--shadow);
            border-radius: 5px;
            z-index: 100;
        }
        
        .header .submenu.open {
            display: block;
        }
        
        .header .submenu a {
            padding: 10px 20px;
            font-size: 14px;
            white-space: nowrap;
        }
        
        .header .arrow {
            margin-left: auto;
            transition: transform 0.3s ease;
        }
        
        .header .arrow.open {
            transform: rotate(90deg);
        }
        
        /* Content Area */
        .content {
            margin-top: 70px;
            padding: 20px;
            transition: var(--transition);
        }
        
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card {
            display: flex;
            align-items: center;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            background: rgba(52, 152, 219, 0.1);
        }
        
        .stat-icon i {
            font-size: 24px;
            color: var(--primary-color);
        }
        
        .stat-details h3 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .stat-details p {
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .chart-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .recent-activity {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--shadow);
        }
        
        .activity-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .activity-list {
            list-style: none;
        }
        
        .activity-item {
            padding: 15px 0;
            border-bottom: 1px solid #ecf0f1;
            display: flex;
            align-items: center;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            background: rgba(52, 152, 219, 0.1);
        }
        
        .activity-details h4 {
            margin-bottom: 5px;
        }
        
        .activity-time {
            font-size: 12px;
            color: #7f8c8d;
        }
        
        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .header .sidebar-menu {
                display: none;
            }
            
            .header .search-wrapper {
                max-width: 200px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <i class="fas fa-tachometer-alt"></i>
            <span>Admin Panel</span>
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="dashboard.php" class="active">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="submenu-toggle">
                    <i class="fas fa-table"></i>
                    <span>Tables</span>
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
                <ul class="submenu">
                    <li><a href="basic-tables.php">Basic Tables</a></li>
                    <li><a href="data-tables.php">Data Tables</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);" class="submenu-toggle">
                    <i class="fas fa-edit"></i>
                    <span>Forms</span>
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
                <ul class="submenu">
                    <li><a href="form-elements.php">Form Elements</a></li>
                    <li><a href="form-validation.php">Form Validation</a></li>
                </ul>
            </li>
            <li>
                <a href="calendar.php">
                    <i class="fas fa-calendar"></i>
                    <span>Calendar</span>
                </a>
            </li>
            <li>
                <a href="charts.php">
                    <i class="fas fa-chart-pie"></i>
                    <span>Charts</span>
                </a>
            </li>
            <li>
                <a href="users.php">
                    <i class="fas fa-users"></i>
                    <span>User Management</span>
                </a>
            </li>
            <li>
                <a href="settings.php">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="submenu-toggle">
                    <i class="fas fa-file-alt"></i>
                    <span>Pages</span>
                    <i class="fas fa-chevron-right arrow"></i>
                </a>
                <ul class="submenu">
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="invoices.php">Invoices</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                </ul>
            </li>
            <li>
                <a href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
        
        <div class="search-wrapper">
            <input type="text" placeholder="Search...">
            <i class="fas fa-search"></i>
        </div>
        
        <div class="user-wrapper">
            <div class="notifications">
                <i class="fas fa-bell"></i>
                <span class="count">5</span>
            </div>
            
            <div class="user-profile">
                <div class="profile-img">
                    <img src="/api/placeholder/40/40" alt="User">
                </div>
                <div>
                    <h4>John Doe</h4>
                    <small>Administrator</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Area -->
    <div class="content">
        <!-- Your content goes here -->
    </div>

    <script>
        // Toggle Submenu
        const submenuToggles = document.querySelectorAll('.submenu-toggle');
        
        submenuToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const submenu = this.nextElementSibling;
                const arrow = this.querySelector('.arrow');
                
                submenu.classList.toggle('open');
                arrow.classList.toggle('open');
            });
        });
    </script>
</body>
</html>