<?php 
$servername = "localhost"; 
$username = "root";  
$password = "";      
$dbname = "Agriculture_Services_Website";  
$conn = new mysqli($servername, $username, $password, $dbname);  

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); 
}

// Handle Search
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $stmt = $conn->prepare("SELECT * FROM videos WHERE title LIKE ?");
    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM videos"); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agriculture Videos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .search-bar {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-bar input {
            padding: 8px;
            width: 60%;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .search-bar button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .video-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .video-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .video-card:hover {
            transform: scale(1.03);
        }
        .video-card video {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        .video-info {
            padding: 15px;
        }
        .video-info h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .download-btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 10px;
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<?php include 'chatbot.php'; ?>

<div class="container">
    <h2>Agriculture Video Library</h2>

    <div class="search-bar">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by title..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="video-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="video-card">
                    <video controls preload="metadata">
                        <source src="uploads/<?= htmlspecialchars($row['filename']) ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <div class="video-info">
                        <h3><?= htmlspecialchars($row['title']) ?></h3>
                        <a href="uploads/<?= htmlspecialchars($row['filename']) ?>" download class="download-btn">Download Video</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align: center; color: red;">No videos found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
<?php $conn->close(); ?>
