<?php
include("../includes/admin_auth.php");
include("../includes/db.php");

// Check if form was submitted
if($_SERVER["REQUEST_METHOD"] != "POST"){
    header("Location: manage_orders.php");
    exit();
}

$order_id = $_POST['order_id'];
$status = $_POST['status'];

// Allow only valid statuses
$allowed_statuses = ["Pending", "Processing", "Completed"];

if(!in_array($status, $allowed_statuses)){
    die("Invalid order status.");
}

// Update the order
$sql = "UPDATE orders
        SET status='$status'
        WHERE id='$order_id'";

if(mysqli_query($conn, $sql)){

    echo "<script>
        alert('Order status updated successfully!');
        window.location='manage_orders.php';
    </script>";

}
else{

    echo "<script>
        alert('Failed to update order status.');
        window.location='manage_orders.php';
    </script>";

}
?>