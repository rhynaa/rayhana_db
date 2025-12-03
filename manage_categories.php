<?php
include 'database.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $description);

    if ($stmt->execute()) {
        echo "<p>Category added successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<p>Category deleted successfully!</p>";
    } else {
        echo "<p>Error deleting category: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$categories = [];
$result = $conn->query("SELECT * FROM categories ORDER BY name ASC");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div align="center">
    <h1>Manage Categories</h1>
</div>

    <h3 style="text-align: center;">Add New Category</h3>
    <form method="post" action="">
        <label>Category Name:</label>
        <input type="text" name="name" required>

        <label>Description:</label>
        <textarea name="description"></textarea>

       <div style="text-align: center; margin-top: 20px;">
    <button type="submit" class="btn btn-primary">Add Category</button>
</div>

    </form>

    <h3 style="text-align: center; margin-top: 40px;">Existing Categories</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($categories as $cat): ?>
        <tr>
            <td><?= $cat['id'] ?></td>
            <td><?= htmlspecialchars($cat['name']) ?></td>
            <td><?= htmlspecialchars($cat['description']) ?></td>
            <td>
                <a href="?delete_id=<?= $cat['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="button-container">
            <a href="index.php" class="button">Back to Dashboard</a>
        </div>
</body>
</html>
