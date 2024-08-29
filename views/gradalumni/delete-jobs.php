<?php
include ('connection.php');

if (isset($_GET['id'])) {
    $user = $_GET['id'];

    // Ensure that the user ID is a number
    if (is_numeric($user)) {
        try {
            $query = "DELETE FROM careers WHERE id = ?";
            $stmt = $conn->prepare($query);

            // Execute the statement with the user ID
            $query_execute = $stmt->execute([$user]);

            if ($query_execute) {
                echo "
                <script>
                    alert('Job Post deleted Successfully.');
                    window.location.href = '../gradalumni/jobs.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Failed to Delete job post.');
                    window.location.href = '../gradalumni/jobs.php';
                </script>
                ";
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "
        <script>
            alert('Failed');
            window.location.href = '../gradalumni/jobs.php';
        </script>
        ";
    }
}
?>

