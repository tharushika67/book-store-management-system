<?php
include("../includes/admin_auth.php");
include("../includes/db.php");

if(!isset($_GET['id'])){
    header("Location: manage_orders.php");
    exit();
}

$order_id = $_GET['id'];

// Get order information
$order_sql = "SELECT orders.*, users.name
              FROM orders
              INNER JOIN users
              ON orders.user_id = users.id
              WHERE orders.id='$order_id'";

$order_result = mysqli_query($conn, $order_sql);
$order = mysqli_fetch_assoc($order_result);

if(!$order){
    die("Order not found.");
}

// Get ordered books
$item_sql = "SELECT order_items.*, books.title
             FROM order_items
             INNER JOIN books
             ON order_items.book_id = books.id
             WHERE order_items.order_id='$order_id'";

$item_result = mysqli_query($conn, $item_sql);
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Order Details</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <link rel="stylesheet" href="../css/style.css">
    </head>
    
    <body class="bg-light">

    <?php include("../includes/header.php"); ?>

        <div class="container mt-5">

            <h2 class="mb-4">

                Order #<?php echo $order_id; ?>

            </h2>

            <div class="card mb-4">

                <div class="card-body">

                    <p><strong>Customer:</strong> <?php echo $order['name']; ?></p>

                    <p><strong>Total:</strong> $<?php echo number_format($order['total_amount'],2); ?></p>

                    <p><strong>Date:</strong> <?php echo $order['created_at']; ?></p>

                    <p><strong>Status:</strong> <?php echo $order['status']; ?></p>

                </div>

            </div>

            <table class="table table-bordered">

                <thead class="table-dark">

                    <tr>

                        <th>Book</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>

                    </tr>

                </thead>

                <tbody>

                    <?php

                    $total = 0;

                    while($item = mysqli_fetch_assoc($item_result)){
                        
                        $subtotal = $item['price'] * $item['quantity'];

                        $total += $subtotal;

                    ?>

                    <tr>

                        <td><?php echo $item['title']; ?></td>

                        <td>$<?php echo number_format($item['price'],2); ?></td>

                        <td><?php echo $item['quantity']; ?></td>

                        <td>$<?php echo number_format($subtotal,2); ?></td>

                    </tr>

                    <?php } ?>

                    <tr>

                        <td colspan="3" class="text-end">

                            <strong>Grand Total</strong>

                        </td>

                        <td>

                            <strong>$<?php echo number_format($total,2); ?></strong>

                        </td>

                    </tr>

                </tbody>

            </table>

            <hr>

            <h4>Update Order Status</h4>

            <form action="update_order_status.php" method="POST">

                <input type="hidden"
                        name="order_id"
                        value="<?php echo $order_id; ?>">

                <select name="status" class="form-select mb-3">
                    
                    <option value="Pending"
                        <?php if($order['status']=="Pending") echo "selected"; ?>>
                        Pending
                    </option>

                    <option value="Processing"
                        <?php if($order['status']=="Processing") echo "selected"; ?>>
                        Processing
                    </option>

                    <option value="Completed"
                        <?php if($order['status']=="Completed") echo "selected"; ?>>
                        Completed
                    </option>

                </select>

                <button class="btn btn-success">
                    Update Status
                </button>

                <a href="manage_orders.php" class="btn btn-secondary">
                    Back
                </a>
                
            </form>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>