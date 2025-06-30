<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

// Handle Stock In
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $buying_price = $_POST['buying_price'];  // New field for buying price

    // Update product quantity
    $conn->query("UPDATE products SET quantity = quantity + $quantity WHERE id = $product_id");

    // Insert into stock_log (to track changes in stock with buying price)
    $conn->query("INSERT INTO stock_log (product_id, change_type, quantity, price) 
                  VALUES ($product_id, 'IN', $quantity, $buying_price)");
}

// Get all products
$products = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stock In</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>
<body>
    <h2>Stock In</h2>
    <a href="dashboard.php">← Back to Dashboard</a>

    <form method="POST">
        <label>Select Product:</label><br>
        <select name="product_id" required>
            <option value="">-- Select --</option>
            <?php while ($row = $products->fetch_assoc()): ?>
                <option value="<?= $row['id']; ?>"><?= $row['product_name']; ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <label>Quantity to Add:</label><br>
        <input type="number" name="quantity" required><br><br>

        <!-- New field for Buying Price -->
        <label>Buying Price:</label><br>
        <input type="number" name="buying_price" step="0.01" required><br><br>

        <button type="submit">Add Stock</button>
    </form>
</body>
</html>
