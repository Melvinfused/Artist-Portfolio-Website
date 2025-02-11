<?php
session_start();

require('fpdf.php');

$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : 'N/A'; 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "imca20010"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$successMessage = $errorMessage = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $bookingToken = bin2hex(random_bytes(32));
    $_SESSION['booking_token'] = $bookingToken; // Store the token in the session

    
    $cid = isset($_POST['cid']) ? intval($_POST['cid']) : 0; 
    $sid = isset($_POST['sid']) ? intval($_POST['sid']) : 0; 
    $showName = isset($_POST['showName']) ? $_POST['showName'] : '';
    $venue = isset($_POST['venue']) ? $_POST['venue'] : '';
    $showDate = isset($_POST['showDate']) ? $_POST['showDate'] : '';
    $totalPrice = isset($_POST['totalPrice']) ? floatval($_POST['totalPrice']) : 0; 
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0; 
    $bdate = date('Y-m-d');

    // Check if the booking has already been made
    if (!isset($_SESSION['payment_success'])) {
        
        $sqlInsertBooking = "INSERT INTO bookings (bprice, cid, qty, showid, bdate) VALUES (?, ?, ?, ?, ?)";
        $stmtInsertBooking = $conn->prepare($sqlInsertBooking);
        $stmtInsertBooking->bind_param("diiis", $totalPrice, $cid, $quantity, $sid, $bdate);

        if ($stmtInsertBooking->execute()) {
            $successMessage = "Booking successfully created. Your booking ID is: " . $stmtInsertBooking->insert_id; 
            $_SESSION['payment_success'] = true; 
            $_SESSION['booking_token'] = $bookingToken; // Store token in session
        } else {
            $errorMessage = "Error: " . $stmtInsertBooking->error;
        }
        
        $stmtInsertBooking->close();
    } else {
        
        header("Location: landing.php");
        exit;
    }
}

$conn->close();

// Check for the booking token
if (!isset($_SESSION['booking_token'])) {
    // Redirect to home if the token doesn't exist (user refreshed the page)
    header("Location: landing.php");
    exit;
}

// Create the PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Ticket header
$pdf->Cell(0, 10, 'INFUTION LIVE', 0, 1, 'C');

// Add details
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Show: ' . $showName, 0, 1);
$pdf->Cell(0, 10, 'Venue: ' . $venue, 0, 1);
$pdf->Cell(0, 10, 'Date: ' . $showDate, 0, 1);
$pdf->Cell(0, 10, 'Quantity: ' . $quantity, 0, 1);
$pdf->Cell(0, 10, 'Total Price: $' . number_format($totalPrice, 2), 0, 1);
$pdf->Cell(0, 10, 'Email: ' . $userEmail, 0, 1); 

// Save the PDF to a temporary file
$fileName = 'ticket_' . time() . '.pdf';
$pdfPath = __DIR__ . '/' . $fileName;
$pdf->Output('F', $pdfPath); // Save PDF on the server
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
    <style>
        body {
            text-align: center;
            padding: 40px 0;
            background: #EBF0F5;
        }
        h1 {
            color: #88B04B;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-weight: 900;
            font-size: 40px;
            margin-bottom: 10px;
        }
        p {
            color: #404F5E;
            font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
            font-size: 20px;
            margin: 0;
        }
        i {
            color: #9ABC66;
            font-size: 100px;
            line-height: 200px;
            margin-left: -15px;
        }
        .card {
            background: white;
            padding: 60px;
            border-radius: 4px;
            box-shadow: 0 2px 3px #C8D0D8;
            display: inline-block;
            margin: 0 auto;
        }
        .btn-success {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-success:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="card">
        <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
            <i class="checkmark">✓</i>
        </div>
        <h1>Success</h1>
        <p>Ticket Purchase Complete;<br/> Thank you.</p> <br><br>

        <a style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;" href="<?php echo htmlspecialchars($fileName); ?>" download="<?php echo htmlspecialchars($fileName); ?>" class="btn-success">Download Ticket</a><br><br>
        <br>
        <a style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;" href="landing.php" class="btn-success">Back to Home</a>
    </div>
</body>
</html>
