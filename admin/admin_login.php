<?php
                    // Initialize a variable for the message
                    $message = '';

                    // Check if the form is submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Get the username and password from the form
                        $username = $_POST['username'];
                        $password = $_POST['password'];

                        // Check if the credentials are correct
                        if ($username === 'admin' && $password === 'admin') {
                            // Redirect or perform any action for successful login
                            header("Location:dash.php");
                            // You can uncomment the next line to redirect
                            // header("Location: admin-dashboard.php"); exit;
                        } else {
                            $message = 'Invalid username or password!';
                        }
                    }
                    ?>
<!doctype html>
<html lang="en">
<head>
    <title>Login 10</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="img js-fullheight" style="background-image: url(images/bg.jpg);">
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section">Admin</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">

                    <form action="" method="post" class="signin-form">
                        <div class="form-group">
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" name="password" class="form-control" placeholder="Password" required>
                            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
                        </div>
                    </form>

                    <div id="message" style="color: red; text-align: center;">
                        <?php echo $message; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
