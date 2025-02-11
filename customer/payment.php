<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    die("You need to be logged in to access this page.");
}

// Include database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "imca20010"; // Replace with your actual DB name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the email of the logged-in user from the session
$userEmail = $_SESSION['email'];

// Fetch the customer ID (cid) using the user's email
$sqlGetCustomer = "SELECT cid FROM customer WHERE email = ?";
$stmtGetCustomer = $conn->prepare($sqlGetCustomer);
$stmtGetCustomer->bind_param("s", $userEmail);
$stmtGetCustomer->execute();
$result = $stmtGetCustomer->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cid = $row['cid']; 
} else {
    die("Customer not found.");
}

$stmtGetCustomer->close();

// Initialize variables
$showName = $venue = $showDate = $quantity = $totalPrice = $pricePerTicket = "";
$sid = 0; // Initialize show ID (sid)

// Get the form data
$showName = isset($_POST['showName']) ? $_POST['showName'] : 'N/A';
$venue = isset($_POST['venue']) ? $_POST['venue'] : 'N/A';
$showDate = isset($_POST['showDate']) ? $_POST['showDate'] : 'N/A';
$pricePerTicket = isset($_POST['price']) ? floatval(str_replace(',', '', $_POST['price'])) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
$totalPrice = $pricePerTicket * $quantity;

// Fetch the show ID (sid) from the `shows` table using the show name
$sqlGetShowId = "SELECT sid FROM shows WHERE venue = ?";
$stmtGetShowId = $conn->prepare($sqlGetShowId);
$stmtGetShowId->bind_param("s", $venue);
$stmtGetShowId->execute();
$resultShowId = $stmtGetShowId->get_result();

if ($resultShowId->num_rows > 0) {
    $rowShow = $resultShowId->fetch_assoc();
    $sid = $rowShow['sid']; // Get the show ID
} else {
    die("Show not found.");
}

// Close the database connection
$conn->close();
$stmtGetShowId->close();


/* echo "Session Variables:\n";
print_r($_SESSION); // Display all session variables

echo "\nPOST Variables:\n";
print_r($_POST); // Display all POST variables
*/
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Confirm and Pay</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Payment Form -->
    <section class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Confirm order and pay</h2>
                <form action="paysuccess.php" method="POST">
                    <div class="card p-3">
                        <h6 class="text-uppercase">Payment details</h6>
                        <div class="inputbox mt-3">
                        <input type="text" 
                                name="name" 
                                class="form-control" 
                                required 
                                placeholder="Name on card" 
                                pattern="^[A-Za-z\s]+$" 
                                title="Name must contain only letters and spaces.">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="inputbox mt-3 mr-2">
                                    <input type="text" name="cardNumber" class="form-control" required pattern="\d{16}" placeholder="Card Number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex">
                                    <div class="inputbox mt-3 mr-2">
                                        <input type="text" name="expiry" class="form-control" required placeholder="MM/YY" pattern="(0[1-9]|1[0-2])\/\d{2}">
                                    </div>
                                    <div class="inputbox mt-3 mr-2">
                                        <input type="text" name="cvv" class="form-control" required pattern="\d{3}" placeholder="CVV">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 mb-4">
                            <h6 class="text-uppercase">Billing Address</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="inputbox mt-3 mr-2">
                                        <input type="text" name="street" class="form-control" required placeholder="Street Address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="inputbox mt-3 mr-2">
                                        <input type="text" name="city" class="form-control" required placeholder="City">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="inputbox mt-3 mr-2">
                                        <input type="text" name="state" class="form-control" required placeholder="State/Province">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                <div class="inputbox mt-3 mr-2">
                                    <input type="text" 
                                        name="zipcode" 
                                        class="form-control" 
                                        required 
                                        placeholder="Zip Code" 
                                        pattern="^[A-Za-z0-9\s\-]{4,10}$" 
                                        title="ZIP Code must be between 4 and 10 characters long, and can include letters, numbers, spaces, or hyphens.">
                                </div>
                            </div>

                            </div>
                        </div>
                    </div>

                    <!-- Hidden fields to pass the booking details -->
                    <input type="hidden" name="showName" value="<?php echo htmlspecialchars($showName); ?>">
                    <input type="hidden" name="venue" value="<?php echo htmlspecialchars($venue); ?>">
                    <input type="hidden" name="showDate" value="<?php echo htmlspecialchars($showDate); ?>">
                    <input type="hidden" name="price" value="<?php echo htmlspecialchars($pricePerTicket); ?>">
                    <input type="hidden" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>">
                    <input type="hidden" name="totalPrice" value="<?php echo htmlspecialchars($totalPrice); ?>">
                    <input type="hidden" name="cid" value="<?php echo htmlspecialchars($cid); ?>">
                    <input type="hidden" name="sid" value="<?php echo htmlspecialchars($sid); ?>">

                    <div class="mt-4 d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Pay $<?php echo htmlspecialchars(number_format($totalPrice, 2)); ?></button>
                        <button type="button" class="btn btn-secondary" onclick="window.history.back();">Go Back</button>
                    </div>
                </form>
            </div>

            <!-- Billing Summary -->
            <div class="col-md-4">
                <div class="card p-3 text-white mb-3 bg-info">
                    <h2>Billing Details</h2>
                    <p><strong>Show Name:</strong> <?php echo htmlspecialchars($showName); ?></p>
                    <p><strong>Venue:</strong> <?php echo htmlspecialchars($venue); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($showDate); ?></p>
                    <p><strong>Quantity:</strong> <?php echo htmlspecialchars($quantity); ?></p>
                    <p><strong>Price per Ticket:</strong> $<?php echo htmlspecialchars(number_format($pricePerTicket, 2)); ?></p>
                    <h5><strong>Total Price:</strong> $<?php echo htmlspecialchars(number_format($totalPrice, 2)); ?></h5>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
