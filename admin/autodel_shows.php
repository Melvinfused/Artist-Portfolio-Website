<?php
$host = 'localhost';
$username = 'root'; 
$password = '';  
$database = 'imca20010'; 

$connection = new mysqli($host, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$currentDate = date('Y-m-d');
$query = "DELETE FROM shows WHERE sdate < '$currentDate'";

$result = $connection->query($query);

if ($result) {
    $affectedRows = $connection->affected_rows;
    echo "Outdated shows deleted successfully.";
} else {
    echo "Error deleting outdated shows: " . $connection->error;
}

$connection->close();
?>
