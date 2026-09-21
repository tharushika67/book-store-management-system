<?php
include("includes/user_auth.php");
include("includes/db.php");

if(!isset($_GET['id'])){
    header("Location: my_orders.php");
    exit();
}

$order_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

// Get books
$sql = "SELECT order_items.*, books.title 
        FROM order_items 
        INNER JOIN books 
            ON order_items.book_id = books.id 
        INNER JOIN orders 
            ON order_items.order_id = orders.id 
        WHERE order_items.order_id = '$order_id' 
        AND orders.user_id = '$user_id'";

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0) {
    echo "<script>
        alert('Order not found!');
        window.location='my_orders.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Order Details</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <link rel="stylesheet" href="css/style.css">
    </head>

    <body class="bg-light">

    <?php include("includes/header.php"); ?>

        <div class="container mt-5">

            <h2 class="mb-4">
                Order #<?php echo $order_id; ?>
            </h2>

            <table class="table table-bordered">

                <thead class="table-dark">
                    <tr>
                        <th>Book Title</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>

                <?php
                $grand_total = 0;

                while($row = mysqli_fetch_assoc($result)){

                    $subtotal = $row['price'] * $row['quantity'];
                    $grand_total += $subtotal;
                ?>

                <tr>

                    <td><?php echo $row['title']; ?></td>

                    <td><?php echo $row['quantity']; ?></td>

                    <td>$<?php echo number_format($row['price'],2); ?></td>

                    <td>$<?php echo number_format($subtotal,2); ?></td>

                </tr>

                <?php } ?>

                <tr>
                    <td colspan="3" class="text-end">
                        <strong>Total</strong>
                    </td>

                    <td>
                        <strong>
                            $<?php echo number_format($grand_total,2); ?>
                        </strong>
                    </td>
                </tr>

                </tbody>

            </table>

            <a href="my_orders.php" class="btn btn-secondary">
                Back to My Orders
            </a>

            <a href="books.php" class="btn btn-dark">
                Continue Shopping
            </a>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
        
    </body>
</html>