<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $product_name = $_POST['product_name'];
    $product_code = $_POST['product_code'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql = "INSERT INTO products (product_name, product_code, description, price, quantity)
            VALUES ('$product_name', '$product_code', '$description', '$price', 0)";
    $conn->query($sql);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_product'])) {
    $delete_id = $_POST['delete_id'];
    $conn->query("DELETE FROM products WHERE id = $delete_id");
}

$products = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>
<body>
    <h2>Product Management</h2>
    <a href="dashboard.php">← Back to Dashboard</a>

    <h3>Add Product</h3>
    <form method="POST">
        <input type="hidden" name="add_product" value="1">
        <label>Product Name:</label><br>
        <input type="text" name="product_name" required><br><br>
        <label>Product Code:</label><br>
        <input type="text" name="product_code" required><br><br>
        <label>Description:</label><br>
        <textarea name="description"></textarea><br><br>
        <label>Market Price:</label><br>
        <input type="number" step="0.01" name="price" required><br><br>
        <button type="submit">Add Product</button>
    </form>

    <h3>Product List</h3>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Code</th>
            <th>Description</th>
            <th>Market Price</th>
            <th>Quantity</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $products->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['product_name']; ?></td>
            <td><?= $row['product_code']; ?></td>
            <td><?= $row['description']; ?></td>
            <td><?= $row['price']; ?></td>
            <td><?= $row['quantity']; ?></td>
            <td>
                <a href="edit_product.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                

                <a href="delete_product.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>

            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
