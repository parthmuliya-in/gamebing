<?php
session_start();
include 'config.php'; // your DB connection
include 'header.php';

// ✅ DELETE MULTIPLE
if (isset($_POST['delete_selected'])) {

    if (!empty($_POST['ids'])) {

        $ids = $_POST['ids'];
        $ids = array_map('intval', $ids); // security
        $ids_list = implode(",", $ids);

        $delete = "DELETE FROM contact_messages WHERE id IN ($ids_list)";
        
        if (mysqli_query($conn, $delete)) {
            $msg = "Selected records deleted successfully!";
        } else {
            $msg = "Error: " . mysqli_error($conn);
        }
    } else {
        $msg = "Please select at least one record.";
    }
}

// ✅ FETCH DATA
$result = mysqli_query($conn, "SELECT * FROM contact_messages ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Contacts</title>

<style>
body {
    font-family: Arial;
    background: #111;
    color: #fff;
    padding: 20px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.table-container {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: #1a1a1a;
}

th, td {
    padding: 12px;
    border: 1px solid #333;
    text-align: left;
}

th {
    background: #ff7a00;
    color: #fff;
}

tr:hover {
    background: #222;
}

button {
    background: #ff7a00;
    border: none;
    padding: 10px 15px;
    color: #fff;
    cursor: pointer;
    border-radius: 5px;
}

button:hover {
    background: #ff5500;
}

.msg {
    text-align: center;
    margin-bottom: 15px;
    color: #00ff88;
}
.error {
    color: #ff4444;
}
</style>

<script>
// ✅ Select All
function toggleSelect(source) {
    checkboxes = document.getElementsByName('ids[]');
    for(let i=0; i<checkboxes.length; i++) {
        checkboxes[i].checked = source.checked;
    }
}
</script>

</head>
<body>

<h2>📩 Contact Messages</h2>

<?php if(isset($msg)): ?>
    <div class="msg"><?= $msg ?></div>
<?php endif; ?>

<form method="POST">

<div style="margin-bottom: 10px;">
    <button type="submit" name="delete_selected">🗑 Delete Selected</button>
</div>

<div class="table-container">
<table>
    <tr>
        <th><input type="checkbox" onclick="toggleSelect(this)"></th>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Message</th>
        <th>Date</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td>
            <input type="checkbox" name="ids[]" value="<?= $row['id'] ?>">
        </td>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['phone']) ?></td>
        <td><?= htmlspecialchars($row['message']) ?></td>
        <td><?= $row['created_at'] ?></td>
    </tr>
    <?php endwhile; ?>

</table>
</div>

</form>

</body>
</html>