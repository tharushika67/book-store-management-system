<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Check if user is an admin
if ($_SESSION['user_role'] != "admin") {
    echo "<script>
        alert('Access Denied! Admins only.');
        window.location='../index.php';
    </script>";
    exit();
}
?>