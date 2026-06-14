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

$best_seller_query = "
SELECT
    products.nama,
    SUM(order_items.quantity) AS total_terjual
FROM order_items
JOIN products
ON order_items.product_id = products.id
GROUP BY products.id
ORDER BY total_terjual DESC
LIMIT 5
";

$latest_orders_query = "
SELECT
    orders.id,
    orders.total_harga,
    orders.status,
    orders.created_at,
    users.username
FROM orders
JOIN users
ON orders.user_id = users.id
ORDER BY orders.created_at DESC
LIMIT 5
";

$latest_orders_result = mysqli_query(
    $conn,
    $latest_orders_query
);

$best_seller_result = mysqli_query(
    $conn,
    $best_seller_query
);

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

    <div class="card mb-4">

        <div class="card-body">

            <h4>
                🏆 Produk Terlaris
            </h4>

            <table class="table">

                <tr>

                    <th>#</th>
                    <th>Produk</th>
                    <th>Terjual</th>

                </tr>

                <?php

                $no = 1;

                while(
                    $product =
                    mysqli_fetch_assoc(
                        $best_seller_result
                    )
                ) :

                ?>

                <tr>

                    <td>
                        <?php echo $no++; ?>
                    </td>

                    <td>
                        <?php echo $product['nama']; ?>
                    </td>

                    <td>
                        <?php echo $product['total_terjual']; ?>
                    </td>

                </tr>

                <?php endwhile; ?>

            </table>

        </div>

    </div>
    
    <div class="card mb-4">

    <div class="card-body">

        <h4>
            📋 Pesanan Terbaru
        </h4>

        <?php if(mysqli_num_rows($latest_orders_result) > 0) : ?>

            <table class="table table-striped">

                <tr>

                    <th>ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>

                </tr>

                <?php while(
                    $order =
                    mysqli_fetch_assoc(
                        $latest_orders_result
                    )
                ) : ?>

                <tr>

                    <td>
                        #<?php echo $order['id']; ?>
                    </td>

                    <td>
                        <?php echo $order['username']; ?>
                    </td>

                    <td>
                        Rp <?php echo number_format(
                            $order['total_harga']
                        ); ?>
                    </td>

                    <td>

                        <?php

                        if (
                            $order['status']
                            == 'pending'
                        ) {

                            echo '<span class="badge bg-secondary">Pending</span>';

                        }
                        elseif (
                            $order['status']
                            == 'diproses'
                        ) {

                            echo '<span class="badge bg-warning">Diproses</span>';

                        }
                        elseif (
                            $order['status']
                            == 'dikirim'
                        ) {

                            echo '<span class="badge bg-info">Dikirim</span>';

                        }
                        else {

                            echo '<span class="badge bg-success">Selesai</span>';

                        }

                        ?>

                    </td>

                    <td>
                        <?php echo $order['created_at']; ?>
                    </td>

                </tr>

                <?php endwhile; ?>

            </table>

        <?php else : ?>

            <div class="alert alert-info">

                Belum ada pesanan.

            </div>

        <?php endif; ?>

    </div>

</div>

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
