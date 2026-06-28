<?php
// session_start();
include 'header.php';
require '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$msg = "";
$game_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($game_id <= 0) {
    die("Error: Invalid Game ID");
}

// Fetch existing game data
$stmt = $conn->prepare("SELECT * FROM games WHERE id = ?");
$stmt->bind_param("i", $game_id);
$stmt->execute();
$result = $stmt->get_result();
$game = $result->fetch_assoc();

if (!$game) {
    die("Error: Game not found!");
}

// Handle Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $desc = $_POST['description'];
    $meta_tag = $_POST['meta_tag'];
    $meta_desc = $_POST['meta_description'];
    $slug = createSlug($name);
    // Image Upload Function (same as add game)
    function uploadImage($file)
    {
        if ($file['name'] != "") {
            $target = "../uploads/images/" . time() . "_" . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $target)) {
                return basename($target);
            }
        }
        return "";
    }

    // Handle Main Image
    $main_image = $game['main_image']; // Keep old by default
    if (!empty($_FILES['main_image']['name'])) {
        $new_main = uploadImage($_FILES['main_image']);
        if ($new_main != "") {
            // Delete old image
            if (!empty($game['main_image']) && file_exists("../uploads/images/" . $game['main_image'])) {
                unlink("../uploads/images/" . $game['main_image']);
            }
            $main_image = $new_main;
        }
    }

    // Handle Screenshot 1,2,3
    $img1 = $game['image1'];
    $img2 = $game['image2'];
    $img3 = $game['image3'];

    if (!empty($_FILES['image1']['name'])) {
        $new_img = uploadImage($_FILES['image1']);
        if ($new_img != "" && !empty($game['image1']) && file_exists("../uploads/images/" . $game['image1'])) {
            unlink("../uploads/images/" . $game['image1']);
        }
        $img1 = $new_img;
    }
    if (!empty($_FILES['image2']['name'])) {
        $new_img = uploadImage($_FILES['image2']);
        if ($new_img != "" && !empty($game['image2']) && file_exists("../uploads/images/" . $game['image2'])) {
            unlink("../uploads/images/" . $game['image2']);
        }
        $img2 = $new_img;
    }
    if (!empty($_FILES['image3']['name'])) {
        $new_img = uploadImage($_FILES['image3']);
        if ($new_img != "" && !empty($game['image3']) && file_exists("../uploads/images/" . $game['image3'])) {
            unlink("../uploads/images/" . $game['image3']);
        }
        $img3 = $new_img;
    }

    // Game File Upload (Optional - only if new file uploaded)
    $game_file = $game['game_file']; // Keep old by default

    if (!empty($_FILES['game_file']['name'])) {
        $originalName = pathinfo($_FILES['game_file']['name'], PATHINFO_FILENAME);
        $ext = strtolower(pathinfo($_FILES['game_file']['name'], PATHINFO_EXTENSION));

        $safeName = preg_replace('/[^\w\s-]/', '', $originalName);
        $folderName = $safeName;
        $folder = "../uploads/games/" . $folderName;

        if (is_dir($folder)) {
            $folderName = $safeName . "_" . time();
            $folder = "../uploads/games/" . $folderName;
        }

        mkdir($folder, 0777, true);

        if ($ext == "zip") {
            $zip = new ZipArchive;
            if ($zip->open($_FILES['game_file']['tmp_name']) === TRUE) {
                $zip->extractTo($folder);
                $zip->close();
                $game_file = $folderName;

                // Optional: Delete old game folder (be careful with this)
                // if (!empty($game['game_file']) && is_dir("../uploads/games/" . $game['game_file'])) {
                //     // You can add recursive delete function here if needed
                // }
            }
        } else if ($ext == "html") {
            $target = $folder . "/index.html";
            move_uploaded_file($_FILES['game_file']['tmp_name'], $target);
            $game_file = $folderName;
        }
    }

    // Update Database
    $update_stmt = $conn->prepare("UPDATE games SET 
        title = ?, 
        description = ?, 
        meta_tag = ?, 
        meta_description = ?, 
        main_image = ?, 
        image1 = ?, 
        image2 = ?, 
        image3 = ?, 
        game_file = ?, 
        slug=?,
        WHERE id = ?");

    $update_stmt->bind_param(
        "ssssssssssi",
        $title,
        $desc,
        $meta_tag,
        $meta_desc,
        $main_image,
        $img1,
        $img2,
        $img3,
        $game_file,
        $slug,
        $game_id
    );

    if ($update_stmt->execute()) {
        $msg = "Game Updated Successfully!";

        // Refresh game data
        $stmt = $conn->prepare("SELECT * FROM games WHERE id = ?");
        $stmt->bind_param("i", $game_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $game = $result->fetch_assoc();
    } else {
        $msg = "Error: " . $update_stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Game - <?php echo htmlspecialchars($game['title']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .tail-container {
            max-width: 900px;
            margin: 2rem auto;
        }

        .form-input {
            transition: all 0.3s ease;
        }

        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        .current-image {
            margin-top: 8px;
        }

        .current-image img {
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="tail-container px-4 py-8">

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6 text-white">
                <div class="flex items-center gap-3">
                    <i class="fas fa-edit text-3xl"></i>
                    <div>
                        <h1 class="text-3xl font-bold">Edit Game</h1>
                        <p class="text-blue-100 mt-1">Update details for:
                            <strong><?php echo htmlspecialchars($game['title']); ?></strong>
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <?php if ($msg): ?>
                    <div
                        class="mb-6 p-4 rounded-lg <?= strpos($msg, 'Success') !== false ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-red-100 text-red-700 border border-red-300' ?>">
                        <?= htmlspecialchars($msg) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" class="space-y-8">

                    <!-- Game Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Game Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" value="<?php echo htmlspecialchars($game['title']); ?>" required
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="4"
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500"><?php echo htmlspecialchars($game['description'] ?? ''); ?></textarea>
                    </div>

                    <!-- Meta Tags -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Meta Tag</label>
                            <input type="text" name="meta_tag"
                                value="<?php echo htmlspecialchars($game['meta_tag'] ?? ''); ?>"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                            <textarea name="meta_description" rows="2"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500"><?php echo htmlspecialchars($game['meta_description'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <!-- Images Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-images"></i> Game Images
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Main Image -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Main Image</label>
                                <?php if (!empty($game['main_image'])): ?>
                                    <div class="current-image mb-3">
                                        <img src="../uploads/images/<?php echo htmlspecialchars($game['main_image']); ?>"
                                            width="180" alt="Main Image">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="main_image" accept="image/*"
                                    class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl file:mr-4 file:py-2 file:px-6 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image</p>
                            </div>

                            <!-- Screenshot 1 -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Screenshot 1</label>
                                <?php if (!empty($game['image1'])): ?>
                                    <div class="current-image mb-3">
                                        <img src="../uploads/images/<?php echo htmlspecialchars($game['image1']); ?>"
                                            width="180" alt="Screenshot 1">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="image1" accept="image/*"
                                    class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl file:mr-4 file:py-2 file:px-6 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>

                            <!-- Screenshot 2 -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Screenshot 2</label>
                                <?php if (!empty($game['image2'])): ?>
                                    <div class="current-image mb-3">
                                        <img src="../uploads/images/<?php echo htmlspecialchars($game['image2']); ?>"
                                            width="180" alt="Screenshot 2">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="image2" accept="image/*"
                                    class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl file:mr-4 file:py-2 file:px-6 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>

                            <!-- Screenshot 3 -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Screenshot 3</label>
                                <?php if (!empty($game['image3'])): ?>
                                    <div class="current-image mb-3">
                                        <img src="../uploads/images/<?php echo htmlspecialchars($game['image3']); ?>"
                                            width="180" alt="Screenshot 3">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="image3" accept="image/*"
                                    class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl file:mr-4 file:py-2 file:px-6 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>
                    </div>

                    <!-- Game File -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Game File (ZIP or HTML)</label>
                        <?php if (!empty($game['game_file'])): ?>
                            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl">
                                <p class="text-green-700 text-sm">
                                    <i class="fas fa-check-circle"></i>
                                    Current Game Folder:
                                    <strong><?php echo htmlspecialchars($game['game_file']); ?></strong>
                                </p>
                            </div>
                        <?php endif; ?>

                        <div
                            class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:border-blue-400 transition-colors">
                            <i class="fas fa-cloud-upload-alt text-5xl text-gray-400 mb-4"></i>
                            <input type="file" name="game_file"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-8 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                            <p class="text-xs text-gray-500 mt-3">Leave empty to keep current game files.<br>Supported:
                                .zip or .html</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-4 rounded-2xl text-lg transition-all duration-300 flex items-center justify-center gap-3 shadow-lg hover:shadow-xl">
                            <i class="fas fa-save"></i>
                            Update Game
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <div class="flex justify-center mt-6">
            <a href="games.php" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                ← Back to All Games
            </a>
        </div>
    </div>

</body>

</html>