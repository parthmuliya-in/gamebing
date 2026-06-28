<?php
include 'config.php';
$sliders = mysqli_query($conn, "SELECT * FROM sliders WHERE status=1 ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/header.css">
</head>

<body>


<section class="hero-slider">
    <div class="slides">

        <?php while ($row = mysqli_fetch_assoc($sliders)) { ?>

            <div class="slide">

                <video autoplay muted loop playsinline class="bg-video">
                    <source src="uploads/<?php echo $row['video']; ?>" type="video/mp4">
                </video>

                <div class="content">
                    <div class="text-content">

                        <?php if ($row['slide_type'] == 'simple') { ?>
                            <h1><?php echo $row['title']; ?></h1>

                        <?php } elseif ($row['slide_type'] == 'text') { ?>
                            <h2><?php echo $row['title']; ?></h2>
                            <p><?php echo $row['description']; ?></p>

                        <?php } elseif ($row['slide_type'] == 'split') { ?>
                            <div class="small-line-text"><?php echo $row['subtitle']; ?></div>
                            <h2><?php echo $row['title']; ?></h2>
                            <p><?php echo $row['description']; ?></p>

                            <?php if ($row['button_text']) { ?>
                                <a href="<?php echo $row['button_link']; ?>" class="image-btn">
                                    <?php echo $row['button_text']; ?>
                                </a>
                            <?php } ?>

                        <?php } ?>

                    </div>
                </div>

            </div>

        <?php } ?>

    </div>

    <button class="nav prev">&#10094;</button>
    <button class="nav next">&#10095;</button>
    <div class="dots"></div>
</section>
<script src="scripts/header.js"></script>
<script src="scripts/index.js"></script>
</body>
</html>