<?php
// Connect to the database
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $student_number = $_POST['student_number'];
    $graduation_year = $_POST['graduation_year'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation
    if ($password !== $confirm_password) {
        echo "Passwords do not match!";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Insert data into the database
        $sql = "INSERT INTO alumni (name, surname, email, student_number, graduation_year, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $surname, $email, $student_number, $graduation_year, $hashed_password]);

        echo "Registration successful!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Alumni Registration</title>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="register.php">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>
        <label for="surname">Surname:</label><br>
        <input type="text" id="surname" name="surname" required><br><br>
        <label for="email">School Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="student_number">Student Number:</label><br>
        <input type="text" id="student_number" name="student_number" required><br><br>
        <label for="graduation_year">Graduation Year:</label><br>
        <input type="text" id="graduation_year" name="graduation_year" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <label for="confirm_password">Confirm Password:</label><br>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        <button type="submit">Register</button>
    </form>
</body>
</html>
