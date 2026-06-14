</div>

<footer class="bg-dark text-white mt-5">

    <div class="container py-4">

        <div class="row">

            <div class="col-md-4">

                <h4>
                    🏀 No Limit Hoops
                </h4>

                <p>
                    Toko sepatu basket original
                    untuk pemain yang ingin
                    melampaui batas mereka.
                </p>

            </div>

            <div class="col-md-4">

                <h5>
                    Menu
                </h5>

                <ul class="list-unstyled">

                    <li>
                        <a
                            href="/NoLimitHoops/index.php"
                            class="text-white text-decoration-none">

                            Home

                        </a>
                    </li>

                    <?php if (
                        isset($_SESSION['role']) &&
                        $_SESSION['role'] == 'customer'
                    ) : ?>

                    <li>
                        <a
                            href="/NoLimitHoops/cart.php"
                            class="text-white text-decoration-none">

                            Keranjang

                        </a>
                    </li>

                    <li>
                        <a
                            href="/NoLimitHoops/orders.php"
                            class="text-white text-decoration-none">

                            Pesanan Saya

                        </a>
                    </li>

                    <?php endif; ?>

                </ul>

            </div>

            <div class="col-md-4">

                <h5>
                    Kontak
                </h5>

                <p>
                    📧 nolimithoops@email.com
                </p>

                <p>
                    📱 +62 812 3456 7890
                </p>

                <p>
                    📍 Indonesia
                </p>

            </div>

        </div>

        <hr>

        <div class="text-center">

            © <?php echo date("Y"); ?>
            No Limit Hoops.

            Step Beyond Limits 🏀

        </div>

    </div>

</footer>

</body>
</html>