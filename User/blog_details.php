<?php
// Include the database connection file
include 'C:/xampp/htdocs/The Department of Agriculture Services Website/db_connect.php';

// Get the blog ID from the URL
if (isset($_GET['id'])) {
    $blog_id = intval($_GET['id']);
} else {
    die("Invalid blog ID.");
}

// Fetch the specific blog from the database
$sql = "SELECT * FROM blogs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Blog not found.");
}

$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo htmlspecialchars($row['title']); ?> - AgriCulture Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

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
    .blog-image {
      width: 100%;
      height: 400px; /* Larger height for the details page */
      object-fit: cover; /* Ensures the image covers the area without distortion */
    }
  </style>
</head>

<body class="blog-page">

<?php include 'header.php'; ?>

<?php include 'chatbot.php'; ?>
  <main class="main">

    <!-- Page Title -->
    
    <!-- Blog Details Section -->
    <section id="blog-details" class="blog-details section">

      <div class="container">
        <div class="row">

          <div class="col-lg-8">
            <article class="position-relative h-100">

              <div class="post-img position-relative overflow-hidden">
                <?php
                // Define the base path for uploaded images
                $uploadDir = "C:/xampp/htdocs/The Department of Agriculture Services Website/admin/uploads/";
                $imagePath = $uploadDir . $row['image'];

                // Check if the image file exists
                if (!empty($row['image']) && file_exists($imagePath)) {
                    // Display the uploaded image
                    echo '<img src="/The Department of Agriculture Services Website/admin/uploads/' . htmlspecialchars($row['image']) . '" class="blog-image" alt="' . htmlspecialchars($row['title']) . '">';
                } else {
                    // Display the default image if no uploaded image is found
                    echo '<img src="assets/img/blog/blog-default.jpg" class="blog-image" alt="Default Blog Image">';
                }
                ?>
              </div>

              <div class="meta d-flex align-items-end">
                <span class="post-date"><span><?php echo date('d', strtotime($row['created_at'])); ?></span><?php echo date('F', strtotime($row['created_at'])); ?></span>
                <div class="d-flex align-items-center">
                  <i class="bi bi-person"></i> <span class="ps-2"><?php echo htmlspecialchars($row['author']); ?></span>
                </div>
                <span class="px-3 text-black-50">/</span>
                <div class="d-flex align-items-center">
                  <i class="bi bi-folder2"></i> <span class="ps-2"><?php echo htmlspecialchars($row['category']); ?></span>
                </div>
              </div>

              <div class="post-content">
                <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                <p><?php echo htmlspecialchars($row['content']); ?></p>
              </div>

            </article>
          </div><!-- End blog details content -->

        </div>
      </div>

    </section><!-- /Blog Details Section -->

  </main>

  <?php include 'footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  
  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>