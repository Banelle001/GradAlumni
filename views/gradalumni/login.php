<?php
// Connect to the database
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $identifier = $_POST['identifier'];
    $password = $_POST['password'];

    try {
        // Query to find the user
        $sql = "SELECT * FROM alumni WHERE email = ? OR student_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$identifier, $identifier]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Debugging steps
        if ($user === false) {
            echo "No user found with the provided email or student number.";
        } else {
            if (password_verify($password, $user['password'])) {
                echo "Login successful!";
                // Start a session and redirect to a logged-in page
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header("Location: forum.php");
                exit;
            } else {
                echo "Password does not match!";
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Alumni Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="login.php">
        <label for="identifier">Email or Student Number:</label><br>
        <input type="text" id="identifier" name="identifier" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
