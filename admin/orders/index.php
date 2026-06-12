<?php

session_start();

require __DIR__ . '/../../config/database.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: ../login.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {

    header("Location: ../../index.php");
    exit;
}

$query = "
SELECT
    orders.*,
    users.username
FROM orders
JOIN users
ON orders.user_id = users.id
ORDER BY orders.created_at DESC
";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Pesanan</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h1>Kelola Pesanan</h1>

    <table class="table table-bordered">

        <tr>

            <th>ID</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>

        </tr>

        <?php while($order = mysqli_fetch_assoc($result)) : ?>

        <tr>

            <td>
                <?php echo $order['id']; ?>
            </td>

            <td>
                <?php echo $order['username']; ?>
            </td>

            <td>
                Rp <?php echo number_format($order['total_harga']); ?>
            </td>

            <td>
                <?php echo ucfirst($order['status']); ?>
            </td>

            <td>
                <?php echo $order['created_at']; ?>
            </td>

            <td>

                <a
                    href="detail.php?id=<?php echo $order['id']; ?>"
                    class="btn btn-primary btn-sm">

                    Detail

                </a>

            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>