<?php

session_start();

require 'config/database.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}

$order_id = $_GET['id'];

$user_id = $_SESSION['user_id'];

$order_query = "
SELECT *
FROM orders
WHERE id = $order_id
AND user_id = $user_id
";

$order_result = mysqli_query($conn, $order_query);

$order = mysqli_fetch_assoc($order_result);

if (!$order) {

    die("Pesanan tidak ditemukan.");
}

$items_query = "
SELECT
    order_items.*,
    products.nama,
    products.gambar
FROM order_items
JOIN products
ON order_items.product_id = products.id
WHERE order_items.order_id = $order_id
";

$items_result = mysqli_query($conn, $items_query);

require 'includes/header.php';

?>

<h1>
    Pesanan #<?php echo $order['id']; ?>
</h1>

<p>
    Status:
    <strong>
        <?php echo ucfirst($order['status']); ?>
    </strong>
</p>

<p>
    Tanggal:
    <?php echo $order['created_at']; ?>
</p>

<hr>

<h3>Produk yang Dibeli</h3>

<?php while($item = mysqli_fetch_assoc($items_result)) : ?>

    <div class="card mb-3">

        <div class="card-body">

            <img
                src="uploads/<?php echo $item['gambar']; ?>"
                width="120">

            <h5>
                <?php echo $item['nama']; ?>
            </h5>

            <p>
                Harga:
                Rp <?php echo number_format($item['harga']); ?>
            </p>

            <p>
                Jumlah:
                <?php echo $item['quantity']; ?>
            </p>

            <p>
                Subtotal:
                Rp <?php echo number_format(
                    $item['harga'] * $item['quantity']
                ); ?>
            </p>

        </div>

    </div>

<?php endwhile; ?>

<hr>

<h3>
    Total Pesanan:
    Rp <?php echo number_format($order['total_harga']); ?>
</h3>

<a
    href="orders.php"
    class="btn btn-secondary">

    Kembali

</a>

<?php require 'includes/footer.php'; ?>