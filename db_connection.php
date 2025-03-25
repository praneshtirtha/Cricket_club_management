<?php
// Database connection parameters
$servername = "localhost"; // Usually 'localhost' for local servers
$username = "root"; // Default MySQL username on local XAMPP
$password = ""; // Default password is empty for XAMPP
$dbname = "cricketclubmanagement_updated"; // Your database name

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
