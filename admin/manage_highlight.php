<?php 
require('../config/autoload.php'); 
include("header.php");

$host = 'localhost'; 
$username = 'root'; 
$password = ''; 
$dbname = 'imca20010'; 
$db = new mysqli($host, $username, $password, $dbname);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$tid = ''; 
$description = '';
$background = '';
$albumName = ''; 


function selectAllTracks($db) {
    $sql = "SELECT tid, album FROM discography GROUP BY album";
    return $db->query($sql)->fetch_all(MYSQLI_ASSOC) ?: [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $sql_truncate = "TRUNCATE TABLE highlight";
    if ($db->query($sql_truncate) === TRUE) {
       
        
       
        if (isset($_FILES['bg_image']) && $_FILES['bg_image']['error'] === UPLOAD_ERR_OK) {
            
            $background = 'bg-' . time() . '.' . pathinfo($_FILES['bg_image']['name'], PATHINFO_EXTENSION);
            
            $uploadPath = '../customer/highlight/' . $background;
            
            if (move_uploaded_file($_FILES['bg_image']['tmp_name'], $uploadPath)) {
                
                $background = $uploadPath; 
            } else {
                echo "<script>alert('Error moving uploaded file.');</script>";
            }
        }


        if (!empty($_POST['featured_track'])) {
            $tid = $_POST['featured_track'];
            $description = $_POST['description'];


            $stmt = $db->prepare("INSERT INTO highlight (background, description, tid) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $background, $description, $tid);
            if ($stmt->execute()) {
                echo "<script>alert('Data saved successfully');</script>";
            } else {
                echo "<script>alert('Error saving data: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }

        
        if (!empty($tid)) {
            $stmt = $db->prepare("SELECT album FROM discography WHERE tid = ?");
            $stmt->bind_param("i", $tid);
            $stmt->execute();
            $result = $stmt->get_result();
            $albumName = $result->fetch_assoc()['album'] ?? ''; 
            $stmt->close();
        }
    } else {
        echo "<script>alert('Error truncating table: " . $db->error . "');</script>";
    }
}


$tracks = selectAllTracks($db);


$highlightData = $db->query("SELECT hid, background, description, tid FROM highlight")->fetch_all(MYSQLI_ASSOC);
?>

<html>
<head>
    <style>

    </style>
</head>
<body>

<form action="" method="POST" enctype="multipart/form-data">
    <h2>Set Featured Album</h2>

    <h3>Background Image</h3>
    <input type="file" name="bg_image" required>

    <h3>Set Featured Album</h3>
    <select name="featured_track" required>
        <option value="">Select an album/single</option>
        <?php foreach ($tracks as $track): ?>
            <option value="<?= $track['tid']; ?>" <?= $track['tid'] == $tid ? 'selected' : ''; ?>><?= htmlspecialchars($track['album']); ?></option>
        <?php endforeach; ?>
    </select>

    <h3>Description</h3>
    <textarea name="description" rows="4" cols="50" placeholder="Enter description for promotion..." required><?= htmlspecialchars($description); ?></textarea>

    <button type="submit">Submit</button>
</form>



<!-- Display highlight data -->
<h3>Current Highlights:</h3>
<table border="1">
    <tr>
        <th>hid</th>
        <th>Background</th>
        <th>Description</th>
        <th>TID</th>
        <th>Album Name</th> 
    </tr>
    <?php foreach ($highlightData as $highlight): ?>
        <?php 
        
        $stmt = $db->prepare("SELECT album FROM discography WHERE tid = ?");
        $stmt->bind_param("i", $highlight['tid']);
        $stmt->execute();
        $result = $stmt->get_result();
        $highlightAlbumName = $result->fetch_assoc()['album'] ?? '';
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
            <td><?= htmlspecialchars($highlight['description']); ?></td>
            <td><?= htmlspecialchars($highlight['tid']); ?></td>
            <td><?= htmlspecialchars($highlightAlbumName); ?></td> 
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>

<?php
$db->close(); 
?>
