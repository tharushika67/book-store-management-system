<?php
include("../includes/admin_auth.php");
include("../includes/db.php");

if(isset($_POST['add_book'])){

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);

    // Image Upload
    $image = $_FILES['image']['name'];
    $temp_name = $_FILES['image']['tmp_name'];

    move_uploaded_file($temp_name,"../images/book_images/$image");

    // Insert into database
    $sql = "INSERT INTO books(title, author, category, price, image)
            VALUES('$title','$author','$category','$price','$image')";

    if(mysqli_query($conn, $sql)){
        echo "<script>alert('Book Added Successfully!');</script>";
    }
    else{
        echo "<script>alert('Error Adding Book!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Book</title>

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

            <div class="row justify-content-center">

                <div class="col-md-6">

                    <div class="card shadow p-4">

                        <h2 class="text-center mb-4">
                            Add New Book
                        </h2>

                        <form method="POST" enctype="multipart/form-data">

                            <input type="text" name="title"
                                class="form-control mb-3"
                                placeholder="Book Title" required>

                            <input type="text" name="author"
                                class="form-control mb-3"
                                placeholder="Author Name" required>

                            <input type="text" name="category"
                                class="form-control mb-3"
                                placeholder="Category" required>

                            <input type="number" step="0.01"
                                name="price"
                                class="form-control mb-3"
                                placeholder="Price" required>

                            <input type="file"
                                name="image"
                                class="form-control mb-3"
                                required>

                            <button type="submit"
                                name="add_book"
                                class="btn btn-primary w-100">
                                Add Book
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>