<?php
include 'database.php';

if (!isset($_GET['id'])) {
    die("Product ID is missing.");
}

$product_id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);

if ($stmt->execute()) {
    echo "<p>Product deleted successfully!</p>";
    echo '<a href="index.php">Back to Dashboard</a>';
} else {
    echo "<p>Error deleting product: " . $stmt->error . "</p>";
}

$stmt->close();
?>
