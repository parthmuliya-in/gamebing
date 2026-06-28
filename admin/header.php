<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <header class="admin-header">
        <div class="logo">Admin Panel</div>

        <nav id="navMenu">
            <!-- CLOSE BUTTON -->
            <div class="close-btn" onclick="toggleMenu()">
                <i class="fas fa-times"></i>
            </div>

            <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
            <a href="add_game2.php"> Games</a>
            <a href="manage_games.php"> Manage Games</a>
            <!-- <a href="orders.php"><i class="fas fa-cart-shopping"></i> Orders</a> -->
            <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>

        <!-- MENU BUTTON -->
        <div class="menu-toggle" onclick="toggleMenu()">
            <i class="fas fa-bars"></i>
        </div>
    </header>

    <!-- OVERLAY -->
    <div id="overlay" onclick="toggleMenu()"></div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* HEADER */
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #363434fb;
            padding: 14px 20px;
            color: #fff;
            border-bottom: 2px solid #ff7a00;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        /* LOGO */
        .logo {
            font-size: 22px;
            font-weight: bold;
            color: #ff7a00;
        }

        /* NAV DESKTOP */
        .admin-header nav {
            display: flex;
            gap: 25px;
        }

        /* LINKS */
        .admin-header nav a {
            color: #fff;
            text-decoration: none;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        /* HOVER */
        .admin-header nav a:hover {
            color: #ff7a00;
        }

        /* LOGOUT */
        .logout {
            color: #ff7a00;
        }

        /* MENU BUTTON */
        .menu-toggle {
            display: none;
            font-size: 22px;
            cursor: pointer;
        }

        /* CLOSE BUTTON */
        .close-btn {
            display: none;
            text-align: right;
            font-size: 22px;
            margin-bottom: 15px;
            cursor: pointer;
        }

        /* OVERLAY */
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            z-index: 999;
        }

        /* 🔥 MOBILE */
        @media (max-width: 768px) {

            .menu-toggle {
                display: block;
            }

            .admin-header nav {
                position: fixed;
                top: 0;
                right: -100%;
                width: 260px;
                height: 100vh;
                background: #000;
                flex-direction: column;
                padding: 20px;
                gap: 15px;
                transition: 0.4s ease;
                z-index: 1001;
                border-left: 3px solid #ff7a00;
            }

            .admin-header nav.active {
                right: 0;
            }

            .admin-header nav a {
                padding: 12px;
                border-bottom: 1px solid #2222225b;
                font-size: 16px;
            }

            .close-btn {
                display: block;
                color: #fff;
            }

            #overlay.active {
                display: block;
            }
        }
    </style>

    <script>
        function toggleMenu() {
            document.getElementById("navMenu").classList.toggle("active");
            document.getElementById("overlay").classList.toggle("active");
        }
    </script>
</body>

</html>