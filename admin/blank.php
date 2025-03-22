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
            display: flex;
            background-color: #f5f7fa;
            color: var(--text-dark);
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: var(--secondary-color);
            color: var(--text-light);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 100;
            transition: var(--transition);
            overflow-y: auto;
            box-shadow: var(--shadow);
        }
        
        .sidebar-header {
            padding: 20px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo i {
            font-size: 24px;
            color: var(--primary-color);
        }
        
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-light);
            font-size: 20px;
            cursor: pointer;
        }
        
        .sidebar ul {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }
        
        .sidebar-menu li {
            position: relative;
        }
        
        .sidebar-menu li a {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            color: var(--text-light);
            text-decoration: none;
            font-size: 16px;
            transition: var(--transition);
            border-left: 3px solid transparent;
        }
        
        .sidebar-menu li a:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left: 3px solid var(--primary-color);
        }
        
        .sidebar-menu li a.active {
            background: rgba(52, 152, 219, 0.2);
            border-left: 3px solid var(--primary-color);
        }
        
        .sidebar-menu i {
            margin-right: 10px;
            font-size: 18px;
            width: 20px;
            text-align: center;
        }
        
        .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: rgba(0, 0, 0, 0.1);
        }
        
        .submenu.open {
            max-height: 1000px;
        }
        
        .submenu a {
            padding-left: 50px!important;
            font-size: 14px!important;
        }
        
        .arrow {
            margin-left: auto;
            transition: transform 0.3s ease;
        }
        
        .arrow.open {
            transform: rotate(90deg);
        }
        
        /* Header Styles */
        .header {
            width: calc(100% - 250px);
            background: #fff;
            color: var(--text-dark);
            position: fixed;
            top: 0;
            left: 250px;
            height: 70px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 99;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }
        
        .search-wrapper {
            position: relative;
            flex: 1;
            max-width: 400px;
            margin: 0 20px;
        }
        
        .search-wrapper input {
            width: 100%;
            height: 40px;
            padding: 0 40px 0 15px;
            border: 1px solid #ddd;
            border-radius: 20px;
            background: #f5f7fa;
            outline: none;
            transition: var(--transition);
        }
        
        .search-wrapper input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }
        
        .search-wrapper i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #7f8c8d;
        }
        
        .user-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .notifications {
            position: relative;
            cursor: pointer;
        }
        
        .notifications .count {
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
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }
        
        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid var(--primary-color);
        }
        
        .profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Content Area */
        .content {
            margin-left: 250px;
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
            .sidebar {
                width: 70px;
                overflow: visible;
            }
            
            .sidebar.expanded {
                width: 250px;
            }
            
            .logo span, .sidebar-menu span {
                display: none;
            }
            
            .sidebar.expanded .logo span, 
            .sidebar.expanded .sidebar-menu span {
                display: inline;
            }
            
            .sidebar-toggle {
                display: block;
            }
            
            .header {
                left: 70px;
                width: calc(100% - 70px);
            }
            
            .sidebar.expanded + .header {
                left: 250px;
                width: calc(100% - 250px);
            }
            
            .content {
                margin-left: 70px;
            }
            
            .sidebar.expanded ~ .content {
                margin-left: 250px;
            }
            
            .chart-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i class="fas fa-tachometer-alt"></i>
                <span>Admin Panel</span>
            </div>
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
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
    </div>
    
    <!-- Header -->
    <div class="header">
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
    
    <!-- Main Content -->
    <div class="content">
        <h1>Dashboard</h1>
        
        <!-- Dashboard Cards -->
        <div class="dashboard-cards">
            <div class="card stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-details">
                    <h3>2,568</h3>
                    <p>Total Users</p>
                </div>
            </div>
            
            <div class="card stat-card">
                <div class="stat-icon" style="background: rgba(46, 204, 113, 0.1);">
                    <i class="fas fa-chart-line" style="color: var(--success-color);"></i>
                </div>
                <div class="stat-details">
                    <h3>$12,897</h3>
                    <p>Total Revenue</p>
                </div>
            </div>
            
            <div class="card stat-card">
                <div class="stat-icon" style="background: rgba(243, 156, 18, 0.1);">
                    <i class="fas fa-shopping-cart" style="color: var(--warning-color);"></i>
                </div>
                <div class="stat-details">
                    <h3>856</h3>
                    <p>New Orders</p>
                </div>
            </div>
            
            <div class="card stat-card">
                <div class="stat-icon" style="background: rgba(231, 76, 60, 0.1);">
                    <i class="fas fa-ticket-alt" style="color: var(--danger-color);"></i>
                </div>
                <div class="stat-details">
                    <h3>15</h3>
                    <p>Support Tickets</p>
                </div>
            </div>
        </div>
        
        <!-- Charts and Recent Activity -->
        <div class="chart-container">
            <div class="card">
                <h2>Sales Analytics</h2>
                <p>Your sales performance over the last 6 months</p>
                <div style="height: 300px; display: flex; align-items: center; justify-content: center; background: #f5f7fa; border-radius: 8px; margin-top: 20px;">
                    <i class="fas fa-chart-line" style="font-size: 48px; color: #bdc3c7;"></i>
                    <p>Chart will be displayed here</p>
                </div>
            </div>
            
            <div class="card">
                <h2>Traffic Sources</h2>
                <p>Where your visitors come from</p>
                <div style="height: 300px; display: flex; align-items: center; justify-content: center; background: #f5f7fa; border-radius: 8px; margin-top: 20px;">
                    <i class="fas fa-chart-pie" style="font-size: 48px; color: #bdc3c7;"></i>
                    <p>Chart will be displayed here</p>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="recent-activity">
            <div class="activity-title">
                <h2>Recent Activity</h2>
                <a href="#" style="color: var(--primary-color);">View All</a>
            </div>
            
            <ul class="activity-list">
                <li class="activity-item">
                    <div class="activity-icon" style="background: rgba(46, 204, 113, 0.1);">
                        <i class="fas fa-user-plus" style="color: var(--success-color);"></i>
                    </div>
                    <div class="activity-details">
                        <h4>New user registered</h4>
                        <p>Jane Smith created a new account.</p>
                        <span class="activity-time">3 minutes ago</span>
                    </div>
                </li>
                
                <li class="activity-item">
                    <div class="activity-icon" style="background: rgba(52, 152, 219, 0.1);">
                        <i class="fas fa-shopping-bag" style="color: var(--primary-color);"></i>
                    </div>
                    <div class="activity-details">
                        <h4>New order received</h4>
                        <p>Order #5682 has been placed.</p>
                        <span class="activity-time">15 minutes ago</span>
                    </div>
                </li>
                
                <li class="activity-item">
                    <div class="activity-icon" style="background: rgba(231, 76, 60, 0.1);">
                        <i class="fas fa-exclamation-circle" style="color: var(--danger-color);"></i>
                    </div>
                    <div class="activity-details">
                        <h4>Server alert</h4>
                        <p>High CPU usage detected on server #3.</p>
                        <span class="activity-time">42 minutes ago</span>
                    </div>
                </li>
                
                <li class="activity-item">
                    <div class="activity-icon" style="background: rgba(243, 156, 18, 0.1);">
                        <i class="fas fa-credit-card" style="color: var(--warning-color);"></i>
                    </div>
                    <div class="activity-details">
                        <h4>Payment received</h4>
                        <p>$1,250 payment from Client #32567.</p>
                        <span class="activity-time">1 hour ago</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <script>
        // Toggle Sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('expanded');
        });
        
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