<?php

require 'config/database.php';

$id = $_GET['id'];

$query = "SELECT * FROM products WHERE id = $id";

$result = mysqli_query($conn, $query);

$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Produk tidak ditemukan");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $product['nama']; ?></title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>
<body>

<div class="container mt-5">

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

</div>

</body>
</html>