<?php
session_start();
require '../../model/conn.php'; // Adjust path as needed

// Check if the form was submitted and POST data exists
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $first_name = $_POST['first_name'] ?? null;
    $last_name = $_POST['last_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $education = $_POST['education'] ?? null;
    $skills = $_POST['skills'] ?? null;
    $job = $_POST['job'] ?? null;
    $company = $_POST['company'] ?? null;
    $about = $_POST['about'] ?? null;

    // Handle file upload
    $profile_image = $_FILES['profile_image'] ?? null;
    $photo_path = $_SESSION['user_photo'] ?? null;

    if ($profile_image && $profile_image['error'] === UPLOAD_ERR_OK) {
        // Validate and move uploaded file
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $maxFileSize = 5 * 1024 * 1024; // 5 MB

        $fileMimeType = mime_content_type($profile_image['tmp_name']);
        $fileExtension = pathinfo($profile_image['name'], PATHINFO_EXTENSION);
        $fileSize = $profile_image['size'];

        if (!in_array($fileMimeType, $allowedMimeTypes)) {
            die("Invalid file type.");
        }

        if (!in_array($fileExtension, $allowedExtensions)) {
            die("Invalid file extension.");
        }

        if ($fileSize > $maxFileSize) {
            die("File size exceeds the maximum limit of 5MB.");
        }

        $targetDirectory = '../../uploads/';
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        $photo_path = $targetDirectory . uniqid() . '-' . basename($profile_image['name']);
        if (!move_uploaded_file($profile_image['tmp_name'], $photo_path)) {
            die("Error uploading file.");
        }

        // Update session data for photo
        $_SESSION['user_photo'] = $photo_path;
    }

    // Update session data
    $_SESSION['user_name'] = $first_name;
    $_SESSION['user_surname'] = $last_name;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_about'] = $about;
    $_SESSION['user_education'] = $education;
    $_SESSION['user_skills'] = $skills;
    $_SESSION['user_job'] = $job;
    $_SESSION['user_company'] = $company;

    // Update database
    if ($photo_path) {
        $sql = "UPDATE users SET name = ?, surname = ?, email = ?, photo = ?, about = ?, education = ?, skills = ?, job = ?, company = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssssss', $first_name, $last_name, $email, $photo_path, $about, $education, $skills, $job, $company, $_SESSION['user_email']);
    } else {
        // Update without changing the photo
        $sql = "UPDATE users SET name = ?, surname = ?, email = ?, about = ?, education = ?, skills = ?, job = ?, company = ? WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssssssss', $first_name, $last_name, $email, $about, $education, $skills, $job, $company, $_SESSION['user_email']);
    }

    if ($stmt->execute()) {
        echo "Profile updated successfully.";
        header("Location: ../../views/profile/bio.php");
        exit;
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
