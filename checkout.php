<?php

session_start();

require 'config/database.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$cart_query = "
SELECT
    cart.*,
    cart.product_id,
    products.harga,
    products.stok
FROM cart
JOIN products
ON cart.product_id = products.id
WHERE cart.user_id = $user_id
";

$cart_result = mysqli_query($conn, $cart_query);

if (mysqli_num_rows($cart_result) == 0) {

    die("Keranjang kosong.");
}

$total = 0;

while ($item = mysqli_fetch_assoc($cart_result)) {

    if ($item['quantity'] > $item['stok']) {

        die(
            "Stok produk tidak mencukupi."
        );
    }

    $total +=
        $item['harga'] *
        $item['quantity'];
}

mysqli_query(
    $conn,
    "INSERT INTO orders
    (user_id, total_harga)
    VALUES
    ($user_id, $total)"
);

$order_id = mysqli_insert_id($conn);

$cart_result = mysqli_query($conn, $cart_query);

while ($item = mysqli_fetch_assoc($cart_result)) {

    mysqli_query(
        $conn,
        "INSERT INTO order_items
        (
            order_id,
            product_id,
            quantity,
            harga
        )
        VALUES
        (
            $order_id,
            {$item['product_id']},
            {$item['quantity']},
            {$item['harga']}
        )"
    );

    mysqli_query(
        $conn,
        "UPDATE products
         SET stok = stok - {$item['quantity']}
         WHERE id = {$item['product_id']}"
    );
}

mysqli_query(
    $conn,
    "DELETE FROM cart
    WHERE user_id = $user_id"
);

header("Location: orders.php");
exit;