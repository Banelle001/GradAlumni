<?php
// Database configuration
include '../../model/conn.php';

if (isset($_POST['comment_id'])) {
    $comment_id = $_POST['comment_id'];

    $query = "DELETE FROM comments WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $comment_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Comment deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete comment']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Comment ID not provided']);
}

$conn->close();
?>