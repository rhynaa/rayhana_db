<?php
include 'database.php';

if (!isset($_GET['id'])) {
    die("Product ID is missing.");
}
$product_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    die("Product not found.");
}

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

    $stmt = $conn->prepare("UPDATE products SET name=?, category_id=?, price=?, quantity=?, description=? WHERE id=?");
    $stmt->bind_param("sidisi", $name, $category_id, $price, $quantity, $description, $product_id);

    if ($stmt->execute()) {
        echo "<p>Product updated successfully!</p>";

        $product = [
            'name' => $name,
            'category_id' => $category_id,
            'price' => $price,
            'quantity' => $quantity,
            'description' => $description
        ];
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Product</h1>
    <a href="index.php">Back to Dashboard</a>

    <form method="post" action="">
        <label>Product Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

        <label>Category:</label>
        <select name="category_id" required>
            <option value="">Select Category</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                    <?= $cat['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>

        <label>Quantity:</label>
        <input type="number" name="quantity" value="<?= $product['quantity'] ?>" required>

        <label>Description:</label>
        <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>

        <button type="submit" name="submit">Update Product</button>
    </form>
</body>
</html>
