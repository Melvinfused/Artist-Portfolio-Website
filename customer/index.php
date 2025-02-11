<?php
include('nheader.php');
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

    <!-- ##### Hero Area Start ##### -->
    <section class="hero-area">
        <div class="hero-slides owl-carousel">
            <!-- Single Hero Slide -->
            <div class="single-hero-slide d-flex align-items-center justify-content-center">
                <!-- Slide Img -->
                <div class="slide-img bg-img" style="background-image: url(img/bg-img/bg-1.jpg);"></div>
                <!-- Slide Content -->
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="hero-slides-content text-center">
                                <h6 data-animation="fadeInUp" data-delay="100ms">Latest</h6>
                                <h2 style="font-family: 'Magz', sans-serif;" data-animation="fadeInUp" data-delay="300ms">Departure EP <span>Departure EP</span></h2>
                                <a data-animation="fadeInUp" data-delay="500ms" href="https://push.fm/fl/tly8mbon" class="btn oneMusic-btn mt-50">Discover <i class="fa fa-angle-double-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Single Hero Slide -->
            <div class="single-hero-slide d-flex align-items-center justify-content-center">
                <!-- Slide Img -->
                <div class="slide-img bg-img" style="background-image: url(img/bg-img/bg-2.jpg);"></div>
                <!-- Slide Content -->
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="hero-slides-content text-center">
                                <h6 data-animation="fadeInUp" data-delay="100ms">Upcoming Performance</h6>
                                <h2 data-animation="fadeInUp" data-delay="300ms">10/11/2024 <span>Tisnoe, Italy</span></h2>
                                <a data-animation="fadeInUp" data-delay="500ms" href="#" class="btn oneMusic-btn mt-50">Book Now <i class="fa fa-angle-double-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- ##### Latest Albums Area Start ##### -->
<section class="latest-albums-area section-padding-100">
    <div class="container" >
        <div class="row">
            <div class="col-12" >
                <div class="section-heading style-2" style="margin-bottom: 20px;">
                    <p>See what’s new</p>
                    <h2>Fresh Releases</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9">
                <div class="ablums-text text-center mb-70">
                <p>Fresh from the studio, this is a glimpse of my latest sounds. While I’m just getting started, these tracks represent where I'm heading. Every melody, beat, and voice is a step on this journey. Take a listen, and stay tuned for more.</p>
                </div>
            </div>
        </div>

        <div class="row">
    <div class="col-12">
        <div class="albums-slideshow owl-carousel">
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
            $sql = "SELECT MIN(tid) AS tid, album, artist, art, url 
                    FROM discography 
                    WHERE status = 1 AND rdate >= DATE_SUB(CURDATE(), INTERVAL 2 YEAR)
                    GROUP BY album, artist
                    ORDER BY rdate DESC";
            $result = $conn->query($sql);

            // Check if there are results
            if ($result->num_rows > 0) {
                // Output data for each row
                while ($row = $result->fetch_assoc()) {
                    // Assuming 'art' contains just the filename
                    $imagePath = '../uploads/' . $row["art"]; // Prepend the uploads directory
                    $albumUrl = $row["url"]; // URL from the database
                    echo '<a href="' . $albumUrl . '" target="_blank"> <!-- Link to the album URL -->
                            <div class="single-album text-center" style="margin: 0 auto;">
                                <img src="' . $imagePath . '" alt="Album Art" style="width:200px; height:auto;" onerror="this.onerror=null; this.src=\'../uploads/default.jpg\';">
                                <div class="album-info">
                                    <h5>' . $row["album"] . '</h5>
                                    <p>by ' . $row["artist"] . '</p>
                                </div>
                            </div>
                          </a>';
                }
            } else {
                echo '<div class="single-album text-center">
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
<section style="margin-bottom: 15px;"> <!-- Adjust margin here -->
    <div class="container">
        <div class="row">
            <div class="col-12">
            <div class="col-12 d-flex justify-content-center">
                <!-- Set the width to approximately 567 pixels for 15 cm -->
                <iframe style="border-radius:12px" src="https://open.spotify.com/embed/playlist/2NpKuxZxcHIQg6hgnNP8wk?utm_source=generator&theme=0" width="567" height="152" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>
<!-- ##### Spotify Mini Player End ##### -->





 
    <!-- ##### Contact Area Start ##### -->
    <section class="contact-area section-padding-100 bg-img bg-overlay bg-fixed has-bg-img" style="background-image: url(img/bg-img/bg-2.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading white wow fadeInUp" data-wow-delay="100ms">
                        <p></p>
                        <h2>Get In Touch With The Artist</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <!-- Contact Form Area -->
                    <div class="contact-form-area">
                        <form action="#" method="post">
                            <div class="row">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group wow fadeInUp" data-wow-delay="100ms">
                                        <input type="text" class="form-control" id="name" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group wow fadeInUp" data-wow-delay="200ms">
                                        <input type="email" class="form-control" id="email" placeholder="E-mail">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group wow fadeInUp" data-wow-delay="300ms">
                                        <input type="text" class="form-control" id="subject" placeholder="Subject">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group wow fadeInUp" data-wow-delay="400ms">
                                        <textarea name="message" class="form-control" id="message" cols="30" rows="10" placeholder="Message"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 text-center wow fadeInUp" data-wow-delay="500ms">
                                    <button class="btn oneMusic-btn mt-30" type="submit">Send <i class="fa fa-angle-double-right"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Contact Area End ##### -->

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