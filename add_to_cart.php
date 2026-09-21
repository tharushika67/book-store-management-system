<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "Please login to add books to your cart.";
    header("Location: auth/login.php");
    exit();
}

include("includes/db.php");

if(!isset($_GET['id'])){
    header("Location: books.php");
    exit();
}

$id = (int)$_GET['id']; // Add (int) before $_GET to ensure ID is treated as an integer

// Get book from database
$sql = "SELECT * FROM books WHERE id=$id";
$result = mysqli_query($conn, $sql);
$book = mysqli_fetch_assoc($result);

$user_id = $_SESSION['user_id'];

// Check if the book is already in the user's cart
$check = mysqli_query($conn,
    "SELECT * FROM cart
     WHERE user_id='$user_id'
     AND book_id='$id'");

if(mysqli_num_rows($check) > 0){

    // Increase quantity
    mysqli_query($conn,
        "UPDATE cart
         SET quantity = quantity + 1
         WHERE user_id='$user_id'
         AND book_id='$id'");

}
else{

    // Add new item to cart
    mysqli_query($conn,
        "INSERT INTO cart(user_id, book_id, quantity)
         VALUES('$user_id','$id',1)");
}

// Redirect back to customer books page
echo "<script>
alert('Book added to cart!');
window.location.href='books.php';
</script>";
?>