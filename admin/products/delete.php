<?php

session_start();

require __DIR__ . '/../../config/database.php';

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] != 'admin'
) {

    header("Location: ../../index.php");
    exit;
}

$id = (int) $_GET['id'];

mysqli_query(
    $conn,
    "DELETE FROM products
     WHERE id = $id"
);

header("Location: index.php");
exit;