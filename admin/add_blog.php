<?php
ob_start();  // Start output buffering
include 'C:/xampp/htdocs/The Department of Agriculture Services Website/db_connect.php';
include 'admin_header.php';

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
    <!-- Tailwind CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-family-karla flex flex-col items-center justify-center min-h-screen">

    <!-- Main Content -->
    <div class="w-full max-w-6xl bg-white p-10 rounded-lg shadow-xl">
        <h1 class="text-3xl font-bold text-center mb-6">Manage Blogs</h1>

        <!-- Add/Edit Blog Form -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-md mb-6">
            <h2 class="text-2xl font-semibold mb-6 text-center">Add / Edit Blog</h2>
            <form action="add_blog.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="blog_id" id="blog_id">

                <div>
                    <label class="block text-sm text-gray-600" for="title">Title</label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                </div>

                <div>
                    <label class="block text-sm text-gray-600" for="author">Author</label>
                    <input type="text" name="author" id="author" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                </div>

                <div>
                    <label class="block text-sm text-gray-600" for="image">Image</label>
                    <input type="file" name="image" id="image" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <label class="block text-sm text-gray-600" for="content">Content</label>
                    <textarea name="content" id="content" class="w-full px-4 py-2 border border-gray-300 rounded-lg" rows="6" required></textarea>
                </div>

                <div>
                    <label class="block text-sm text-gray-600" for="category">Category</label>
                    <input type="text" name="category" id="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <label class="block text-sm text-gray-600" for="tags">Tags</label>
                    <input type="text" name="tags" id="tags" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Save Blog</button>
                </div>
            </form>
        </div>

        <!-- Blog List -->
        <div class="bg-gray-50 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold mb-6 text-center">Blog List</h2>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2 text-left">ID</th>
                        <th class="border p-2 text-left">Title</th>
                        <th class="border p-2 text-left">Author</th>
                        <th class="border p-2 text-left">Category</th>
                        <th class="border p-2 text-left">Image</th>
                        <th class="border p-2 text-left">Actions</th>
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
                                    <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Blog Image" class="w-20 h-20 object-cover rounded-lg">
                                <?php else: ?>
                                    <span class="text-gray-500">No Image</span>
                                <?php endif; ?>
                            </td>
                            <td class="border p-2">
                                <button onclick="editBlog(<?php echo $row['id']; ?>, '<?php echo addslashes($row['title']); ?>', '<?php echo addslashes($row['author']); ?>', '<?php echo addslashes($row['content']); ?>', '<?php echo addslashes($row['category']); ?>', '<?php echo addslashes($row['tags']); ?>')" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition duration-300">Edit</button>
                                <a href="add_blog.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition duration-300">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="w-full bg-white text-center p-4 mt-6">
        <p class="text-gray-600">&copy; <?php echo date("Y"); ?> The Department of Agriculture Services. All rights reserved.</p>
    </footer>

    <!-- AlpineJS for Dropdown Nav -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <!-- JavaScript for Edit Blog Functionality -->
    <script>
        function editBlog(id, title, author, content, category, tags) {
            document.getElementById('blog_id').value = id;
            document.getElementById('title').value = title;
            document.getElementById('author').value = author;
            document.getElementById('content').value = content;
            document.getElementById('category').value = category;
            document.getElementById('tags').value = tags;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    </script>
</body>
</html>