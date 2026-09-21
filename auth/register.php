<?php
include("../includes/db.php");

if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check);

    if(mysqli_num_rows($result) > 0){
        echo "<script>alert('Email already exists!');</script>";
    }
    else{
        $sql = "INSERT INTO users (name,email,password) 
                VALUES ('$name','$email','$password')";

        if(mysqli_query($conn, $sql)){
            echo "<script>
            alert('Registration Successful! Please login.');
            window.location.href='login.php';
            </script>";
        }
        else{
            echo "<script>alert('Error occurred!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">

</head>

<body class="bg-light d-flex flex-column min-vh-100">

<?php include("../includes/header.php"); ?>

<main class="flex-grow-1">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-12 col-sm-10 col-md-8 col-lg-5">

            <div class="card shadow p-4">

                <h2 class="text-center fw-bold mb-4">
                    Create Account
                </h2>

                <form method="POST">

                    <input 
                        type="text" 
                        name="name" 
                        class="form-control mb-3" 
                        placeholder="Full Name" 
                        autocomplete="name"
                        required>

                    <input 
                        type="email" 
                        name="email" 
                        class="form-control mb-3" 
                        placeholder="Email" 
                        inputmode="email" 
                        autocomplete="email" 
                        required>

                    <input 
                        type="password" 
                        name="password" 
                        class="form-control mb-3" 
                        placeholder="Password" 
                        autocomplete="new-password"
                        required>

                    <button 
                        type="submit" 
                        name="register" 
                        class="btn btn-primary w-100">
                        Register
                    </button>

                </form>

                <hr>

                <p class="text-center mb-0">
                    Already have an account?

                    <a href="login.php">
                        Login here
                    </a>

                </p>

            </div>

        </div>

    </div>

</div>

</main>

<?php include("../includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>