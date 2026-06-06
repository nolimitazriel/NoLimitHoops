<?php

require __DIR__ . '/../../config/database.php';
require __DIR__ . '/../../middleware/admin_only.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = $_POST['nama'];
    $brand = $_POST['brand'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $warna = $_POST['warna'];
    $ukuran = $_POST['ukuran'];
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    move_uploaded_file(
        $tmp_name,
        "../../uploads/" . $gambar
    );
    $deskripsi = $_POST['deskripsi'];

    $query = "INSERT INTO products
    (nama, brand, harga, stok, warna, ukuran, gambar, deskripsi)
    VALUES
    ('$nama','$brand','$harga','$stok','$warna','$ukuran','$gambar','$deskripsi')";

    mysqli_query($conn, $query);

    header("Location: ../../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
</head>
<body>

<h1>Tambah Produk</h1>

<form method="POST" enctype="multipart/form-data">

    <p>Nama Produk</p>
    <input type="text" name="nama" required>

    <p>Brand</p>
    <input type="text" name="brand" required>

    <p>Harga</p>
    <input type="number" name="harga" required>

    <p>Stok</p>
    <input type="number" name="stok" required>

    <p>Warna</p>
    <input type="text" name="warna">

    <p>Ukuran</p>
    <input type="text" name="ukuran">

    <p>Nama File Gambar</p>
    <input type="file" name="gambar">

    <p>Deskripsi</p>
    <textarea name="deskripsi"></textarea>

    <br><br>

    <button type="submit">
        Simpan Produk
    </button>

</form>

</body>
</html>