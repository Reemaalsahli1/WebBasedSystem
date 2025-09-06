<?php
// --------------------------------------
//  Layan Alqahtani
// Description: Logout Script
// --------------------------------------

include('header.php'); // Include site header

session_destroy(); // Destroy all session data (logs the user out)
header('Location: index.php'); // Redirect to homepage
exit(); // End script execution
?>
