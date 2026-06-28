<?php
include 'config.php';

if (isset($_POST['submit'])) {

    $title = $_POST['title'];
    $subtitle = $_POST['subtitle'];
    $description = $_POST['description'];
    $button_text = $_POST['button_text'];
    $button_link = $_POST['button_link'];
    $type = $_POST['slide_type'];

    // Upload Video
    $video = $_FILES['video']['name'];
    $tmp = $_FILES['video']['tmp_name'];
    move_uploaded_file($tmp, "../uploads/" . $video);

    $query = "INSERT INTO sliders 
    (title, subtitle, description, button_text, button_link, video, slide_type)
    VALUES 
    ('$title','$subtitle','$description','$button_text','$button_link','$video','$type')";

    mysqli_query($conn, $query);

    echo "Slider Added Successfully!";
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title"><br>
    <input type="text" name="subtitle" placeholder="Subtitle"><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <input type="text" name="button_text" placeholder="Button Text"><br>
    <input type="text" name="button_link" placeholder="Button Link"><br>

    <select name="slide_type">
        <option value="simple">Simple</option>
        <option value="text">Text</option>
        <option value="split">Split</option>
    </select><br>

    <input type="file" name="video"><br>

    <button type="submit" name="submit">Add Slider</button>
</form>