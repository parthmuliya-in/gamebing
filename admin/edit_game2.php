<?php
include 'header.php';
require '../config.php';

// 🔒 Admin Check
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$msg = "";

// ✅ Get ID
$id = $_GET['id'] ?? 0;

// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM games WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Game not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $meta_tag = $_POST['meta_tag'];
    $meta_description = $_POST['meta_description'];
    $demo_link = $_POST['demo_link'];

    // ================= MAIN IMAGE =================
    $main_image = $data['main_image'];

    if (!empty($_FILES['main_image']['name'])) {
        $main_image = time() . "_" . $_FILES['main_image']['name'];
        move_uploaded_file($_FILES['main_image']['tmp_name'], "../uploads/images/" . $main_image);
    }

    // ================= GAME FILE UPDATE =================
    $game_folder = $data['game_file'];

    if (!empty($_FILES['game_file']['name'])) {

        // Delete old folder (optional but recommended)
        $old_folder = "../uploads/games/" . $data['game_file'];
        if (is_dir($old_folder)) {
            function deleteFolder($folder)
            {
                foreach (scandir($folder) as $file) {
                    if ($file != '.' && $file != '..') {
                        $path = $folder . '/' . $file;
                        is_dir($path) ? deleteFolder($path) : unlink($path);
                    }
                }
                rmdir($folder);
            }
            deleteFolder($old_folder);
        }

        // Process new ZIP
        $original_name = pathinfo($_FILES['game_file']['name'], PATHINFO_FILENAME);
        $safe_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $original_name);

        $zip_name = $safe_name . ".zip";
        $zip_path = "../uploads/games/" . $zip_name;

        move_uploaded_file($_FILES['game_file']['tmp_name'], $zip_path);

        $extract_folder = "../uploads/games/" . $safe_name;

        if (file_exists($extract_folder)) {
            $extract_folder .= "_" . time();
        }

        mkdir($extract_folder, 0777, true);

        $zip = new ZipArchive;

        if ($zip->open($zip_path) === TRUE) {
            $zip->extractTo($extract_folder);
            $zip->close();

            $game_folder = basename($extract_folder);

            unlink($zip_path);
        } else {
            echo "Failed to extract ZIP";
        }
    }

    // ================= UPDATE =================
    $stmt = $conn->prepare("UPDATE games SET 
        title=?, 
        description=?, 
        meta_tag=?, 
        meta_description=?, 
        demo_link=?, 
        main_image=?, 
        game_file=? 
        WHERE id=?");

    $stmt->bind_param(
        "sssssssi",
        $title,
        $description,
        $meta_tag,
        $meta_description,
        $demo_link,
        $main_image,
        $game_folder,
        $id
    );

    if ($stmt->execute()) {
        $msg = "Game Updated Successfully!";
    } else {
        $msg = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Game</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Config for Custom Color -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ff7a00',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-100">

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Header -->
    <!-- <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Edit Game</h2>
        <a href="manage_games.php" class="mt-3 md:mt-0 text-sm text-primary font-medium hover:underline">
            ← Back to Games
        </a>
    </div> -->

    <!-- Message -->
    <?php if ($msg): ?>
        <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-700">
            <?= $msg ?>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="bg-white shadow-xl rounded-2xl p-6 md:p-10">

        <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Title -->
            <div class="md:col-span-2">
                <label class="font-semibold text-gray-700">Game Title</label>
                <input type="text" name="title"
                    value="<?= htmlspecialchars($data['title']) ?>"
                    class="w-full mt-2 border p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label class="font-semibold text-gray-700">Description</label>
                <textarea name="description"
                    class="w-full mt-2 border p-3 rounded-lg h-32 focus:outline-none focus:ring-2 focus:ring-primary"><?= htmlspecialchars($data['description']) ?></textarea>
            </div>

            <!-- Meta Title -->
            <div>
                <label class="font-semibold text-gray-700">Meta Title</label>
                <input type="text" name="meta_tag"
                    value="<?= htmlspecialchars($data['meta_tag']) ?>"
                    class="w-full mt-2 border p-3 rounded-lg focus:ring-2 focus:ring-primary">
            </div>

            <!-- Meta Description -->
            <div>
                <label class="font-semibold text-gray-700">Meta Description</label>
                <textarea name="meta_description"
                    class="w-full mt-2 border p-3 rounded-lg h-24 focus:ring-2 focus:ring-primary"><?= htmlspecialchars($data['meta_description']) ?></textarea>
            </div>

            <!-- Demo Link -->
            <div class="md:col-span-2">
                <label class="font-semibold text-gray-700">Demo Link</label>
                <input type="url" name="demo_link"
                    value="<?= htmlspecialchars($data['demo_link']) ?>"
                    class="w-full mt-2 border p-3 rounded-lg focus:ring-2 focus:ring-primary">
            </div>

            <!-- Current Image -->
            <div>
                <label class="font-semibold text-gray-700">Current Image</label>
                <img src="../uploads/images/<?= $data['main_image'] ?>"
                    class="mt-3 w-32 h-32 object-cover rounded-lg border">
            </div>

            <!-- Upload New Image -->
            <div>
                <label class="font-semibold text-gray-700">Change Image</label>
                <input type="file" name="main_image"
                    class="w-full mt-3 border p-2 rounded-lg">
            </div>

            <!-- Current Game Folder -->
            <div>
                <label class="font-semibold text-gray-700">Game Folder</label>
                <p class="mt-2 text-gray-600 text-sm bg-gray-100 p-2 rounded">
                    <?= $data['game_file'] ?>
                </p>
            </div>

            <!-- Replace Game ZIP -->
            <div>
                <label class="font-semibold text-gray-700">Replace Game ZIP</label>
                <input type="file" name="game_file"
                    class="w-full mt-3 border p-2 rounded-lg">
            </div>

            <!-- Submit -->
            <div class="md:col-span-2 mt-4">
                <button type="submit"
                    class="w-full bg-primary text-white py-3 rounded-xl text-lg font-semibold hover:opacity-90 transition">
                    Update Game
                </button>
            </div>

        </form>
    </div>
</div>

</body>
</html>