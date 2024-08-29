<?php
session_start();
// Database configuration
include '../../model/conn.php';

// Start session
session_start();

$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

// Handle form submission for creating comments
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_comment'])) {
    $content = $_POST['commentContent'];
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session

    $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $post_id, $user_id, $content);

    if ($stmt->execute()) {
        echo "Comment added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Retrieve comments for the post
$stmt = $conn->prepare("SELECT comments.*, users.user_name FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
?>
