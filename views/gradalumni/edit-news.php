<?php
include('connection.php');

if (isset($_GET['id'])) {
    $news_id = $_GET['id'];

    // Ensure that the news ID is a number
    if (is_numeric($news_id)) {
        // Fetch the existing details from the database
        $query = "SELECT `title`, `content` FROM `news` WHERE `id` = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$news_id]);
        $news = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$news) {
            echo "
            <script>
                alert('No such news found.');
                window.location.href = '../gradalumni/news.php';
            </script>
            ";
            exit;
        }
    } else {
        echo "
        <script>
            alert('Invalid News ID');
            window.location.href = '../gradalumni/news.php';
        </script>
        ";
        exit;
    }
} elseif (isset($_POST['submit'])) {
    $news_id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Ensure that the news ID is a number
    if (is_numeric($news_id)) {
        try {
            $query = "UPDATE `news` SET `title` = ?, `content` = ? WHERE `id` = ?";
            $stmt = $conn->prepare($query);
            $query_execute = $stmt->execute([$title, $content, $news_id]);

            if ($query_execute) {
                echo "
                <script>
                    alert('Updated Successfully.');
                    window.location.href = '../gradalumni/news.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Failed to Update.');
                    window.location.href = '../gradalumni/news.php';
                </script>
                ";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "
        <script>
            alert('Invalid News ID');
            window.location.href = '../gradalumni/news.php';
        </script>
        ";
    }
} else {
    echo "
    <script>
        alert('No news ID provided.');
        window.location.href = '../gradalumni/news.php';
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
    <title>Edit News Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

</head>
<body>
    <h1>Edit News Details</h1>
    <form action="edit-news.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($news_id); ?>">
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($news['title']); ?>" required>
        </div>
        <div>
            <label for="content">Content:</label>
            <textarea id="content" name="content" required><?php echo htmlspecialchars($news['content']); ?></textarea>
        </div>
        <div>
            <button type="submit" name="submit">Update</button>
        </div>
    </form>
</body>
</html>
