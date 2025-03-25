<?php
include 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php';
include 'admin_header.php'; 

if (isset($_POST["reply_submit"])) {
    $query_id = $_POST["query_id"];
    $reply = $_POST["reply"];
    $replyFilePath = "";
    if (isset($_FILES["reply_file"]) && $_FILES["reply_file"]["error"] == 0) {
        $fileTmpName = $_FILES["reply_file"]["tmp_name"];
        $fileName = basename($_FILES["reply_file"]["name"]);
        $uploadDir = "uploads/";
        $replyFilePath = $uploadDir . uniqid() . "_" . $fileName;

        move_uploaded_file($fileTmpName, $replyFilePath);
    }
    
    $sql = "UPDATE user_queries SET reply = ?, reply_file = ?, replied_at = NOW() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $reply, $replyFilePath, $query_id);
    $stmt->execute();
    
    // Fetch user email to send notification
    $query = $conn->query("SELECT email FROM user_queries WHERE id = $query_id");
    $user = $query->fetch_assoc();
    
    mail($user["email"], "Your Query Has Been Answered", "Your query has been responded to. Please check your account.");
    
    echo "<script>alert('Reply sent successfully.'); window.location.href='admin.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Queries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        textarea {
            width: 100%;
            height: 60px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type='file'] {
            padding: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
            transition: background 0.3s ease;
        }
        button:hover {
            background-color: #45a049;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2> Manage User Queries</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>Message</th>
            <th>Attachment</th>
            <th>Reply</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM user_queries");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["contact_no"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["message"]) . "</td>";
            echo "<td><a href='" . htmlspecialchars($row["file_path"]) . "' target='_blank'>Download</a></td>";
            echo "<td>";
            echo "<form method='POST' enctype='multipart/form-data'>";
            echo "<input type='hidden' name='query_id' value='" . $row["id"] . "'>";
            echo "<textarea name='reply' required></textarea>";
            echo "<input type='file' name='reply_file'>";
            echo "<button type='submit' name='reply_submit'>Send Reply</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
