<?php 
require('../config/autoload.php'); 
include("header.php");

// Create a new DataAccess object
$dao = new DataAccess();

// Query to get the total visits ever
$sqlTotalVisits = "SELECT SUM(vcount) AS total_visits FROM visit_log";
$totalVisitsResult = $dao->query($sqlTotalVisits);

// Initialize total visits variable
$totalVisits = 0;

// Check if the query was successful and fetch the result
if ($totalVisitsResult !== false) {
    $totalVisitsRow = $totalVisitsResult[0]; // Assuming query returns an array
    $totalVisits = $totalVisitsRow['total_visits'];
} else {
    echo "<p>Error fetching total visits: " . $dao->error . "</p>";
}


// Query to get the sum of visit counts and group by IP
$sql = "SELECT ip, SUM(vcount) AS total_count FROM visit_log GROUP BY ip";
$results = $dao->query($sql); // Ensure your DataAccess class has a `query` method

// Array to hold the visit count and country information
$visits = [];

// Function to get the country from IP using IPinfo API
function getCountryFromIP($ip) {
    $accessKey = '58389d8df32ea0'; // Replace with your actual IPinfo API access key
    $url = "https://ipinfo.io/{$ip}/json?token={$accessKey}";

    // Suppress warnings and handle errors gracefully
    $response = @file_get_contents($url);
    if ($response === FALSE) {
        return 'Unknown'; // Return 'Unknown' if the request fails
    }

    $data = json_decode($response, true);
    return isset($data['country']) ? $data['country'] : 'Unknown';
}

// Loop through the results to populate the visits array
if ($results !== false) {
    foreach ($results as $row) {
        $ip = $row['ip'];
        $totalCount = $row['total_count'];
        $country = getCountryFromIP($ip); // Get country from IP

        $visits[] = [
            'ip' => $ip,
            'total_count' => $totalCount,
            'country' => $country
        ];
    }
} else {
    echo "<p>Error fetching visit logs: " . $dao->error . "</p>";
}

// Query to get the most used device types
$sqlDevices = "SELECT vdevice, COUNT(*) AS device_count FROM visit_log GROUP BY vdevice ORDER BY device_count DESC LIMIT 5"; // Limiting to top 5 devices
$deviceResults = $dao->query($sqlDevices);

// Array to hold device type counts
$deviceTypes = [];
if ($deviceResults !== false) {
    foreach ($deviceResults as $deviceRow) {
        $deviceTypes[] = [
            'device' => $deviceRow['vdevice'],
            'count' => $deviceRow['device_count']
        ];
    }
} else {
    echo "<p>Error fetching device types: " . $dao->error . "</p>";
}

// Query for show booking report
$sqlshow = "SELECT s.sid, s.blimit, COUNT(b.showid) AS total_bookings 
    FROM shows s 
    LEFT JOIN bookings b ON s.sid = b.showid 
    GROUP BY s.sid, s.blimit";
$showResults = $dao->query($sqlshow); // Ensure your DataAccess class has a `query` method

// Check if show results are valid
if ($showResults === false) {
    echo "<p>Error fetching show bookings: " . $dao->error . "</p>";
    $showResults = []; // Initialize to an empty array to avoid foreach errors
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visit Log Report</title>
    <style>
        /* Basic styles for the table */
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
    </style>
</head>
<body>

<h1>Visit Logs</h1>
<h3>Total Visits Ever :</h3> <p style="font-size: 40px"><?php echo htmlspecialchars($totalVisits); ?></p> <br><br>
<table>
    <thead>
        <tr>
            <th>IP Address</th>
            <th>Total Visits</th>
            <th>Country</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($visits as $visit): ?>
            <tr>
                <td><?php echo htmlspecialchars($visit['ip']); ?></td>
                <td><?php echo htmlspecialchars($visit['total_count']); ?></td>
                <td><?php echo htmlspecialchars($visit['country']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Most Used Device Types</h2>
<table>
    <thead>
        <tr>
            <th>Device Type</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($deviceTypes as $device): ?>
            <tr>
                <td><?php echo htmlspecialchars($device['device']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Show Booking Report</h2>

<table>
    <thead>
        <tr>
            <th>Show ID</th>
            <th>Booking Limit</th>
            <th>Total Bookings</th>
            <th>Available Spots</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($showResults as $show): ?>
            <tr>
                <td><?php echo htmlspecialchars($show['sid']); ?></td>
                <td><?php echo htmlspecialchars($show['blimit']); ?></td>
                <td><?php echo htmlspecialchars($show['total_bookings']); ?></td>
                <td><?php echo htmlspecialchars($show['blimit'] - $show['total_bookings']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>

<?php 
// Close the DataAccess connection if needed
?>
