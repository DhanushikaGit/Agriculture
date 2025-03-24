<?php
session_start();
require 'C:\xampp\htdocs\The Department of Agriculture Services Website\db_connect.php';



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    $user_id = $_SESSION['user_id'];
    $message = $conn->real_escape_string(trim($_POST['message']));
    
    // Create uploads directory if it doesn't exist
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // File handling with unique names
    $photo = null;
    $video = null;
    $attachment = null;

    if ($_FILES['photo']['name']) {
        $photo = $uploadDir . uniqid() . '_' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photo);
    }
    if ($_FILES['video']['name']) {
        $video = $uploadDir . uniqid() . '_' . basename($_FILES['video']['name']);
        move_uploaded_file($_FILES['video']['tmp_name'], $video);
    }
    if ($_FILES['attachment']['name']) {
        $attachment = $uploadDir . uniqid() . '_' . basename($_FILES['attachment']['name']);
        move_uploaded_file($_FILES['attachment']['tmp_name'], $attachment);
    }

    $stmt = $conn->prepare("INSERT INTO discussion (user_id, message, photo, video, attachment) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $user_id, $message, $photo, $video, $attachment);
    
    if ($stmt->execute()) {
        header("Location: discussion.php");
        exit();
    }
    $stmt->close();
}

$result = $conn->query("SELECT d.*, u.name FROM discussion d JOIN users u ON d.user_id = u.id ORDER BY d.created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agricultural Discussion Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link href="assets/img/logoo-Recovered.jpg" rel="icon">
   

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Marcellus:wght@400&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
    <style>
        /* Main Color Scheme */
:root {
  --primary-color: #2e7d32;
  --primary-light: #60ad5e;
  --primary-dark: #005005;
  --secondary-color: #f9a825;
  --bg-color: #f5f7f1;
  --card-bg: #ffffff;
  --text-primary: #333333;
  --text-secondary: #666666;
  --border-color: #e0e0e0;
}

body {
  background-color: var(--bg-color);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: var(--text-primary);
}

/* Header Styling */
header {
  background-color: var(--primary-color);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

/* Main Container */
main.container {
  max-width: 1200px;
  padding: 2rem 1rem;
}

/* Page Title */
.page-title {
  font-size: 2.5rem;
  font-weight: 700;
  color: var(--primary-color);
  text-align: center;
  margin-bottom: 2rem;
  position: relative;
  padding-bottom: 1rem;
}

.page-title:after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 80px;
  height: 4px;
  background-color: var(--secondary-color);
  border-radius: 2px;
}

/* Discussion Form Card */
.discussion-form {
  background-color: var(--card-bg);
  border-radius: 12px;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
  padding: 1.5rem;
  margin-bottom: 2rem;
  border-top: 5px solid var(--primary-color);
}

.discussion-form h2 {
  font-size: 1.5rem;
  color: var(--primary-color);
  margin-bottom: 1.5rem;
  font-weight: 600;
}

.discussion-form textarea {
  width: 100%;
  padding: 1rem;
  border: 1px solid var(--border-color);
  border-radius: 8px;
  resize: vertical;
  min-height: 120px;
  font-size: 1rem;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.discussion-form textarea:focus {
  outline: none;
  border-color: var(--primary-light);
  box-shadow: 0 0 0 3px rgba(96, 173, 94, 0.2);
}

/* File Upload Styling */
.upload-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
  margin: 1.5rem 0;
}

.upload-item {
  position: relative;
}

.upload-label {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 1.5rem 1rem;
  border: 2px dashed var(--border-color);
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
  background-color: rgba(46, 125, 50, 0.05);
}

.upload-label:hover {
  border-color: var(--primary-light);
  background-color: rgba(46, 125, 50, 0.1);
}

.upload-label i {
  font-size: 1.5rem;
  color: var(--primary-color);
  margin-bottom: 0.5rem;
}

.upload-label span {
  font-size: 0.9rem;
  color: var(--text-secondary);
  text-align: center;
}

/* Submit Button */
.submit-btn {
  background-color: var(--primary-color);
  color: white;
  font-weight: 600;
  padding: 0.8rem 1.5rem;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s ease, transform 0.2s ease;
  width: 100%;
  font-size: 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.submit-btn:hover {
  background-color: var(--primary-dark);
  transform: translateY(-2px);
}

.submit-btn:active {
  transform: translateY(0);
}

/* Discussion Posts */
.discussion-posts {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.post-card {
  background-color: var(--card-bg);
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  padding: 1.5rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  overflow: hidden;
}

.post-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.post-header {
  display: flex;
  align-items: center;
  margin-bottom: 1rem;
}

.avatar {
  width: 48px;
  height: 48px;
  border-radius: 50%;
  background-color: rgba(46, 125, 50, 0.15);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 1rem;
}

.avatar i {
  color: var(--primary-color);
  font-size: 1.2rem;
}

.post-info .username {
  font-weight: 600;
  color: var(--text-primary);
  margin-bottom: 0.2rem;
}

.post-info .timestamp {
  font-size: 0.8rem;
  color: var(--text-secondary);
}

.post-content {
  margin-bottom: 1rem;
  line-height: 1.6;
  color: var(--text-primary);
}

.post-media {
  margin-top: 1rem;
  border-radius: 8px;
  overflow: hidden;
}

.post-media img,
.post-media video {
  width: 100%;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.post-attachment {
  display: inline-flex;
  align-items: center;
  margin-top: 1rem;
  padding: 0.5rem 1rem;
  background-color: rgba(46, 125, 50, 0.1);
  border-radius: 20px;
  transition: background-color 0.3s ease;
}

.post-attachment:hover {
  background-color: rgba(46, 125, 50, 0.2);
}

.post-attachment i {
  color: var(--primary-color);
  margin-right: 0.5rem;
}

.post-attachment a {
  color: var(--primary-color);
  text-decoration: none;
  font-size: 0.9rem;
  font-weight: 500;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .page-title {
    font-size: 2rem;
  }
  
  .discussion-form {
    padding: 1.2rem;
  }
  
  .upload-container {
    grid-template-columns: 1fr;
  }
  
  .post-card {
    padding: 1.2rem;
  }
}

/* Animation Effects */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.discussion-posts .post-card {
  animation: fadeIn 0.5s ease forwards;
}

.discussion-posts .post-card:nth-child(odd) {
  animation-delay: 0.1s;
}

.discussion-posts .post-card:nth-child(even) {
  animation-delay: 0.2s;
}
    </style>
</head>
<body class="bg-gray-50">
    <?php include 'header.php'; ?>

    <?php include 'chatbot.php'; ?>
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-green-800 mb-8 text-center">Agricultural Discussion Forum</h1>

            <!-- Post Message Form -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-xl font-semibold mb-4">Start a Discussion</h2>
                <form action="discussion.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <textarea 
                            name="message" 
                            required 
                            placeholder="Share your agricultural knowledge or ask a question..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 h-32"
                        ></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="relative">
                            <input type="file" name="photo" accept="image/*" class="hidden" id="photo-upload">
                            <label for="photo-upload" class="cursor-pointer block text-center p-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500">
                                <i class="fas fa-image text-gray-400 mb-2"></i>
                                <span class="block text-sm text-gray-600">Add Photo</span>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="file" name="video" accept="video/*" class="hidden" id="video-upload">
                            <label for="video-upload" class="cursor-pointer block text-center p-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500">
                                <i class="fas fa-video text-gray-400 mb-2"></i>
                                <span class="block text-sm text-gray-600">Add Video</span>
                            </label>
                        </div>

                        <div class="relative">
                            <input type="file" name="attachment" class="hidden" id="file-upload">
                            <label for="file-upload" class="cursor-pointer block text-center p-3 border-2 border-dashed border-gray-300 rounded-lg hover:border-green-500">
                                <i class="fas fa-paperclip text-gray-400 mb-2"></i>
                                <span class="block text-sm text-gray-600">Add Attachment</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-300">
                        Post Discussion
                    </button>
                </form>
            </div>

            <!-- Discussion Posts -->
            <div class="space-y-6">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-green-600"></i>
                                </div>
                                <div class="ml-3">
                                    <h3 class="font-semibold text-gray-800"><?= htmlspecialchars($row['name']) ?></h3>
                                    <p class="text-sm text-gray-500"><?= date('F j, Y g:i a', strtotime($row['created_at'])) ?></p>
                                </div>
                            </div>
                        </div>

                        <p class="text-gray-700 mb-4"><?= nl2br(htmlspecialchars($row['message'])) ?></p>

                        <?php if ($row['photo']) : ?>
                            <div class="mb-4">
                                <img src="<?= htmlspecialchars($row['photo']) ?>" class="rounded-lg max-w-full h-auto" alt="Posted photo">
                            </div>
                        <?php endif; ?>

                        <?php if ($row['video']) : ?>
                            <div class="mb-4">
                                <video class="rounded-lg w-full" controls>
                                    <source src="<?= htmlspecialchars($row['video']) ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        <?php endif; ?>

                        <?php if ($row['attachment']) : ?>
                            <div class="flex items-center text-blue-600 hover:text-blue-800">
                                <i class="fas fa-paperclip mr-2"></i>
                                <a href="<?= htmlspecialchars($row['attachment']) ?>" download class="text-sm">
                                    Download Attachment
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script>
        // Preview file names when selected
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const label = this.nextElementSibling;
                const fileName = this.files[0]?.name;
                if (fileName) {
                    label.querySelector('span').textContent = fileName;
                }
            });
        });
    </script>
</body>
</html>