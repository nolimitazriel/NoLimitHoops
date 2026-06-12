<?php

session_start();

require 'config/database.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] != 'customer') {

    header("Location: index.php");
    exit;
}

$cart_id = $_GET['id'];

$user_id = $_SESSION['user_id'];

$query = "
DELETE FROM cart
WHERE id = $cart_id
AND user_id = $user_id
";

mysqli_query($conn, $query);

header("Location: cart.php");
exit;