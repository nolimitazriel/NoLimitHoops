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

$order_id = $_GET['id'];

$order_query = "
SELECT
    orders.*,
    users.username,
    users.nama_lengkap,
    users.nomor_hp,
    users.alamat
FROM orders
JOIN users
ON orders.user_id = users.id
WHERE orders.id = $order_id
";

$order_result = mysqli_query($conn, $order_query);

$order = mysqli_fetch_assoc($order_result);

$items_query = "
SELECT
    order_items.*,
    products.nama
FROM order_items
JOIN products
ON order_items.product_id = products.id
WHERE order_items.order_id = $order_id
";

$items_result = mysqli_query($conn, $items_query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h1>Pesanan #<?php echo $order['id']; ?></h1>

    <hr>

    <h4>Data Customer</h4>

    <p>
        Nama:
        <?php echo $order['nama_lengkap']; ?>
    </p>

    <p>
        Username:
        <?php echo $order['username']; ?>
    </p>

    <p>
        Nomor HP:
        <?php echo $order['nomor_hp']; ?>
    </p>

    <p>
        Alamat:
        <?php echo $order['alamat']; ?>
    </p>

    <hr>

    <h4>Produk Dipesan</h4>

    <table class="table table-bordered">

        <tr>

            <th>Produk</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Subtotal</th>

        </tr>

        <?php while($item = mysqli_fetch_assoc($items_result)) : ?>

        <tr>

            <td>
                <?php echo $item['nama']; ?>
            </td>

            <td>
                <?php echo $item['quantity']; ?>
            </td>

            <td>
                Rp <?php echo number_format($item['harga']); ?>
            </td>

            <td>
                Rp <?php echo number_format(
                    $item['harga'] * $item['quantity']
                ); ?>
            </td>

        </tr>

        <?php endwhile; ?>

    </table>

    <h4>
        Total:
        Rp <?php echo number_format($order['total_harga']); ?>
    </h4>
    
    <hr>

    <h4>Status Pesanan</h4>

    <form action="update_status.php" method="POST">

        <input
            type="hidden"
            name="order_id"
            value="<?php echo $order['id']; ?>">

        <select
            name="status"
            class="form-control mb-3">

            <option value="pending"
                <?php if($order['status']=='pending') echo 'selected'; ?>>
                Pending
            </option>

            <option value="diproses"
                <?php if($order['status']=='diproses') echo 'selected'; ?>>
                Diproses
            </option>

            <option value="dikirim"
                <?php if($order['status']=='dikirim') echo 'selected'; ?>>
                Dikirim
            </option>

            <option value="selesai"
                <?php if($order['status']=='selesai') echo 'selected'; ?>>
                Selesai
            </option>

        </select>

        <button
            type="submit"
            class="btn btn-success">

            Simpan Status

        </button>

    </form>

</div>

</body>
</html>