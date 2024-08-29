<?php
session_start();
require '../../model/conn.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        // Create a new post
        $content = $_POST['postContent'];
        $user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session

        $stmt = $conn->prepare("INSERT INTO posts (user_id,content) VALUES ( ?, ?)");
        $stmt->bind_param("is", $user_id, $content );

        if ($stmt->execute()) {
            echo "New post created successfully.";
           
            // Optionally redirect to a different page
             header("Location: ../../views/public/Alumni_dash.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['update'])) {
        // Update an existing post
        $post_id = $_POST['postId'];
        $content = $_POST['postContent'];

        $stmt = $conn->prepare("UPDATE posts SET content = ? WHERE id = ?");
        $stmt->bind_param("si", $content, $post_id);

        if ($stmt->execute()) {
            echo "Post updated successfully.";
              // Optionally redirect to a different page
              header("Location: ../../views/public/Alumni_dash.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        // Delete a post
        $post_id = $_POST['postId'];

        $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $post_id);

        if ($stmt->execute()) {
            echo "Post deleted successfully.";
              // Optionally redirect to a different page
              header("Location: ../../views/public/Alumni_dash.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Close database connection
$conn->close();
?>
