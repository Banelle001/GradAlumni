<?php
include('connection.php');

if (isset($_GET['id'])) {
    $topic_id = $_GET['id'];

    // Ensure that the topic ID is a number
    if (is_numeric($topic_id)) {
        // Fetch the existing details from the database
        $query = "SELECT  `description` FROM `forum_topics` WHERE `id` = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$topic_id]);
        $topic = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$topic) {
            echo "
            <script>
                alert('No such topic found.');
                window.location.href = '../gradalumni/forum.php';
            </script>
            ";
            exit;
        }
    } else {
        echo "
        <script>
            alert('Invalid Topic ID');
            window.location.href = '../gradalumni/forum.php';
        </script>
        ";
        exit;
    }
} elseif (isset($_POST['submit'])) {
    $topic_id = $_POST['id'];
    $description = $_POST['description'];

    // Ensure that the topic ID is a number
    if (is_numeric($topic_id)) {
        try {
            $query = "UPDATE `forum_topics` SET `description` = ? WHERE `id` = ?";
            $stmt = $conn->prepare($query);
            $query_execute = $stmt->execute([ $description, $topic_id]);

            if ($query_execute) {
                echo "
                <script>
                    alert('Updated Successfully.');
                    window.location.href = '../gradalumni/forum.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Failed to Update.');
                    window.location.href = '../gradalumni/forum.php';
                </script>
                ";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "
        <script>
            alert('Invalid Topic ID');
            window.location.href = '../gradalumni/forum.php';
        </script>
        ";
    }
} else {
    echo "
    <script>
        alert('No topic ID provided.');
        window.location.href = '../gradalumni/forum.php';
    </script>
    ";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Forum Topic Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

</head>
<body>
    <h1>Edit Forum Topic Details</h1>
    <form action="edit-forum.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($topic_id); ?>">
       
        <div>
            <label for="description">Update your post here :</label><br>
            <textarea id="description" name="description" ><?php echo htmlspecialchars($topic['description']); ?></textarea>
        </div>
        <div>
            <button type="submit" name="submit">Update</button>
        </div>
    </form>
</body>
</html>
