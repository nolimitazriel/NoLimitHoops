<?php

session_start();

require 'config/database.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "
SELECT
    wishlist.id,
    products.*
FROM wishlist
JOIN products
ON wishlist.product_id = products.id
WHERE wishlist.user_id = $user_id
";

$result = mysqli_query($conn, $query);

require 'includes/header.php';
?>

<h1>❤️ Wishlist Saya</h1>

<?php while($product = mysqli_fetch_assoc($result)) : ?>

<div class="card mb-3">

    <div class="card-body">

        <img
            src="uploads/<?php echo $product['gambar']; ?>"
            width="150">

        <h4>
            <?php echo $product['nama']; ?>
        </h4>

        <p>
            Rp <?php echo number_format($product['harga']); ?>
        </p>

        <a
            href="add_to_cart.php?id=<?php echo $product['id']; ?>"
            class="btn btn-primary">

            🛒 Keranjang

        </a>

        <a
            href="remove_wishlist.php?id=<?php echo $product['id']; ?>"
            class="btn btn-danger">

            Hapus

        </a>

    </div>

</div>

<?php endwhile; ?>

<?php require 'includes/footer.php'; ?>