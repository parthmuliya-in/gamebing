<?php
$conn = new mysqli("localhost", "root", "", "miniar");

$pass = password_hash("admin123", PASSWORD_DEFAULT);

$sql = "INSERT INTO admins (email, password) VALUES ('admin@gmail.com', '$pass')";
$conn->query($sql);

echo "Admin Created";
?>