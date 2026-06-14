<?php

session_start();

require __DIR__ . '/../../config/database.php';

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] != 'admin'
) {

    header("Location: ../../index.php");
    exit;
}

$id = (int) $_GET['id'];

$result = mysqli_query(
    $conn,
    "SELECT * FROM products
     WHERE id = $id"
);

$product = mysqli_fetch_assoc($result);

if (!$product) {

    die("Produk tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama = mysqli_real_escape_string(
        $conn,
        $_POST['nama']
    );

    $brand = mysqli_real_escape_string(
        $conn,
        $_POST['brand']
    );

    $harga = (int) $_POST['harga'];

    $stok = (int) $_POST['stok'];

    $warna = mysqli_real_escape_string(
        $conn,
        $_POST['warna']
    );

    $ukuran = mysqli_real_escape_string(
        $conn,
        $_POST['ukuran']
    );

    $deskripsi = mysqli_real_escape_string(
        $conn,
        $_POST['deskripsi']
    );

    $gambar = $product['gambar'];

    if (
        isset($_FILES['gambar']) &&
        $_FILES['gambar']['error'] == 0
    ) {

        $gambar =
            time() .
            '_' .
            $_FILES['gambar']['name'];

        move_uploaded_file(
            $_FILES['gambar']['tmp_name'],
            __DIR__ .
            '/../../uploads/' .
            $gambar
        );
    }

    mysqli_query(

        $conn,

        "UPDATE products
         SET
            nama = '$nama',
            brand = '$brand',
            harga = $harga,
            stok = $stok,
            warna = '$warna',
            ukuran = '$ukuran',
            deskripsi = '$deskripsi',
            gambar = '$gambar'
         WHERE id = $id"
    );

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Edit Produk</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>
<body>

<div class="container mt-5">

    <h1>Edit Produk</h1>

    <form
        method="POST"
        enctype="multipart/form-data">

        <div class="mb-3">

            <label>Nama Produk</label>

            <input
                type="text"
                name="nama"
                class="form-control"
                value="<?php echo $product['nama']; ?>"
                required>

        </div>

        <div class="mb-3">

            <label>Brand</label>

            <input
                type="text"
                name="brand"
                class="form-control"
                value="<?php echo $product['brand']; ?>"
                required>

        </div>

        <div class="mb-3">

            <label>Harga</label>

            <input
                type="number"
                name="harga"
                class="form-control"
                value="<?php echo $product['harga']; ?>"
                required>

        </div>

        <div class="mb-3">

            <label>Stok</label>

            <input
                type="number"
                name="stok"
                class="form-control"
                value="<?php echo $product['stok']; ?>"
                required>

        </div>

        <div class="mb-3">

            <label>Warna</label>

            <input
                type="text"
                name="warna"
                class="form-control"
                value="<?php echo $product['warna']; ?>">

        </div>

        <div class="mb-3">

            <label>Ukuran</label>

            <input
                type="text"
                name="ukuran"
                class="form-control"
                value="<?php echo $product['ukuran']; ?>">

        </div>

        <div class="mb-3">

            <label>Deskripsi</label>

            <textarea
                name="deskripsi"
                class="form-control"
                rows="5"><?php echo $product['deskripsi']; ?></textarea>

        </div>

        <div class="mb-3">

            <label>Gambar Saat Ini</label>

            <br>

            <img
                src="../../uploads/<?php echo $product['gambar']; ?>"
                width="200"
                class="mb-3">

        </div>

        <div class="mb-3">

            <label>Ganti Gambar</label>

            <input
                type="file"
                name="gambar"
                class="form-control">

        </div>

        <button
            type="submit"
            class="btn btn-success">

            Simpan Perubahan

        </button>

        <a
            href="index.php"
            class="btn btn-secondary">

            Kembali

        </a>

    </form>

</div>

</body>
</html>