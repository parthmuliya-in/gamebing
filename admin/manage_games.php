<?php
require '../config.php';
include 'header.php';
$result = $conn->query("SELECT * FROM games");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Games</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            /* padding: 20px; */
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .table-container {
            overflow-x: auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            background: white;
        }

        table {
            width: 100%;
            min-width: 600px;
            /* Prevents too much squeezing on mobile */
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #2c3e50;
            color: white;
            font-weight: 600;
            white-space: nowrap;
        }

        tr:hover {
            background-color: #f1f3f5;
        }

        td {
            vertical-align: middle;
        }

        img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .action-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }

            th,
            td {
                padding: 12px 8px;
                font-size: 14px;
            }

            img {
                width: 60px;
                height: 60px;
            }

            .action-btn {
                padding: 7px 12px;
                font-size: 13px;
            }
        }

        /* Card view for very small screens (optional enhancement) */
        @media (max-width: 576px) {
            .table-container {
                border-radius: 8px;
            }

            table {
                min-width: 100%;
            }
        }
    </style>
</head>

<body>

    <h2>All Games</h2>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td>
                            <img src="../uploads/images/<?php echo htmlspecialchars($row['main_image']); ?>"
                                alt="<?php echo htmlspecialchars($row['title']); ?>">
                        </td>
                        <td>
                            <a href="edit_game2.php?id=<?php echo $row['id']; ?>">
                                <i class="fa-regular fa-pen-to-square" style="color: rgb(116, 192, 252);"></i></a> ||
                            <a href="delete_game.php?id=<?php echo $row['id']; ?>" class="text-red-600 hover:text-red-800"
                                onclick="return confirm('Are you sure you want to delete this game?')">
                                <i class="fa-solid fa-trash" style="color: red;"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>

</html>