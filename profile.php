<?php

session_start();

require 'config/database.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "
SELECT *
FROM users
WHERE id = $user_id
";

$result = mysqli_query(
    $conn,
    $query
);

$user = mysqli_fetch_assoc($result);

$order_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM orders
     WHERE user_id = $user_id"
);

$total_orders =
    mysqli_fetch_assoc($order_result)['total'];

$wishlist_result = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM wishlist
     WHERE user_id = $user_id"
);

$total_wishlist =
    mysqli_fetch_assoc($wishlist_result)['total'];

require 'includes/header.php';

?>

<h1 class="mb-4">
    👤 Akun Saya
</h1>

<div class="row">

<div class="col-md-4 mb-3">

    <div class="card text-center">

        <div class="card-body">

            <h5>
                📦 Pesanan
            </h5>

            <h2>
                <?php echo $total_orders; ?>
            </h2>

        </div>

    </div>

</div>

<div class="col-md-4 mb-3">

    <div class="card text-center">

        <div class="card-body">

            <h5>
                ❤️ Wishlist
            </h5>

            <h2>
                <?php echo $total_wishlist; ?>
            </h2>

        </div>

    </div>

</div>

<div class="col-md-4 mb-3">

    <div class="card text-center">

        <div class="card-body">

            <h5>
                👋 Selamat Datang
            </h5>

            <h6>
                <?php echo $user['nama_lengkap']; ?>
            </h6>

        </div>

    </div>

</div>

</div>

<div class="card mb-4">

<div class="card-body">

    <h4>
        Informasi Akun
    </h4>

    <hr>

    <p>

        <strong>Username:</strong>
        <?php echo $user['username']; ?>

    </p>

    <p>

        <strong>Nama Lengkap:</strong>
        <?php echo $user['nama_lengkap']; ?>

    </p>

    <p>

        <strong>Email:</strong>
        <?php echo $user['email']; ?>

    </p>

    <p>

        <strong>Nomor HP:</strong>
        <?php echo $user['nomor_hp']; ?>

    </p>

    <p>

        <strong>Alamat:</strong>
        <?php echo nl2br($user['alamat']); ?>

    </p>

</div>

</div>

<div class="card">

<div class="card-body">

    <h4>
        Menu Akun
    </h4>

    <hr>

    <a
        href="edit_profile.php"
        class="btn btn-primary me-2 mb-2">

        ✏️ Edit Profil

    </a>

    <a
        href="orders.php"
        class="btn btn-success me-2 mb-2">

        📦 Riwayat Pembelian

    </a>

    <a
        href="wishlist.php"
        class="btn btn-danger me-2 mb-2">

        ❤️ Wishlist

    </a>

</div>

</div>

<?php require 'includes/footer.php'; ?>
