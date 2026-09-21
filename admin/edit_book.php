<?php
include("../includes/admin_auth.php");
include("../includes/db.php");

$id = $_GET['id'];

// Get book data
$sql = "SELECT * FROM books WHERE id=$id";
$result = mysqli_query($conn, $sql);
$book = mysqli_fetch_assoc($result);

// Update book
if(isset($_POST['update_book'])){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    $sql = "UPDATE books SET 
            title='$title',
            author='$author',
            category='$category',
            price='$price'
            WHERE id=$id";

    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Book Updated!'); window.location='view_books.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Edit Book</title>

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

                        <div class="col-md-6 mx-auto">

                            <div class="card p-4 shadow">

                                <h3>Edit Book</h3>

                                <form method="POST">

                                    <input type="text" name="title" value="<?php echo $book['title']; ?>" class="form-control mb-2">

                                    <input type="text" name="author" value="<?php echo $book['author']; ?>" class="form-control mb-2">

                                    <input type="text" name="category" value="<?php echo $book['category']; ?>" class="form-control mb-2">

                                    <input type="number" name="price" value="<?php echo $book['price']; ?>" class="form-control mb-2">

                                    <button name="update_book" class="btn btn-success w-100">
                                        Update Book
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>