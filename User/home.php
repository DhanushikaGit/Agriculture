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
  <title>Index - AgriCulture Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/logoo-Recovered.jpg" rel="icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
 

<body class="index-page">

  <?php include 'header.php'; ?>
  
  <?php include 'chatbot.php'; ?>
  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

        <div class="carousel-item active">
          <img src="assets/img/hero_1.jpg" alt="">
          <div class="carousel-container">
            <h2>Farming is the best solution of worlds starvation</h2>
         
          </div>
        </div><!-- End Carousel Item -->

        <div class="carousel-item">
          <img src="assets/img/hero_2.jpg" alt="">
          <div class="carousel-container">
            <h2>Organic vegetables is good for health</h2>
           
          </div>
        </div><!-- End Carousel Item -->

        <div class="carousel-item">
          <img src="assets/img/hero_3.jpg" alt="">
          <div class="carousel-container">
            <h2>Providing Fresh Produce Every Single Day</h2>
           
          </div>
        </div><!-- End Carousel Item -->

        <div class="carousel-item">
          <img src="assets/img/hero_4.jpg" alt="">
          <div class="carousel-container">
            <h2>Farming as a Passione</h2>
            
          </div>
        </div><!-- End Carousel Item -->

        <div class="carousel-item">
          <img src="assets/img/hero_5.jpg" alt="">
          <div class="carousel-container">
            <h2>Good Food For All</h2>
          
          </div>
        </div><!-- End Carousel Item -->

        <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>

        <ol class="carousel-indicators"></ol>

      </div>
      

    </section><!-- /Hero Section -->
<!-- New Technology Grid Section -->
<!-- New Technology Grid Section -->
<section id="technology" class="technology section">
  <div class="container">
    <div class="row g-0">
      <!-- Tech 1 -->
      <div class="col-lg-3 col-md-6">
        <div class="tech-item">
          <div class="tech-icon">
            <i class="fas fa-tint"></i> <!-- Font Awesome icon for water -->
          </div>
          <h3 class="tech-heading">Smart Irrigation Systems</h3>
          <p>
            Advanced irrigation systems that use sensors and AI to optimize water usage, ensuring crops get the right amount of water at the right time.
          </p>
        </div>
      </div>
      <!-- Tech 2 -->
      <div class="col-lg-3 col-md-6">
        <div class="tech-item">
          <div class="tech-icon">
            <i class="fas fa-helicopter"></i> <!-- Font Awesome icon for drone -->
          </div>
          <h3 class="tech-heading">Drone Farming</h3>
          <p>
            Drones equipped with cameras and sensors to monitor crop health, spray fertilizers, and map fields for precision agriculture.
          </p>
        </div>
      </div>
      <!-- Tech 3 -->
      <div class="col-lg-3 col-md-6">
        <div class="tech-item">
          <div class="tech-icon">
            <i class="fas fa-seedling"></i> <!-- Font Awesome icon for plants -->
          </div>
          <h3 class="tech-heading">Vertical Farming</h3>
          <p>
            Innovative farming technique that grows crops in vertically stacked layers, using less space and resources while maximizing yield.
          </p>
        </div>
      </div>
      <!-- Tech 4 -->
      <div class="col-lg-3 col-md-6">
        <div class="tech-item">
          <div class="tech-icon">
            <i class="fas fa-brain"></i> <!-- Font Awesome icon for AI -->
          </div>
          <h3 class="tech-heading">AI-Powered Crop Monitoring</h3>
          <p>
            Artificial intelligence systems that analyze data from sensors and satellites to predict crop diseases, optimize planting, and improve yields.
          </p>
        </div>
      </div>
      <!-- Tech 5 -->
      <div class="col-lg-3 col-md-6">
        <div class="tech-item">
          <div class="tech-icon">
            <i class="fas fa-water"></i> <!-- Font Awesome icon for hydroponics -->
          </div>
          <h3 class="tech-heading">Hydroponics</h3>
          <p>
            Soil-less farming method that grows plants in nutrient-rich water, reducing water usage and allowing farming in urban areas.
          </p>
        </div>
      </div>
      <!-- Tech 6 -->
      <div class="col-lg-3 col-md-6">
        <div class="tech-item">
          <div class="tech-icon">
            <i class="fas fa-link"></i> <!-- Font Awesome icon for blockchain -->
          </div>
          <h3 class="tech-heading">Blockchain for Supply Chain</h3>
          <p>
            Blockchain technology used to track and verify the origin of agricultural products, ensuring transparency and food safety.
          </p>
        </div>
      </div>
      <!-- Tech 7 -->
      <div class="col-lg-3 col-md-6">
        <div class="tech-item">
          <div class="tech-icon">
            <i class="fas fa-robot"></i> <!-- Font Awesome icon for robots -->
          </div>
          <h3 class="tech-heading">Robotic Harvesting</h3>
          <p>
            Robots designed to harvest crops efficiently, reducing labor costs and minimizing damage to plants during the harvesting process.
          </p>
        </div>
      </div>
      <!-- Tech 8 -->
      <div class="col-lg-3 col-md-6">
        <div class="tech-item">
          <div class="tech-icon">
            <i class="fas fa-wifi"></i> <!-- Font Awesome icon for IoT -->
          </div>
          <h3 class="tech-heading">IoT in Agriculture</h3>
          <p>
            Internet of Things (IoT) devices that collect real-time data on soil moisture, temperature, and humidity to optimize farming practices.
          </p>
        </div>
      </div>
    </div>
  </div>
</section><!-- /New Technology Grid Section -->




    <!-- About Section -->
    <section id="about" class="about section">

    <div class="content">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <img src="assets/img/img_long_5.jpg" alt="Image" class="img-fluid img-overlap" data-aos="zoom-out">
      </div>
      <div class="col-lg-5 ml-auto" data-aos="fade-up" data-aos-delay="100">
        <h3 class="content-subtitle text-white opacity-50">About Us</h3>
        <h2 class="content-title mb-4">
          Over <strong>50 years of experience</strong> in the agricultural sector
        </h2>
        <p class="opacity-50">
          The Anuradhapura Agriculture Department has been a cornerstone in Sri Lanka's agricultural development, providing expertise and support to farmers for decades.
        </p>

        <div class="row my-5">
          <div class="col-lg-12 d-flex align-items-start mb-4">
            <i class="bi bi-cloud-rain me-4 display-6"></i>
            <div>
              <h4 class="m-0 h5 text-white">Water for Crops</h4>
              <p class="text-white opacity-50">Ensuring sustainable water management for agriculture.</p>
            </div>
          </div>
          <div class="col-lg-12 d-flex align-items-start mb-4">
            <i class="bi bi-heart me-4 display-6"></i>
            <div>
              <h4 class="m-0 h5 text-white">Promoting Organic Farming</h4>
              <p class="text-white opacity-50">Encouraging eco-friendly and sustainable farming practices.</p>
            </div>
          </div>
          <div class="col-lg-12 d-flex align-items-start">
            <i class="bi bi-shop me-4 display-6"></i>
            <div>
              <h4 class="m-0 h5 text-white">Supporting Local Farmers</h4>
              <p class="text-white opacity-50">Helping farmers market their produce effectively.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
    </section><!-- /About Section -->

    <!-- About 3 Section -->
    <section id="about-3" class="about-3 section">
        <div class="container">
            <div class="row gy-4 justify-content-between align-items-center">
                <!-- Image and Play Button -->
                <div class="col-lg-6 order-lg-2 position-relative" data-aos="zoom-out">
                    <img src="assets/img/img_sq_1.jpg" alt="Image" class="img-fluid">
                    <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox pulsating-play-btn">
                        <span class="play"><i class="bi bi-play-fill"></i></span>
                    </a>
                </div>

                <!-- Text Content -->
                <div class="col-lg-5 order-lg-1" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="content-title mb-4">VISION</h2>
                    <p class="mb-4">
                        To create a prosperous province with a satisfied and prosperous farming community.
                    </p>

                    <h2 class="content-title mb-4">MISSION</h2>
                    <p class="mb-4">
                        To develop food security, environmentally friendly agriculture, commercial agriculture, and agribusiness through the use of 
                        new appropriate agricultural technology and agricultural infrastructure, with the full cooperation and transparency of all stakeholders.
                    </p>

                    <h2 class="content-title mb-4">OBJECTIVES</h2>
                    <ul class="list-unstyled list-check">
                        <li>Popularizing new and appropriate agricultural technology in the North Central Province.</li>
                        <li>Promoting the production of quality seeds and planting materials.</li>
                        <li>Creating food security.</li>
                        <li>Promoting environmentally friendly agriculture.</li>
                        <li>Promoting commercial agriculture and agribusiness.</li>
                    </ul>

                    <p><a href="#" class="btn-cta">Get in touch</a></p>
                </div>
            </div>
        </div>
    </section>


    <!-- Services 2 Section -->
    <section id="services-2" class="services-2 section dark-background">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Services</h2>
        <p>Necessitatibus eius consequatur</p>
      </div><!-- End Section Title -->

      <div class="services-carousel-wrap">
        <div class="container">
          <div class="swiper init-swiper">
            <script type="application/json" class="swiper-config">
              {
                "loop": true,
                "speed": 600,
                "autoplay": {
                  "delay": 5000
                },
                "slidesPerView": "auto",
                "pagination": {
                  "el": ".swiper-pagination",
                  "type": "bullets",
                  "clickable": true
                },
                "navigation": {
                  "nextEl": ".js-custom-next",
                  "prevEl": ".js-custom-prev"
                },
                "breakpoints": {
                  "320": {
                    "slidesPerView": 1,
                    "spaceBetween": 40
                  },
                  "1200": {
                    "slidesPerView": 3,
                    "spaceBetween": 40
                  }
                }
              }
            </script>
            <button class="navigation-prev js-custom-prev">
              <i class="bi bi-arrow-left-short"></i>
            </button>
            <button class="navigation-next js-custom-next">
              <i class="bi bi-arrow-right-short"></i>
            </button>
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="service-item">
                  <div class="service-item-contents">
                    <a href="#">
                      <span class="service-item-category">We do</span>
                      <h2 class="service-item-title">Planting</h2>
                    </a>
                  </div>
                  <img src="assets/img/img_sq_1.jpg" alt="Image" class="img-fluid">
                </div>
              </div>
              <div class="swiper-slide">
                <div class="service-item">
                  <div class="service-item-contents">
                    <a href="#">
                      <span class="service-item-category">We do</span>
                      <h2 class="service-item-title">Mulching</h2>
                    </a>
                  </div>
                  <img src="assets/img/img_sq_3.jpg" alt="Image" class="img-fluid">
                </div>
              </div>
              <div class="swiper-slide">
                <div class="service-item">
                  <div class="service-item-contents">
                    <a href="#">
                      <span class="service-item-category">We do</span>
                      <h2 class="service-item-title">Watering</h2>
                    </a>
                  </div>
                  <img src="assets/img/img_sq_8.jpg" alt="Image" class="img-fluid">
                </div>
              </div>

              <div class="swiper-slide">
                <div class="service-item">
                  <div class="service-item-contents">
                    <a href="#">
                      <span class="service-item-category">We do</span>
                      <h2 class="service-item-title">Fertilizing</h2>
                    </a>
                  </div>
                  <img src="assets/img/img_sq_4.jpg" alt="Image" class="img-fluid">
                </div>
              </div>
              <div class="swiper-slide">
                <div class="service-item">
                  <div class="service-item-contents">
                    <a href="#">
                      <span class="service-item-category">We do</span>
                      <h2 class="service-item-title">Harvesting</h2>
                    </a>
                  </div>
                  <img src="assets/img/img_sq_5.jpg" alt="Image" class="img-fluid">
                </div>
              </div>
              <div class="swiper-slide">
                <div class="service-item">
                  <div class="service-item-contents">
                    <a href="#">
                      <span class="service-item-category">We do</span>
                      <h2 class="service-item-title">Mowing</h2>
                    </a>
                  </div>
                  <img src="assets/img/img_sq_6.jpg" alt="Image" class="img-fluid">
                </div>
              </div>
              <div class="swiper-slide">
                <div class="service-item">
                  <div class="service-item-contents">
                    <a href="#">
                      <span class="service-item-category">We do</span>
                      <h2 class="service-item-title">Seeding Plants</h2>
                    </a>
                  </div>
                  <img src="assets/img/img_sq_8.jpg" alt="Image" class="img-fluid">
                </div>
              </div>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>
    </section><!-- /Services 2 Section -->

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
    </section><!-- /Blog Posts 2 Section -

    <?php include 'footer.php'; ?>

  </main>

 

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
  <?php include 'footer.php'; ?>
</body>

</html>