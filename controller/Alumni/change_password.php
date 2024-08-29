<?php
session_start();
require '../../model/conn.php'; // Adjust the path as needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form inputs
    $currentPassword = $_POST['currentPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Validate that the new password and confirm password match
    if ($newPassword !== $confirmPassword) {
        die("New password and confirm password do not match.");
    }

    // Retrieve the current user's email from the session
    $email = $_SESSION['user_email'];

    // Fetch the current password hash from the database
    $stmt = $conn->prepare("SELECT password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($passwordHash);
    $stmt->fetch();
    $stmt->close();

    // Verify the current password
    if (!password_verify($currentPassword, $passwordHash)) {
        die("Current password is incorrect.");
    }

    // Hash the new password
    $newPasswordHash = password_hash($newPassword, PASSWORD_BCRYPT);

    // Update the password in the database
    $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE email = ?");
    $stmt->bind_param("ss", $newPasswordHash, $email);

    if ($stmt->execute()) {
        echo "Password changed successfully.";
        // Optionally redirect to a different page
        header("Location: ../../views/profile/bio.php");
        exit;
    } else {
        echo "Error changing password: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
