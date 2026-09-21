<?php
include("../includes/admin_auth.php");
include("../includes/db.php");

$id = $_GET['id'];

// Delete book
$sql = "DELETE FROM books WHERE id=$id";

if(mysqli_query($conn, $sql)){
    echo "<script>
        alert('Book Deleted!');
        window.location='view_books.php';
    </script>";
}
?>