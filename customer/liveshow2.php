<?php
session_start(); // Start the session

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    include 'header.php'; // Include header for logged-in users
} else {
    include 'nheader.php'; // Include header for unregistered users
}
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
            <p>Watch me perform on-stage</p>
            <h2>Live Performances</h2>
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
                    $host = 'localhost';
                    $username = 'root';
                    $password = '';
                    $database = 'imca20010';

                    // Create connection
                    $conn = new mysqli($host, $username, $password, $database);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    // Fetch live shows with a status of 1 (available for booking)
                    $sql = "SELECT sid, sname, venue, price, sdate FROM shows WHERE status = 1 ORDER BY sdate ASC";
                    $result = $conn->query($sql);

                    // Check if there are results
                    if ($result->num_rows > 0) {
                        // Output data for each live show
                        while ($row = $result->fetch_assoc()) {
                            $showid = $row['sid'];
                            $cid = $_SESSION['cid'];

/*                            $sqlchk = "SELECT SUM(qty) as total_qty FROM bookings WHERE cid = ? AND showid = ?";
                            $chkqty = $conn->prepare($sqlchk);
                            $chkqty->bind_param("ii", $cid, $showid);

                            if ($chkqty->execute()) {
                                $result2 = $chkqty->get_result();
                                $row2 = $result2->fetch_assoc();
                                $totalBooked = $row2['total_qty'] ? intval($row2['total_qty']) : 0;

                                if ($totalBooked == 4) {
                                    echo '<div class="single-show-box" style="border: 4px solid #ddd; padding: 20px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                                        <div class="show-details" style="flex-grow: 1;">
                                            <h5>' . htmlspecialchars($row["sname"]) . '</h5> <!-- Show name -->
                                            <p>Venue: ' . htmlspecialchars($row["venue"]) . '</p> <!-- Venue -->
                                        </div>
                                        <div class="show-meta" style="text-align: right; min-width: 150px;">
                                            <p>Date: ' . date("F j, Y", strtotime($row["sdate"])) . '</p> <!-- Show date -->
                                            <p>Price: $' . htmlspecialchars(number_format($row["price"], 2)) . '</p> <!-- Price -->
                                        </div>
                                        <div class="ticket-selector" style="margin-left: 20px;">
                                            <p style="color: red;">User Booking limit exceeded (4 tickets max per show).</p>
                                        </div>
                                    </div>';
                                } else {
                                    // Show available tickets form
                                    echo '<div class="single-show-box" style="border: 4px solid #ddd; padding: 20px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                                        <div class="show-details" style="flex-grow: 1;">
                                            <h5>' . htmlspecialchars($row["sname"]) . '</h5> <!-- Show name -->
                                            <p>Venue: ' . htmlspecialchars($row["venue"]) . '</p> <!-- Venue -->
                                        </div>
                                        <div class="show-meta" style="text-align: right; min-width: 150px;">
                                            <p>Date: ' . date("F j, Y", strtotime($row["sdate"])) . '</p> <!-- Show date -->
                                            <p>Price: $' . htmlspecialchars(number_format($row["price"], 2)) . '</p> <!-- Price -->
                                        </div>
                                        <div class="ticket-selector" style="margin-left: 20px; display: flex; align-items: center;">
                                            <button type="button" class="quantity-btn" onclick="decreaseTicket(this)" style="width: 30px; height: 30px; border: none; background-color: #f0f0f0; color: #333; font-size: 20px; line-height: 1; text-align: center; cursor: pointer; border-radius: 50%; transition: background-color 0.3s;">-</button>
                                            <input type="text" class="ticket-quantity" value="1" min="1" max="4" style="width: 50px; text-align: center; margin: 0 10px; border: none; background-color: #f0f0f0; padding: 5px; border-radius: 4px;" onchange="updateHiddenQuantity(this)">
                                            <button type="button" class="quantity-btn" onclick="increaseTicket(this)" style="width: 30px; height: 30px; border: none; background-color: #f0f0f0; color: #333; font-size: 20px; line-height: 1; text-align: center; cursor: pointer; border-radius: 50%; transition: background-color 0.3s;">+</button>
                                        </div>
                                        <div class="book-tickets" style="margin-left: 20px;">
                                            <form action="payment.php" method="post" style="display:inline;">
                                                <input type="hidden" name="showName" value="' . htmlspecialchars($row["sname"]) . '">
                                                <input type="hidden" name="venue" value="' . htmlspecialchars($row["venue"]) . '">
                                                <input type="hidden" name="showDate" value="' . htmlspecialchars(date("F j, Y", strtotime($row["sdate"]))) . '">
                                                <input type="hidden" name="price" value="' . htmlspecialchars(number_format($row["price"], 2)) . '">
                                                <input type="hidden" name="quantity" class="ticket-quantity-hidden" value="1"> <!-- Default to 1 -->
                                                <button type="submit" class="btn oneMusic-btn mt-50">Book Now <i class="fa fa-angle-double-right"></i></button>
                                            </form>
                                        </div>
                                    </div>';
                                }
                            } */

                            // Get the total booked tickets for the user for this show
                            $sqlchk = "SELECT SUM(qty) as total_qty FROM bookings WHERE cid = ? AND showid = ? AND status = 1";
                            $chkqty = $conn->prepare($sqlchk);
                            $chkqty->bind_param("ii", $cid, $showid);

                            if ($chkqty->execute()) {
                                $result2 = $chkqty->get_result();
                                $row2 = $result2->fetch_assoc();
                                $totalBooked = $row2['total_qty'] ? intval($row2['total_qty']) : 0;

                                // If booking limit exceeded, show limit message, otherwise show booking form
                                if ($totalBooked == 4) {
                                    echo '<div class="single-show-box" style="border: 4px solid #ddd; padding: 20px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                                        <div class="show-details" style="flex-grow: 1;">
                                            <h5>' . htmlspecialchars($row["sname"]) . '</h5> <!-- Show name -->
                                            <p>Venue: ' . htmlspecialchars($row["venue"]) . '</p> <!-- Venue -->
                                        </div>
                                        <div class="show-meta" style="text-align: right; min-width: 150px;">
                                            <p>Date: ' . date("F j, Y", strtotime($row["sdate"])) . '</p> <!-- Show date -->
                                            <p>Price: $' . htmlspecialchars(number_format($row["price"], 2)) . '</p> <!-- Price -->
                                        </div>
                                        <div class="ticket-selector" style="margin-left: 20px;">
                                            <p style="color: red;">User limit exceeded!</p>
                                        </div>
                                    </div>';
                                } else {
                                    // Show available tickets form
                                    echo '<div class="single-show-box" style="border: 4px solid #ddd; padding: 20px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                                        <div class="show-details" style="flex-grow: 1;">
                                            <h5>' . htmlspecialchars($row["sname"]) . '</h5> <!-- Show name -->
                                            <p>Venue: ' . htmlspecialchars($row["venue"]) . '</p> <!-- Venue -->
                                        </div>
                                        <div class="show-meta" style="text-align: right; min-width: 150px;">
                                            <p>Date: ' . date("F j, Y", strtotime($row["sdate"])) . '</p> <!-- Show date -->
                                            <p>Price: $' . htmlspecialchars(number_format($row["price"], 2)) . '</p> <!-- Price -->
                                        </div>
                                        <div class="ticket-selector" style="margin-left: 20px; display: flex; align-items: center;">
                                            <button type="button" class="quantity-btn" onclick="decreaseTicket(this)" style="width: 30px; height: 30px; border: none; background-color: #f0f0f0; color: #333; font-size: 20px; line-height: 1; text-align: center; cursor: pointer; border-radius: 50%; transition: background-color 0.3s;">-</button>
                                            <input type="text" class="ticket-quantity" value="1" min="1" max="4" style="width: 50px; text-align: center; margin: 0 10px; border: none; background-color: #f0f0f0; padding: 5px; border-radius: 4px;" onchange="updateHiddenQuantity(this)">
                                            <button type="button" class="quantity-btn" onclick="increaseTicket(this)" style="width: 30px; height: 30px; border: none; background-color: #f0f0f0; color: #333; font-size: 20px; line-height: 1; text-align: center; cursor: pointer; border-radius: 50%; transition: background-color 0.3s;">+</button>
                                        </div>
                                        <div class="book-tickets" style="margin-left: 20px;">
                                            <form action="payment.php" method="post" style="display:inline;">
                                                <input type="hidden" name="showName" value="' . htmlspecialchars($row["sname"]) . '">
                                                <input type="hidden" name="venue" value="' . htmlspecialchars($row["venue"]) . '">
                                                <input type="hidden" name="showDate" value="' . htmlspecialchars(date("F j, Y", strtotime($row["sdate"]))) . '">
                                                <input type="hidden" name="price" value="' . htmlspecialchars(number_format($row["price"], 2)) . '">
                                                <input type="hidden" name="quantity" class="ticket-quantity-hidden" value="1"> <!-- Default to 1 -->
                                                <button type="submit" class="btn oneMusic-btn mt-50">Book Now <i class="fa fa-angle-double-right"></i></button>
                                            </form>
                                        </div>
                                    </div>';
                                }
                            }
                        }
                    } else {
                        echo '<div class="col-12 text-center">
                            <p>No live shows available for booking at this time.</p>
                        </div>';
                    }

                    // Close connection
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### Live Shows Area End ##### -->

<script>
// Function to decrease ticket quantity
function decreaseTicket(button) {
    const input = button.nextElementSibling;
    let quantity = parseInt(input.value);
    if (quantity > 1) {
        quantity--;
        input.value = quantity;
        updateHiddenQuantity(input);
    }
}

// Function to increase ticket quantity
function increaseTicket(button) {
    const input = button.previousElementSibling;
    let quantity = parseInt(input.value);
    if (quantity < 4) { // Assuming the max quantity is 4
        quantity++;
        input.value = quantity;
        updateHiddenQuantity(input);
    }
}

// Update the hidden quantity input
function updateHiddenQuantity(input) {
    const hiddenInput = input.closest('.single-show-box').querySelector('.ticket-quantity-hidden');
    hiddenInput.value = input.value; // Set hidden input value to current quantity
}
</script>









 
<?php
/*
// Assuming you have a connection to the database already established
// Database connection
$host = 'localhost'; 
$username = 'root'; 
$password = ''; 
$dbname = 'imca20010'; 
$db = new mysqli($host, $username, $password, $dbname);

// Check if the connection is successful
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Query to fetch the background and album title
$query = "SELECT h.description, d.url, d.art
          FROM highlight h
          JOIN discography d ON h.tid = d.tid
          WHERE h.hid = 1"; 
$result = mysqli_query($db, $query);
$row = mysqli_fetch_assoc($result);

$bg = $row['art']; // Fetch background image URL
$desc = $row['description']; 
$url = $row['url'];

*/
?>

    <!-- ##### Add Area Start ##### -->
     <!--
    <div class="add-area mb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="adds">
                        <a href="#"><img src="img/bg-img/add3.gif" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>  --!>
    <!-- ##### Add Area End ##### -->

   



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