<?php
// session_start();
include 'header.php';
require '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$msg = "";
function createSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
    $slug = trim($slug, '-');
    return $slug;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $desc = $_POST['description'];
    $meta_tag = $_POST['meta_tag'];
    $meta_desc = $_POST['meta_description'];
    $slug = createSlug($title);

    // Upload Images
    function uploadImage($file)
    {
        if ($file['name'] != "") {
            $target = "../uploads/images/" . time() . "_" . basename($file['name']);
            move_uploaded_file($file['tmp_name'], $target);
            return basename($target);
        }
        return "";
    }

    $main_image = uploadImage($_FILES['main_image']);
    $img1 = uploadImage($_FILES['image1']);
    $img2 = uploadImage($_FILES['image2']);
    $img3 = uploadImage($_FILES['image3']);

    // Upload Game ZIP / HTML
    $game_file = "";

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
            }
        } else if ($ext == "html") {
            $target = $folder . "/index.html";
            move_uploaded_file($_FILES['game_file']['tmp_name'], $target);
            $game_file = $folderName;
        }
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO games (title, description, meta_tag, meta_description, main_image, image1, image2, image3, game_file,slug) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("ssssssssss", $title, $desc, $meta_tag, $meta_desc, $main_image, $img1, $img2, $img3, $game_file,$slug);

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
    <title>Add New Game</title>
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
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

    <div class="tail-container px-4 py-8">

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-6 text-white">
                <div class="flex items-center gap-3">
                    <i class="fas fa-gamepad text-3xl"></i>
                    <div>
                        <h1 class="text-3xl font-bold">Add New Game</h1>
                        <p class="text-blue-100 mt-1">Fill in the details to upload a new game</p>
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
                        <input type="text" name="title" required
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500"
                            placeholder="Enter game title">
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="4"
                            class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500"
                            placeholder="Write a short description of the game"></textarea>
                    </div>

                    <!-- Meta Tags -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Meta Tag</label>
                            <input type="text" name="meta_tag"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500"
                                placeholder="e.g. action, puzzle, multiplayer">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                            <textarea name="meta_description" rows="2"
                                class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-blue-500"
                                placeholder="SEO description for the game"></textarea>
                        </div>
                    </div>

                    <!-- Images Section -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <i class="fas fa-images"></i> Game Images
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Main Image <span
                                        class="text-red-500">*</span></label>
                                <input type="file" name="main_image" accept="image/*"
                                    class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl file:mr-4 file:py-2 file:px-6 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Screenshot 1</label>
                                <input type="file" name="image1" accept="image/*"
                                    class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl file:mr-4 file:py-2 file:px-6 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Screenshot 2</label>
                                <input type="file" name="image2" accept="image/*"
                                    class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl file:mr-4 file:py-2 file:px-6 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Screenshot 3</label>
                                <input type="file" name="image3" accept="image/*"
                                    class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl file:mr-4 file:py-2 file:px-6 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>
                    </div>

                    <!-- Game File -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Game File (ZIP or HTML) <span
                                class="text-red-500">*</span></label>
                        <div
                            class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center hover:border-blue-400 transition-colors">
                            <i class="fas fa-cloud-upload-alt text-5xl text-gray-400 mb-4"></i>
                            <input type="file" name="game_file" required
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-8 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                            <p class="text-xs text-gray-500 mt-3">Supported: .zip or .html files</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-4 rounded-2xl text-lg transition-all duration-300 flex items-center justify-center gap-3 shadow-lg hover:shadow-xl">
                            <i class="fas fa-plus"></i>
                            Add Game
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Footer Note -->
        <p class="text-center text-gray-500 text-sm mt-8">
            All uploaded files are stored securely • Make sure images are optimized
        </p>
    </div>

</body>

</html>