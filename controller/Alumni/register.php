<?php
session_start();

// Include database connection
include '../../model/conn.php'; // Adjust this path according to your folder structure

// Function to sanitize user inputs
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to validate the uploaded file
function validate_upload($file) {
    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    $maxFileSize = 5 * 1024 * 1024; // 5 MB

    $fileMimeType = mime_content_type($file['tmp_name']);
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileSize = $file['size'];

    if (!in_array($fileMimeType, $allowedMimeTypes)) {
        return "Invalid file type. Only JPEG, PNG, and GIF are allowed.";
    }

    if (!in_array($fileExtension, $allowedExtensions)) {
        return "Invalid file extension. Only jpg, jpeg, png, and gif are allowed.";
    }

    if ($fileSize > $maxFileSize) {
        return "File size exceeds the maximum limit of 5MB.";
    }

    return null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = sanitize_input($_POST['name'] ?? '');
    $surname = sanitize_input($_POST['surname'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $degree = sanitize_input($_POST['degree'] ?? '');
    $password = sanitize_input($_POST['password'] ?? '');
    $confirmPassword = sanitize_input($_POST['confirmPassword'] ?? '');
    $category = sanitize_input($_POST['category'] ?? '');
    $termsAccepted = isset($_POST['terms']) ? 1 : 0;

    // File upload handling
    $photo = "";
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $uploadError = validate_upload($_FILES['photo']);
        if ($uploadError) {
            die($uploadError);
        }

        $targetDirectory = '../../uploads/';
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        $photo = $targetDirectory . uniqid() . '-' . basename($_FILES['photo']['name']);
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photo)) {
            die("Error uploading file.");
        }
    }

    // Validate passwords
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Prepare and bind statements
    $stmt = $conn->prepare("INSERT INTO Users (photo, name, surname, email,degree, password_hash, role_id, terms_accepted) VALUES (?, ?,? ,?, ?, ?, ?, ?)");
    $roleId = ($category == '1') ? 1 : 2; // 1 for Alumni, 2 for Staff
    $stmt->bind_param("sssssssi", $photo, $name, $surname, $email, $degree, $passwordHash, $roleId, $termsAccepted);

    if ($stmt->execute()) {
        $userId = $stmt->insert_id;

        // Insert into specific table based on role
        if ($category == '1') { // Alumni
            $graduationYear = sanitize_input($_POST['graduationYear'] ?? '');
            $studentNumber = sanitize_input($_POST['studentNumber'] ?? '');

            $stmt = $conn->prepare("INSERT INTO Alumni (user_id, graduation_year, student_number) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $userId, $graduationYear, $studentNumber);
        } elseif ($category == '2') { // Staff
            $staffNumber = sanitize_input($_POST['staffNumber'] ?? '');

            $stmt = $conn->prepare("INSERT INTO Staff (user_id, staff_number) VALUES (?, ?)");
            $stmt->bind_param("is", $userId, $staffNumber);
        }

        if ($stmt->execute()) {
            echo "Registered successfully.";
            // Optionally redirect to a different page
            header("Location: ../../views/home.php");
            exit;
        } else {
            echo "Error registering: " . $stmt->error;
        }
    } else {
        echo "Error registering: " . $stmt->error;
    }

    // Close statements and connection
    $stmt->close();
    $conn->close();
}
?>
