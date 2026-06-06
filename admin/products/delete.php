<?php

require __DIR__ . '/../../config/database.php';
require __DIR__ . '/../../middleware/admin_only.php';

$id = $_GET['id'];

$query = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $query);

$product = mysqli_fetch_assoc($result);

if ($product) {

    $gambar = $product['gambar'];

    if (!empty($gambar) && file_exists("uploads/" . $gambar)) {

        unlink("uploads/" . $gambar);
    }

    $query = "DELETE FROM products WHERE id = $id";

    mysqli_query($conn, $query);
}

header("Location: ../../index.php");
exit;