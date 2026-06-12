<?php

require 'config/database.php';

$brand_query = "
SELECT DISTINCT brand
FROM products
WHERE brand IS NOT NULL
AND brand != ''
ORDER BY brand ASC
";

$brand_result = mysqli_query(
    $conn,
    $brand_query
);

$limit = 9;

$page = isset($_GET['page'])
    ? (int)$_GET['page']
    : 1;

if ($page < 1) {
    $page = 1;
}

$offset = ($page - 1) * $limit;

$search = isset($_GET['search'])
    ? mysqli_real_escape_string($conn, $_GET['search'])
    : '';

$brand = isset($_GET['brand'])
    ? mysqli_real_escape_string($conn, $_GET['brand'])
    : '';

$count_query = "
SELECT COUNT(*) AS total
FROM products
WHERE 1=1
";

if ($search != '') {

    $count_query .= "
    AND (
        nama LIKE '%$search%'
        OR brand LIKE '%$search%'
    )
    ";
}

if ($brand != '') {

    $count_query .= "
    AND brand = '$brand'
    ";
}

$count_result = mysqli_query(
    $conn,
    $count_query
);

$total_products =
    mysqli_fetch_assoc($count_result)['total'];

$total_pages =
    ceil($total_products / $limit);

$sort = isset($_GET['sort'])
    ? $_GET['sort']
    : '';

$query = "
SELECT *
FROM products
WHERE 1=1
";

if ($search != '') {

    $query .= "
    AND (
        nama LIKE '%$search%'
        OR brand LIKE '%$search%'
    )
    ";
}

if ($brand != '') {

    $query .= "
    AND brand = '$brand'
    ";
}

if ($sort == 'low') {

    $query .= "
    ORDER BY harga ASC
    ";
}
elseif ($sort == 'high') {

    $query .= "
    ORDER BY harga DESC
    ";
}
else {

    $query .= "
    ORDER BY id DESC
    ";
}

$query .= "
LIMIT $limit
OFFSET $offset
";

$result = mysqli_query($conn, $query);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'includes/header.php';

?>

<h1 class="mb-4">
    🏀 No Limit Hoops
</h1>

<form method="GET" class="row mb-4">

    <div class="col-md-4">

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Cari produk..."
            value="<?php echo $search; ?>">

    </div>

    <div class="col-md-3">

        <select
    name="brand"
    class="form-control">

    <option value="">
        Semua Brand
    </option>

    <?php while($brand_item = mysqli_fetch_assoc($brand_result)) : ?>

        <option
            value="<?php echo $brand_item['brand']; ?>"
            <?php
            if (
                $brand ==
                $brand_item['brand']
            ) echo 'selected';
            ?>>

            <?php echo $brand_item['brand']; ?>

        </option>

    <?php endwhile; ?>

</select>

    </div>

    <div class="col-md-3">

        <select
            name="sort"
            class="form-control">

            <option value="">
                Urutkan
            </option>

            <option
                value="low"
                <?php if($sort == 'low') echo 'selected'; ?>>
                Harga Termurah
            </option>

            <option
                value="high"
                <?php if($sort == 'high') echo 'selected'; ?>>
                Harga Termahal
            </option>

        </select>

    </div>

    <div class="col-md-2">

        <button
            type="submit"
            class="btn btn-primary w-100">

            Terapkan

        </button>

    </div>

</form>

<a
    href="index.php"
    class="btn btn-secondary mb-4">

    Reset Filter

</a>

<?php if(mysqli_num_rows($result) == 0) : ?>

    <div class="alert alert-warning">

        Produk tidak ditemukan.

    </div>

<?php endif; ?>

<div class="row">
<?php while($product = mysqli_fetch_assoc($result)) : ?>

<div class="col-md-4 mb-4">

    <div class="card h-100 shadow-sm">

        <img
            src="uploads/<?php echo $product['gambar']; ?>"
            class="card-img-top"
            style="
                height:250px;
                object-fit:cover;
            ">

        <div class="card-body">

            <h5 class="card-title">

                <a
                    href="product.php?id=<?php echo $product['id']; ?>"
                    class="text-decoration-none">

                    <?php echo $product['nama']; ?>

                </a>

            </h5>

            <p class="text-muted mb-1">

                <?php echo $product['brand']; ?>

            </p>

            <h5>

                Rp <?php echo number_format($product['harga']); ?>

            </h5>

            <p>

                Stok:
                <?php echo $product['stok']; ?>

            </p>

        </div>

        <div class="card-footer bg-white">

            <a
                href="product.php?id=<?php echo $product['id']; ?>"
                class="btn btn-dark w-100">

                Lihat Detail

            </a>

            <?php if (
                isset($_SESSION['role']) &&
                $_SESSION['role'] == 'admin'
            ) : ?>

                <div class="mt-2">

                    <a
                        href="admin/products/edit.php?id=<?php echo $product['id']; ?>"
                        class="btn btn-warning btn-sm">

                        Edit

                    </a>

                    <a
                        href="admin/products/delete.php?id=<?php echo $product['id']; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin ingin menghapus produk ini?')">

                        Hapus

                    </a>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php endwhile; ?>

</div>

<p class="text-muted">

    Menampilkan
    <?php echo mysqli_num_rows($result); ?>
    produk dari
    <?php echo $total_products; ?>
    produk

</p>

<nav class="mt-4">

    <ul class="pagination justify-content-center">

        <?php for(
            $i = 1;
            $i <= $total_pages;
            $i++
        ) : ?>

            <li class="
                page-item
                <?php
                if($page == $i)
                    echo 'active';
                ?>
            ">

                <a
                    class="page-link"
                    href="?search=<?php echo $search; ?>
                    &brand=<?php echo $brand; ?>
                    &sort=<?php echo $sort; ?>
                    &page=<?php echo $i; ?>">

                    <?php echo $i; ?>

                </a>

            </li>

        <?php endfor; ?>

    </ul>

</nav>

<?php require 'includes/footer.php'; ?>