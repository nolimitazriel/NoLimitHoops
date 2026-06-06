<?php

session_start();
require '../config/database.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit;
        }
    }

    $error = "Username atau password salah";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
</head>
<body>

<h1>Login Admin</h1>

<?php if($error): ?>
    <p style="color:red;">
        <?php echo $error; ?>
    </p>
<?php endif; ?>

<form method="POST">

    <p>Username</p>
    <input type="text" name="username" required>

    <p>Password</p>
    <input type="password" name="password" required>

    <br><br>

    <button type="submit">
        Login
    </button>

</form>

</body>
</html>