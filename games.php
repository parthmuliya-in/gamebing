<?php
require 'config.php';
include 'header.php';
include 'whatsapp.php';

// Fetch all games
$result = $conn->query("SELECT * FROM games ORDER BY created_at DESC");
$games = [];
while ($row = $result->fetch_assoc()) {
  $games[] = $row;
}
?>



  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Games</title>
  <!--<link rel="icon" type="image/png" href="g1.png">-->
  <!--<link rel="icon" type="image/png" href="favimage.png">-->
  <link rel="stylesheet" href="styles/game.css" />
  <link rel="stylesheet" href="styles/header.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<!--  <link rel="icon" href="/Gamebinge/favicon.ico" type="image/x-icon">-->
<!--<link rel="shortcut icon" href="/Gamebinge/favicon.ico" type="image/x-icon">-->
  

  <!-- cursor element -->
  <div class="cursor"></div>
  <div class="cursor-ring"></div>
  <!-- ================= BANNER ================= -->
  <div class="container">
    <div class="banner">
      <div class="emoji-container">
        <div class="emoji e1">🎮</div>
        <div class="emoji e2">🔥</div>
        <div class="emoji e3">⚔️</div>
        <div class="emoji e4">🎯</div>
      </div>

      <div class="content">
        <h3 class="game-heading text-solid">Our</h3>
        <br />
        <h3 class="game-heading text-outline">Games</h3>

        <div class="sub-text">
          <a href="games.php" class="banner-btn" style="background-image: url(assets/images/btn-bg.png)">
            Explore Games
          </a>
        </div>
      </div>
    </div>

    <!-- ================= SEARCH BOX ================= -->
    <!-- SEARCH BOX -->
    <div class="search-container">
      <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search for games..." />
        <button><i class="fas fa-search"></i></button>
      </div>
    </div>
    <!-- GRID SECTION -->
    <div class="grid-section" id="gamesGrid">
      <?php foreach ($games as $row): ?>
        <div class="column-card" data-title="<?= strtolower(htmlspecialchars($row['title'])) ?>"
          data-description="<?= strtolower(htmlspecialchars($row['description'] ?? '')) ?>">

          <img src="uploads/images/<?= htmlspecialchars($row['main_image']) ?>"
            onerror="this.src='assets/image/default.png';" class="card-img"
            alt="<?= htmlspecialchars($row['title']) ?>" />

          <div class="card-content">
            <a href="<?= htmlspecialchars($row['demo_link']) ?>" target="_blank" class="card-link"
              style="background-image: url('assets/images/btn-bg.png');">
              View Demo
            </a>
            <h3>
              <a href="play.php?game=<?= $row['id'] ?>" style="color:#ff7a00; text-decoration: none;">
                <?= htmlspecialchars($row['title']) ?>
              </a>
            </h3>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- FOOTER -->
  <?php include 'footer.php'; ?>

  <script src="scripts/header.js"></script>

  <!-- SEARCH FUNCTIONALITY -->
  <script>
    const searchInput = document.getElementById('searchInput');
    const gamesGrid = document.getElementById('gamesGrid');
    const cards = gamesGrid.getElementsByClassName('column-card');

    searchInput.addEventListener('input', function () {
      const searchTerm = this.value.toLowerCase().trim();

      Array.from(cards).forEach(card => {
        const title = card.getAttribute('data-title') || '';
        const description = card.getAttribute('data-description') || '';

        if (title.includes(searchTerm) || description.includes(searchTerm)) {
          card.style.display = '';        // Show card
        } else {
          card.style.display = 'none';    // Hide card
        }
      });
    });
  </script>
</body>

</html>