<?php
include 'database.php';

$categories = [];
$result = $conn->query("SELECT * FROM categories");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("INSERT INTO products (name, category_id, price, quantity, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sidis", $name, $category_id, $price, $quantity, $description);

    if ($stmt->execute()) {
        $message = "Product added successfully!";
        $message_class = "success";
    } else {
        $message = "Error: " . $stmt->error;
        $message_class = "error";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div align="center">
    <h1>Add Product</h1>
</div>


        <?php if(isset($message)): ?>
            <p class="<?= $message_class ?>"><?= $message ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <label>Product Name:</label>
            <input type="text" name="name" required>

            <label>Category:</label>
            <select name="category_id" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label>Price:</label>
            <input type="number" step="0.01" name="price" required>

            <label>Quantity:</label>
            <input type="number" name="quantity" required>

            <label>Description:</label>
            <textarea name="description"></textarea>

            <div style="text-align: center; margin-top: 20px;">
    <button type="submit" class="btn btn-primary">Add Product</button>
</div>

        </form>
    </div>
    <div class="button-container">
            <a href="index.php" class="button">Back to Dashboard</a>
        </div>
</body>
</html>
