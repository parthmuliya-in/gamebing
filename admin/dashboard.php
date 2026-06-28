<?php
// session_start();
include 'header.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
?>
<title>Dashboard</title>
<h1>Welcome Admin</h1>