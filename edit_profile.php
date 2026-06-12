<?php

session_start();

require 'config/database.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama_lengkap =
        mysqli_real_escape_string(
            $conn,
            $_POST['nama_lengkap']
        );

    $nomor_hp =
        mysqli_real_escape_string(
            $conn,
            $_POST['nomor_hp']
        );

    $alamat =
        mysqli_real_escape_string(
            $conn,
            $_POST['alamat']
        );

    mysqli_query(
        $conn,
        "UPDATE users
        SET
        nama_lengkap='$nama_lengkap',
        nomor_hp='$nomor_hp',
        alamat='$alamat'
        WHERE id=$user_id"
    );

    header("Location: profile.php");
    exit;
}

$result = mysqli_query(
    $conn,
    "SELECT *
    FROM users
    WHERE id=$user_id"
);

$user = mysqli_fetch_assoc($result);

require 'includes/header.php';

?>

<h1>Edit Profil</h1>

<form method="POST">

    <div class="mb-3">

        <label class="form-label">

            Nama Lengkap

        </label>

        <input
            type="text"
            name="nama_lengkap"
            class="form-control"
            value="<?php echo $user['nama_lengkap']; ?>">

    </div>

    <div class="mb-3">

        <label class="form-label">

            Nomor HP

        </label>

        <input
            type="text"
            name="nomor_hp"
            class="form-control"
            value="<?php echo $user['nomor_hp']; ?>">

    </div>

    <div class="mb-3">

        <label class="form-label">

            Alamat

        </label>

        <textarea
            name="alamat"
            class="form-control"><?php echo $user['alamat']; ?></textarea>

    </div>

    <button
        class="btn btn-success">

        Simpan

    </button>

</form>

<?php require 'includes/footer.php'; ?>