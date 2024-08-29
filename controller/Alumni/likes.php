<?php
session_start();
require '../../model/conn.php';

// Start session
session_start();

$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session

// Handle like or unlike action
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['like'])) {
        // Like the post
        $stmt = $conn->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $post_id, $user_id);

        if ($stmt->execute()) {
            echo "Post liked.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['unlike'])) {
        // Unlike the post
        $stmt = $conn->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->bind_param("ii", $post_id, $user_id);

        if ($stmt->execute()) {
            echo "Post unliked.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Check if the user has already liked the post
$stmt = $conn->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ? AND user_id = ?");
$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$has_liked = $result->fetch_column() > 0;

// Retrieve like count for the post
$stmt = $conn->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$like_count = $result->fetch_column();
?>