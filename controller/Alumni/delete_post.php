<?php
// Database configuration
include '../../model/conn.php';

if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    $query = "DELETE FROM posts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $post_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Post deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete post']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Post ID not provided']);
}

$conn->close();
?>