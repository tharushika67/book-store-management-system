<?php
include("../includes/admin_auth.php");
include("../includes/db.php");

// Search value
$search = "";
$category = "";

if(isset($_GET['search'])){
    $search = $_GET['search'];
}

// Category value
if(isset($_GET['category'])){
    $category = $_GET['category'];
}

// SQL query
$sql = "SELECT * FROM books WHERE 1";

// Search filter
if($search != ""){
    $search = mysqli_real_escape_string($conn, $search);

    $sql .= " AND (
        title LIKE '%$search%'
        OR author LIKE '%$search%'
        OR category LIKE '%$search%'
    )";
}

// Category filter
if($category != ""){
    $sql .= " AND category='$category'";
}

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View Books</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

<?php include("../includes/header.php"); ?>

<main class="flex-grow-1">

<div class="container-fluid">

    <div class="row">

        <?php include("../includes/admin_sidebar.php"); ?>

        <div class="col-lg-10 col-md-9 p-4">

            <h2 class="text-center mb-5">
                All Books
            </h2>

            <form method="GET" class="row g-3 mb-4">

                <!-- Search -->
                <div class="col-12 col-md-5">

                    <input type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search books..."
                        value="<?php echo $search; ?>">

                </div>

                <!-- Category -->
                <div class="col-12 col-md-4">

                    <select name="category" class="form-control">

                        <option value="">All Categories</option>
                        <option value="Adventure">Adventure</option>
                        <option value="Business">Business</option>
                        <option value="Fantasy">Fantasy</option>
                        <option value="Novel">Novel</option>
                        <option value="Personal Finance">Personal Finance</option>
                        <option value="Programming">Programming</option>
                        <option value="Science Fiction">Science Fiction</option>
                        <option value="Self-Help">Self-Help</option>

                    </select>

                </div>

                <!-- Button -->
                <div class="col-12 col-md-3">

                    <button class="btn btn-primary w-100">
                        Search
                    </button>

                </div>
        
            </form>

            <div class="row">

            <?php

                if(mysqli_num_rows($result) > 0){
        
                while($row = mysqli_fetch_assoc($result)){

            ?>

                <div class="col-6 col-md-6 col-lg-3 mb-4"> <!-- Change book card size: md-2 to md-3 & height:220px to 300px for large size -->

                    <div class="card shadow h-100">

                        <!-- Book Image -->
                        <img src="../images/book_images/<?php echo $row['image']; ?>"
                            class="card-img-top bg-white"
                            style="height:320px; width:100%; object-fit:contain;">

                        <div class="card-body d-flex flex-column">

                            <!-- Book Title -->
                            <h5 class="card-title" style="min-height:60px;">
                                <?php echo $row['title']; ?>
                            </h5>

                            <!-- Author -->
                            <p class="card-text">
                                Author:
                                <?php echo $row['author']; ?>
                            </p>

                            <!-- Category -->
                            <p class="card-text">
                                Category:
                                <?php echo $row['category']; ?>
                            </p>

                            <!-- Price -->
                            <h6 class="text-primary">
                                $<?php echo number_format($row['price'],2); ?>
                            </h6>

                            <!-- Edit Button -->
                            <a href="edit_book.php?id=<?php echo $row['id']; ?>" 
                                class="btn btn-warning btn-sm w-100 mt-auto">
                                Edit
                            </a>

                            <!-- Delete Button -->
                            <a href="delete_book.php?id=<?php echo $row['id']; ?>" 
                                class="btn btn-danger btn-sm w-100 mt-2"
                                onclick="return confirm('Are you sure?')">
                                Delete
                            </a>

                        </div>

                    </div>

                </div>

            <?php }
            }
            else{
            ?>

            <div class="col-12">

                <div class="alert alert-warning text-center">

                    <h5>No books found.</h5>

                </div>

            </div>

            <?php
            }
            ?>

        </div>

    </div>

</div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>