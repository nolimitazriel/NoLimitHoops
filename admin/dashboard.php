<?php

session_start();

require __DIR__ . '/../config/database.php';

$product_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM products"
);

$total_products =
    mysqli_fetch_assoc($product_result)['total'];

$user_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM users
     WHERE role='customer'"
);

$total_customers =
    mysqli_fetch_assoc($user_result)['total'];

$order_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM orders"
);

$total_orders =
    mysqli_fetch_assoc($order_result)['total'];

$revenue_result = mysqli_query(
    $conn,
    "SELECT SUM(total_harga) AS total
     FROM orders"
);

$total_revenue =
    mysqli_fetch_assoc($revenue_result)['total'];

$pending_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM orders
     WHERE status='pending'"
);

$total_pending =
    mysqli_fetch_assoc($pending_result)['total'];

$shipped_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM orders
     WHERE status='dikirim'"
);

$total_shipped =
    mysqli_fetch_assoc($shipped_result)['total'];

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Dashboard Admin</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>
<body>

<div class="container mt-5">

    <h1>Dashboard Admin</h1>

    <p>
        Selamat datang,
        <?php echo $_SESSION['username']; ?>
    </p>

    <hr>

    <div class="row">

        <div class="col-md-4 mb-3">

            <div class="card">

                <div class="card-body">

                    <h5>📦 Produk</h5>

                    <h2>
                        <?php echo $total_products; ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-3">

            <div class="card">

                <div class="card-body">

                    <h5>👤 Customer</h5>

                    <h2>
                        <?php echo $total_customers; ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-4 mb-3">

            <div class="card">

                <div class="card-body">

                    <h5>🛒 Pesanan</h5>

                    <h2>
                        <?php echo $total_orders; ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-6 mb-3">

            <div class="card">

                <div class="card-body">

                    <h5>💰 Pendapatan</h5>

                    <h2>
                        Rp <?php echo number_format($total_revenue); ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card">

                <div class="card-body">

                    <h5>⏳ Pending</h5>

                    <h2>
                        <?php echo $total_pending; ?>
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card">

                <div class="card-body">

                    <h5>🚚 Dikirim</h5>

                    <h2>
                        <?php echo $total_shipped; ?>
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <hr>

    <a
        href="products/index.php"
        class="btn btn-primary">
        Kelola Produk
    </a>

    <a
        href="orders/index.php"
        class="btn btn-success">
        Kelola Pesanan
    </a>

    <a
        href="../index.php"
        class="btn btn-secondary">
        Lihat Website
    </a>

</div>

</body>
</html>
