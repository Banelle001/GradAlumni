<?php
// image.php
// Start the session
session_start();

// Database connection
include('../../model/conn.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: ../login.php");
    exit();
}

// Get the user ID from the session
$userId = $_SESSION['user_id'];

// Fetch the photo from the database
$stmt = $conn->prepare("SELECT photo FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($photo);
$stmt->fetch();
$stmt->close();

// Output the photo as an image
header("Content-Type: image/jpeg");
echo $photo;
?>
