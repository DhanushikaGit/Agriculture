<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Agriculture_Services_Website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch Water Schedule Data
$sql = "SELECT * FROM water_schedule";
$result = $conn->query($sql);
$schedules = [];

while ($row = $result->fetch_assoc()) {
    $schedules[] = $row;
}

// Close Connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Schedule Viewer</title>

    <!-- jQuery & DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- FileSaver.js for CSV download -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

 <!-- Favicons -->
 <link href="assets/img/logoo-Recovered.bmp" rel="icon">
    <link href="assets/img/logoo-Recovered.bmp" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Vendor CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <!-- Main CSS -->
    <link href="assets/css/main.css" rel="stylesheet">
<style>
    /* Main CSS for Water Schedule Page */
:root {
    --primary-color: #2e7d32;
    --secondary-color: #dcedc8;
    --accent-color: #558b2f;
    --text-color: #333;
    --light-bg: #f9f9f9;
    --border-color: #e0e0e0;
    --hover-color: #f5f5f5;
}

body {
    font-family: 'Open Sans', 'Segoe UI', Arial, sans-serif;
    line-height: 1.6;
    color: var(--text-color);
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

h2 {
    color: var(--primary-color);
    text-align: center;
    margin: 30px 0;
    padding-bottom: 10px;
    border-bottom: 3px solid var(--accent-color);
    display: inline-block;
    position: relative;
    left: 50%;
    transform: translateX(-50%);
}

/* Search and Download Section */
#search {
    width: 100%;
    max-width: 400px;
    padding: 12px 15px;
    margin-bottom: 20px;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    font-size: 16px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

#search:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 5px rgba(46, 125, 50, 0.3);
}

.download-btn {
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    float: right;
    transition: background-color 0.3s;
}

.download-btn:hover {
    background-color: var(--accent-color);
}

/* Table Styling */
#scheduleTable {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    background-color: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

#scheduleTable thead {
    background-color: var(--primary-color);
    color: white;
}

#scheduleTable th {
    padding: 15px;
    text-align: left;
    font-weight: 600;
    border: none;
}

#scheduleTable td {
    padding: 12px 15px;
    border-bottom: 1px solid var(--border-color);
}

#scheduleTable tbody tr:hover {
    background-color: var(--secondary-color);
}

#scheduleTable tbody tr:last-child td {
    border-bottom: none;
}

/* DataTables Customization */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_processing,
.dataTables_wrapper .dataTables_paginate {
    color: var(--text-color);
    margin-bottom: 15px;
}

.dataTables_wrapper .dataTables_length select {
    border: 1px solid var(--border-color);
    border-radius: 4px;
    padding: 5px;
    background-color: white;
}

.dataTables_wrapper .dataTables_filter input {
    border: 1px solid var(--border-color);
    border-radius: 4px;
    padding: 8px;
    margin-left: 5px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    border: 1px solid transparent;
    border-radius: 4px;
    padding: 6px 12px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current,
.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    background: var(--primary-color) !important;
    color: white !important;
    border-color: var(--primary-color) !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: var(--secondary-color) !important;
    color: var(--primary-color) !important;
    border-color: var(--primary-color) !important;
}

/* Responsive Styles */
@media screen and (max-width: 768px) {
    .container {
        padding: 15px;
    }
    
    #search {
        max-width: 100%;
        margin-bottom: 15px;
    }
    
    .download-btn {
        float: none;
        width: 100%;
        margin-bottom: 20px;
    }
    
    #scheduleTable {
        display: block;
        overflow-x: auto;
    }
    
    #scheduleTable th, 
    #scheduleTable td {
        padding: 10px;
    }
}

/* Additional UI Elements */
.schedule-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.schedule-title {
    font-size: 24px;
    color: var(--primary-color);
    margin: 0;
}

.schedule-actions {
    display: flex;
    gap: 10px;
}

.info-box {
    background-color: var(--secondary-color);
    border-left: 4px solid var(--primary-color);
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.info-box h3 {
    margin-top: 0;
    color: var(--primary-color);
}

.info-box p {
    margin-bottom: 0;
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: var(--accent-color);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: var(--primary-color);
}
</style>

</head>
<body>
<?php include 'header.php'; ?>
    <h2>Water Schedule</h2>

    <div class="container">
        <input type="text" id="search" placeholder="Search schedule..." onkeyup="searchTable()">
        <button class="download-btn" onclick="downloadCSV()">Download CSV</button>

        <table id="scheduleTable">
            <thead>
                <tr>
                    
                    <th>Region</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($schedules as $schedule): ?>
                    <tr>
                     
                        <td><?= htmlspecialchars($schedule['region']) ?></td>
                        <td><?= htmlspecialchars($schedule['date']) ?></td>
                        <td><?= htmlspecialchars($schedule['time']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            $("#scheduleTable").DataTable();
        });

        function searchTable() {
            let input = document.getElementById("search").value.toLowerCase();
            $("#scheduleTable tbody tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(input) > -1);
            });
        }

        function downloadCSV() {
            let csv = "ID,Region,Date,Time\n";
            $("#scheduleTable tbody tr").each(function () {
                let row = [];
                $(this).find("td").each(function () {
                    row.push($(this).text());
                });
                csv += row.join(",") + "\n";
            });

            let blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
            saveAs(blob, "water_schedule.csv");
        }
    </script>
       <?php include 'footer.php'; ?>
</body>
</html>
