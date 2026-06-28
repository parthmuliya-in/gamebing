<?php

include 'header.php';
require '../config.php';

// 🔒 Admin Check
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $meta_tag = $_POST['meta_tag'];
    $meta_description = $_POST['meta_description'];
    $demo_link = $_POST['demo_link'];

    // ================= MAIN IMAGE UPLOAD =================
    $main_image = "";

    if (!empty($_FILES['main_image']['name'])) {
        $main_image = time() . "_" . $_FILES['main_image']['name'];
        move_uploaded_file($_FILES['main_image']['tmp_name'], "../uploads/images/" . $main_image);
    }

    // ================= GAME FILE UPLOAD & EXTRACT =================
    $game_folder = "";

    if (!empty($_FILES['game_file']['name'])) {

        // Get original file name without extension
        $original_name = pathinfo($_FILES['game_file']['name'], PATHINFO_FILENAME);

        // Clean folder name (remove spaces & special chars)
        $safe_name = preg_replace('/[^A-Za-z0-9\-]/', '_', $original_name);

        // Final ZIP name
        $zip_name = $safe_name . ".zip";
        $zip_path = "../uploads/games/" . $zip_name;

        // Move ZIP file
        move_uploaded_file($_FILES['game_file']['tmp_name'], $zip_path);
        //  if (!move_uploaded_file($_FILES['game_file']['tmp_name'], $zip_path)) {
        //     die("ZIP upload failed");
        //     }


        // Create extract folder with same name
        $extract_folder = "../uploads/games/" . $safe_name;

        // If folder already exists → make unique
        if (file_exists($extract_folder)) {
            $extract_folder .= "_" . time();
        }

        mkdir($extract_folder, 0777, true);

        // Extract ZIP
        $zip = new ZipArchive;

        if ($zip->open($zip_path) === TRUE) {
            $zip->extractTo($extract_folder);
            $zip->close();

            // Save folder name in DB
            $game_folder = basename($extract_folder);

            // Delete ZIP after extraction
            unlink($zip_path);

        } else {
            echo "Failed to extract ZIP file";
        }
    }
    // ================= INSERT =================
    $stmt = $conn->prepare("INSERT INTO games 
(title, description, meta_tag, meta_description, demo_link, main_image, game_file, created_at) 
VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");

    $stmt->bind_param(
        "sssssss",
        $title,
        $description,
        $meta_tag,
        $meta_description,
        $demo_link,
        $main_image,
        $game_folder
    );

    if ($stmt->execute()) {
        $msg = "Game Added Successfully!";
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
    <title>Add Game</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-xl shadow">

        <h2 class="text-2xl font-bold mb-6">Add Game</h2>

        <?php if ($msg): ?>
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                <?= $msg ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-5">

            <!-- Title -->
            <input type="text" name="title" placeholder="Game Title" required class="w-full border p-3 rounded">

            <!-- Description -->
            <textarea name="description" placeholder="Description" class="w-full border p-3 rounded"></textarea>

            <!-- Meta Title -->
            <input type="text" name="meta_tag" placeholder="Meta Title" class="w-full border p-3 rounded">

            <!-- Meta Description -->
            <textarea name="meta_description" placeholder="Meta Description"
                class="w-full border p-3 rounded"></textarea>

            <!-- Demo Link -->
            <input type="url" name="demo_link" placeholder="Demo Link" class="w-full border p-3 rounded">

            <!-- Main Image -->
            <div>
                <label>Main Image</label>
                <input type="file" name="main_image" class="w-full">
            </div>

            <!-- Game File -->
            <div>
                <label>Game File</label>
                <input type="file" name="game_file" required class="w-full">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded w-full">
                Add Game
            </button>

        </form>

    </div>

</body>

</html>