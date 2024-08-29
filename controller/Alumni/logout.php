<?php
session_start();

// Include the database connection file
include '../../model/conn.php';

// Get user ID before clearing session data
$userId = $_SESSION['user_id'];

// Destroy all session data
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Update user status to 'offline' in the database
$updateStatus = "UPDATE users SET status = 'offline' WHERE id = $userId";
mysqli_query($conn, $updateStatus);

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: ../../views/home.php");
exit();
?>
