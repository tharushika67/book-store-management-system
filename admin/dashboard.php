<?php
include("../includes/admin_auth.php");
include("../includes/db.php");

// Total Users
$user_query = "SELECT COUNT(*) as total_users FROM users";
$user_result = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_result);

// Total Books
$book_query = "SELECT COUNT(*) as total_books FROM books";
$book_result = mysqli_query($conn, $book_query);
$book_data = mysqli_fetch_assoc($book_result);

// Total Orders
$order_query = "SELECT COUNT(*) as total_orders FROM orders";
$order_result = mysqli_query($conn, $order_query);
$order_data = mysqli_fetch_assoc($order_result);

// Total Revenue
$revenue_query = "SELECT SUM(total_amount) as total_revenue FROM orders";
$revenue_result = mysqli_query($conn, $revenue_query);
$revenue_data = mysqli_fetch_assoc($revenue_result);

// Recent Orders
$recent_orders = "SELECT orders.*, users.name
                  FROM orders
                  INNER JOIN users
                  ON orders.user_id = users.id
                  ORDER BY orders.created_at DESC
                  LIMIT 5";

$recent_orders_result = mysqli_query($conn, $recent_orders);

// Recently Added Books
$recent_books = "SELECT *
                 FROM books
                 ORDER BY created_at DESC
                 LIMIT 5";

$recent_books_result = mysqli_query($conn, $recent_books);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Admin Dashboard</title>

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

                        <h1 class="text-center mb-5">
                            Admin Dashboard
                        </h1>

                        <p class="text-center text-muted mb-5">

                        Welcome,
                        <strong><?php echo $_SESSION['user_name']; ?></strong>!

                        Manage books, customer orders and monitor system statistics from here.

                        </p>

                        <div class="row">
                            
                            <!-- Users -->
                            <div class="col-md-3 mb-4">

                                <div class="card text-white bg-primary shadow">

                                    <div class="card-body text-center">

                                        <h3>
                                            <?php echo $user_data['total_users']; ?>
                                        </h3>

                                        <p>Total Users</p>

                                    </div>

                                </div>

                            </div>

                            <!-- Books -->
                            <div class="col-md-3 mb-4">

                                <div class="card text-white bg-success shadow">

                                    <div class="card-body text-center">

                                        <h3>
                                            <?php echo $book_data['total_books']; ?>
                                        </h3>

                                        <p>Total Books</p>

                                    </div>

                                </div>

                            </div>

                            <!-- Orders -->
                            <div class="col-md-3 mb-4">

                                <div class="card text-white bg-warning shadow">

                                    <div class="card-body text-center">

                                        <h3>
                                            <?php echo $order_data['total_orders']; ?>
                                        </h3>

                                        <p>Total Orders</p>

                                    </div>

                                </div>

                            </div>

                            <!-- Revenue -->
                            <div class="col-md-3 mb-4">

                                <div class="card text-white bg-danger shadow">

                                    <div class="card-body text-center">

                                        <h3>
                                            $<?php echo number_format($revenue_data['total_revenue'] ?? 0, 2); ?>
                                        </h3>

                                        <p>Total Revenue</p>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <hr class="my-5">

                        <div class="row">

                            <!-- Recent Orders -->
                            <div class="col-lg-6 mb-4">

                                <div class="card shadow h-100">

                                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

                                        <h5 class="mb-0">
                                            Recent Orders
                                        </h5>

                                        <a href="manage_orders.php"
                                        class="btn btn-sm btn-light">
                                            View All
                                        </a>

                                    </div>

                                    <div class="table-responsive">

                                        <table class="table table-hover align-middle mb-0">

                                            <thead>

                                                <tr>

                                                    <th>ID</th>
                                                    <th>Customer</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                            <?php while($order = mysqli_fetch_assoc($recent_orders_result)){ ?>

                                                <tr>

                                                    <td>#<?php echo $order['id']; ?></td>

                                                    <td><?php echo $order['name']; ?></td>

                                                    <td>
                                                        $<?php echo number_format($order['total_amount'],2); ?>
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

                                                </tr>

                                            <?php } ?>

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                            <!-- Recently Added Books -->
                            <div class="col-lg-6 mb-4">

                                <div class="card shadow h-100">

                                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

                                        <h5 class="mb-0">
                                            Recently Added Books
                                        </h5>

                                        <a href="view_books.php"
                                        class="btn btn-sm btn-light">
                                            Manage
                                        </a>

                                    </div>

                                    <div class="table-responsive">

                                        <table class="table table-hover align-middle mb-0">

                                            <thead>

                                                <tr>

                                                    <th>Cover</th>
                                                    <th>Book</th>
                                                    <th>Price</th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                            <?php while($book = mysqli_fetch_assoc($recent_books_result)){ ?>

                                                <tr>

                                                    <td>

                                                        <img src="../images/book_images/<?php echo $book['image']; ?>"

                                                            style="width:45px;
                                                                    height:60px;
                                                                    object-fit:contain;">

                                                    </td>

                                                    <td>

                                                        <?php echo $book['title']; ?>

                                                    </td>

                                                    <td>

                                                        $<?php echo number_format($book['price'],2); ?>

                                                    </td>

                                                </tr>

                                            <?php } ?>

                                            </tbody>

                                        </table>

                                    </div>

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