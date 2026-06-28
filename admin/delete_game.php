<?php
session_start();
require '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$msg = "";
$game_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($game_id <= 0) {
    die("Error: Invalid Game ID");
}image

// Fetch game details before deleting
$stmt = $conn->prepare("SELECT * FROM games WHERE id = ?");
$stmt->bind_param("i", $game_id);
$stmt->execute();
$result = $stmt->get_result();
$game = $result->fetch_assoc();

if (!$game) {
    die("Error: Game not found!");
}

// Function to delete directory and all its contents
function deleteDirectory($dir)
{
    if (!is_dir($dir)) {
        return false;
    }
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        is_dir($path) ? deleteDirectory($path) : unlink($path);
    }
    return rmdir($dir);
}

// Handle Delete Confirmation
if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'yes') {

    $deleted = false;
    $errors = [];

    // 1. Delete Images
    $image_fields = ['main_image', 'image1', 'image2', 'image3'];
    foreach ($image_fields as $field) {
        if (!empty($game[$field])) {
            $image_path = "../uploads/images/" . $game[$field];
            if (file_exists($image_path)) {
                if (!unlink($image_path)) {
                    $errors[] = "Failed to delete image: " . $game[$field];
                }
            }
        }
    }

    // 2. Delete Game Folder (if exists)
    if (!empty($game['game_file'])) {
        $game_folder = "../uploads/games/" . $game['game_file'];
        if (is_dir($game_folder)) {
            if (!deleteDirectory($game_folder)) {
                $errors[] = "Failed to delete game folder: " . $game['game_file'];
            }
        }
    }

    // 3. Delete record from database
    $delete_stmt = $conn->prepare("DELETE FROM games WHERE id = ?");
    $delete_stmt->bind_param("i", $game_id);

    if ($delete_stmt->execute()) {
        $deleted = true;
    } else {
        $errors[] = "Database deletion failed: " . $conn->error;
    }

    if ($deleted && empty($errors)) {
        $msg = "Game deleted successfully!";
        // Redirect after successful deletion
        // header("Refresh: 2; url=games.php");
        header("Location: manage_games.php");
        // exit();
    } else {
        $msg = "Game deleted with some issues:<br>" . implode("<br>", $errors);
    }
}
include 'header.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Game - <?php echo htmlspecialchars($game['title']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .tail-container {
            max-width: 700px;
            margin: 3rem auto;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="tail-container px-4 py-8">

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-red-600 to-rose-600 px-8 py-6 text-white">
                <div class="flex items-center gap-3">
                    <i class="fas fa-trash-alt text-3xl"></i>
                    <div>
                        <h1 class="text-3xl font-bold">Delete Game</h1>
                        <p class="text-red-100 mt-1">You are about to permanently delete this game</p>
                    </div>
                </div>
            </div>

            <div class="p-8">

                <?php if ($msg): ?>
                    <div
                        class="mb-6 p-4 rounded-lg <?= strpos($msg, 'successfully') !== false ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                        <?= $msg ?>
                    </div>
                <?php endif; ?>

                <div class="bg-red-50 border border-red-200 rounded-2xl p-6 mb-8">
                    <h3 class="text-xl font-semibold text-red-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i>
                        Warning!
                    </h3>
                    <p class="text-red-700 mb-4">
                        This action cannot be undone. The following will be permanently deleted:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-red-700">
                        <li><strong>Game Title:</strong> <?php echo htmlspecialchars($game['title']); ?></li>
                        <li>Main image and all screenshots (if any)</li>
                        <?php if (!empty($game['game_file'])): ?>
                            <li>Game folder: <code
                                    class="bg-red-100 px-2 py-1 rounded"><?php echo htmlspecialchars($game['game_file']); ?></code>
                            </li>
                        <?php endif; ?>
                        <li>Database record</li>
                    </ul>
                </div>

                <form method="POST" class="space-y-6">
                    <input type="hidden" name="confirm_delete" value="yes">

                    <div class="flex gap-4">
                        <button type="submit"
                            onclick="return confirm('Are you 100% sure you want to delete this game? This cannot be undone!')"
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-4 rounded-2xl text-lg transition-all flex items-center justify-center gap-3">
                            <i class="fas fa-trash"></i>
                            Yes, Delete Game
                        </button>

                        <a href="games.php"
                            class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-4 rounded-2xl text-lg transition-all flex items-center justify-center gap-3">
                            <i class="fas fa-arrow-left"></i>
                            Cancel
                        </a>
                    </div>
                </form>

                <div class="mt-10 text-center text-sm text-gray-500">
                    <p>Make sure you have a backup if needed.</p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>