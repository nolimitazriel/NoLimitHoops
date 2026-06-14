<?php

session_start();

require 'config/database.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$product_id = (int) $_POST['product_id'];

$rating = (int) $_POST['rating'];

$review = mysqli_real_escape_string(
    $conn,
    $_POST['review']
);

mysqli_query(
    $conn,
    "INSERT INTO reviews
    (
        user_id,
        product_id,
        rating,
        review
    )
    VALUES
    (
        $user_id,
        $product_id,
        $rating,
        '$review'
    )"
);

header(
    "Location: product.php?id=$product_id"
);

exit;