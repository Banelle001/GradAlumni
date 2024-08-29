<?php
session_start();
// Database configuration
include '../../model/conn.php';

// Function to sanitize user inputs
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$error = ''; // Initialize the error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);

    // Prepare and bind statements to check user credentials
    $stmt = $conn->prepare("SELECT id, password_hash, role_id, name, surname, email, about, education, skills, job, company FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userId, $passwordHash, $roleId, $name, $surname, $email, $about, $education, $skills, $job, $company);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $passwordHash)) {
            // Set session variables
            $_SESSION['user_id'] = $userId;
            $_SESSION['role_id'] = $roleId;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_surname'] = $surname;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_about'] = $about;
            $_SESSION['user_education'] = $education;
            $_SESSION['user_skills'] = $skills;
            $_SESSION['user_job'] = $job;
            $_SESSION['user_company'] = $company;

            // Update user status to 'online' after successful login
            $updateStatus = "UPDATE users SET status = 'online' WHERE id = $userId";
            mysqli_query($conn, $updateStatus);

            // Redirect based on role
            if ($roleId == 1) { // Alumni
                header("Location: ../../views/public/Alumni_dash.php");
            } elseif ($roleId == 2) { // Staff
                header("Location: ../../views/public/Staff_dash.php");
            }
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "No user found with this email.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
<html lang="en">
<body>
    <?php
    if (!empty($error)) {
        echo "<p style='color:red;'>$error</p>";
    }
    ?>
</body>
</html>
