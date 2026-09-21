<?php
include("../includes/db.php");
session_start();

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Find user by email
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){

        $user = mysqli_fetch_assoc($result);

        // Check password
        if(password_verify($password, $user['password'])){

            // Create session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            echo "<script>
                alert('Login Successful!');
                window.location.href = '../index.php';
            </script>";

        }
        else{
            echo "<script>alert('Incorrect Password!');</script>";
        }

    }
    else{
        echo "<script>alert('User not found!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Login</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="css/style.css">

    </head>

    <body class="bg-light d-flex flex-column min-vh-100">

    <?php include("../includes/header.php"); ?>

    <main class="flex-grow-1">

    <div class="container mt-5">

        <div class="row justify-content-center">

            <div class="col-12 col-sm-10 col-md-8 col-lg-5">

                <div class="card shadow p-4">

                    <h2 class="text-center fw-bold mb-4">
                        Login
                    </h2>

                    <form method="POST">

                        <input 
                            type="email" 
                            name="email" 
                            class="form-control mb-3" 
                            placeholder="Email" 
                            inputmode="email" 
                            inputmode="email"  
                            required>

                        <input 
                            type="password" 
                            name="password" 
                            class="form-control mb-3" 
                            placeholder="Password" 
                            autocomplete="current-password"
                            required>

                        <button 
                            type="submit" 
                            name="login" 
                            class="btn btn-success w-100">
                            Login
                        </button>

                    </form>

                    <hr>

                    <p class="text-center mb-0">
                        Don't have an account?

                        <a href="register.php">
                            Register here
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