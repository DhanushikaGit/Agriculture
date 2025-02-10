<?php
// Define the current page variable
$current_page = basename($_SERVER['PHP_SELF']);

echo '<header id="header" class="header d-flex align-items-center position-relative">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/logoo-Recovered.bmp" alt="AgriCulture" style="height: auto; width: 150px;">
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" ' . ($current_page == 'index.php' ? 'class="active"' : '') . '>Home</a></li>
          <li><a href="about.php" ' . ($current_page == 'about.php' ? 'class="active"' : '') . '>About Us</a></li>
          <li><a href="services.php" ' . ($current_page == 'services.php' ? 'class="active"' : '') . '>Our Services</a></li>
          <li><a href="testimonials.php" ' . ($current_page == 'testimonials.php' ? 'class="active"' : '') . '>Testimonials</a></li>
          <li><a href="blog.php" ' . ($current_page == 'blog.php' ? 'class="active"' : '') . '>Blog</a></li>
          <li class="dropdown">
            <a href="#" aria-label="Resources dropdown" aria-expanded="false"><span>Resources</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Farming Tips</a></li>
              <li class="dropdown">
                <a href="#" aria-label="Guides dropdown" aria-expanded="false"><span>Guides</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Soil Preparation</a></li>
                  <li><a href="#">Crop Rotation</a></li>
                  <li><a href="#">Organic Farming</a></li>
                  <li><a href="#">Water Management</a></li>
                  <li><a href="#">Pest Control</a></li>
                </ul>
              </li>
              <li><a href="#">Market Trends</a></li>
              <li><a href="#">Weather Updates</a></li>
              <li><a href="#">Government Policies</a></li>
            </ul>
          </li>
          <li><a href="contact.php" ' . ($current_page == 'contact.php' ? 'class="active"' : '') . '>Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list" onclick="toggleNav()"></i>
      </nav>

      <div class="search-bar">
        <form action="search.php" method="GET">
          <input type="text" name="query" placeholder="Search resources..." aria-label="Search">
          <button type="submit"><i class="bi bi-search"></i></button>
        </form>
      </div>

      <div class="user-actions">
        <?php if (isset($_SESSION["user"])): ?>
          <a href="logout.php" class="btn btn-primary">Logout</a>
        <?php else: ?>
          <a href="login.php" class="btn btn-primary">Login</a>
        <?php endif; ?>
      </div>

    </div>
  </header>';
?>