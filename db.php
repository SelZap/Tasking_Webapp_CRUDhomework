<?php
// Database connection settings
$servername = "localhost";   // or 127.0.0.1
$username   = "root";        // default in XAMPP
$password   = "";            // default is empty
$dbname     = "crud_app";    // make sure this matches the DB you created

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
