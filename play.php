<?php
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: signup.php");
    exit();
}
// ✅ FIX PARAMETER
$id = $_GET['game'] ?? 0;

// ✅ SAFE QUERY
$stmt = $conn->prepare("SELECT * FROM games WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// ✅ CHECK GAME EXISTS
if (!$row) {
    die("Game not found");
}

// Folder path
$folder = "uploads/games/" . $row['game_file'];

// Default file
$game_file = $folder . "/index.html";

// ✅ AUTO FIX if index not found
// if (!file_exists($game_file)) {
//     $files = scandir($folder);
//     foreach ($files as $file) {
//         if (pathinfo($file, PATHINFO_EXTENSION) == 'html') {
//             $game_file = $folder . "/" . $file;
//             break;
//         }
//     }
// }
if (!is_dir($folder)) {
    die("Game folder not found!");
}

if (!file_exists($game_file)) {
    $files = scandir($folder);
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) == 'html') {
            $game_file = $folder . "/" . $file;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($row['title']) ?></title>
<link rel="icon" type="image/png" href="favimage.png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #000;
            overflow: hidden;
        }

        /* Fullscreen Game */
        .game-frame {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Close Button */
        .close-btn {
            position: fixed;
            top: 15px;
            right: 15px;
            background: #ff7a00;
            color: #fff;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            z-index: 9999;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            transition: 0.3s;
        }

        .close-btn:hover {
            background: #ff5500;
            transform: scale(1.05);
        }
    </style>

</head>

<body>

    <!-- Close Button -->
    <a href="games.php" class="close-btn">❌ Close</a>

    <!-- Fullscreen Game -->
    <iframe src="<?= $game_file ?>" class="game-frame" allowfullscreen></iframe>

</body>

</html>