<?php
include("includes/user_auth.php");
include("includes/db.php");

$user_id = $_SESSION['user_id'];

$cart_items = mysqli_query($conn,
    "SELECT cart.quantity,
            books.price
     FROM cart
     INNER JOIN books
     ON cart.book_id = books.id
     WHERE cart.user_id='$user_id'");

if(mysqli_num_rows($cart_items) == 0){
    echo "<script>
        alert('Your cart is empty!');
        window.location='cart.php';
    </script>";
    exit();
}

$total = 0;
$itemCount = 0;

while($item = mysqli_fetch_assoc($cart_items)){

    $total += $item['price'] * $item['quantity'];
    $itemCount += $item['quantity'];

}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Payment</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <link rel="stylesheet" href="css/style.css">
    </head>

    <body class="bg-light d-flex flex-column min-vh-100">

    <?php include("includes/header.php"); ?>

    <main class="flex-grow-1">

        <div class="container mt-5">

            <div class="row justify-content-center">

                <div class="col-12 col-sm-10 col-md-8 col-lg-6">

                    <div class="card shadow">

                        <div class="card-header bg-primary text-white">

                            <h3 class="text-center fw-bold">
                                Secure Payment
                            </h3>

                        </div>

                        <div class="card-body">

                            <div class="card bg-light border mb-4">

                                <div class="card-body">

                                    <h5 class="text-center mb-3 fw-bold">
                                        Order Summary
                                    </h5>

                                    <div class="d-flex justify-content-between">

                                        <span>Items</span>

                                        <strong><?php echo $itemCount; ?></strong>

                                    </div>

                                    <div class="d-flex justify-content-between mt-2">

                                        <span>Subtotal</span>

                                        <strong>$<?php echo number_format($total,2); ?></strong>

                                    </div>

                                    <div class="d-flex justify-content-between mt-2">

                                        <span>Shipping</span>

                                        <span class="text-success">Free</span>

                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between fs-5">

                                        <strong>Total</strong>

                                        <strong class="text-success">
                                            $<?php echo number_format($total,2); ?>
                                        </strong>

                                    </div>

                                </div>

                            </div>

                            <form action="checkout.php" method="POST">

                                <div class="mb-3">

                                    <label class="form-label">
                                        Cardholder Name
                                    </label>

                                    <input type="text"
                                            name="card_name"
                                            class="form-control"
                                            required>

                                </div>

                                <div class="mb-3">

                                    <label class="form-label">
                                        Card Number
                                    </label>

                                    <input type="text" 
                                            inputmode="numeric"
                                            name="card_number"
                                            class="form-control"
                                            maxlength="16"
                                            placeholder="1234123412341234"
                                            required>

                                </div>

                                <div class="row">

                                    <div class="col-md-6">

                                        <label class="form-label">
                                            Expiry Date
                                        </label>

                                        <input type="month"
                                                name="expiry"
                                                class="form-control"
                                                required>

                                    </div>

                                    <div class="col-md-6">

                                        <label class="form-label">
                                            CVV
                                        </label>

                                        <input type="password"
                                                inputmode="numeric"
                                                name="cvv"
                                                class="form-control"
                                                maxlength="3"
                                                required>

                                    </div>

                                </div>

                                <div class="mt-3">

                                    <a href="cart.php" class="btn btn-outline-dark w-100">
                                        <i class="bi bi-arrow-left me-2"></i>
                                        Back to Cart
                                    </a>

                                </div>

                                <div class="mt-4">

                                    <button class="btn btn-success w-100">

                                        <i class="bi bi-lock-fill me-2"></i>
                                        Pay Securely

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

    <?php include("includes/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
        
    </body>
</html>