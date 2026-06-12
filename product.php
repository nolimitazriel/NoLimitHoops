<?php

require 'config/database.php';

$id = $_GET['id'];

$query = "SELECT * FROM products WHERE id = $id";

$result = mysqli_query($conn, $query);

$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Produk tidak ditemukan");
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

<?php require 'includes/footer.php'; ?>