<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

include("includes/db.php");

// Get all categories
$category_sql = "SELECT DISTINCT category FROM books ORDER BY category ASC";
$category_result = mysqli_query($conn, $category_sql);

// Search and Category Filter
$search = "";
$category = "";

$sql = "SELECT * FROM books WHERE 1";

if(isset($_GET['search']) && $_GET['search'] != ""){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql .= " AND (
        title LIKE '%$search%' 
        OR author LIKE '%$search%' 
        OR category LIKE '%$search%'
    )";
}

if(isset($_GET['category']) && $_GET['category'] != ""){
    $category = mysqli_real_escape_string($conn, $_GET['category']);
    $sql .= " AND category='$category'";
}

$sql .= " ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Books</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <link rel="stylesheet" href="css/style.css">

    </head>

    <body class="bg-light d-flex flex-column min-vh-100">

    <?php include("includes/header.php"); ?>

        <main class="flex-grow-1">

        <div class="container mt-5">

            <h2 class="text-center mb-4 display-6 fw-bold">
                Browse Books
            </h2>

            <div class="mb-4">

                <div class="row g-2">

                    <div class="col-12 col-md-10">

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>

                            <input
                                type="text"
                                id="search"
                                name="search"
                                class="form-control"
                                placeholder="Search by title or author..."
                                value="<?php echo htmlspecialchars($search); ?>">

                        </div>

                    </div>

                    <div class="col-12 col-md-2">

                        <a href="books.php" class="btn btn-primary w-100">
                            Clear
                        </a>

                    </div>

                </div>

            </div>

            <div class="mb-4 d-flex flex-wrap gap-2">

                <a href="books.php" class="btn btn-outline-dark btn-sm mb-2">
                    All
                </a>

                <?php while($cat = mysqli_fetch_assoc($category_result)){ ?>

                    <a href="books.php?category=<?php echo urlencode($cat['category']); ?>"
                        class="btn btn-sm mb-2 <?php echo ($category == $cat['category']) ? 'btn-primary' : 'btn-outline-primary'; ?>">

                        <?php echo $cat['category']; ?>

                    </a>

                <?php } ?>

            </div>

            <div class="row" id="bookContainer">

                <?php

                    if(mysqli_num_rows($result) > 0){

                        while($book = mysqli_fetch_assoc($result)){

                ?>

                <div class="col-6 col-md-4 col-lg-3 mb-4">

                    <div class="card h-100 shadow-sm">

                        <img src="images/book_images/<?php echo $book['image']; ?>"
                            class="card-img-top bg-white"
                            style="height:300px; width:100%; object-fit:contain;">

                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title" style="min-height:60px;">
                                <?php echo $book['title']; ?>
                            </h5>

                            <p class="mb-1">
                                <strong>Author:</strong>
                                <?php echo $book['author']; ?>
                            </p>

                            <p class="mb-2">
                                <span class="badge bg-info text-dark">
                                    <?php echo $book['category']; ?>
                                </span>
                            </p>

                            <h5 class="text-success fw-bold mb-3">
                                $<?php echo number_format($book['price'],2); ?>
                            </h5>

                        </div>

                        <div class="card-footer bg-white border-0">

                            <a href="book_details.php?id=<?php echo $book['id']; ?>" class="btn btn-primary w-100 mb-2">
                                View Details
                            </a>

                            <?php if(isset($_SESSION['user_id'])) { ?>

                                <a href="add_to_cart.php?id=<?php echo $book['id']; ?>" class="btn btn-success w-100">
                                    Add to Cart
                                </a>

                            <?php } else { ?>

                                <a href="auth/login.php" class="btn btn-warning w-100">
                                    Login to Add to Cart
                                </a>

                            <?php } ?>

                        </div>

                    </div>

                </div>

                <?php
                }
                }
                else{
                ?>

                <div class="col-12">

                    <div class="alert alert-warning text-center">
                        <i class="bi bi-search fs-1"></i>

                        <h5 class="mt-3">
                            No books matched your search.
                        </h5>

                        <p>
                            Try another keyword or browse another category.
                        </p>
                    </div>

                </div>

                <?php
                }
                ?>

            </div>

        </div>

        </main>

        <?php include("includes/footer.php"); ?>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

        <script>

        const search = document.getElementById("search");

        search.addEventListener("keyup", function () {

            const xhr = new XMLHttpRequest();

            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById("bookContainer").innerHTML = xhr.responseText;
                }
            };

            xhr.open("GET", "live_search.php?search=" + encodeURIComponent(search.value), true);

            xhr.send();

        });

        </script>

    </body>
</html>