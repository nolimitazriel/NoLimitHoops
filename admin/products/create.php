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

    $gambar = '';

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

        "INSERT INTO products
        (
            nama,
            brand,
            harga,
            stok,
            warna,
            ukuran,
            deskripsi,
            gambar
        )
        VALUES
        (
            '$nama',
            '$brand',
            $harga,
            $stok,
            '$warna',
            '$ukuran',
            '$deskripsi',
            '$gambar'
        )"
    );

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Tambah Produk</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>
<body>

<div class="container mt-5">

    <h1>Tambah Produk</h1>

    <form
        method="POST"
        enctype="multipart/form-data">

        <div class="mb-3">

            <label>Nama Produk</label>

            <input
                type="text"
                name="nama"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label>Brand</label>

            <input
                type="text"
                name="brand"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label>Harga</label>

            <input
                type="number"
                name="harga"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label>Stok</label>

            <input
                type="number"
                name="stok"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label>Warna</label>

            <input
                type="text"
                name="warna"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Ukuran</label>

            <input
                type="text"
                name="ukuran"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Deskripsi</label>

            <textarea
                name="deskripsi"
                class="form-control"
                rows="5"></textarea>

        </div>

        <div class="mb-3">

            <label>Gambar Produk</label>

            <input
                type="file"
                name="gambar"
                class="form-control"
                required>

        </div>

        <button
            type="submit"
            class="btn btn-success">

            Simpan Produk

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