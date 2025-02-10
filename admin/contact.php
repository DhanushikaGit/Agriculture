<?php
include 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php';

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
</head>
<body>
    <h2>User Queries</h2>
    <table border="1">
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
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["contact_no"] . "</td>";
            echo "<td>" . $row["message"] . "</td>";
            echo "<td><a href='" . $row["file_path"] . "' target='_blank'>Download</a></td>";
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
