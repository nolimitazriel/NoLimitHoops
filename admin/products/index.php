<?php

session_start();

require __DIR__ . '/../../config/database.php';

if ($_SESSION['role'] != 'admin') {

    header("Location: ../../index.php");
    exit;
}

$result = mysqli_query(
    $conn,
    "SELECT * FROM products
     ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html>
<head>

    <title>Kelola Produk</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>
<body>

<div class="container mt-5">

    <h1>Kelola Produk</h1>

    <a
        href="create.php"
        class="btn btn-success mb-3">

        + Tambah Produk

    </a>

    <table class="table table-bordered">

        <tr>

            <th>ID</th>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Brand</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>

        </tr>

        <?php while($product = mysqli_fetch_assoc($result)) : ?>

        <tr>

            <td>
                <?php echo $product['id']; ?>
            </td>

            <td>

                <img
                    src="../../uploads/<?php echo $product['gambar']; ?>"
                    width="80">

            </td>

            <td>
                <?php echo $product['nama']; ?>
            </td>

            <td>
                <?php echo $product['brand']; ?>
            </td>

            <td>
                Rp <?php echo number_format($product['harga']); ?>
            </td>

            <td>
                <?php echo $product['stok']; ?>
            </td>

            <td>

                <a
                    href="edit.php?id=<?php echo $product['id']; ?>"
                    class="btn btn-warning btn-sm">

                    Edit

                </a>

                <a
                    href="delete.php?id=<?php echo $product['id']; ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Yakin ingin menghapus produk ini?')">

                    Hapus

                </a>

            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>