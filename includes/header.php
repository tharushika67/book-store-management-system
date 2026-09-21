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

<!-- Navbar Start -->
     <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_role'] == "admin"){ ?>

                <a class="navbar-brand fw-bold" href="<?php echo $base; ?>admin/dashboard.php">
                    Book Store
                </a>

            <?php } else { ?>

                <a class="navbar-brand fw-bold" href="<?php echo $base; ?>index.php">
                    Book Store
                </a>

            <?php } ?>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav ms-auto">

                    <!-- Home -->
                    <?php if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != "admin"){ ?>

                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $base; ?>index.php">
                            Home
                        </a>
                    </li>

                    <?php } ?>

                    <!-- Books -->
                    <?php if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != "admin"){ ?>

                        <!-- Guest & Customer -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base; ?>books.php">
                                Books
                            </a>
                        </li>

                    <?php } ?>

                    <?php if(isset($_SESSION['user_id'])) { ?>

                        <!-- Admin Navigation -->
                        <?php if($_SESSION['user_role'] == "admin") { ?>

                        <?php } else { ?>

                            <!-- Customer Navigation -->

                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $base; ?>cart.php">
                                    Cart
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $base; ?>my_orders.php">
                                    My Orders
                                </a>
                            </li>

                        <?php } ?>

                        <?php if($_SESSION['user_role'] != "admin"){ ?>

                            <!-- Logout -->
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $base; ?>auth/logout.php">
                                    Logout
                                </a>
                            </li>

                        <?php } ?>

                    <?php } else { ?>

                        <!-- Guest Navigation -->

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base; ?>auth/login.php">
                                Login
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base; ?>auth/register.php">
                                Register
                            </a>
                        </li>

                    <?php } ?>

                </ul>

            </div>

        </div>
     </nav>
     <!-- Navbar End -->