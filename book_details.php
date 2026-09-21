<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

include("includes/db.php");

// Check if book ID exists
if(!isset($_GET['id'])){
    header("Location: books.php");
    exit();
}

$id = (int)$_GET['id'];

// Get book details
$sql = "SELECT * FROM books WHERE id=$id";
$result = mysqli_query($conn, $sql);

// If book doesn't exist
if(mysqli_num_rows($result) == 0){
    header("Location: books.php");
    exit();
}

$book = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo $book['title']; ?></title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <link rel="stylesheet" href="css/style.css">
    </head>

    <body class="bg-light d-flex flex-column min-vh-100">

    <?php include("includes/header.php"); ?>

    <main class="flex-grow-1">

    <div class="container mt-5">
        
        <div class="row">

            <!-- Book Image -->
            <div class="col-12 col-md-4 mb-4">

                <img src="images/book_images/<?php echo $book['image']; ?>"
                    class="img-fluid rounded shadow d-block mx-auto"
                    style="max-height:500px; object-fit:contain;">
                
            </div>

            <!-- Book Details -->
            <div class="col-12 col-md-8">

                <h2 class="fw-bold mb-3">
                    <?php echo $book['title']; ?>
                </h2>

                <hr>

                <p>
                    <i class="bi bi-person-fill"></i>
                    <strong>Author :</strong>
                    <?php echo $book['author']; ?>
                </p>

                <p>
                    <i class="bi bi-bookmark-fill"></i>
                    <strong>Category :</strong>
                    <?php echo $book['category']; ?>
                </p>

                <p class="text-success fs-4 fw-bold">
                    $<?php echo number_format($book['price'],2); ?>
                </p>

                <h5>
                    Description
                </h5>

                <p>
                    <?php echo $book['description']; ?>
                </p>

                <hr>
                
                <div class="d-grid gap-2 d-md-flex mt-4">

                    <?php if(isset($_SESSION['user_id'])) { ?>

                        <a href="add_to_cart.php?id=<?php echo $book['id']; ?>" 
                            class="btn btn-success flex-fill">
                            <i class="bi bi-cart-plus"></i>
                            Add to Cart
                        </a>

                        <?php } else { ?>

                        <a href="auth/login.php" 
                            class="btn btn-warning flex-fill">
                            <i class="bi bi-box-arrow-in-right"></i>
                            Login to Add to Cart
                        </a>

                    <?php } ?>

                        <a href="books.php" 
                            class="btn btn-dark flex-fill">
                            <i class="bi bi-arrow-left"></i>
                            Back to Books
                        </a>

                </div>

            </div>

        </div>

    </div>

    </main>

    <?php include("includes/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>