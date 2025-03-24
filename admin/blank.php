<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Department Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
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
        
        .page-title {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 600;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .page-title i {
            color: var(--primary-color);
            font-size: 28px;
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
        }
        
        .stat-icon i {
            font-size: 24px;
            color: white;
        }
        
        .stat-details h3 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .stat-details p {
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .icon-crops {
            background-color: var(--primary-color);
        }
        
        .icon-farmers {
            background-color: var(--success-color);
        }
        
        .icon-land {
            background-color: var(--warning-color);
        }
        
        .icon-yield {
            background-color: var(--accent-color);
        }
        
        .chart-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .chart-card {
            min-height: 400px;
        }
        
        .chart-title {
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
            color: var(--secondary-color);
        }
        
        .weather-card {
            display: flex;
            flex-direction: column;
        }
        
        .weather-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .weather-location {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .weather-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px 0;
        }
        
        .weather-icon {
            font-size: 50px;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .weather-temp {
            font-size: 38px;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .weather-desc {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 15px;
        }
        
        .weather-details {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 10px;
        }
        
        .weather-detail {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .weather-detail i {
            color: var(--primary-color);
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
        
        .view-all {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
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
        
        .activity-item:last-child {
            border-bottom: none;
        }
        
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
        }
        
        .icon-add {
            background-color: var(--success-color);
        }
        
        .icon-update {
            background-color: var(--primary-color);
        }
        
        .icon-alert {
            background-color: var(--warning-color);
        }
        
        .icon-delete {
            background-color: var(--danger-color);
        }
        
        .activity-details {
            flex: 1;
        }
        
        .activity-details h4 {
            margin-bottom: 5px;
        }
        
        .activity-time {
            font-size: 12px;
            color: #7f8c8d;
        }
        
        .crop-table {
            margin-top: 15px;
            width: 100%;
            border-collapse: collapse;
        }
        
        .crop-table th {
            background-color: #f5f7fa;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
        }
        
        .crop-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ecf0f1;
        }
        
        .crop-table tr:last-child td {
            border-bottom: none;
        }
        
        .crop-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-healthy {
            background-color: rgba(46, 204, 113, 0.2);
            color: var(--success-color);
        }
        
        .status-warning {
            background-color: rgba(243, 156, 18, 0.2);
            color: var(--warning-color);
        }
        
        .status-danger {
            background-color: rgba(231, 76, 60, 0.2);
            color: var(--danger-color);
        }
        
        .grid-bottom {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        
        /* Calendar styles */
        .calendar {
            width: 100%;
        }
        
        .calendar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .calendar-month {
            font-size: 18px;
            font-weight: 600;
        }
        
        .calendar-nav {
            display: flex;
            gap: 10px;
        }
        
        .calendar-nav button {
            width: 30px;
            height: 30px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .calendar-nav button:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        .calendar-days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        
        .calendar-days div {
            text-align: center;
            padding: 5px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .calendar-dates {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        
        .calendar-date {
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .calendar-date:hover {
            background: rgba(52, 152, 219, 0.1);
        }
        
        .calendar-date.today {
            background: var(--primary-color);
            color: white;
        }
        
        .calendar-date.event {
            position: relative;
        }
        
        .calendar-date.event::after {
            content: '';
            position: absolute;
            bottom: 3px;
            width: 5px;
            height: 5px;
            background: var(--primary-color);
            border-radius: 50%;
        }
        
        .calendar-date.muted {
            color: #bdc3c7;
        }
        
        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .header .sidebar-menu {
                display: none;
            }
            
            .header .search-wrapper {
                max-width: 200px;
            }
            
            .chart-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header included in the original file -->

    <!-- Content Area -->
    <div class="content">
        <h1 class="page-title"><i class="fas fa-seedling"></i> Agriculture Department Dashboard</h1>
        
        <!-- Stat Cards -->
        <div class="dashboard-cards">
            <div class="card stat-card">
                <div class="stat-icon icon-crops">
                    <i class="fas fa-seedling"></i>
                </div>
                <div class="stat-details">
                    <h3>42</h3>
                    <p>Active Crops</p>
                </div>
            </div>
            
            <div class="card stat-card">
                <div class="stat-icon icon-farmers">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-details">
                    <h3>1,254</h3>
                    <p>Registered Farmers</p>
                </div>
            </div>
            
            <div class="card stat-card">
                <div class="stat-icon icon-land">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <div class="stat-details">
                    <h3>15,420</h3>
                    <p>Hectares Cultivated</p>
                </div>
            </div>
            
            <div class="card stat-card">
                <div class="stat-icon icon-yield">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-details">
                    <h3>+12.5%</h3>
                    <p>Yield Increase</p>
                </div>
            </div>
        </div>
        
        <!-- Charts and Weather -->
        <div class="chart-container">
            <div class="card chart-card">
                <h3 class="chart-title">Crop Production Trends</h3>
                <canvas id="productionChart"></canvas>
            </div>
            
            <div class="card weather-card">
                <div class="weather-header">
                    <div class="weather-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Central District</span>
                    </div>
                    <span>Today, Mar 22</span>
                </div>
                
                <div class="weather-body">
                    <i class="fas fa-sun weather-icon"></i>
                    <div class="weather-temp">29°C</div>
                    <div class="weather-desc">Sunny, Clear Sky</div>
                    <div class="weather-details">
                        <div class="weather-detail">
                            <i class="fas fa-tint"></i>
                            <span>Humidity: 65%</span>
                        </div>
                        <div class="weather-detail">
                            <i class="fas fa-wind"></i>
                            <span>Wind: 12 km/h</span>
                        </div>
                        <div class="weather-detail">
                            <i class="fas fa-cloud-rain"></i>
                            <span>Rain: 5%</span>
                        </div>
                        <div class="weather-detail">
                            <i class="fas fa-temperature-high"></i>
                            <span>UV Index: High</span>
                        </div>
                    </div>
                </div>
                
                <div class="weather-forecast">
                    <h4>5-Day Forecast</h4>
                    <!-- Forecast details would go here -->
                </div>
            </div>
        </div>
        
        <!-- Recent Activities and Crop Status -->
        <div class="grid-bottom">
            <div class="card recent-activity">
                <div class="activity-title">
                    <h3>Recent Activities</h3>
                    <a href="#" class="view-all">View All <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <ul class="activity-list">
                    <li class="activity-item">
                        <div class="activity-icon icon-add">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="activity-details">
                            <h4>New Rice Cultivation Added</h4>
                            <p>Added by Admin</p>
                            <span class="activity-time">2 hours ago</span>
                        </div>
                    </li>
                    
                    <li class="activity-item">
                        <div class="activity-icon icon-update">
                            <i class="fas fa-sync"></i>
                        </div>
                        <div class="activity-details">
                            <h4>Wheat Irrigation Schedule Updated</h4>
                            <p>Updated by Field Officer</p>
                            <span class="activity-time">Yesterday</span>
                        </div>
                    </li>
                    
                    <li class="activity-item">
                        <div class="activity-icon icon-alert">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="activity-details">
                            <h4>Pest Alert - South Region</h4>
                            <p>Reported by System</p>
                            <span class="activity-time">2 days ago</span>
                        </div>
                    </li>
                    
                    <li class="activity-item">
                        <div class="activity-icon icon-delete">
                            <i class="fas fa-trash"></i>
                        </div>
                        <div class="activity-details">
                            <h4>Removed Outdated Farming Tip</h4>
                            <p>Removed by Admin</p>
                            <span class="activity-time">3 days ago</span>
                        </div>
                    </li>
                </ul>
            </div>
            
            <div class="card">
                <div class="activity-title">
                    <h3>Current Crop Status</h3>
                    <a href="#" class="view-all">View All <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <table class="crop-table">
                    <thead>
                        <tr>
                            <th>Crop</th>
                            <th>Region</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Rice</td>
                            <td>Eastern District</td>
                            <td><span class="crop-status status-healthy">Healthy</span></td>
                        </tr>
                        <tr>
                            <td>Wheat</td>
                            <td>Central District</td>
                            <td><span class="crop-status status-warning">Needs Attention</span></td>
                        </tr>
                        <tr>
                            <td>Maize</td>
                            <td>Northern District</td>
                            <td><span class="crop-status status-healthy">Healthy</span></td>
                        </tr>
                        <tr>
                            <td>Sugarcane</td>
                            <td>Southern District</td>
                            <td><span class="crop-status status-danger">Critical</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="card">
                <div class="calendar">
                    <div class="calendar-header">
                        <div class="calendar-month">March 2025</div>
                        <div class="calendar-nav">
                            <button><i class="fas fa-chevron-left"></i></button>
                            <button><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                    
                    <div class="calendar-days">
                        <div>Su</div>
                        <div>Mo</div>
                        <div>Tu</div>
                        <div>We</div>
                        <div>Th</div>
                        <div>Fr</div>
                        <div>Sa</div>
                    </div>
                    
                    <div class="calendar-dates">
                        <div class="calendar-date muted">24</div>
                        <div class="calendar-date muted">25</div>
                        <div class="calendar-date muted">26</div>
                        <div class="calendar-date muted">27</div>
                        <div class="calendar-date muted">28</div>
                        <div class="calendar-date">1</div>
                        <div class="calendar-date">2</div>
                        <div class="calendar-date">3</div>
                        <div class="calendar-date event">4</div>
                        <div class="calendar-date">5</div>
                        <div class="calendar-date">6</div>
                        <div class="calendar-date">7</div>
                        <div class="calendar-date event">8</div>
                        <div class="calendar-date">9</div>
                        <div class="calendar-date">10</div>
                        <div class="calendar-date">11</div>
                        <div class="calendar-date">12</div>
                        <div class="calendar-date event">13</div>
                        <div class="calendar-date">14</div>
                        <div class="calendar-date">15</div>
                        <div class="calendar-date">16</div>
                        <div class="calendar-date">17</div>
                        <div class="calendar-date">18</div>
                        <div class="calendar-date">19</div>
                        <div class="calendar-date">20</div>
                        <div class="calendar-date">21</div>
                        <div class="calendar-date today">22</div>
                        <div class="calendar-date">23</div>
                        <div class="calendar-date event">24</div>
                        <div class="calendar-date">25</div>
                        <div class="calendar-date">26</div>
                        <div class="calendar-date">27</div>
                        <div class="calendar-date">28</div>
                        <div class="calendar-date">29</div>
                        <div class="calendar-date">30</div>
                        <div class="calendar-date">31</div>
                        <div class="calendar-date muted">1</div>
                        <div class="calendar-date muted">2</div>
                        <div class="calendar-date muted">3</div>
                        <div class="calendar-date muted">4</div>
                        <div class="calendar-date muted">5</div>
                        <div class="calendar-date muted">6</div>
                    </div>
                </div>
            </div>
        </div>
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
        
        // Chart.js - Production Trends
        const productionCtx = document.getElementById('productionChart').getContext('2d');
        const productionChart = new Chart(productionCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Rice',
                        data: [65, 59, 80, 81, 56, 55, 40, 45, 50, 62, 70, 75],
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Wheat',
                        data: [28, 48, 40, 19, 86, 27, 90, 85, 72, 65, 50, 40],
                        borderColor: '#2ecc71',
                        backgroundColor: 'rgba(46, 204, 113, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Maize',
                        data: [45, 25, 40, 62, 35, 25, 50, 60, 65, 45, 30, 20],
                        borderColor: '#f39c12',
                        backgroundColor: 'rgba(243, 156, 18, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Production (tons)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                }
            }
        });
    </script>
</body>
</html>