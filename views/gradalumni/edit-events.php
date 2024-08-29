<?php
include('connection.php');

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Ensure that the event ID is a number
    if (is_numeric($event_id)) {
        // Fetch the existing details from the database
        $query = "SELECT `title`, `venue`, `content`, `schedule` FROM `events` WHERE `id` = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$event_id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$event) {
            echo "
            <script>
                alert('No such event found.');
                window.location.href = '../gradalumni/events.php';
            </script>
            ";
            exit;
        }
    } else {
        echo "
        <script>
            alert('Invalid Event ID');
            window.location.href = '../gradalumni/events.php';
        </script>
        ";
        exit;
    }
} elseif (isset($_POST['submit'])) {
    $event_id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $venue = $_POST['venue'];
    $schedule = $_POST['schedule'];

    // Ensure that the event ID is a number
    if (is_numeric($event_id)) {
        try {
            $query = "UPDATE `events` SET `title` = ?, `venue` = ?, `content` = ?, `schedule` = ? WHERE `id` = ?";
            $stmt = $conn->prepare($query);
            $query_execute = $stmt->execute([$title, $venue, $content, $schedule, $event_id]);

            if ($query_execute) {
                echo "
                <script>
                    alert('Updated Successfully.');
                    window.location.href = '../gradalumni/events.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Failed to Update.');
                    window.location.href = '../gradalumni/events.php';
                </script>
                ";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "
        <script>
            alert('Invalid Event ID');
            window.location.href = '../gradalumni/events.php';
        </script>
        ";
    }
} else {
    echo "
    <script>
        alert('No event ID provided.');
        window.location.href = '../gradalumni/events.php';
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
    <title>Edit Event Details</title>
</head>
<body>
    <h1>Edit Event Details</h1>
    <form action="edit-events.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($event_id); ?>">
        <div>
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>
        </div>
        <div>
            <label for="content">Content:</label><br>
            <textarea id="content" name="content" required><?php echo htmlspecialchars($event['content']); ?></textarea>
        </div>
        <div>
            <label for="venue">Venue:</label><br>
            <input type="text" id="venue" name="venue" value="<?php echo htmlspecialchars($event['venue']); ?>" required>
        </div>
        <div>
            <label for="schedule">Schedule:</label><br>
            <input type="datetime-local" id="schedule" name="schedule" value="<?php echo htmlspecialchars($event['schedule']); ?>" required>
        </div>
        <div>
            <button type="submit" name="submit">Update</button>
        </div>
    </form>
</body>
</html>
