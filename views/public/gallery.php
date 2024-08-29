<?php
session_start();
?>

<html>
    <header>
    <title>Title</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <script src="https://kit.fontawesome.com/49d89f7fa2.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../css/home2.css">

    </header>
    <body>
      <?php include '../includes/nav.php'; ?>
      <main>
        <h1 style="text-align: center;">Our Gallery</h1>
      </main>
      <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
        
    </body>
    
</html>

<?php
// Connect to database
$db = mysqli_connect("localhost", "root", "", "gradalumni_db");

// Check if connection was successful
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query to fetch images from gallery table
$sql = "SELECT id, filename, description FROM gallery ORDER BY id ASC";
$result = mysqli_query($db, $sql);

// Check if there are any rows returned
if (mysqli_num_rows($result) > 0) {
    echo '<div class="container">';
    echo '<div class="grid-container">';

    // Loop through each row
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $filename = $row['filename'];
        $description = $row['description'];
        $imagePath = "../gradalumni/assets/uploads/gallery/" . $filename;

        echo '<div class="grid-item">';
        echo '<img src="' . $imagePath . '" alt="' . htmlspecialchars($filename) . '" class="gallery-image" style="width: 380px; height: 300px;">';
        echo '<p>' . $description . '</p>';
        echo '</div>';
    }

    echo '</div>';
    echo '</div>';
} else {
    echo "<p>No images found.</p>";
}

mysqli_close($db); // Close database connection
?>

<!-- Add some CSS for grid layout -->
<style>
.container {
    padding: 20px;
}

.grid-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.grid-item {
    border: 1px solid #ddd;
    padding: 15px;
    box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
    background-color: #f9f9f9;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.gallery-image {
    width: 100%; /* Ensure all images take up full width of their container */
    height: auto; /* Maintain aspect ratio */
    margin-bottom: 10px;
}

</style>

<?php include '../includes/footer.php'; ?>
