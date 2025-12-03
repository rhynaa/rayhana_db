<?php
include 'database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rayhana_db</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>

        <div class="dashboard-cards">
            <a href="manage_categories.php" class="card">
                <h2>Categories</h2>
                <p>Manage your product categories</p>
            </a>
            <a href="add_product.php" class="card">
                <h2>Add Product</h2>
                <p>Add new products to inventory</p>
            </a>
            <a href="add_customer.php" class="card">
                <h2>Add Customer</h2>
                <p>Add new customers</p>
            </a>
            <a href="add_order.php" class="card">
                <h2>Add Order</h2>
                <p>Create new orders</p>
            </a>
            <a href="view_orders.php" class="card">
                <h2>View Orders</h2>
                <p>See all orders and details</p>
            </a>
        </div>
    </div>
</body>
</html>
