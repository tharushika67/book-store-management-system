<?php
include("includes/user_auth.php");
include("includes/db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cart</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="css/style.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

<?php include("includes/header.php"); ?>

<main class="flex-grow-1">

<div class="container mt-5">

    <h2 class="text-center fw-bold mb-4">
        Shopping Cart
    </h2>

    <?php
    $user_id = $_SESSION['user_id'];
    $total = 0;

    $sql = "SELECT
            cart.book_id,
            cart.quantity,
            books.title,
            books.price,
            books.image
        FROM cart
        INNER JOIN books
        ON cart.book_id = books.id
        WHERE cart.user_id = '$user_id'";

    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
    ?>

    <div class="table-responsive">

        <table class="table table-bordered align-middle text-center">

            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>

            <?php while($item = mysqli_fetch_assoc($result)){

                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>

            <tr>

                <td>
                    <img src="images/book_images/<?php echo $item['image']; ?>"
                        class="img-fluid rounded"
                        style="width:70px; height:100px; object-fit:contain;">
                </td>

                <td><?php echo $item['title']; ?></td>

                <td>$<?php echo number_format($item['price'], 2); ?></td>

                <td>

                    <div class="d-flex justify-content-center align-items-center gap-2">

                        <a href="cart_update.php?action=decrease&id=<?php echo $item['book_id']; ?>"
                        class="btn btn-warning btn-sm px-2">
                            -
                        </a>

                        <span class="fw-bold">
                            <?php echo $item['quantity']; ?>
                        </span>

                        <a href="cart_update.php?action=increase&id=<?php echo $item['book_id']; ?>"
                        class="btn btn-success btn-sm px-2">
                            +
                        </a>

                    </div>

                </td>

                <td>$<?php echo number_format($subtotal, 2); ?></td>

                <td>
                    <a href="cart_update.php?action=remove&id=<?php echo $item['book_id']; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Remove item?')">
                        Remove
                    </a>
                </td>

            </tr>

            <?php } ?>

            <tr class="table-dark">

                <td colspan="4" class="text-end">
                    <strong>Total</strong>
                </td>

                <td>
                    <strong>$<?php echo number_format($total,2); ?></strong>
                </td>

                <td></td>

            </tr>

        </table>

    </div>

    <div class="d-grid gap-2 d-md-flex justify-content-end mt-4">

        <a href="books.php" class="btn btn-dark">
            Continue Shopping
        </a>

        <a href="payment.php" class="btn btn-success">
            Checkout
        </a>

    </div>

    <?php } else { ?>

        <div class="alert alert-warning text-center">

            <h5>Your shopping cart is empty.</h5>

            <p class="mb-3">
                Start exploring our collection and add your favourite books.
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