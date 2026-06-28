<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About us</title>
<!--<link rel="icon" type="image/png" href="g1.png">-->
  <link href="https://fonts.googleapis.com/css2?family=Anton&family=Montserrat:wght@400;600;700&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="styles/about.css">
  <link rel="stylesheet" href="styles/header.css">
  <link rel="icon" type="image/png" href="favimage.png">
  
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-1DJ9T9G6JK"></script>
<script>

  window.dataLayer = window.dataLayer || [];

  function gtag(){dataLayer.push(arguments);}

  gtag('js', new Date());
 
  gtag('config', 'G-1DJ9T9G6JK');
</script>
</head>

<body>
  <!-- ================= CURSOR ELEMENTS ================= -->
  <div class="cursor"></div>
  <div class="cursor-ring"></div>


  <header>
    <div class="logo">
      <video src="assets/images/logo.mp4" autoplay loop muted playsinline></video>
    </div>

    <nav>
      <ul id="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="aboutus.php">About Us</a></li>
        <li><a href="games.php">Games</a></li>
        <li><a href="contactus.php">Contact Us</a></li>
      </ul>

      <div class="hamburger" id="hamburger">
        <div></div>
        <div></div>
        <div></div>
      </div>
    </nav>
  </header>

  <!--  ===========================  Header section end  ==================================================-->

  <!--  ===========================  about us banner start  ==================================================-->

  <section class="banner-section">
    <div class="banner">

      <!-- VIDEO -->
      <video class="banner-video" autoplay muted loop playsinline>
        <source src="assets/images/aboutus/aboutus-banner-vdo.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
      </video>

      <!-- DARK OVERLAY -->
      <div class="banner-overlay"></div>

      <!-- RUNNING BORDER -->
      <div class="banner-border"></div>

      <!-- EMOJIS -->
      <div class="emoji-container"></div>

      <!-- CONTENT -->
      <div class="banner-content">
        <h1 class="about-heading">
          <span>About</span>
          <span class="outline-text">Us</span>
        </h1>

      </div>

    </div>
  </section>






  <!--  ===========================  about banner end  ==================================================-->
  <!--  ===========================  About page Section-1 ==================================================-->

  <section class="gaming-section" id="gamingSection">
    <div class="container">

      <!-- LEFT IMAGE -->
      <div class="left">
        <div class="image-box">
          <img src="assets/images/aboutus/game-1.jpg" alt="Game Image">

          <div class="overlay-text">
            <span class="gaming">GAMING</span>
            <span class="zone">ZONE</span>
          </div>

        </div>
      </div>

      <!-- RIGHT CONTENT -->
      <div class="right">
        <h5>The World of Game Hub</h5>
        <h2>The Ultimate Gaming Experience</h2>
        <p>
          Enjoy smooth gameplay, stunning visuals, and exciting challenges. Start your journey to mastering the
          game today.
        </p>

        <div class="counter-box">
          <div class="counter">
            <h3 data-target="1500+">0</h3>
            <span>Games</span>
          </div>
          <div class="counter">
            <h3 data-target="8000+">0</h3>
            <span>Active Players</span>
          </div>
          <div class="counter">
            <h3 data-target="450+">0</h3>
            <span> game levels</span>
          </div>
          <div class="counter">
            <h3 data-target="24/7">0</h3>
            <span> Non-stop fun</span>
          </div>
        </div>

        <!-- Anchor Tag a button HTML -->
        <a href="games.php" class="image-btn">Play Now</a>
      </div>

    </div>
  </section>


  <!--  ===========================  ABOUT US SECTION-1 END ==================================================-->

  <!--  ===========================  ABOUT US SECTION-2  START ==================================================-->

  <section class="feature-section" id="featureSection">

    <div class="feature-container">

      <!-- LEFT -->
      <div class="feature-left">
        <div class="glow"></div>
        <img src="assets/images/aboutus/game-2.png" alt="">
      </div>

      <!-- RIGHT -->
      <div class="feature-right">

        <h5 class="section-tag"><span>Game Highlights</span></h5>

        <h2>Elite Features,<br> Smooth Gameplay</h2>

        <p class="desc">
          Crafted for gamers who demand performance, quality, and innovation.
        </p>

        <div class="feature-box">
          <i class="fa-solid fa-gamepad"></i>
          <div>
            <h3>Elite Graphics</h3>
            <p>High-definition visuals with flawless performance for a premium gaming experience.</p>
          </div>
        </div>

        <div class="feature-box">
          <i class="fas fa-headphones"></i>
          <div>
            <h3>Advanced Sound Design</h3>
            <p>Cinematic audio that makes gameplay more immersive and realistic.</p>
          </div>
        </div>

        <div class="feature-box">
          <i class="fas fa-brain"></i>
          <div>
            <h3>Dynamic Worlds</h3>
            <p>Deep storytelling with beautifully crafted gaming environments..</p>
          </div>
        </div>

      </div>

    </div>

  </section>

  <!--  ===================================  SECTION-2 END ==================================================-->

  <!--  ===================================  SECTION-3 START ==================================================-->
  <div class="border"></div>
  <section class="section">


    <div class="card" id="card">

      <!-- IMAGE -->
      <img src="assets/images/aboutus/game-3.jpg">

      <!-- CONTENT -->
      <div class="content">
        <span class="tag">Love To Play</span>

        <h1>
          Sweet Revenge <br>
          <span>Gameplay</span>
        </h1>

        <!-- Anchor Tag a button HTML -->
        <a href="games.php" class="image-btn">Play Now</a>
      </div>

      <!-- SIDE BUTTON -->
      <!-- <div class="side-btn">
        <a href="#" class="image-btn">Play Now</a>
      </div> -->

      <!-- DOT -->
      <div class="dot"></div>

    </div>

  </section>


  <!--  ===========================  ABOUT US SECTION-3  END================================================== -->

  <!--  ===========================  ABOUT US SECTION-4  START ================================================== -->
  <div class="slider">
    <div class="track" id="track">
      <!-- 15 Images -->
      <div class="slide"><img src="assets/images/aboutus/ballsort1.png">
        <div class="overlay"><i class="fa fa-camera"></i></div>
      </div>
      <div class="slide"><img src="assets/images/aboutus/egghetch1.png">
        <div class="overlay"><i class="fa fa-camera"></i></div>
      </div>
      <div class="slide"><img src="assets/images/aboutus/fruitmaster1.png">
        <div class="overlay"><i class="fa fa-camera"></i></div>
      </div>
      <div class="slide"><img src="assets/images/aboutus/fruitmaster2.png">
        <div class="overlay"><i class="fa fa-camera"></i></div>
      </div>
      <div class="slide"><img src="assets/images/aboutus/egghetch3.png">
        <div class="overlay"><i class="fa fa-camera"></i></div>
      </div>
      <div class="slide"><img src="assets/images/aboutus/labyrinth1.png">
        <div class="overlay"><i class="fa fa-camera"></i></div>
      </div>
      <div class="slide"><img src="assets/images/aboutus/colorcatch2.png">
        <div class="overlay"><i class="fa fa-camera"></i></div>
      </div>
      <div class="slide"><img src="assets/images/aboutus/ballsort2.png">
        <div class="overlay"><i class="fa fa-camera"></i></div>
      </div>
      <div class="slide"><img src="assets/images/aboutus/fruitmaster3.png">
        <div class="overlay"><i class="fa fa-camera"></i></div>
      </div>
      <div class="slide"><img src="assets/images/aboutus/minizoo1.png">
        <div class="overlay"><i class="fa fa-camera"></i></div>
      </div>
      <div class="slide"><img src="assets/images/aboutus/colorcatch3.png">
        <div class="overlay"><i class="fa fa-camera"></i></div>
      </div>
      <div class="slide"><img src="assets/images/aboutus/colorcatch2.png">
        <div class="overlay"><i class="fa fa-camera"></i></div>
      </div>
      <div class="slide"><img src="assets/images/aboutus/cub-n-pup3.png">
        <div class="overlay"><i class="fa fa-camera"></i></div>
      </div>
      <div class="slide"><img src="assets/images/aboutus/crazyfruit1.png">
        <div class="overlay"><i class="fa fa-camera"></i></div>
      </div>
      <div class="slide"><img src="assets/images/aboutus/crazyfruit3.png">
        <div class="overlay"><i class="fa fa-camera"></i></div>
      </div>
    </div>
  </div>

  <!--  ===========================  ABOUT US SECTION-4  END================================================== -->

  <!-- ================= FOOTER ================= -->

  <footer class="gaming-site-footer">
    <!-- Animated Lines -->
    <div class="footer-line-anim f-line-top"></div>
    <div class="footer-line-anim f-line-bottom"></div>

    <!-- Neon Dots -->
    <div class="f-neon-dot f-top-dot" style="animation-delay: 0s"></div>
    <div class="f-neon-dot f-top-dot" style="animation-delay: 3s"></div>
    <div class="f-neon-dot f-top-dot" style="animation-delay: 6s"></div>
    <div class="f-neon-dot f-top-dot" style="animation-delay: 9s"></div>

    <div class="f-neon-dot f-bottom-dot" style="animation-delay: 1.5s"></div>
    <div class="f-neon-dot f-bottom-dot" style="animation-delay: 4.5s"></div>
    <div class="f-neon-dot f-bottom-dot" style="animation-delay: 7.5s"></div>
    <div class="f-neon-dot f-bottom-dot" style="animation-delay: 10.5s"></div>

    <div class="f-grid">
      <!-- Logo + Social -->
      <div class="f-col-center f-col-center-logo">
        <!-- Fallback image logic if video doesn't load: use poster attr if you want -->
        <video autoplay loop muted playsinline class="f-video-logo">
          <source src="assets/images/logo.mp4" type="video/mp4" />
        </video>

        <h2 class="logo-text" style="margin-left: 4.5%;">Gaming World</h2>

        <div class="f-social-wrap">
          <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="https://www.youtube.com/@GameBinge-h5n"><i class="fab fa-youtube"></i></a>
          <a href="https://www.instagram.com/gamebinge.club/"><i class="fab fa-instagram"></i></a>
        </div>
      </div>

      <!-- Quick Links -->
      <div class="f-col-center-logo">
        <h3>Quick Links</h3>
        <ul class="f-col-center">
          <li><a href="index.php">Home</a></li>
          <li><a href="aboutus.php">About Us</a></li>
          <li><a href="games.php">Games</a></li>
          <li><a href="contactus.php">Contact Us</a></li>
          <li><a href="ourpolicy.php">Privacy Policy</a></li>
        </ul>
      </div>

      <!-- Store Info -->
      <div class="f-col-center-logo">
        <h3>Store Information</h3>
        <ul class="f-col-center">
          <li><i class="fas fa-map-marker-alt"></i> Ahmedabad, Gujarat</li>
          <li><i class="fas fa-envelope"></i> contact@gamebinge.club</li>
          <li><i class="fas fa-phone"></i> +91 9099090677</li>
        </ul>
      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="f-bottom-bar">© 2026 Game Binge All Rights Reserved</div>
  </footer>



  <script src="scripts/about.js"></script>
  <script src="scripts/header.js"></script>
</body>

</html>