<?php

session_start();

require 'config/database.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] != 'customer') {  

    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "
SELECT
    cart.id,
    cart.product_id,
    cart.quantity,
    products.nama,
    products.harga,
    products.gambar
FROM cart
JOIN products
ON cart.product_id = products.id
WHERE cart.user_id = $user_id
";

$result = mysqli_query($conn, $query);

require 'includes/header.php';

$total = 0;
?>

<h1>Keranjang Belanja</h1>

<?php while($item = mysqli_fetch_assoc($result)) : ?>

    <?php
    $subtotal =
        $item['harga'] *
        $item['quantity'];

    $total += $subtotal;
    ?>

    <div class="card mb-3">

        <div class="card-body">

            <img
                src="uploads/<?php echo $item['gambar']; ?>"
                width="100">

            <h4>
                <?php echo $item['nama']; ?>
            </h4>

            <p>

                <a
                    href="update_cart.php?id=<?php echo $item['id']; ?>&action=decrease"
                    class="btn btn-secondary btn-sm">

                    -

                </a>

                <strong class="mx-2">
                    <?php echo $item['quantity']; ?>
                </strong>

                <a
                    href="update_cart.php?id=<?php echo $item['id']; ?>&action=increase"
                    class="btn btn-secondary btn-sm">

                    +

                </a>

            </p>

            <p>
                Subtotal:
                Rp <?php echo number_format($subtotal); ?>
            </p>

            <p>

                <a
                    href="remove_from_cart.php?id=<?php echo $item['id']; ?>"
                    class="btn btn-danger"
                    onclick="return confirm('Hapus produk dari keranjang?')">

                    Hapus

                </a>

            </p>

        </div>

    </div>

<?php endwhile; ?>

<hr>

<h3>
    Total:
    Rp <?php echo number_format($total); ?>
</h3>

<a
    href="checkout.php"
    class="btn btn-success">

    Checkout

</a>

<?php require 'includes/footer.php'; ?>