
<?php
session_start();

include('connection.php');


// Session timeout duration (in seconds)
$timeout_duration = 3000; // 5 minutes

// Check for session timeout
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();     
    session_destroy();   
    header("Location: logout.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery | GradConnect</title>
    <link rel="stylesheet" href="../gradalumni/css/admin.css">
    <link rel="stylesheet" href="../gradalumni/css/table.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

</head>
<body>
    <div class="dashboard">
    <aside class="sidebar">
            <ul>
                <img src="https://www.ump.ac.za/images/logo.png" alt="GradConnect Logo" width="80%" height="70%">
                <hr>
                <li><a href="home.php"><img width="30" height="30" src="https://img.icons8.com/3d-fluency/94/control-panel.png" alt="control-panel"/>Dashboard</a></li>
                <li><a href="gallery.php"><img width="30" height="30" src="https://img.icons8.com/color/48/image-gallery.png" alt="image-gallery"/>Gallery</a></li>
                <li><a href="alumnilist.php"><img width="30" height="30" src="https://img.icons8.com/fluency/48/overview-pages-3.png" alt="overview-pages-3"/>Alumni List</a></li>
                <li><a href="jobs.php"><img width="30" height="30" src="https://img.icons8.com/stickers/100/new-job.png" alt="new-job"/>Jobs</a></li>
                <li><a href="events.php"><img width="30" height="30" src="https://img.icons8.com/fluency/48/event-accepted--v1.png" alt="event-accepted--v1"/>Events</a></li>
                <li><a href="news.php"><img width="30" height="30" src="https://img.icons8.com/3d-fluency/94/news.png" alt="news"/>News</a></li>
                <li><a href="rsvplist.php"><img width="30" height="30" src="https://img.icons8.com/external-flaticons-lineal-color-flat-icons/64/external-rsvp-event-management-flaticons-lineal-color-flat-icons-3.png" alt="external-rsvp-event-management-flaticons-lineal-color-flat-icons-3"/>RSVP List</a></li>
                <li><a href="logout.php"><img width="30" height="30" src="https://img.icons8.com/matisse/100/exit.png" alt="exit"/>Logout</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <header class="header">
                <h3>UMP GradConnect System</h3>
            </header>
            <section class="content">
                <div class="container">
                    <h1>Gallery</h1>
                    <div>
                        <!-- Form for uploading images -->
                        <div id="content">
                            <form method="POST" action="" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input class="form-control" type="file" name="uploadfile" value="" required />
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Short Description</label>
                                    <textarea class="form-control" name='description' ></textarea>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <?php
                    if (isset($_POST['upload'])) {
                        $filename = $_FILES["uploadfile"]["name"]; // Get the filename
                        $tempname = $_FILES["uploadfile"]["tmp_name"]; // Get the temporary filename
                        $folder = "./assets/uploads/gallery/" . $filename; // Destination folder path
                    
                        // Connect to database
                        $db = mysqli_connect("localhost", "root", "", "gradalumni_db");
                    
                        // Check if connection was successful
                        if (!$db) {
                            die("Connection failed: " . mysqli_connect_error());
                        }
                    
                        // Escape the filename to prevent SQL injection
                        $description = mysqli_real_escape_string($db, $_POST['description']);
                        $escaped_filename = mysqli_real_escape_string($db, $filename);
                    
                        // Check if the file already exists in the database
                        $check_query = "SELECT filename FROM gallery WHERE filename = '$escaped_filename'";
                        $check_result = mysqli_query($db, $check_query);
                    
                        if (mysqli_num_rows($check_result) > 0) {
                            echo "<h3>File already exists in the gallery!</h3>";
                        } else {
                            // SQL query to insert filename into the gallery table
                            $sql = "INSERT INTO gallery (filename , description) VALUES ('$escaped_filename','$description')";
                    
                            // Execute query
                            if (mysqli_query($db, $sql)) {
                                // If the query was successful, move the uploaded file to the destination folder
                                if (move_uploaded_file($tempname, $folder)) {
                                    echo "<h3>Image uploaded successfully!</h3>";
                                } else {
                                    echo "<h3>Failed to move uploaded file!</h3>";
                                }
                            } else {
                                echo "<h3>Error: " . $sql . "<br>" . mysqli_error($db) . "</h3>";
                            }
                        }
                    
                        mysqli_close($db); // Close database connection
                    }

                    ?>
                    <hr>
                    <div>
                        <?php
                            // Connect to database
                            $db = mysqli_connect("localhost", "root", "", "gradalumni_db");

                            // Check if connection was successful
                            if (!$db) {
                                die("Connection failed: " . mysqli_connect_error());

                            }


                            // SQL query to fetch images from gallery table
                            $sql = "SELECT id, filename,description, created FROM gallery ORDER BY id ASC";
                            $result = mysqli_query($db, $sql);

                            // Check if there are any rows returned
                            if (mysqli_num_rows($result) > 0) {
                                echo '<table class="table table-striped">';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th>ID</th>';
                                echo '<th>Image</th>';
                                echo '<th>Description</th>';
                                echo '<th>Date</th>';
                                echo '<th>Actions</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';

                                // Loop through each row
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['id'];
                                    $filename = $row['filename'];
                                    $upload_date = $row['created'];
                                    $description = $row['description'];
                                    $imagePath = "./assets/uploads/gallery/" . $filename;

                                    echo '<tr>';
                                    echo '<td>' . $id . '</td>';
                                    echo '<td><img src="' . $imagePath . '" alt="' . $filename . '" style="max-width: 100px; max-height: 100px;"></td>';
                                    echo '<td>' . $description . '</td>';
                                    echo '<td>' . $upload_date . '</td>';
                                    echo '<td>';
                                    echo '<a href="edit-gallery.php?id=' . $id . '">Edit</a> | '; // Replace edit.php with your edit functionality
                                    echo '<a href="delete-gallery.php?id=' . $id . '">Delete</a>'; // Replace delete.php with your delete functionality
                                    echo '</td>';
                                    echo '</tr>';
                                }

                                echo '</tbody>';
                                echo '</table>';
                            } else {
                                echo "<p>No images found.</p>";
                            }

                            mysqli_close($db); // Close database connection
                            ?>
                         </div>
                </div>
            </section>
        </main>
    </div>
    <script src="../gradalumni/script/script.js"></script>
    <script src="../gradalumni/script/sec.js"></script>

    
</body>
</html>
