<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    include 'header.php'; // Include header for logged-in users
    $userEmail = $_SESSION['email']; // Assuming email is stored in session after login
} else {
    include 'nheader.php'; // Include header for unregistered users
    exit; // Exit if the user is not logged in
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>One Music - Modern Music HTML5 Template</title>
    <link rel="icon" href="img/core-img/favicon.ico">
    <link rel="stylesheet" href="style.css">
    <style>
        .single-album {
            max-width: 200px; /* Set a max width for album cards */
            margin: 0 auto; /* Center the card */
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="lds-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- ##### Breadcumb Area Start ##### -->
    <section class="breadcumb-area bg-img bg-overlay" style="background-image: url(img/bg-img/breadcumb3.jpg);">
        <div class="bradcumbContent">
            <p>Your Booking Details</p>
            <h2>My Bookings</h2>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Live Shows Area Start ##### -->
    <section class="live-shows-area" style="padding-top: 100px; padding-bottom: 30px;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shows-grid">
                        <?php
                        // Database configuration
                        $host = 'localhost'; // Change as necessary
                        $username = 'root'; // Your database username
                        $password = ''; // Your database password
                        $database = 'imca20010'; // Your database name

                        // Create connection
                        $conn = new mysqli($host, $username, $password, $database);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Prepare and bind
                        $stmt = $conn->prepare("
                            SELECT bookings.bid, bookings.bprice, bookings.qty, 
                                   customer.username, customer.email, 
                                   shows.sname, shows.venue, shows.sdate
                            FROM bookings
                            INNER JOIN customer ON bookings.cid = customer.cid
                            INNER JOIN shows ON bookings.showid = shows.sid
                            WHERE customer.email = ? 
                            AND bookings.status = '1'
                        ");
                        $stmt->bind_param("s", $userEmail);
                        $stmt->execute();
                        $result = $stmt->get_result();
                                                /*
                                                if ($stmtCancel->execute()) {
        // Set a session message if needed
        $_SESSION['cancellation_message'] = "Booking cancelled successfully!";
    } else {
        // Handle error (optional)
        echo "Error cancelling booking: " . $stmtCancel->error;
    }

    // Close the cancellation statement
    $stmtCancel->close();

    // Redirect back to the same page to refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit; // Ensure script stops running after redirect
} */
                                                // delete section
                                                if (isset($_POST['bid'])) {
                                                    $bid = $_POST['bid'];
                            
                                
                                                    $stmt = $conn->prepare("UPDATE bookings SET status = '0' WHERE bid = ?");
                                                    $stmt->bind_param("i", $bid);
                                                    $stmt->execute();
                                                }


                        // Check if there are results
                        if ($result->num_rows > 0) {
                            
                            // Output data for each booking
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="single-show-box" style="border: 4px solid #ddd; padding: 20px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                                    <div class="show-details" style="flex-grow: 1;">
                                        <h5>' . htmlspecialchars($row["sname"]) . '</h5> <!-- Show name -->
                                        <p>Venue: ' . htmlspecialchars($row["venue"]) . '</p> <!-- Venue -->
                                        <p>Quantity: ' . htmlspecialchars($row["qty"]) . '</p> <!-- Quantity -->
                                        <p>Price: $' . htmlspecialchars(number_format($row["bprice"], 2)) . '</p> <!-- Total price -->
                                        <p>Date: ' . date("F j, Y", strtotime($row["sdate"])) . '</p> <!-- Show date -->
                                    </div>
                                    <div class="action-buttons">
                                        <form method="POST" style="margin-right: 10px;">
                                            <input type="hidden" name="bid" value="' . htmlspecialchars($row["bid"]) . '">
                                            <button type="submit" class="btn oneMusic-btn mt-30">Cancel Booking</button>
                                        </form> <br><br>
                                        <form method="POST" action="downbooking.php">
                                            <input type="hidden" name="bid" value="' . htmlspecialchars($row["bid"]) . '">
                                            <button type="submit" class="btn oneMusic-btn mt-30">Download Ticket</button>
                                        </form>
                                    </div>
                                </div>'; 
                            }
                        } else {
                            echo '<div class="col-12 text-center">
                                    <p>No bookings made.</p>
                                  </div>';
                        }

                        // Close connection
                        $stmt->close();
                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Live Shows Area End ##### -->

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
