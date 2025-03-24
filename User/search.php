<?php
// search.php

// Database connection
$servername = "127.0.0.1";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "agriculture_services_website";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query from the URL parameter
$query = isset($_GET['query']) ? $_GET['query'] : '';

// If the query is not empty, perform the search
if (!empty($query)) {
    // Prepare the SQL statement to search across multiple tables
    $sql = "
    (SELECT id, title, content AS description, 'blogs' AS source FROM blogs WHERE title LIKE ? OR content LIKE ?)
    UNION
    (SELECT id, title, content AS description, 'farming_guides' AS source FROM farming_guides WHERE title LIKE ? OR content LIKE ?)
    UNION
    (SELECT id, title, introduction AS description, 'farming_tips' AS source FROM farming_tips WHERE title LIKE ? OR introduction LIKE ?)
    UNION
    (SELECT id, product_name AS title, description, 'market_trends' AS source FROM market_trends WHERE product_name LIKE ? OR description LIKE ?)
";


    // Prepare the statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $searchQuery = "%$query%";
    $stmt->bind_param("ssssssss", $searchQuery, $searchQuery, $searchQuery, $searchQuery, $searchQuery, $searchQuery, $searchQuery, $searchQuery);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch results
    $results = [];
    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }

    // Close the statement
    $stmt->close();
} else {
    $results = [];
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="assets/css/main.css" rel="stylesheet">
    <?php include 'header.php'; ?>
  
  <?php include 'chatbot.php'; ?>
    <style>
        .search-results {
            margin: 20px;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .result-item {
            margin-bottom: 15px;
            padding: 10px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .result-item h3 {
            margin: 0;
            color: #2e5d34;
        }
        .result-item p {
            margin: 5px 0;
            color: #555;
        }
        .result-item .source {
            font-size: 0.9em;
            color: #888;
        }
    </style>
</head>
<body>
    <header id="header">
        <h1>Search Results</h1>
    <main id="main">
        <div class="search-results">
            <h2>Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $result): ?>
                    <div class="result-item">
                        <h3><?php echo htmlspecialchars($result['title']); ?></h3>
                        <p><?php echo htmlspecialchars($result['description']); ?></p>
                        <p class="source">Source: <?php echo htmlspecialchars($result['source']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No results found.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>