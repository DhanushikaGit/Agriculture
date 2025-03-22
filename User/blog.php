<?php
// Include the database connection file
include 'C:/xampp/htdocs/The Department of Agriculture Services Website/db_connect.php';

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
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Blog - AgriCulture Bootstrap Template</title>
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

  <!-- =======================================================
  * Template Name: AgriCulture
  * Template URL: https://bootstrapmade.com/agriculture-bootstrap-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="blog-page">

<?php include 'header.php'; ?>

  <main class="main">

  <h1 class="text-3xl font-bold text-center mb-6">Blogs</h1>

    <!-- Blog Posts 2 Section -->
    <section id="blog-posts-2" class="blog-posts-2 section">

      <div class="container">
        <div class="row gy-4">

          <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-lg-4">
              <article class="position-relative h-100">

                <div class="post-img position-relative overflow-hidden">
                  <?php
                  // Define the base path for uploaded images
                  $uploadDir = "C:/xampp/htdocs/The Department of Agriculture Services Website/admin/uploads/";
                  $imagePath = $uploadDir . $row['image'];

                  // Check if the image file exists
                  if (!empty($row['image']) && file_exists($imagePath)) {
                      // Display the uploaded image
                      echo '<img src="/The Department of Agriculture Services Website/admin/uploads/' . htmlspecialchars($row['image']) . '" class="img-fluid" alt="' . htmlspecialchars($row['title']) . '">';
                  } else {
                      // Display the default image if no uploaded image is found
                      echo '<img src="assets/img/blog/blog-default.jpg" class="img-fluid" alt="Default Blog Image">';
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

                <div class="post-content d-flex flex-column">
                  <h3 class="post-title"><?php echo htmlspecialchars($row['title']); ?></h3>
                  <p><?php echo substr(htmlspecialchars($row['content']), 0, 100) . '...'; ?></p>
                  <a href="blog_details.php?id=<?php echo $row['id']; ?>" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
                </div>

              </article>
            </div><!-- End post list item -->
          <?php endwhile; ?>

        </div>
      </div>

    </section><!-- /Blog Posts 2 Section -->

    <!-- Blog Pagination Section -->
    <section id="blog-pagination" class="blog-pagination section">

      <div class="container">
        <div class="d-flex justify-content-center">
          <ul>
            <li><a href="#"><i class="bi bi-chevron-left"></i></a></li>
            <li><a href="#">1</a></li>
            <li><a href="#" class="active">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li>...</li>
            <li><a href="#">10</a></li>
            <li><a href="#"><i class="bi bi-chevron-right"></i></a></li>
          </ul>
        </div>
      </div>

    </section><!-- /Blog Pagination Section -->

    

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