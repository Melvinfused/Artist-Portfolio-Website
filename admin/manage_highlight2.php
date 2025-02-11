<?php 
require('../config/autoload.php'); 
include("header.php");

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

// Initialize variables
$sid = ''; 
$background = '';
$showName = ''; // Variable to store the show name
$venue = ''; // Variable to store the venue

// Function to fetch all shows from the database
function selectAllShows($db) {
    $sql = "SELECT sid, sname, venue FROM shows";
    return $db->query($sql)->fetch_all(MYSQLI_ASSOC) ?: [];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Truncate the table before inserting new data
    $sql_truncate = "TRUNCATE TABLE highlight2";
    if ($db->query($sql_truncate) === TRUE) {
        // Proceed if table truncation was successful
        
        // Upload background image
        if (isset($_FILES['bg_image']) && $_FILES['bg_image']['error'] === UPLOAD_ERR_OK) {
            // Generate unique file name for the image
            $background = 'bg-' . time() . '.' . pathinfo($_FILES['bg_image']['name'], PATHINFO_EXTENSION);
            // Move the uploaded file to the desired directory
            $uploadPath = '../customer/highlight2/' . $background;
            
            if (move_uploaded_file($_FILES['bg_image']['tmp_name'], $uploadPath)) {
                // Save the full path in the database
                $background = $uploadPath; // Store the full path to the file
            } else {
                echo "<script>alert('Error moving uploaded file.');</script>";
            }
        }

        // Save featured show and background
        if (!empty($_POST['featured_show'])) {
            $sid = $_POST['featured_show'];

            // Prepare and execute the insert statement
            $stmt = $db->prepare("INSERT INTO highlight2 (background, sid) VALUES (?, ?)");
            $stmt->bind_param("si", $background, $sid);
            if ($stmt->execute()) {
                echo "<script>alert('Data saved successfully');</script>";
            } else {
                echo "<script>alert('Error saving data: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }

        // Fetch the show name and venue based on sid
        if (!empty($sid)) {
            $stmt = $db->prepare("SELECT sname, venue FROM shows WHERE sid = ?");
            $stmt->bind_param("i", $sid);
            $stmt->execute();
            $result = $stmt->get_result();
            $showData = $result->fetch_assoc();
            $showName = $showData['sname'] ?? ''; // Fetch show name or set to empty if not found
            $venue = $showData['venue'] ?? ''; // Fetch venue or set to empty if not found
            $stmt->close();
        }
    } else {
        echo "<script>alert('Error truncating table: " . $db->error . "');</script>";
    }
}

// Fetch available shows
$shows = selectAllShows($db);

// Fetch highlight data from highlight2 table
$highlightData = $db->query("SELECT hid, background, sid FROM highlight2")->fetch_all(MYSQLI_ASSOC);
?>

<html>
<head>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>

<form action="" method="POST" enctype="multipart/form-data">
    <h2>Set Featured Show</h2>

    <h3>Background Image</h3>
    <input type="file" name="bg_image" required>

    <h3>Set Featured Show</h3>
    <select name="featured_show" required>
        <option value="">Select a show</option>
        <?php foreach ($shows as $show): ?>
            <option value="<?= $show['sid']; ?>" <?= $show['sid'] == $sid ? 'selected' : ''; ?>>
                <?= htmlspecialchars($show['sname']) . ' (' . htmlspecialchars($show['venue']) . ')'; ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Submit</button>
</form>

<!-- Display selected show details -->
<?php if ($sid): ?>
    <h2>Featured Show: <?= htmlspecialchars($showName); ?> at <?= htmlspecialchars($venue); ?></h2>
<?php endif; ?>

<!-- Display highlight2 data -->
<h3>Current Highlights:</h3>
<table border="1">
    <tr>
        <th>hid</th>
        <th>Background</th>
        <th>SID</th>
        <th>Show Name</th> <!-- Add a new column for the show name -->
        <th>Venue</th> <!-- Add a new column for the venue -->
    </tr>
    <?php foreach ($highlightData as $highlight): ?>
        <?php 
        // Fetch the show name and venue for each highlight
        $stmt = $db->prepare("SELECT sname, venue FROM shows WHERE sid = ?");
        $stmt->bind_param("i", $highlight['sid']);
        $stmt->execute();
        $result = $stmt->get_result();
        $highlightShowData = $result->fetch_assoc();
        $highlightShowName = $highlightShowData['sname'] ?? ''; // Fetch show name or set to empty if not found
        $highlightVenue = $highlightShowData['venue'] ?? ''; // Fetch venue or set to empty if not found
        $stmt->close();
        ?>
        <tr>
            <td><?= htmlspecialchars($highlight['hid']); ?></td>
            <td>
                <?php if (!empty($highlight['background'])): ?>
                    <img src="<?= htmlspecialchars($highlight['background']); ?>" alt="Background Image" style="max-width: 100px;">
                <?php else: ?>
                    No Image
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($highlight['sid']); ?></td>
            <td><?= htmlspecialchars($highlightShowName); ?></td> <!-- Display show name -->
            <td><?= htmlspecialchars($highlightVenue); ?></td> <!-- Display venue -->
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

<?php
$db->close(); // Close the database connection
?>
