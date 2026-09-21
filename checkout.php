<?php
include("includes/user_auth.php");
include("includes/db.php");

// Ensure the payment form was submitted
if($_SERVER["REQUEST_METHOD"] != "POST"){
    header("Location: payment.php");
    exit();
}

// Get payment details
$card_name = trim($_POST['card_name']);
$card_number = trim($_POST['card_number']);
$expiry = $_POST['expiry'];
$cvv = trim($_POST['cvv']);

// Simple validation
if(
    empty($card_name) ||
    empty($card_number) ||
    empty($expiry) ||
    empty($cvv)
){
    echo "<script>
        alert('Please complete all payment details.');
        window.location='payment.php';
    </script>";
    exit();
}

// Card number must contain exactly 16 digits
// preg_match() is a PHP function that checks if a string matches a pattern. preg_match(pattern, string)
if(!preg_match('/^[0-9]{16}$/', $card_number)){
    echo "<script>
        alert('Card number must contain exactly 16 digits.');
        window.location='payment.php';
    </script>";
    exit();
}

// CVV must contain exactly 3 digits
if(!preg_match('/^[0-9]{3}$/', $cvv)){
    echo "<script>
        alert('CVV must contain exactly 3 digits.');
        window.location='payment.php';
    </script>";
    exit();
}

// Check login
if(!isset($_SESSION['user_id'])){
    echo "<script>
        alert('Please login first!');
        window.location='../auth/login.php';
    </script>";
    exit();
}

// Check cart
$user_id = $_SESSION['user_id'];

$cart_check = mysqli_query($conn,
    "SELECT * FROM cart
     WHERE user_id='$user_id'");

if(mysqli_num_rows($cart_check) == 0){
    echo "<script>
        alert('Cart is empty!');
        window.location='cart.php';
    </script>";
    exit();
}

$total = 0;

$cart_items = mysqli_query($conn,
    "SELECT cart.book_id,
            cart.quantity,
            books.price
     FROM cart
     INNER JOIN books
     ON cart.book_id = books.id
     WHERE cart.user_id='$user_id'");

while($item = mysqli_fetch_assoc($cart_items)){
    $total += $item['price'] * $item['quantity'];
}

// Insert order
$order_sql = "INSERT INTO orders(user_id, total_amount)
              VALUES('$user_id', '$total')";

mysqli_query($conn, $order_sql);

// Get last inserted order id
$order_id = mysqli_insert_id($conn);

// Get all cart items
$cart_items = mysqli_query($conn,
    "SELECT cart.book_id,
            cart.quantity,
            books.price
     FROM cart
     INNER JOIN books
     ON cart.book_id = books.id
     WHERE cart.user_id='$user_id'");

// Save each cart item into order_items
while($item = mysqli_fetch_assoc($cart_items)){

    $book_id = $item['book_id'];
    $qty = $item['quantity'];
    $price = $item['price'];

    $item_sql = "INSERT INTO order_items(order_id, book_id, quantity, price)
                 VALUES('$order_id', '$book_id', '$qty', '$price')";

    mysqli_query($conn, $item_sql);
}

// Empty the user's cart
mysqli_query($conn,
    "DELETE FROM cart
     WHERE user_id='$user_id'");

echo "<script>
    alert('Order placed successfully!');
    window.location='my_orders.php';
</script>";
?>