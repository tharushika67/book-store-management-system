<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$base = "";

if (
    strpos($_SERVER['PHP_SELF'], "/admin/") !== false ||
    strpos($_SERVER['PHP_SELF'], "/auth/") !== false
) {
    $base = "../";
}
?>

<footer class="bg-dark text-white mt-5">

    <div class="container py-5">

        <!-- About -->
        <div class="text-center mb-5">

            <h3 class="fw-bold">
                Online Book Store
            </h3>

            <p class="text-light mx-auto" style="max-width:700px;">

                Your one-stop destination for discovering, purchasing and enjoying
                books online. We provide quality books, secure shopping,
                fast delivery and excellent customer service.

            </p>

        </div>

        <div class="row text-center text-md-start">

            <!-- Quick Links -->
            <div class="col-md-4 mb-4">

                <h5 class="fw-bold mb-3">
                    Quick Links
                </h5>

                <ul class="list-unstyled">

                    <li class="mb-2">
                        <a href="<?php echo $base; ?>index.php"
                           class="text-white text-decoration-none">
                            Home
                        </a>
                    </li>

                    <li class="mb-2">
                        <a href="<?php echo $base; ?>books.php"
                           class="text-white text-decoration-none">
                            Books
                        </a>
                    </li>

                    <li class="mb-2">

                        <?php if(isset($_SESSION['user_id'])){ ?>

                            <a href="<?php echo $base; ?>cart.php"
                               class="text-white text-decoration-none">
                                Cart
                            </a>

                        <?php } else { ?>

                            <a href="<?php echo $base; ?>auth/login.php"
                               class="text-white text-decoration-none">
                                Cart
                            </a>

                        <?php } ?>

                    </li>

                    <li class="mb-2">

                        <?php if(isset($_SESSION['user_id'])){ ?>

                            <a href="<?php echo $base; ?>my_orders.php"
                               class="text-white text-decoration-none">
                                My Orders
                            </a>

                        <?php } else { ?>

                            <a href="<?php echo $base; ?>auth/login.php"
                               class="text-white text-decoration-none">
                                My Orders
                            </a>

                        <?php } ?>

                    </li>

                </ul>

            </div>

            <!-- Contact -->
            <div class="col-md-4 mb-4">

                <h5 class="fw-bold mb-3">
                    Contact Us
                </h5>

                <p>
                    <i class="bi bi-envelope-fill me-2"></i>
                    info@onlinebookstore.com
                </p>

                <p>
                    <i class="bi bi-telephone-fill me-2"></i>
                    +94 71 234 5678
                </p>

                <p>
                    <i class="bi bi-geo-alt-fill me-2"></i>
                    Colombo, Sri Lanka
                </p>

            </div>

            <!-- Follow Us -->
            <div class="col-md-4 mb-4">

                <h5 class="fw-bold mb-3">
                    Follow Us
                </h5>

                <p>
                    <i class="bi bi-facebook me-2"></i>
                    Facebook
                </p>

                <p>
                    <i class="bi bi-instagram me-2"></i>
                    Instagram
                </p>

                <p>
                    <i class="bi bi-twitter-x me-2"></i></i>
                    Twitter
                </p>

                <p>
                    <i class="bi bi-youtube me-2"></i>
                    YouTube
                </p>

            </div>

        </div>

    </div>

    <div class="border-top border-secondary py-3">

        <div class="container text-center">

            <small class="text-light">

                © <?php echo date("Y"); ?>
                Online Book Store. All Rights Reserved.

            </small>

        </div>

    </div>

</footer>