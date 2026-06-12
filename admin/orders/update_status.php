<?php

session_start();

require __DIR__ . '/../../config/database.php';

if ($_SESSION['role'] != 'admin') {

    header("Location: ../../index.php");
    exit;
}

$order_id = $_POST['order_id'];

$status = $_POST['status'];

mysqli_query(
    $conn,
    "UPDATE orders
     SET status = '$status'
     WHERE id = $order_id"
);

header("Location: detail.php?id=$order_id");
exit;