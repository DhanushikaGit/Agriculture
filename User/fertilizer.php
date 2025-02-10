<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Fertilizer Application</title>
  <meta name="description" content="Fertilizer Application Form">
  <meta name="keywords" content="fertilizer, agriculture, farming">

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
</head>

<body class="fertilizer-page">
  <?php include 'header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
      <div class="container position-relative">
        <h1>Fertilizer Application</h1>
        <p>Apply for fertilizer and get the best support for your farming needs.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Fertilizer</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Fertilizer Form Section -->
    <section id="fertilizer-form" class="fertilizer-form section">

      <div class="container">
        <div class="row gy-4 justify-content-center">
          <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
            <h2 class="content-title mb-4">Fertilizer Application Form</h2>
            <form action="submit_fertilizer.php" method="post" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="name">Full Name</label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>
                <div class="col-md-6 form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="phone">Phone Number</label>
                  <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone" required>
                </div>
                <div class="col-md-6 form-group">
                  <label for="address">Address</label>
                  <input type="text" class="form-control" name="address" id="address" placeholder="Your Address" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="fertilizer-type">Fertilizer Type</label>
                  <select name="fertilizer-type" id="fertilizer-type" class="form-control" required>
                    <option value="">Select Fertilizer Type</option>
                    <option value="urea">Urea</option>
                    <option value="tsp">TSP</option>
                    <option value="potassium">Potassium</option>
                  </select>
                </div>
                <div class="col-md-6 form-group">
                  <label for="quantity">Quantity (kg)</label>
                  <input type="number" class="form-control" name="quantity" id="quantity" placeholder="Quantity" required>
                </div>
              </div>
              <div class="form-group">
                <label for="message">Additional Information</label>
                <textarea class="form-control" name="message" rows="5" placeholder="Any additional information"></textarea>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit Application</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section><!-- /Fertilizer Form Section -->

  </main>

  <?php include 'footer.php'; ?>
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

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