<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

// Fetch all stock logs with product name
$query = "
    SELECT sl.*, p.product_name 
    FROM stock_log sl 
    JOIN products p ON sl.product_id = p.id 
    ORDER BY sl.created_at DESC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stock Report</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>
<body>
    <h2>Stock Movement Report</h2>
    <a href="dashboard.php">← Back to Dashboard</a><br><br>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Type</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['product_name']); ?></td>
                    <td><?= $row['change_type']; ?></td>
                    <td><?= $row['quantity']; ?></td>
                    <td>₹<?= number_format($row['price'], 2); ?></td>
                    <td>₹<?= number_format($row['price'] * $row['quantity'], 2); ?></td>
                    <td><?= date("d M Y, h:i A", strtotime($row['created_at'])); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">No stock movements recorded yet.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
