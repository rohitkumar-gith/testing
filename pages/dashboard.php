<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include('../config/db.php');
include('../includes/header.php');

// Total Spending (Buying Price * Quantity for IN logs)
$spendingResult = $conn->query("SELECT SUM(price * quantity) AS total_spending FROM stock_log WHERE change_type = 'IN'");
$spendingData = mysqli_fetch_assoc($spendingResult);
$totalSpending = $spendingData['total_spending'] ?? 0;

// Total Earning (Selling Price * Quantity for OUT logs)
$earningResult = $conn->query("SELECT SUM(price * quantity) AS total_earning FROM stock_log WHERE change_type = 'OUT'");
$earningData = mysqli_fetch_assoc($earningResult);
$totalEarning = $earningData['total_earning'] ?? 0;

// Total Profit = Earning - Spending
$totalProfit = $totalEarning - $totalSpending;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['user']; ?>!</h2>
    <p>This is the Inventory Dashboard.</p>

    <h3>Business Summary</h3>
    <table border="1" cellpadding="8">
        <tr>
            <th>Total Spending</th>
            <th>Total Earning</th>
            <th>Total Profit</th>
        </tr>
        <tr>
            <td>₹<?= number_format($totalSpending, 2) ?></td>
            <td>₹<?= number_format($totalEarning, 2) ?></td>
            <td>₹<?= number_format($totalProfit, 2) ?></td>
        </tr>
    </table>
</body>
</html>
