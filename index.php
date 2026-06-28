<?php
require 'config.php';
include 'header.php';
$result = $conn->query("SELECT * FROM games");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Binge</title>
<!--<link rel="icon" type="image/png" href="g1.png">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="icon" type="image/png" href="favimage.png">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/header.css">
</head>

<body>

    <!-- ================= CURSOR ELEMENTS ================= -->
    <div class="cursor"></div>
    <div class="cursor-ring"></div>


    <!-- ************************************** SECTION 1 ********************************************** -->
    <section class="hero-slider">
        <div class="slides">

            <!-- SLIDE 1: Original Title -->
            <div class="slide slide1">
                <video autoplay muted loop playsinline class="bg-video">
                    <!-- <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4"> -->
                    <source src="assets/images/video-1.mp4" type="video/mp4">
                </video>
                <div class="content">
                    <h1>GAME BINGE</h1>
                </div>
            </div>

            <!-- SLIDE 2: Heading and Paragraph -->
            <div class="slide slide2">
                <video autoplay muted loop playsinline class="bg-video">
                    <!-- <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4"> -->
                    <source src="assets/images/home-hero-1 (2).mp4" type="video/mp4">
                </video>
                <div class="content">
                    <div class="text-content">
                        <h2>PLAY COMPETE WIN</h2>
                        <p>Enjoy stunning worlds, push your limits, and climb higher with every
                            game. A whole new level of gaming is waiting for you.</p>
                    </div>
                </div>
            </div>

            <!-- SLIDE 3: Split Layout -->
            <div class="slide slide3">
                <video autoplay muted loop playsinline class="bg-video">
                    <!-- <source src="https://www.w3schools.com/html/mov_bbb.mp4" type="video/mp4"> -->
                    <source src="assets/images/vide0-2.mp4" type="video/mp4">
                </video>

                <div class="content">
                    <div class="text-content">

                        <div class="small-line-text">New Release</div>

                        <h2>UNLOCK YOUR ADVENTURE</h2>

                        <p>
                            Explore vast open worlds, battle powerful enemies, and create your own journey while
                            enjoying a
                            smooth and exciting gaming experience every time.
                        </p>

                        <a href="games.php" class="image-btn">Play Now</a>

                    </div>
                </div>
            </div>
        </div>


        <button class="nav prev">&#10094;</button>
        <button class="nav next">&#10095;</button>
        <div class="dots"></div>
    </section>

    <br>
    <br>


    <!-- ************************************** SECTION 2 ********************************************** -->

    <section class="gb-slider-section" aria-label="Featured games slider">
        <div class="gb-slider-head">
            <h1>Game collection</h1>
            <p>
                Explore our game collection with action, adventure, and casual
                games. Find your favorites, enjoy smooth gameplay, and start
                playing instantly anytime online.
            </p>
        </div>

        <div class="gb-slider-wrapper">

            <!-- ✅ ONLY ONE SLIDER -->
            <div class="gb-slider" id="gbSlider">

                <?php
                $first = true;
                while ($row = $result->fetch_assoc()):
                    ?>
                    <div class="gb-card <?php if ($first) {
                        echo 'gb-active';
                        $first = false;
                    } ?>">
                        <img src="uploads/images/<?php echo $row['main_image']; ?>" alt="">
                        <div class="gb-overlay">
                            <h2><?php echo $row['title']; ?></h2>
                            <a href="play.php?game=<?= $row['id'] ?>" class="img-card-btn">Play Now</a>
                        </div>
                    </div>
                <?php endwhile; ?>

            </div>
        </div>

        <!-- Bottom controls -->
        <div class="gb-bottom-bar">
            <div class="gb-indicator">
                <div class="gb-fill" id="gbFill"></div>
            </div>
            <div class="gb-nav-buttons">
                <button class="gb-nav-btn" id="gbPrevBtn">&#8592;</button>
                <button class="gb-nav-btn" id="gbNextBtn">&#8594;</button>
            </div>
        </div>
    </section>



    <!-- ************************************** SECTION 3 ********************************************** -->
    <div class="gb-slider-head" style="text-align: center;">
        <h1>Launching Soon</h1>
    </div>

    <section class="upcoming-games">

        <div class="gs-showcase-section">
            <div class="gs-slider-container">

                <!-- Card 1 -->
                <div class="gs-card gs-active" style="background-image: url('assets/images/img1.jpg');">
                    <div class="gs-overlay"></div>
                    <h2 class="gs-card-title">UNO</h2>
                </div>

                <!-- Card 2 -->
                <div class="gs-card gs-next-1" style="background-image: url('assets/images/img2.jpg');">
                    <div class="gs-overlay"></div>
                    <h2 class="gs-card-title">LUDO</h2>
                </div>

                <!-- Card 3 -->
                <div class="gs-card gs-next-2" style="background-image: url('assets/images/img3.jpg');">
                    <div class="gs-overlay"></div>
                    <h2 class="gs-card-title">SNAKE AND LADDER</h2>
                </div>

                <!-- Card 4 -->
                <div class="gs-card gs-next-3" style="background-image: url('assets/images/img4.jpg');">
                    <div class="gs-overlay"></div>
                    <h2 class="gs-card-title">CAR RACING</h2>
                </div>

                <!-- Card 5 -->
                <div class="gs-card gs-next-4" style="background-image: url('assets/images/img5.jpg');">
                    <div class="gs-overlay"></div>
                    <h2 class="gs-card-title">SANTA GIFTS CATCHER</h2>
                </div>

            </div>

            <!-- Pagination Dots -->
            <div class="gs-pagination"></div>

            <div class="gs-explore-wrapper">
                <!-- Anchor Tag a button HTML -->
                <a href="games.php" class="image-btn">Explore More</a>
            </div>
        </div>

    </section>

    <!-- ************************************** SECTION 4 ********************************************** -->

    <div class="gb-slider-head" style="text-align: center;">
        <h1>About Us</h1>
    </div>
    <section class="subscribe-card-section">

        <div class="subscribe-card">

            <!-- EMOJIS -->
            <div class="emoji-container">
                <div class="emoji e1">🎮</div>
                <div class="emoji e2">🔥</div>
                <div class="emoji e3">⚔️</div>
                <div class="emoji e4">🎯</div>
            </div>



            <div class="image-box">
                <img src="assets/images/about-us-ch.png" alt="Character" class="pop-out-image">
            </div>

            <div class="content-box">
                <h2>Real time play</h2>
                <!-- <p>Join <strong>200k+ other subscribers</strong> and get the major announcements from Gamico Studio
                    straight in your inbox.</p> -->
                <p>Welcome to GameBinge. We’re building a space for gamers to explore, play, and enjoy. Stay
                    connected for the latest updates and new games in one place.</p>

                <div class="button-container">
                    <a href="aboutus.php" class="image-btn">Explore now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ************************************** SECTION 5 ********************************************** -->
    <?php
    include 'footer.php';
    ?>
    <script src="scripts/header.js"></script>
    <script src="scripts/index.js"></script>
</body>

</html>