<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<?php

$wishlist_count = 0;
$cart_count = 0;

if (
    isset($_SESSION['user_id']) &&
    $_SESSION['role'] == 'customer'
) {

    require_once __DIR__ . '/../config/database.php';

    $user_id = $_SESSION['user_id'];

    $wishlist_query = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM wishlist
         WHERE user_id = $user_id"
    );

    $wishlist_count =
        mysqli_fetch_assoc(
            $wishlist_query
        )['total'];

    $cart_query = mysqli_query(
        $conn,
        "SELECT COUNT(*) AS total
         FROM cart
         WHERE user_id = $user_id"
    );

    $cart_count =
        mysqli_fetch_assoc(
            $cart_query
        )['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>No Limit Hoops</title>

    <link
    rel="icon"
    type="image/png"
    href="/NoLimitHoops/assets/nolimithoopsv7.png">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="/NoLimitHoops/assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">

    <div class="container">

        <a
            class="navbar-brand d-flex align-items-center"
            href="/NoLimitHoops/index.php">

            <img
                src="/NoLimitHoops/assets/nolimithoopsgold.png"
                width="50"
                height="50"
                class="me-2">

        </a>

        <div>
            <?php if (!isset($_SESSION['user_id'])) : ?>

                <a
                    class="btn btn-outline-light me-2"
                    href="/NoLimitHoops/login.php">
                    Login
                </a>

                <a
                    class="btn btn-warning"
                    href="/NoLimitHoops/register.php">
                    Register
                </a>

            <?php else : ?>

                <?php if (
                    isset($_SESSION['role']) &&
                    $_SESSION['role'] == 'customer'
                ) : ?>

                    <a
                        class="btn btn-success me-2"
                        href="/NoLimitHoops/cart.php">
                        🛒 Keranjang
                        (<?php echo $cart_count; ?>)
                    </a>

                <?php endif; ?>

                <a
                    href="/NoLimitHoops/profile.php"
                    class="btn btn-outline-light me-2">

                    Account

                </a>


                <?php if ($_SESSION['role'] == 'admin') : ?>

                    <a
                        class="btn btn-outline-warning me-2"
                        href="/NoLimitHoops/admin/dashboard.php">
                        Dashboard
                    </a>

                <?php endif; ?>

                <a
                    class="btn btn-danger"
                    href="/NoLimitHoops/logout.php">
                    Logout
                </a>

            <?php endif; ?>

        </div>

    </div>

</nav>

<div class="container mt-4">

