<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'gradalumni_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$status_message = '';

// Insert new post
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_post'])) {
    $description = $conn->real_escape_string($_POST['description']);

    $sql = "INSERT INTO forum_topics (description) VALUES ('$description')";
    if ($conn->query($sql) === TRUE) {
        $status_message = "Post submitted successfully.";
    } else {
        $status_message = "Error: " . $conn->error;
    }
}

// Insert new comment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_comment'])) {
    $comment = $conn->real_escape_string($_POST['comment']);
    $topic_id = $_POST['topic_id']; // Get the topic_id from the form
    $user_id = $_POST['user_id']; // This should be obtained from the logged-in user session

    $sql = "INSERT INTO forum_comment (topic_id, comment, user_id) VALUES ('$topic_id', '$comment', '$user_id')";
    if ($conn->query($sql) === TRUE) {
        $status_message = "Comment submitted successfully.";
    } else {
        $status_message = "Error: " . $conn->error;
    }
}

// Fetch posts
$sql = "SELECT f.*, u.first_name FROM forum_topics f JOIN tbl_user u ON f.id = u.id ORDER BY f.date_created DESC";
$posts = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum | GradConnect</title>
    <link rel="stylesheet" href="../gradalumni/css/admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <ul>
                <img src="https://www.ump.ac.za/images/logo.png" alt="GradConnect Logo" width="80%" height="70%">
                <li><a href="home.php">Home</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="alumnilist.php">Alumni List</a></li>
                <li><a href="jobs.php">Jobs</a></li>
                <li><a href="events.php">Events</a></li>
                <li><a href="news.php">News</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <header class="header">
                <h1>UMP GradConnect System</h1>
            </header>
            <section class="content">
                <div class="container">
                    <h1>Forum</h1>
                    <?php if ($status_message): ?>
                        <div class="alert alert-info">
                            <?php echo $status_message; ?>
                        </div>
                    <?php endif; ?>
                    <form method="post">
                        <input type="hidden" name="user_id" value="1"> <!-- Replace with actual user ID -->
                        <div class="form-group">
                            <textarea name="description" class="form-control" placeholder="Type your post here..." required></textarea>
                        </div>
                        <button type="submit" name="new_post" class="btn btn-primary">Post</button>
                    </form>

                    <?php while ($post = $posts->fetch_assoc()): ?>
                        <div class="post">
                            <p><?php echo htmlspecialchars($post['description']); ?></p>
                            <p>Posted by: <?php echo htmlspecialchars($post['first_name']); ?> on <?php echo $post['date_created']; ?></p>

                            <!-- Fetch comments -->
                            <?php
                            $post_id = $post['id'];
                            $sql = "SELECT fc.*, u.first_name FROM forum_comment fc JOIN tbl_user u ON fc.user_id = u.id WHERE fc.topic_id = $post_id ORDER BY fc.date_created ASC";
                            $comments = $conn->query($sql);
                            ?>

                            <div class="comments">
                                <?php while ($comment = $comments->fetch_assoc()): ?>
                                    <p><?php echo htmlspecialchars($comment['comment']); ?> - <?php echo htmlspecialchars($comment['first_name']); ?> on <?php echo $comment['date_created']; ?></p>
                                <?php endwhile; ?>

                                <form method="post">
                                    <input type="hidden" name="topic_id" value="<?php echo $post['id']; ?>">
                                    <input type="hidden" name="user_id" value="1"> <!-- Replace with actual user ID -->
                                    <div class="form-group">
                                        <textarea name="comment" class="form-control" placeholder="Comment" required></textarea>
                                    </div>
                                    <button type="submit" name="new_comment" class="btn btn-secondary">Comment</button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <hr>
                    <div>
                        <?php
                        // Connect to database
                        $db = mysqli_connect("localhost", "root", "", "gradalumni_db");

                        // Check if connection was successful
                        if (!$db) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        // SQL query to fetch courses from course table
                        $sql = "SELECT * FROM forum_topics ORDER BY id ASC";
                        $result = mysqli_query($db, $sql);

                        // Check if there are any rows returned
                        if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table table-striped">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>ID</th>';
                            echo '<th>Post</th>';
                            echo '<th>Date Created</th>';
                            echo '<th>Actions</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            // Loop through each row
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['id'];
                                $description = $row['description'];
                                $date = $row['date_created'];

                                echo '<tr>';
                                echo '<td>' . $id . '</td>';
                                echo '<td>' . $description . '</td>';
                                echo '<td>' . $date . '</td>';
                                echo '<td>';
                                echo '<a href="edit-forum.php?id=' . $id . '">Edit</a> | '; // Replace edit.php with your edit functionality
                                echo '<a href="delete-forum.php?id=' . $id . '">Delete</a>'; // Replace delete.php with your delete functionality
                                echo '</td>';
                                echo '</tr>';
                            }

                            echo '</tbody>';
                            echo '</table>';
                        } else {
                            echo "<p>No topic found.</p>";
                        }

                        mysqli_close($db); // Close database connection
                        ?>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script src="../gradalumni/script/script.js"></script>
</body>
</html>

<?php $conn->close(); ?>
