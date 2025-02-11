<?php
session_start(); // Start the session

// Destroy all session variables
session_destroy();

// Redirect to the home page or another page after logout
header("Location: login.php");
exit(); // Ensure no further code is executed
?>
