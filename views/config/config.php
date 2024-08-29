<?php
require '../../model/conn.php';
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header("Location: ../home.php");
    exit();
}

// Assuming user data is stored in session
$user = [
   'id' => $_SESSION['user_id'] ?? '',
    'name' => $_SESSION['user_name'] ?? '',
    'surname' => $_SESSION['user_surname'] ?? '',
    'email' => $_SESSION['user_email'] ?? '',
    'photo' => $_SESSION['user_photo'] ?? '',
    'about' => $_SESSION['user_about'] ?? '',
    'education' => $_SESSION['user_education'] ?? '',
    'skills' => $_SESSION['user_skills'] ?? '',
    'job' => $_SESSION['user_job'] ?? '',
    'company' => $_SESSION['user_company'] ?? ''
];

$user_name = htmlspecialchars($user['name']);
$user_surname = htmlspecialchars($user['surname']);
$user_email = htmlspecialchars($user['email']);
$user_photo = htmlspecialchars($user['photo']);
$user_about = htmlspecialchars($user['about']);
$user_education = htmlspecialchars($user['education']);
$user_skills = htmlspecialchars($user['skills']);
$user_job = htmlspecialchars($user['job']);
$user_company = htmlspecialchars($user['company']);
$photo_path = $_SESSION['user_photo'] ?? '../img/pic2.png'; // Use a default image if no photo

// Fetch posts created by the logged-in user
$stmt = $conn->prepare("SELECT * from posts ");
$stmt->execute();
$result = $stmt->get_result();

// Prepare and execute the query
$stmt = $conn->prepare("SELECT photo FROM Users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($photoPath);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
