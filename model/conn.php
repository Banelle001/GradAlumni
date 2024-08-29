<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gradalumni_db"; // Ensure this is set to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>