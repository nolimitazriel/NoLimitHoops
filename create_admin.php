<?php

require 'config/database.php';

$username = "admin";
$email = "admin@nolimithoops.com";

$password = password_hash(
    "admin123",
    PASSWORD_DEFAULT
);

$role = "admin";

$query = "INSERT INTO users
(username, email, password, role)
VALUES
('$username', '$email', '$password', '$role')";

mysqli_query($conn, $query);

echo "Admin berhasil dibuat";

?>