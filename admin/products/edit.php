<?php

require __DIR__ . '/../../config/database.php';
require __DIR__ . '/../../middleware/admin_only.php';
$id = $_GET['id'];

$query = "SELECT * FROM products WHERE id=$id";
$result = mysqli_query($conn, $query);

$product = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = $_POST['nama'];
    $brand = $_POST['brand'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $warna = $_POST['warna'];
    $ukuran = $_POST['ukuran'];
    $gambar = $product['gambar'];
    if ($_FILES['gambar']['name'] != "") {
        $gambar = $_FILES['gambar']['name'];
        $tmp_name = $_FILES['gambar']['tmp_name'];
        move_uploaded_file(
            $tmp_name,
                "../../uploads/" . $gambar
        );
    }
    $deskripsi = $_POST['deskripsi'];

    $query = "UPDATE products SET
        nama='$nama',
        brand='$brand',
        harga='$harga',
        stok='$stok',
        warna='$warna',
        ukuran='$ukuran',
        gambar='$gambar',
        deskripsi='$deskripsi'
        WHERE id=$id";

    mysqli_query($conn, $query);

    header("Location: ../../index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
</head>
<body>

<h1>Edit Produk</h1>

<form method="POST" enctype="multipart/form-data">

    <p>Nama Produk</p>
    <input
        type="text"
        name="nama"
        value="<?php echo $product['nama']; ?>"
        required>

    <p>Brand</p>
    <input
        type="text"
        name="brand"
        value="<?php echo $product['brand']; ?>"
        required>

    <p>Harga</p>
    <input
        type="number"
        name="harga"
        value="<?php echo $product['harga']; ?>"
        required>

    <p>Stok</p>
    <input
        type="number"
        name="stok"
        value="<?php echo $product['stok']; ?>"
        required>

    <p>Warna</p>
    <input
        type="text"
        name="warna"
        value="<?php echo $product['warna']; ?>">

    <p>Ukuran</p>
    <input
        type="text"
        name="ukuran"
        value="<?php echo $product['ukuran']; ?>">

    <p>Gambar Saat Ini</p>
    <img
        src="../../uploads/<?php echo $product['gambar']; ?>"
        width="150">

    <p>Ganti Gambar (Opsional)</p>
    <input
        type="file"
        name="gambar">

    <p>Deskripsi</p>
    <textarea name="deskripsi"><?php echo $product['deskripsi']; ?></textarea>

    <br><br>

    <button type="submit">
        Update Produk
    </button>

</form>

</body>
</html>