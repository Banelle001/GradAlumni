<?php
include ('connection.php');

if (isset($_GET['user'])) {
    $user = $_GET['user'];

    try {

        $query = "DELETE FROM `users` WHERE `id` = '$user'";

        $stmt = $conn->prepare($query);

        $query_execute = $stmt->execute();

        if ($query_execute) {
            echo "
            <script>
                alert('User Deleted Successfully');
                window.location.href = '../alumnilist.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Failed to delete user');
                window.location.href = '../alumnilist.php';
            </script>
            ";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>