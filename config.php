<?php
// Author: Reema Alsahli
// Description: This code establishes a connection to a MySQL database named 'glamour_shop' on a local server.
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "glamour_shop"; 

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
