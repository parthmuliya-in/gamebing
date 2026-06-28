<?php
// $host = "localhost";
// $user = "root";
// $pass = "";
// $db = "miniar";

// $conn = new mysqli($host, $user, $pass, $db);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
$host = "localhost";
$user = "gamebinge_club";
$pass = "AprQ0B~8CzOZtVt~";
$db = "gamebinge_club";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
?>