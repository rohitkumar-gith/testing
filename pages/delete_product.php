<?php
session_start();
include '../config/db.php';

if (isset($_GET['id'])) {
    $product_id = (int) $_GET['id'];

    $conn->query("DELETE FROM stock_logs WHERE product_id = $product_id");
    $conn->query("DELETE FROM stock_log WHERE product_id = $product_id");
    $conn->query("DELETE FROM price_history WHERE product_id = $product_id");
    if ($conn->query("DELETE FROM products WHERE id = $product_id")) {
        $_SESSION['message'] = "Product and related logs deleted successfully.";
    } else {
        $_SESSION['message'] = "Failed to delete product: " . $conn->error;
    }
} else {
    $_SESSION['message'] = "Invalid product ID.";
}

header("Location: products.php");
exit();
?>
