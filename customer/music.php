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
            <p>All my releases, since day one.</p>
            <h2>Discography</h2>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->



    <!-- ##### Latest Albums Area Start ##### -->
<section class="latest-albums-area" style="padding-top: 100px; padding-bottom: 30px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="albums-grid row">
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

                    // Fetch unique albums with distinct album and artist + added date limit to fetch from.
                    $sql = "SELECT album, artist, art, url 
                            FROM discography 
                            WHERE status = 1 
                            GROUP BY album, artist 
                            ORDER BY rdate DESC";
                    $result = $conn->query($sql);

                    // Check if there are results
                    if ($result->num_rows > 0) {
                        // Output data for each unique album
                        while ($row = $result->fetch_assoc()) {
                            // Assuming 'art' contains just the filename
                            $imagePath = '../uploads/' . $row["art"]; // Prepend the uploads directory
                            $albumUrl = $row["url"]; // URL from the database
                            echo '<div class="col-12 col-sm-6 col-md-3 text-center mb-4"> <!-- Changed col-md-4 to col-md-3 for 4 albums per row -->
                                    <a href="' . $albumUrl . '" target="_blank"> <!-- Link to the album URL -->
                                        <div class="single-album" style="margin: 0 auto;">
                                            <img src="' . $imagePath . '" alt="Album Art" style="width:200px; height:auto;" onerror="this.onerror=null; this.src=\'../uploads/default.jpg\';">
                                            <div class="album-info">
                                                <h5>' . $row["album"] . '</h5>
                                                <p>' . $row["artist"] . '</p>
                                            </div>
                                        </div>
                                    </a>
                                  </div>'; // Each album is in a Bootstrap column
                        }
                    } else {
                        echo '<div class="col-12 text-center">
                                <p>No active albums found.</p>
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
<!-- ##### Latest Albums Area End ##### -->

<!-- ##### Spotify Mini Player Start ##### -->
<section style="margin-bottom: 30px;"> <!-- Adjust margin here -->
    <div class="container">
        <div class="row">
            <div class="col-12">
            <div class="col-12 d-flex justify-content-center">
                <!-- Set the width to approximately 567 pixels for 15 cm -->
                <iframe style="border-radius:5px" src="https://open.spotify.com/embed/playlist/2NpKuxZxcHIQg6hgnNP8wk?utm_source=generator&theme=0" width="567" height="152" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>
<!-- ##### Spotify Mini Player End ##### -->


 
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