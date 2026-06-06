<?php

session_start();

require __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}

$product_query = "SELECT COUNT(*) AS total_products FROM products";

$product_result = mysqli_query($conn, $product_query);

$product_data = mysqli_fetch_assoc($product_result);

$total_products = $product_data['total_products'];

$user_query = "SELECT COUNT(*) AS total_users FROM users";

$user_result = mysqli_query($conn, $user_query);

$user_data = mysqli_fetch_assoc($user_result);

$total_users = $user_data['total_users'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
<h1>Dashboard Admin</h1>

<p>
    Selamat datang,
    <?php echo $_SESSION['username']; ?>
</p>

<hr>

<h3>Total Produk</h3>

<p>
    <?php echo $total_products; ?>
</p>

<h3>Total User</h3>

<p>
    <?php echo $total_users; ?>
</p>

<hr>

<p>

    <a href="products/create.php">
        Tambah Produk
    </a>

</p>

<p>

    <a href="../index.php">
        Lihat Website
    </a>

</p>

<p>

    <a href="logout.php">
        Logout
    </a>

</p>

</body>
</html>