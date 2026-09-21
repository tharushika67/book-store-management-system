<?php
include("includes/user_auth.php");
include("includes/db.php");

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM orders
        WHERE user_id = '$user_id'
        ORDER BY created_at DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>My Orders</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <link rel="stylesheet" href="css/style.css">
    </head>

    <body class="bg-light d-flex flex-column min-vh-100">

    <?php include("includes/header.php"); ?>

    <main class="flex-grow-1">

    <div class="container mt-5">

        <h2 class="text-center fw-bold mb-4">
            My Orders
        </h2>

        <?php if(mysqli_num_rows($result) > 0){ ?>

        <div class="table-responsive">
    
            <table class="table table-bordered table-striped align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Total Amount</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                <?php while($order = mysqli_fetch_assoc($result)){ ?>
            
                    <tr>

                        <td>#<?php echo $order['id']; ?></td>

                        <td>
                            $<?php echo number_format($order['total_amount'],2); ?>
                        </td>

                        <td>
                            <?php echo $order['created_at']; ?>
                        </td>

                        <td>

                        <?php

                        $status = $order['status'];

                        if($status == "Pending"){
                            echo "<span class='badge bg-warning text-dark'>Pending</span>";
                        }
                        elseif($status == "Processing"){
                            echo "<span class='badge bg-primary'>Processing</span>";
                        }
                        else{
                            echo "<span class='badge bg-success'>Completed</span>";
                        }

                        ?>
                        
                        </td>

                        <td>
                            <a href="order_details.php?id=<?php echo $order['id']; ?>"
                                class="btn btn-primary btn-sm w-100">
                                View Details
                            </a>
                        </td>

                    </tr>
                
                <?php } ?>

                </tbody>

            </table>

        </div>

        <div class="text-end mt-3">

            <a href="books.php" class="btn btn-dark">
                Continue Shopping
            </a>

        </div>
        
        <?php } else { ?>
    
            <div class="alert alert-info text-center">

                <h5 class="mb-3">
                    You haven't placed any orders yet.
                </h5>

            <p>
                Browse our collection and place your first order.
            </p>
                
                <a href="books.php" class="btn btn-primary mt-3">
                    Browse Books
                </a>
                
            </div>
        
        <?php } ?>

    </div>

    </main>

    <?php include("includes/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>