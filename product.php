<?php

session_start();

require 'config/database.php';

$id = (int) $_GET['id'];

$query = "SELECT * FROM products WHERE id = $id";

$result = mysqli_query($conn, $query);

$product = mysqli_fetch_assoc($result);

$can_review = false;

if (
    isset($_SESSION['user_id']) &&
    $_SESSION['role'] == 'customer'
) {

    $user_id = $_SESSION['user_id'];

    $purchase_query = "
    SELECT *
    FROM order_items
    JOIN orders
    ON order_items.order_id = orders.id
    WHERE orders.user_id = $user_id
    AND order_items.product_id = $id
    ";

    $purchase_result = mysqli_query(
        $conn,
        $purchase_query
    );

    if (
        mysqli_num_rows(
            $purchase_result
        ) > 0
    ) {

        $can_review = true;
    }
}

if (!$product) {
    die("Produk tidak ditemukan");
}

$review_query = "
SELECT
    reviews.*,
    users.username
FROM reviews
JOIN users
ON reviews.user_id = users.id
WHERE product_id = $id
ORDER BY reviews.created_at DESC
";

$review_result = mysqli_query(
    $conn,
    $review_query
);

$user_reviewed = false;

if (
    isset($_SESSION['user_id']) &&
    $_SESSION['role'] == 'customer'
) {

    $user_id = $_SESSION['user_id'];

    $check_review_query = "
    SELECT *
    FROM reviews
    WHERE user_id = $user_id
    AND product_id = $id
    ";

    $check_review_result = mysqli_query(
        $conn,
        $check_review_query
    );

    if (
        mysqli_num_rows(
            $check_review_result
        ) > 0
    ) {

        $user_reviewed = true;
    }
}

require 'includes/header.php';

?>

<a href="index.php" class="btn btn-secondary mb-3">
    ← Kembali
</a>

<div class="card">

    <div class="card-body">

        <img
            src="uploads/<?php echo $product['gambar']; ?>"
            class="img-fluid mb-3"
            style="max-width:300px;">

        <h1>
            <?php echo $product['nama']; ?>
        </h1>

        <h5>
            Brand:
            <?php echo $product['brand']; ?>
        </h5>

        <h4>
            Rp <?php echo number_format($product['harga']); ?>
        </h4>

        <p>
            Stok:
            <?php echo $product['stok']; ?>
        </p>

        <?php if (
            isset($_SESSION['user_id']) &&
            $_SESSION['role'] == 'customer'
        ) : ?>

            <form action="add_to_cart.php" method="GET">

                <input
                    type="hidden"
                    name="id"
                    value="<?php echo $product['id']; ?>">

                <label class="mb-2">
                    Jumlah
                </label>

                <div class="d-flex align-items-center mb-3">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="decreaseQuantity()">

                        -

                    </button>

                    <input
                        type="number"
                        id="quantity"
                        name="quantity"
                        value="1"
                        min="1"
                        max="<?php echo $product['stok']; ?>"
                        class="form-control mx-2 text-center"
                        style="width:80px;">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="increaseQuantity()">

                        +

                    </button>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary">

                    Tambah ke Keranjang

                </button>

                <a
                    href="add_to_wishlist.php?id=<?php echo $product['id']; ?>"
                    class="btn btn-danger">

                    ❤️ Wishlist

                </a>

            </form>

            

        <?php endif; ?>

        <p>
            Warna:
            <?php echo $product['warna']; ?>
        </p>

        <p>
            Ukuran:
            <?php echo $product['ukuran']; ?>
        </p>

        <hr>

        <p>
            <?php echo nl2br($product['deskripsi']); ?>
        </p>

    </div>

</div>

<script>

function increaseQuantity() {

    let qty =
        document.getElementById("quantity");

    let max =
        parseInt(qty.max);

    let current =
        parseInt(qty.value);

    if (current < max) {

        qty.value = current + 1;
    }
}

function decreaseQuantity() {

    let qty =
        document.getElementById("quantity");

    let current =
        parseInt(qty.value);

    if (current > 1) {

        qty.value = current - 1;
    }
}

</script>


<hr>

<h3>Review Customer</h3>

<?php if(mysqli_num_rows($review_result) > 0) : ?>

    <?php while(
        $review =
        mysqli_fetch_assoc(
            $review_result
        )
    ) : ?>

        <div class="card mb-2">

            <div class="card-body">

                <strong>

                    <?php
                    echo str_repeat(
                        "⭐",
                        $review['rating']
                    );
                    ?>

                </strong>

                <p>
                    <?php echo $review['review']; ?>
                </p>

                <small>
                    - <?php echo $review['username']; ?>
                </small>

            </div>

        </div>

    <?php endwhile; ?>

<?php else : ?>

    <div class="alert alert-info">
        Belum ada review untuk produk ini.
    </div>

<?php endif; ?>

<h3>Berikan Review</h3>

<?php if ($can_review && !$user_reviewed) : ?>

<form
    action="submit_review.php"
    method="POST">

    <input
        type="hidden"
        name="product_id"
        value="<?php echo $product['id']; ?>">

    <div class="mb-3">

        <label>Rating</label>

        <select
            name="rating"
            class="form-control"
            required>

            <option value="5">★★★★★</option>
            <option value="4">★★★★☆</option>
            <option value="3">★★★☆☆</option>
            <option value="2">★★☆☆☆</option>
            <option value="1">★☆☆☆☆</option>

        </select>

    </div>

    <div class="mb-3">

        <label>Review</label>

        <textarea
            name="review"
            class="form-control"
            rows="4"
            required></textarea>

    </div>

    <button
        type="submit"
        class="btn btn-success">

        Kirim Review

    </button>

</form>

<?php elseif ($user_reviewed) : ?>

<div class="alert alert-success">

    Anda sudah memberikan review untuk produk ini.

</div>

<?php else : ?>

<div class="alert alert-warning">

    Anda harus membeli produk ini terlebih dahulu
    sebelum memberikan review.

</div>

<?php endif; ?>

<?php require 'includes/footer.php'; ?>