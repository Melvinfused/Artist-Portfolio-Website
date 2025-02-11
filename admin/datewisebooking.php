<?php
require('../config/autoload.php'); 
include("header.php");

try {
    $pdo = new PDO('mysql:host=localhost;dbname=imca20010', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

$startDate = $_POST['start_date'] ?? '';
$endDate = $_POST['end_date'] ?? '';


if (empty($endDate)) {
    $endDate = date('Y-m-d');
}


if (!empty($startDate) && !empty($endDate)) {

    $startDate = date('Y-m-d', strtotime($startDate));
    $endDate = date('Y-m-d', strtotime($endDate));


    $sqlBookings = "SELECT * FROM bookings WHERE bdate BETWEEN :start_date AND :end_date ORDER BY bid DESC";
    

    $stmt = $pdo->prepare($sqlBookings);
    

    $stmt->bindParam(':start_date', $startDate);
    $stmt->bindParam(':end_date', $endDate);
    

    $stmt->execute();
    

    $bookingsResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {

    $sqlBookings = "SELECT * FROM bookings ORDER BY bid DESC";
    

    $stmt = $pdo->prepare($sqlBookings);
    $stmt->execute();
    

    $bookingsResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


if (!$bookingsResults) {
    echo "<p>Error fetching bookings. Please try again later.</p>";
    $bookingsResults = []; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings Viewer</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin-bottom: 20px;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            table, table * {
                visibility: visible; 
            }
            table {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                border-collapse: collapse;
            }
        }
    </style>
    <script type="text/javascript">
        function printPage() {
            window.print();  
        }
    </script>
</head>
<body>

<h1>Datewise Bookings Viewer</h1>

<!-- Print Button -->
<button onclick="printPage()">Print</button>

<form method="POST" action="">
    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>">
    <label for="end_date">End Date:</label>
    <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($endDate); ?>">
    <button type="submit">Filter</button>
</form>

<table>
    <thead>
        <tr>
            <?php if (!empty($bookingsResults)): ?>
                <?php foreach (array_keys($bookingsResults[0]) as $column): ?>
                    <th><?php echo htmlspecialchars($column); ?></th>
                <?php endforeach; ?>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bookingsResults as $booking): ?>
            <tr>
                <?php foreach ($booking as $value): ?>
                    <td><?php echo htmlspecialchars($value); ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
