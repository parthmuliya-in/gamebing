<?php
session_start();
include 'config.php';
include 'header.php';
include 'whatsapp.php';
$message = "";

// CAPTCHA GENERATE
// if (!isset($_SESSION['captcha_answer'])) {
//     $num1 = rand(1, 9);
//     $num2 = rand(1, 9);
//     $_SESSION['captcha_answer'] = $num1 + $num2;
//     $_SESSION['captcha_num1'] = $num1;
//     $_SESSION['captcha_num2'] = $num2;
// }

function generateCaptcha($length = 6)
{
  $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // avoid confusing chars
  return substr(str_shuffle($chars), 0, $length);
}

if (!isset($_SESSION['captcha'])) {
  $_SESSION['captcha'] = generateCaptcha();
}

// $_SESSION['captcha'] = generateCaptcha();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $name = mysqli_real_escape_string($conn, $_POST['Name']);
  $email = mysqli_real_escape_string($conn, $_POST['Email']);
  $phone = mysqli_real_escape_string($conn, $_POST['Con_num']);
  $comment = mysqli_real_escape_string($conn, $_POST['Comment']);
  $user_captcha = strtoupper(trim($_POST['captcha']));

  // ✅ CAPTCHA CHECK
  if ($user_captcha !== $_SESSION['captcha']) {
    $message = "Invalid CAPTCHA!";
  }
  elseif (!empty($name) && !empty($email) && !empty($phone) && !empty($comment)) {

    $sql = "INSERT INTO contact_messages (name, email, phone, message, created_at) 
            VALUES ('$name', '$email', '$phone', '$comment', NOW())";

    if (mysqli_query($conn, $sql)) {
        $message = "Thank you! Message sent.";
    } else {
        $message = "DB Error: " . mysqli_error($conn);
    }
  } else {
    $message = "All fields required!";
  }

  // ✅ ALWAYS GENERATE NEW CAPTCHA AFTER SUBMIT
  $_SESSION['captcha'] = generateCaptcha();
}
?>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact</title>
  <!--<link rel="icon" type="image/png" href="favimage.png">-->
<!--<link rel="icon" type="image/png" href="g1.png">-->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <link rel="stylesheet" href="styles/contact.css">
  <link rel="stylesheet" href="styles/header.css">
  <!-- for banner -->
  <link rel="stylesheet" href="styles/about.css">
   <style>
    .contact-form p {
      padding: 12px;
      border-radius: 5px;
      text-align: center;
      margin-bottom: 15px;
    }

    .success {
      background: #000;
      color: #00ff88;
      border: 1px solid #00ff88;
    }

    .error {
      background: #000;
      color: #ff4444;
      border: 1px solid #ff4444;
    }

    .captcha-box {
      display: flex;
      align-items: center;
      gap: 10px;
      margin: 15px 0;
    }

    .captcha-code {
      background: #333;
      color: #ff7a00;
      padding: 10px 15px;
      font-size: 14px;
      font-weight: bold;
      border: 2px solid #ff7a00;
      border-radius: 5px;
      min-width: 80px;
      text-align: center;
    }
        .about-heading span {
    display: inline-block;
    opacity: 1 !important;         /* Changed from 0 to 1 */
    transform: translateY(0) !important; /* Changed from 40px to 0 */
    color: #ffffff;                /* Ensures text isn't black on black */
    position: relative;
    z-index: 10;                   /* Keeps it above the video and overlay */
}

/* Ensure the container isn't cutting off the content */
.banner-content {
    position: relative;
    z-index: 5;
    display: block !important;     /* Ensures the div is rendered */
    visibility: visible !important;
}
  </style>




  <!-- ================= CURSOR ELEMENTS ================= -->
  <div class="cursor"></div>
  <div class="cursor-ring"></div>


  <!--  ===========================  about us banner start  ==================================================-->

  <section class="banner-section">
    <div class="banner">

      <!-- VIDEO -->
      <video class="banner-video" autoplay muted loop playsinline>
        <source src="assets/images/home-hero-1 (2).mp4" type="video/mp4">
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
          <span>Contact</span>
          <span class="outline-text">Us</span>
        </h1>

      </div>

    </div>
  </section>




  <!-- TOP SECTION: Heading + Form -->
  <section class="top-section">
    <div class="left">
      <h5>GET IN TOUCH</h5>
      <h1>DO YOU HAVE SOME QUESTIONS?</h1>
    </div>

    <div class="form-card">
      <?php if (!empty($message)): ?>
          <p class="<?php echo (strpos($message, 'Thank you') !== false) ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
          </p>
        <?php endif; ?>
      <form id="contactForm" method="POST">
        <div class="input-group">
          <input type="text" name="Name" required>
          <label>Your Name</label>
        </div>
        <div class="input-group">
          <input type="email" name="Email" required>
          <label>Email Address</label>
        </div>
        <div class="input-group">
          <input type="tel" name="Con_num" required>
          <label>Phone</label>
        </div>
        <div class="input-group">
          <textarea name="Comment" required></textarea>
          <label>Message</label>
        </div>
        <div class="input-group">
          <div class="captcha-box">
              <span class="captcha-code">
                <?= $_SESSION['captcha'] ?>
              </span>
              <input type="text" name="captcha" placeholder="Enter code" required>
            </div>
        </div>
        <button type="submit">Submit</button>
        <!-- <div class="success">✔ Message Sent Successfully!</div> -->
      </form>
    </div>
  </section>

  <!-- BOTTOM SECTION: 3 Animated Cards -->
  <section class="bottom-section">
    <h2>Contact Information</h2>
    <div class="info-grid">
      <div class="info-card">
        <i class="fas fa-location-dot"></i>
        <h4>OUR ADDRESS</h4>
        <p>Ahmedabad, Gujarat, India</p>
      </div>

      <div class="info-card">
        <i class="fas fa-phone"></i>
        <h4>CONTACT DETAILS</h4>
        <p>+91 9099090677</p>
      </div>

      <div class="info-card">
        <i class="fas fa-envelope"></i>
        <h4>EMAIL</h4>
        <p>contact@gamebinge.club</p>
      </div>
    </div>
  </section>



  <?php
  include 'footer.php';
  ?>


  <script src="scripts/index.js"></script>


<script src="scripts/header.js"></script>
<!-- <script src="scripts/contact.js"></script> -->

</body>

</html>