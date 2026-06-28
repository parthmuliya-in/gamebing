<?php
session_start();
require 'config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {

        // Prepared Statement
        $stmt = $conn->prepare("SELECT id, password FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {

                // Secure session
                session_regenerate_id(true);

                $_SESSION['admin_id'] = $id;
                $_SESSION['admin_email'] = $email;

                header("Location: dashboard.php");
                exit();

            } else {
                $error = "Invalid password!";
            }

        } else {
            $error = "Email not found!";
        }

        $stmt->close();

    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial;
            background: #0f172a;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background: #1e293b;
            padding: 30px;
            border-radius: 10px;
            width: 300px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #38bdf8;
            border: none;
            color: #000;
            font-weight: bold;
            cursor: pointer;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>

    <form method="POST">
        <h2>Admin Login</h2>

        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

</body>

</html>