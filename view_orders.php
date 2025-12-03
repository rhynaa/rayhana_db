<?php
include 'database.php';

$query = "
    SELECT o.id, o.order_date, o.total_amount, c.name AS customer_name
    FROM orders o
    JOIN customers c ON o.customer_id = c.id
    ORDER BY o.order_date DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div align="center">
    <h1>All Orders</h1>
</div>

   
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Order Date</th>
            <th>Total Amount</th>
            <th>Actions</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($order = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= htmlspecialchars($order['customer_name']) ?></td>
                    <td><?= $order['order_date'] ?></td>
                    <td>₱<?= number_format($order['total_amount'], 2) ?></td>
                    <td>
                        <a href="view_order_details.php?id=<?= $order['id'] ?>">View Details</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No orders found.</td>
            </tr>
        <?php endif; ?>
    </table>
    <div class="button-container">
            <a href="index.php" class="button">Back to Dashboard</a>
        </div>
</body>
</html>
