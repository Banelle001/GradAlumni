<?php
include ('connection.php');

if (isset($_GET['id'])) {
    $user = $_GET['id'];

    // Ensure that the user ID is a number
    if (is_numeric($user)) {
        try {
            $query = "DELETE FROM forum_topics WHERE id = ?";
            $stmt = $conn->prepare($query);

            // Execute the statement with the user ID
            $query_execute = $stmt->execute([$user]);

            if ($query_execute) {
                echo "
                <script>
                    alert('Post deleted Successfully.');
                    window.location.href = 'http://localhost/gradalumni/forum.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Failed to delete Post.');
                    window.location.href = 'http://localhost/gradalumni/events.php';
                </script>
                ";
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "
        <script>
            alert('FAILED');
            window.location.href = 'http://localhost/gradalumni/events.php';
        </script>
        ";
    }
}
?>

