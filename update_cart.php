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

$action = $_GET['action'];

$user_id = $_SESSION['user_id'];

if ($action == 'increase') {

    mysqli_query(
        $conn,
        "UPDATE cart
         SET quantity = quantity + 1
         WHERE id = $cart_id
         AND user_id = $user_id"
    );
}

if ($action == 'decrease') {

    $result = mysqli_query(
        $conn,
        "SELECT quantity
         FROM cart
         WHERE id = $cart_id
         AND user_id = $user_id"
    );

    $item = mysqli_fetch_assoc($result);

    if ($item['quantity'] > 1) {

        mysqli_query(
            $conn,
            "UPDATE cart
             SET quantity = quantity - 1
             WHERE id = $cart_id
             AND user_id = $user_id"
        );

    } else {

        mysqli_query(
            $conn,
            "DELETE FROM cart
             WHERE id = $cart_id
             AND user_id = $user_id"
        );
    }
}

header("Location: cart.php");
exit;