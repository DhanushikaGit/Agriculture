<?php
include 'C:/xampp/htdocs/The Department of Agriculture Services Website/db_connect.php';

// Debugging: Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Handle Add/Edit Blog
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES);
    $author = htmlspecialchars($_POST['author'], ENT_QUOTES);
    $content = htmlspecialchars($_POST['content'], ENT_QUOTES);
    $category = htmlspecialchars($_POST['category'], ENT_QUOTES);
    $tags = htmlspecialchars($_POST['tags'], ENT_QUOTES);
    $blog_id = isset($_POST['blog_id']) ? intval($_POST['blog_id']) : null;

    // Image Upload Handling
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = "";
    if (!empty($_FILES["image"]["name"])) {
        $fileName = uniqid() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $uploadDir . $fileName;

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            die("Error uploading file.");
        }
    }

    if ($blog_id) {
        // Update existing blog
        if ($fileName) {
            $sql = "UPDATE blogs SET title=?, author=?, image=?, content=?, category=?, tags=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $title, $author, $fileName, $content, $category, $tags, $blog_id);
        } else {
            $sql = "UPDATE blogs SET title=?, author=?, content=?, category=?, tags=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $title, $author, $content, $category, $tags, $blog_id);
        }
    } else {
        // Insert new blog
        $sql = "INSERT INTO blogs (title, author, image, content, category, tags) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $title, $author, $fileName, $content, $category, $tags);
    }

    if ($stmt->execute()) {
        header("Location: add_blog.php?rand=" . rand());
        exit;
    } else {
        die("Error: " . $stmt->error);
    }
    $stmt->close();
}

// Handle Delete Blog
if (isset($_GET['delete'])) {
    $blog_id = intval($_GET['delete']);
    $sql = "DELETE FROM blogs WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $blog_id);

    if ($stmt->execute()) {
        header("Location: add_blog.php?rand=" . rand());
        exit;
    } else {
        die("Error: " . $stmt->error);
    }
    $stmt->close();
}

// Fetch Blogs for Display
$sql = "SELECT * FROM blogs ORDER BY id DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching blogs: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-center mb-6">Manage Blogs</h1>

        <!-- Add/Edit Blog Form -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-xl font-semibold mb-4">Add / Edit Blog</h2>
            <form action="add_blog.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="blog_id" id="blog_id">
                
                <label class="block mb-2">Title</label>
                <input type="text" name="title" id="title" class="w-full p-2 border rounded-lg mb-2" required>

                <label class="block mb-2">Author</label>
                <input type="text" name="author" id="author" class="w-full p-2 border rounded-lg mb-2" required>

                <label class="block mb-2">Image</label>
                <input type="file" name="image" id="image" class="w-full p-2 border rounded-lg mb-2">

                <label class="block mb-2">Content</label>
                <textarea name="content" id="content" class="w-full p-2 border rounded-lg mb-2" rows="4" required></textarea>

                <label class="block mb-2">Category</label>
                <input type="text" name="category" id="category" class="w-full p-2 border rounded-lg mb-2">

                <label class="block mb-2">Tags</label>
                <input type="text" name="tags" id="tags" class="w-full p-2 border rounded-lg mb-2">

                <button type="submit" class="bg-blue-500 text-white p-2 rounded-lg">Save Blog</button>
            </form>
        </div>

        <!-- Blog List -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Blog List</h2>
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">ID</th>
                        <th class="border p-2">Title</th>
                        <th class="border p-2">Author</th>
                        <th class="border p-2">Category</th>
                        <th class="border p-2">Image</th>
                        <th class="border p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="border p-2"><?php echo $row['id']; ?></td>
                            <td class="border p-2"><?php echo htmlspecialchars($row['title']); ?></td>
                            <td class="border p-2"><?php echo htmlspecialchars($row['author']); ?></td>
                            <td class="border p-2"><?php echo htmlspecialchars($row['category']); ?></td>
                            <td class="border p-2">
                                <?php if (!empty($row['image']) && file_exists("uploads/" . $row['image'])): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Blog Image" class="w-20 h-20 object-cover">
                                <?php else: ?>
                                    No Image
                                <?php endif; ?>
                            </td>
                            <td class="border p-2">
                                <button onclick="editBlog(<?php echo $row['id']; ?>, '<?php echo addslashes($row['title']); ?>', '<?php echo addslashes($row['author']); ?>', '<?php echo addslashes($row['content']); ?>', '<?php echo addslashes($row['category']); ?>', '<?php echo addslashes($row['tags']); ?>')" class="bg-yellow-500 text-white p-2 rounded">Edit</button>
                                <a href="add_blog.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="bg-red-500 text-white p-2 rounded">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function editBlog(id, title, author, content, category, tags) {
        document.getElementById("blog_id").value = id;
        document.getElementById("title").value = title;
        document.getElementById("author").value = author;
        document.getElementById("content").value = content;
        document.getElementById("category").value = category;
        document.getElementById("tags").value = tags;
    }
    </script>
</body>
</html>