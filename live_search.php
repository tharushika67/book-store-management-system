<?php 
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

include("includes/db.php");

$search = "";

if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn,$_GET['search']);
}

$category = "";

if(isset($_GET['category'])){
    $category = mysqli_real_escape_string($conn,$_GET['category']);
}

$sql = "SELECT * FROM books WHERE 1";

if($search != ""){
    $sql .= " AND (
        title LIKE '%$search%'
        OR author LIKE '%$search%'
        OR category LIKE '%$search%'
    )";
}

if($category != ""){
    $sql .= " AND category='$category'";
}

$sql .= " ORDER BY created_at DESC";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0){

    while($book=mysqli_fetch_assoc($result)){
?>

<div class="col-6 col-md-4 col-lg-3 mb-4">

    <div class="card h-100 shadow">

        <img src="images/book_images/<?php echo $book['image'];?>"
             class="card-img-top bg-white"
             style="height:320px;object-fit:contain;">

        <div class="card-body d-flex flex-column">

            <h5 class="card-title" style="min-height:60px;">
                <?php echo $book['title']; ?>
            </h5>

            <p class="mb-1">
                <strong>Author:</strong>
                <?php echo $book['author']; ?>
            </p>

            <p class="mb-2">
                <span class="badge bg-secondary">
                    <?php echo $book['category']; ?>
                </span>
            </p>

            <h5 class="text-success fw-bold mb-3">
                $<?php echo number_format($book['price'],2); ?>
            </h5>

        </div>

        <div class="card-footer bg-white border-0">

            <a href="book_details.php?id=<?php echo $book['id'];?>"
            class="btn btn-primary w-100">
                View Details
            </a>

        </div>

        <div class="card-footer bg-white border-0">

            <?php if(isset($_SESSION['user_id'])) { ?>

    <a href="add_to_cart.php?id=<?php echo $book['id'];?>" 
       class="btn btn-success w-100">
        Add to Cart
    </a>

<?php } else { ?>

    <a href="auth/login.php" 
       class="btn btn-warning w-100">
        Login to Add to Cart
    </a>

<?php } ?>

        </div>

    </div>

</div>

<?php
    }

}else{

echo '
<div class="col-12">

    <div class="alert alert-warning text-center py-4">

        <i class="bi bi-search fs-1"></i>

        <h5 class="mt-3">
            No books matched your search.
        </h5>

        <p class="mb-0">
            Try another keyword or browse another category.
        </p>

    </div>

</div>';

}
?>