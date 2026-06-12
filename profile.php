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

require 'includes/header.php';

?>

<h1>Profil Saya</h1>

<div class="card">

    <div class="card-body">

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

        <a
            href="edit_profile.php"
            class="btn btn-primary">

            Edit Profil

        </a>

    </div>

</div>

<?php require 'includes/footer.php'; ?>