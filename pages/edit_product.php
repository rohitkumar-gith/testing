<?php
include('../config/db.php');
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['description'];
    $updateQuery = "UPDATE products SET product_name='$name', price='$price', description='$quantity' WHERE id=$id";
    mysqli_query($conn, $updateQuery);

    header("Location: products.php");
    exit();
}
?>

<?php include('../includes/header.php'); ?>

<!-- Main Content -->
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Edit Product</h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <form method="POST">
        <div class="form-group">
          <label>Product Name</label>
          <input type="text" name="name" value="<?php echo $product['product_name']; ?>" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Market Price</label>
          <input type="number" name="price" value="<?php echo $product['price']; ?>" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Description</label>
          <input type="text" name="description" value="<?php echo $product['description']; ?>" class="form-control" required>
        </div>
        <button type="submit" name="update" class="btn btn-success">Update Product</button>
      </form>
    </div>
  </section>
</div>

<?php include('../includes/footer.php'); ?>
