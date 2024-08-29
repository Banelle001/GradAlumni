<?php
// Connect to database
$db = mysqli_connect("localhost", "root", "", "gradalumni_db");

// Check if connection was successful
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$event_id = $_POST['event_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$guests = $_POST['guests'];
$requirements = $_POST['requirements'];

// Insert RSVP data into the database
$sql = "INSERT INTO rsvps (event_id, name, email, guests, requirements) VALUES ('$event_id', '$name', '$email', '$guests', '$requirements')";

if (mysqli_query($db, $sql)) {
    echo "<script>alert('RSVP Successful!'); window.location.href = 'events.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($db);
}

mysqli_close($db); // Close database connection
?>
