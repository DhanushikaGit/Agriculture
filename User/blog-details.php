<?php
include 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = $conn->prepare("SELECT * FROM blogs WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $blog = $result->fetch_assoc();
    } else {
        echo "<h2>Blog Not Found!</h2>";
        exit;
    }
} else {
    echo "<h2>Invalid Request!</h2>";
    exit;
}
?>

<div class="post-img">
    <img src="uploads/<?php echo $blog['image']; ?>" alt="" class="img-fluid">
</div>

<h2 class="title"><?php echo $blog['title']; ?></h2>

<div class="meta-top">
    <ul>
        <li><i class="bi bi-person"></i> <?php echo $blog['author']; ?></li>
        <li><i class="bi bi-clock"></i> <time><?php echo date("F j, Y", strtotime($blog['created_at'])); ?></time></li>
    </ul>
</div>

<div class="content">
    <p><?php echo nl2br($blog['content']); ?></p>
</div>
