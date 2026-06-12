<?php

session_start();

require 'config/database.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "
SELECT *
FROM orders
WHERE user_id = $user_id
ORDER BY created_at DESC
";

$result = mysqli_query($conn, $query);

require 'includes/header.php';

?>

<h1>Riwayat Pesanan</h1>

<?php while($order = mysqli_fetch_assoc($result)) : ?>

    <div class="card mb-3">

        <div class="card-body">

            <h5>
                Pesanan #<?php echo $order['id']; ?>
            </h5>

            <p>
                Total:
                Rp <?php echo number_format($order['total_harga']); ?>
            </p>

            <p>
                Status:
                <?php echo ucfirst($order['status']); ?>
            </p>

            <p>

                <a
                    href="order_detail.php?id=<?php echo $order['id']; ?>"
                    class="btn btn-primary">

                    Detail Pesanan

                </a>

            </p>

            <p>
                Tanggal:
                <?php echo $order['created_at']; ?>
            </p>

        </div>

    </div>

<?php endwhile; ?>

<?php require 'includes/footer.php'; ?>