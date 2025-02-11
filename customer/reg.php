<?php
include('nheader.php');
?>
<?php

session_start();


$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "imca20010";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

   
   if (empty($fullname) && empty($email) && empty($password) && empty($confirm_password)) {
    $error = "Please fill the form before submitting.";
    } else {
        
        if (empty($fullname)) {
            $error = "Full Name is required!";
        } elseif (empty($email)) {
            $error = "Email is required!";
        } elseif (empty($password)) {
            $error = "Password is required!";
        } elseif ($password !== $confirm_password) {
            $error = "Passwords do not match!";
        } else {
            
            $sql = "SELECT * FROM customer WHERE email='$email'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $error = "Email already registered!";
            } else {
                // Hash the password and insert user into the database
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);             // used for password hashing
                $sql = "INSERT INTO customer (username, password, email) VALUES ('$fullname', '$hashed_password', '$email')";

                if ($conn->query($sql) === TRUE) {
                    echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
                    exit();
                } else {
                    $error = "Error: " . $conn->error;
                }
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>One Music - Modern Music HTML5 Template</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <!-- ##### Breadcumb Area Start ##### -->
    <section class="breadcumb-area bg-img bg-overlay" style="background-image: url(img/bg-img/breadcumb3.jpg);">
        <div class="bradcumbContent">
            <p></p>
            <h2>Register</h2>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->

<!-- ##### Registration Form ##### -->
<section class="login-area section-padding-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="login-content">
                    <h3>You are only a few steps away.</h3>
                    <div class="login-form">
                        <!-- Display error message if any -->
                        <?php if (!empty($error)) : ?>
                            <div class="alert alert-danger">
                                <?= $error; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Registration Form -->
                        <form action="reg.php" method="post">
                        <div class="form-group">
        <label for="exampleInputName">Full Name</label>
        <input type="text" 
               class="form-control" 
               name="fullname" 
               placeholder="Enter Full Name" 
               required
               pattern="^[a-zA-Z\s]+$" 
               title="Full Name should not contain numbers or special characters. Only letters and spaces are allowed.">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" 
               class="form-control" 
               name="email" 
               placeholder="Enter E-mail" 
               required
               pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" 
               title="Please enter a valid email address (e.g., example@mail.com).">
        <small class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" 
               class="form-control" 
               name="password" 
               placeholder="Password" 
               required
               minlength="8"
               pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}" 
               title="Password must be at least 8 characters long, include at least one uppercase letter, one lowercase letter, one digit, and one special character.">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword2">Confirm Password</label>
        <input type="password" 
               class="form-control" 
               name="confirm_password" 
               placeholder="Confirm Password" 
               required
               minlength="8"
               pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}" 
               title="Confirm Password must match the above criteria.">
    </div>
    <button type="submit" class="btn oneMusic-btn mt-30">Register</button><br><br>
    <a href="login.php" class="href">Already registered? Login</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### Registration Form End Here ##### -->

<!-- ##### Footer Area Start ##### -->
<footer class="footer-area" style="background-color: #000; padding: 20px; color: white;">
    <div class="container">
        <div class="row d-flex flex-wrap align-items-center">
            <div class="col-12 col-md-6">
                <a href="#"><img src="img/core-img/logo.png" alt=""></a>
                <p class="copywrite-text" style="margin-top: 10px; color: grey;">
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" style="color: white;">Colorlib</a>
                </p>
            </div>

            <div class="col-12 col-md-6 text-right">
                <div class="row mt-4" style="text-align: left;">
                    <div class="col-12" style="color: white;">
                        <h5 style="margin: 10px 0; color: white;">Contact Us</h5>
                        <p style="margin: 5px 0; color: white;"><strong>Prism Sound Labs</strong></p>
                        <p style="margin: 5px 0;">
                            <a href="https://goo.gl/maps/pFZLhLPT7Tk" target="_blank" style="color: white;">456 Countryside Road, Cotswolds, GL54 2RN, England</a>
                        </p>
                        <p style="margin: 5px 0;">
                            Email: <a href="mailto:info@harmonygrovestudio.com" style="color: white;">info@prismsoundlabs.com</a>
                        </p>
                        <p style="margin: 5px 0;">
                            Phone: <a href="tel:+441234567890" style="color: white;">(+44) 1234 567890</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- ##### Footer Area End ##### -->

    <!-- ##### All Javascript Script ##### -->
    <!-- jQuery-2.2.4 js -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins js -->
    <script src="js/plugins/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>
</body>

</html>