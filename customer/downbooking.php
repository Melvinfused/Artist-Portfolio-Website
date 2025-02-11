<?php
session_start(); // Start the session

// Assuming the user is logged in and you've established a DB connection
if (isset($_POST['bid'])) {
    $bid = $_POST['bid'];

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
        WHERE bookings.bid = ?
    ");
    $stmt->bind_param("i", $bid);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are results
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Extract details from the result
        $showName = $row['sname'];
        $venue = $row['venue'];
        $showDate = date("F j, Y", strtotime($row['sdate']));
        $quantity = $row['qty'];
        $totalPrice = $row['bprice'];
        $userEmail = $row['email']; // Include user's email
        $username = $row['username'];

        // Create the PDF
        require('fpdf.php'); // Make sure to include the FPDF library
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
        $pdf->Cell(0, 10, 'Customer: ' . $username, 0, 1);
        $pdf->Cell(0, 10, 'Email: ' . $userEmail, 0, 1); // Include user's email

        // Save the PDF to a temporary file
        $fileName = 'ticket_' . time() . '.pdf';
        $pdfPath = __DIR__ . '/' . $fileName;
        $pdf->Output('F', $pdfPath); // Save PDF on the server

        // Now, send the file as a download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($pdfPath) . '"');
        readfile($pdfPath);

        // Clean up
        unlink($pdfPath); // Delete the temporary file after download
    } else {
        echo "No booking found.";
    }

    // Close connection
    $stmt->close();
    $conn->close();
} else {
    echo "No booking ID provided.";
}
?>
