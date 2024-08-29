<?php
include('connection.php');

if (isset($_GET['id'])) {
    $user = $_GET['id'];

    // Ensure that the user ID is a number
    if (is_numeric($user)) {
        // Fetch the existing details from the database
        $query = "SELECT `description` FROM `gallery` WHERE `id` = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$user]);
        $gallery_item = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$gallery_item) {
            echo "
            <script>
                alert('No such image found.');
                window.location.href = '../gradalumni/gallery.php';
            </script>
            ";
            exit;
        }
    } else {
        echo "
        <script>
            alert('Invalid Image ID');
            window.location.href = '../gradalumni/gallery.php';
        </script>
        ";
        exit;
    }
} elseif (isset($_POST['submit'])) {
    $user = $_POST['id'];
    $description = $_POST['description'];

    // Ensure that the user ID is a number
    if (is_numeric($user)) {
        try {
            $query = "UPDATE `gallery` SET `description` = ? WHERE `id` = ?";
            $stmt = $conn->prepare($query);
            $query_execute = $stmt->execute([ $description, $user]);

            if ($query_execute) {
                echo "
                <script>
                    alert('Updated Successfully.');
                    window.location.href = '../gradalumni/gallery.php';
                </script>
                ";
            } else {
                echo "
                <script>
                    alert('Failed to Update.');
                    window.location.href = '../gradalumni/gallery.php';
                </script>
                ";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "
        <script>
            alert('Invalid Image ID');
            window.location.href = '../gradalumni/gallery.php';
        </script>
        ";
    }
} else {
    echo "
    <script>
        alert('No image ID provided.');
        window.location.href = '../gradalumni/gallery.php';
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
    <title>Edit Image Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

</head>
<body>
    <h1>Edit Image Details</h1>
    <form action="edit-gallery.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($user); ?>">
        <div>
            <textarea id="description" name="description" placeholder="Image Description" required><?php echo htmlspecialchars($gallery_item['description']); ?></textarea>
        </div>
        <div>
            <button type="submit" name="submit">Update</button>
        </div>
    </form>
</body>
</html>
