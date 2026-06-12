<?php

session_start();

require 'config/database.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$product_id = $_GET['id'];
$quantity = isset($_GET['quantity'])
    ? (int)$_GET['quantity']
    : 1;

$product_query = "
SELECT stok
FROM products
WHERE id = $product_id
";

$product_result =
    mysqli_query($conn, $product_query);

$product =
    mysqli_fetch_assoc($product_result);

if (!$product) {

    die("Produk tidak ditemukan.");
}

if ($quantity > $product['stok']) {

    die("Jumlah melebihi stok yang tersedia.");
}

$check_query = "
SELECT *
FROM cart
WHERE user_id = $user_id
AND product_id = $product_id
";

$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {

    $cart_item =
        mysqli_fetch_assoc($check_result);

    $new_quantity =
        $cart_item['quantity'] + $quantity;

    if (
        $new_quantity >
        $product['stok']
    ) {
       $_SESSION['error'] =
           "Stok tidak mencukupi.";

        header(
            "Location: product.php?id=$product_id"
        );
        exit;
    }

    mysqli_query(
        $conn,
        "UPDATE cart
         SET quantity = $new_quantity
         WHERE user_id = $user_id
         AND product_id = $product_id"
    );

} else {

    mysqli_query(
        $conn,
        "INSERT INTO cart
        (user_id, product_id, quantity)
        VALUES
        ($user_id, $product_id, $quantity)"
    );
}

header("Location: cart.php");
exit;