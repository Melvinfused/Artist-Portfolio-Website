<?php 

require('../config/autoload.php'); 

$dao = new DataAccess();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the input

    // Check if the ID exists before attempting to delete
    $info = $dao->getData('*', 'shows', 'sid=' . $id);

    if ($info) {
        // Perform the delete operation
        if ($dao->delete('shows', 'sid=' . $id)) {
            // Redirect with success message
            header('Location: manage_shows.php?msg=deleted');
            exit();
        } else {
            // Redirect with error message
            header('Location: manage_shows.php?msg=error');
            exit();
        }
    } else {
        // Redirect with invalid ID message
        header('Location: manage_shows.php?msg=invalid');
        exit();
    }
} else {
    // Redirect with no ID message
    header('Location: manage_shows.php?msg=invalid');
    exit();
}
?>