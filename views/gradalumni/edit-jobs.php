<?php
include('connection.php');

if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    // Ensure that the course ID is a number
    if (is_numeric($course_id)) {
        // Fetch the existing details from the database
        $query = "SELECT `company`, `job_title`, `location`, `description` FROM `careers` WHERE `id` = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$course_id]);
        $course = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$course) {
            echo "
            <script>
                alert('No such career entry found.');
                window.location.href = '../gradalumni/jobs.php';
            </script>
            ";
            exit;
        }
    } else {
        echo "
        <script>
            alert('Invalid Career ID');
            window.location.href = '../gradalumni/jobs.php';
        </script>
        ";
        exit;
    }
} elseif (isset($_POST['submit'])) {
    $course_id = $_POST['id'];
    $company = $_POST['company'];
    $job_title = $_POST['job_title'];
    $location = $_POST['location'];
    $description = $_POST['description'];

    // Ensure that the course ID is a number
    if (is_numeric($course_id)) {
        try {
            $query = "UPDATE `careers` SET `company` = ?, `job_title` = ?, `location` = ?, `description` = ? WHERE `id` = ?";
            $stmt = $conn->prepare($query);
            $query_execute = $stmt->execute([$company, $job_title, $location, $description, $course_id]);

            if ($query_execute) {
                echo "
                <script>
                    alert('Updated Successfully.');
                    window.location.href = '../gradalumni/jobs.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Failed to Update.');
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
            alert('Invalid Career ID');
            window.location.href = '../gradalumni/jobs.php';
        </script>
        ";
    }
} else {
    echo "
    <script>
        alert('No career ID provided.');
        window.location.href = '../gradalumni/jobs.php';
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
    <title>Edit Career Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

</head>
<body>
    <h1>Edit Career Details</h1>
    <form action="edit-jobs.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($course_id); ?>">
        <div>
            <label for="company">Company:</label>
            <input type="text" id="company" name="company" value="<?php echo htmlspecialchars($course['company']); ?>" required>
        </div>
        <div>
            <label for="job_title">Job Title:</label>
            <input type="text" id="job_title" name="job_title" value="<?php echo htmlspecialchars($course['job_title']); ?>" required>
        </div>
        <div>
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($course['location']); ?>" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($course['description']); ?></textarea>
        </div>
        <div>
            <button type="submit" name="submit">Update</button>
        </div>
    </form>
</body>
</html>
