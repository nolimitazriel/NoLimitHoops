<?php

require 'config/database.php';

$query = "SELECT * FROM products";

$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>No Limit Hoops</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h1 class="mb-4">
        🏀 No Limit Hoops
    </h1>

    <?php while($product = mysqli_fetch_assoc($result)) : ?>

        <div class="card mb-3">

            <div class="card-body">
                
                <img
                    src="uploads/<?php echo $product['gambar']; ?>"
                    width="200">

                <h3>

                    <a href="product.php?id=<?php echo $product['id']; ?>">
                        <?php echo $product['nama']; ?>
                    </a>

                </h3>

                <p>
                    Brand:
                    <?php echo $product['brand']; ?>
                </p>

                <p>
                    Harga:
                    Rp <?php echo number_format($product['harga']); ?>
                </p>

                <p>
                    Stok:
                    <?php echo $product['stok']; ?>
                </p>

                <p>
                    <a href="admin/products/edit.php?id=<?php echo $product['id']; ?>">
                    Edit
                    </a>

                    <a href="admin/products/delete.php?id=<?php echo $product['id']; ?>"
                    onclick="return confirm('Yakin ingin menghapus produk ini?')">
                    Hapus
                    </a>
                </p>

                

            </div>

        </div>

    <?php endwhile; ?>

</div>

</body>
</html>