<?php

require 'config/database.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $nama_lengkap = trim($_POST['nama_lengkap']);
    $nomor_hp = trim($_POST['nomor_hp']);
    $alamat = trim($_POST['alamat']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {

        $message = "Password dan konfirmasi password tidak sama.";

    } else {

        $check_query = "SELECT * FROM users
                        WHERE username='$username'
                        OR email='$email'";

        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {

            $message = "Username atau email sudah digunakan.";

        } else {

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

           $query = "INSERT INTO users
            (
                username,
                nama_lengkap,
                email,
                password,
                nomor_hp,
                alamat,
                role
            )
            VALUES
            (
                '$username',
                '$nama_lengkap',
                '$email',
                '$hashed_password',
                '$nomor_hp',
                '$alamat',
                'customer'
            )";

            mysqli_query($conn, $query);

            header("Location: login.php");
            exit;
        }
    }
}

require 'includes/header.php';

?>

<h1>Register Customer</h1>

<?php if ($message != "") : ?>

    <div class="alert alert-danger">
        <?php echo $message; ?>
    </div>

<?php endif; ?>

<form method="POST">

    <div class="mb-3">

        <label>Username</label>

        <input
            type="text"
            name="username"
            class="form-control"
            required>

    </div>

    <div class="mb-3">

    <label>Nama Lengkap</label>

    <input
        type="text"
        name="nama_lengkap"
        class="form-control"
        required>

    </div>

    <div class="mb-3">

    <label>Nomor HP</label>

    <input
        type="text"
        name="nomor_hp"
        class="form-control"
        required>

    </div>

    <div class="mb-3">

    <label>Alamat</label>

    <textarea
        name="alamat"
        class="form-control"
        rows="3"
        required></textarea>

    </div>

    <div class="mb-3">

        <label>Email</label>

        <input
            type="email"
            name="email"
            class="form-control"
            required>

    </div>

    <div class="mb-3">

        <label>Password</label>

        <input
            type="password"
            name="password"
            class="form-control"
            required>

    </div>

    <div class="mb-3">

        <label>Konfirmasi Password</label>

        <input
            type="password"
            name="confirm_password"
            class="form-control"
            required>

    </div>

    <button
        type="submit"
        class="btn btn-primary">

        Daftar

    </button>

</form>

<?php require 'includes/footer.php'; ?>