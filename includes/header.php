<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container">

        <a class="navbar-brand" href="/NoLimitHoops/">
            🏀 No Limit Hoops
        </a>

        <div>

            <a
                class="btn btn-outline-light me-2"
                href="/NoLimitHoops/index.php">
                Home
            </a>

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
                
                <span class="text-light me-3">
                    Halo,
                    <?php echo $_SESSION['username']; ?>
                </span>

                <a
                    href="/NoLimitHoops/profile.php"
                    class="btn btn-outline-light me-2">

                    Profil

                </a>

                <?php if (
                    isset($_SESSION['role']) &&
                    $_SESSION['role'] == 'customer'
                ) : ?>

                    <a
                        class="btn btn-success me-2"
                        href="/NoLimitHoops/cart.php">
                        Keranjang
                    </a>

                <?php endif; ?>

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

                <?php if (
                        isset($_SESSION['user_id']) &&
                        $_SESSION['role'] == 'customer'
                    ) : ?>

                        <a
                            class="btn btn-outline-light me-2"
                            href="/NoLimitHoops/orders.php">
                            Pesanan Saya
                        </a>

                <?php endif; ?>

            <?php endif; ?>

        </div>

    </div>

</nav>

<div class="container mt-4">