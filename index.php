<?php
session_start();

if (isset($_SESSION['user_id']) && $_SESSION['user_role'] == "admin") {
    header("Location: admin/dashboard.php");
    exit();
}

include("includes/db.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Online Book Store</title>

        <!-- Bootstrap CSS -->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="css/style.css">

    </head>
    <body>

    <?php include("includes/header.php"); ?>

    <!-- Hero Section Start -->
    <section class="hero-section">

        <div class="container text-center">

            <h1 class="display-4 fw-bold">
                Welcome to Online Book Store
            </h1>

            <p class="lead mt-3">
                Discover amazing books anytime and anywhere.
            </p>

            <a href="books.php" class="btn btn-primary btn-lg">
                Browse Books
            </a>

        </div>

    </section>
    <!-- Hero Section End -->

    <!-- Featured Books -->
    <section class="container my-5">

        <h2 class="text-center fw-bold mb-4">
            Featured Books
        </h2>

        <div class="row">

        <?php

        $sql = "SELECT * FROM books 
        ORDER BY RAND() 
        LIMIT 8";
        $result = mysqli_query($conn, $sql);

        while($book = mysqli_fetch_assoc($result)){
        ?>

            <div class="col-6 col-md-3 mb-4">

                <div class="card h-100 shadow">

                    <img src="images/book_images/<?php echo $book['image']; ?>"
                        class="card-img-top bg-white"
                        style="height:320px; width:100%; object-fit:contain;">
                    
                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title" style="min-height:90px;">
                            <?php echo $book['title']; ?>
                        </h5>

                        <p style="min-height:50px;">
                            <strong>Author:</strong>
                            <?php echo $book['author']; ?>
                        </p>

                        <h5 class="text-success fw-bold mb-3">
                            $<?php echo number_format($book['price'],2); ?>
                        </h5>

                        <a href="book_details.php?id=<?php echo $book['id']; ?>" class="btn btn-primary w-100 mt-auto">
                            View Details
                        </a>

                    </div>

                </div>

            </div>

        <?php } ?>

        </div>

    </section>

    <!-- Why Choose Us Start -->
    <section class="py-5 bg-light">

        <div class="container">

            <h2 class="text-center fw-bold mb-5">
                Why Choose Our Book Store?
            </h2>

            <div class="row text-center">

                <div class="col-md-4 mb-4">

                    <i class="bi bi-book fs-1 text-primary"></i>

                    <h4 class="mt-3">Wide Collection</h4>

                    <p>
                        Explore books from various genres for readers of every age.
                    </p>

                </div>

                <div class="col-md-4 mb-4">

                    <i class="bi bi-truck fs-1 text-success"></i>

                    <h4 class="mt-3">Fast Delivery</h4>

                    <p>
                        Get your favorite books delivered quickly and securely.
                    </p>

                </div>

                <div class="col-md-4 mb-4">

                    <i class="bi bi-shield-check fs-1 text-danger"></i>

                    <h4 class="mt-3">Secure Shopping</h4>

                    <p>
                        Shop with confidence using our secure ordering system.
                    </p>

                </div>

            </div>

        </div>

    </section>
    <!-- Why Choose Us End -->

    <!-- New Arrivals Start -->
    <section class="container my-5">

        <h2 class="text-center fw-bold mb-4">
            New Arrivals
        </h2>

        <div class="row">

        <?php

        $newBooks = "SELECT * FROM books
                    ORDER BY created_at DESC
                    LIMIT 8";

        $newResult = mysqli_query($conn, $newBooks);

        while($book = mysqli_fetch_assoc($newResult)){
        ?>

            <div class="col-6 col-md-3 mb-4">

                <div class="card h-100 shadow">

                    <img src="images/book_images/<?php echo $book['image']; ?>"
                        class="card-img-top bg-white"
                        style="height:280px; object-fit:contain;">

                    <div class="card-body d-flex flex-column">

                        <h6 class="card-title">
                            <?php echo $book['title']; ?>
                        </h6>

                        <p class="text-success fw-bold">
                            $<?php echo number_format($book['price'],2); ?>
                        </p>

                        <a href="book_details.php?id=<?php echo $book['id']; ?>"
                        class="btn btn-outline-primary mt-auto">
                            View Details
                        </a>

                    </div>

                </div>

            </div>

        <?php } ?>

        </div>

    </section>
    <!-- New Arrivals End -->

    <!-- Customer Reviews Start -->
    <section class="py-5 bg-light">

        <div class="container">

            <h2 class="text-center fw-bold mb-5">
                What Our Readers Say
            </h2>

            <div class="row">

                <!-- Review 1 -->
                <div class="col-md-4 mb-4">

                    <div class="card h-100 shadow-sm border-0">

                        <div class="card-body text-center">

                            <div class="text-warning fs-5 mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>

                            <p class="fst-italic">
                                "Excellent collection of books and a very easy ordering process. Highly recommended!"
                            </p>

                            <h6 class="fw-bold mt-3 mb-0">
                                Sarah L.
                            </h6>

                        </div>

                    </div>

                </div>

                <!-- Review 2 -->
                <div class="col-md-4 mb-4">

                    <div class="card h-100 shadow-sm border-0">

                        <div class="card-body text-center">

                            <div class="text-warning fs-5 mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>

                            <p class="fst-italic">
                                "Fast delivery, affordable prices, and the books arrived in perfect condition."
                            </p>

                            <h6 class="fw-bold mt-3 mb-0">
                                David M.
                            </h6>

                        </div>

                    </div>

                </div>

                <!-- Review 3 -->
                <div class="col-md-4 mb-4">

                    <div class="card h-100 shadow-sm border-0">

                        <div class="card-body text-center">

                            <div class="text-warning fs-5 mb-3">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>

                            <p class="fst-italic">
                                "My favorite place to buy books online. Great service and secure shopping experience."
                            </p>

                            <h6 class="fw-bold mt-3 mb-0">
                                Emily R.
                            </h6>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>
    <!-- Customer Reviews End -->

    <!-- Our Services Start -->
    <section class="py-5">

        <div class="container">

            <h2 class="text-center fw-bold mb-5">
                Our Services
            </h2>

            <div class="row text-center">

                <!-- Free Delivery -->
                <div class="col-6 col-md-3 mb-4">

                    <i class="bi bi-truck fs-1 text-primary"></i>

                    <h5 class="mt-3">Free Delivery</h5>

                    <p class="small text-muted">
                        Enjoy free delivery on selected book orders.
                    </p>

                </div>

                <!-- Secure Payment -->
                <div class="col-6 col-md-3 mb-4">

                    <i class="bi bi-credit-card-2-front fs-1 text-success"></i>

                    <h5 class="mt-3">Secure Payment</h5>

                    <p class="small text-muted">
                        Safe and secure payment with protected transactions.
                    </p>

                </div>

                <!-- Customer Support -->
                <div class="col-6 col-md-3 mb-4">

                    <i class="bi bi-headset fs-1 text-warning"></i>

                    <h5 class="mt-3">24/7 Support</h5>

                    <p class="small text-muted">
                        Friendly support whenever you need assistance.
                    </p>

                </div>

                <!-- Best Quality -->
                <div class="col-6 col-md-3 mb-4">

                    <i class="bi bi-patch-check fs-1 text-danger"></i>

                    <h5 class="mt-3">Best Quality</h5>

                    <p class="small text-muted">
                        We provide genuine books with excellent quality.
                    </p>

                </div>

            </div>

        </div>

    </section>
    <!-- Our Services End -->

    <?php include("includes/footer.php"); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="js/script.js"></script>

    </body>
</html>