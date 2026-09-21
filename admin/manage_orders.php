<?php
include("../includes/admin_auth.php");
include("../includes/db.php");

// Get all orders with customer name
$sql = "SELECT orders.*, users.name
        FROM orders
        INNER JOIN users
        ON orders.user_id = users.id
        ORDER BY orders.created_at DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Manage Orders</title>

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

            <div class="col-lg-10 col-md-9 col-12 p-4">

            <h2 class="text-center mb-4">
                Manage Orders
            </h2>

            <?php if(mysqli_num_rows($result) > 0){ ?>

            <div class="table-responsive">

            <table class="table table-bordered table-striped align-middle text-center">

                <thead class="table-dark">

                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
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

                        <td><?php echo $order['name']; ?></td>

                        <td>$<?php echo number_format($order['total_amount'],2); ?></td>

                        <td class="small">
                            <?php echo $order['created_at']; ?>
                        </td>

                        <td>

                            <?php

                                if($order['status']=="Pending"){
                                    echo "<span class='badge bg-warning text-dark'>Pending</span>";
                                }
                                elseif($order['status']=="Processing"){
                                    echo "<span class='badge bg-primary'>Processing</span>";
                                }
                                else{
                                    echo "<span class='badge bg-success'>Completed</span>";
                                }

                            ?>

                        </td>

                        <td>

                            <a href="order_details.php?id=<?php echo $order['id']; ?>"
                               class="btn btn-info btn-sm w-100">
                                View
                            </a>

                        </td>

                    </tr>

                    <?php } ?>

                </tbody>

            </table>

            </div>

            <?php } else { ?>

                <div class="alert alert-info text-center">
                    No orders found.
                </div>

            <?php } ?>

        </div>

    </div>

    </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>