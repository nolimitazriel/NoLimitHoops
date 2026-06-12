<?php

require 'config/database.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

            session_start();

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: index.php");
            exit;

        } else {

            $message = "Password salah.";
        }

    } else {

        $message = "Username tidak ditemukan.";
    }
}

require 'includes/header.php';

?>

<h1>Login Customer</h1>

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

        <label>Password</label>

        <input
            type="password"
            name="password"
            class="form-control"
            required>

    </div>

    <button
        type="submit"
        class="btn btn-primary">

        Login

    </button>

</form>

<?php require 'includes/footer.php'; ?>