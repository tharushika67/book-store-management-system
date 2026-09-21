<?php
session_start();
include("includes/db.php");

$user_id = $_SESSION['user_id'];
$book_id = (int)$_GET['id'];
$action = $_GET['action'];

// Allowed actions
$allowed_actions = ['increase', 'decrease', 'remove'];

if(!in_array($action, $allowed_actions)){
    header("Location: cart.php");
    exit();
}

// Increase quantity
if($action == "increase"){

    mysqli_query($conn,
        "UPDATE cart
         SET quantity = quantity + 1
         WHERE user_id='$user_id'
         AND book_id='$book_id'");

}

// Decrease quantity
elseif($action == "decrease"){

    $result = mysqli_query($conn,
        "SELECT quantity
         FROM cart
         WHERE user_id='$user_id'
         AND book_id='$book_id'");

    $item = mysqli_fetch_assoc($result);

    if($item['quantity'] > 1){

        mysqli_query($conn,
            "UPDATE cart
             SET quantity = quantity - 1
             WHERE user_id='$user_id'
             AND book_id='$book_id'");

    }else{

        mysqli_query($conn,
            "DELETE FROM cart
             WHERE user_id='$user_id'
             AND book_id='$book_id'");

    }

}

// Remove item
elseif($action == "remove"){

    mysqli_query($conn,
        "DELETE FROM cart
         WHERE user_id='$user_id'
         AND book_id='$book_id'");

}

header("Location: cart.php");
exit();
?>