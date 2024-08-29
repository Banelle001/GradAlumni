<?php
session_start();

include('connection.php'); 

$timeout_duration = 3000; // 5 minutes

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();     
    session_destroy();   
    header("Location: logout.php"); 
    exit();
}

$_SESSION['last_activity'] = time(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs | GradConnect</title>
    <link rel="stylesheet" href="../gradalumni/css/admin.css">
    <link rel="stylesheet" href="../gradalumni/css/table.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script>
    tinymce.init({
        selector: 'textarea#description',
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
        toolbar: 'undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        menubar: false,
        height: 300
    });
</script>

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
                    <h1>Jobs | Careers</h1>
                    <div id="content">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label">Company</label>
                                <input type="text" class="form-control" name="company" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Location</label>
                                <input type="text" class="form-control" name="location" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Job Title</label>
                                <input type="text" class="form-control" name="job_title" required>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Category</label>
                                <select id="category" name="category">
                                    <option value="technology">Technology</option>
                                    <option value="agriculture">Agriculture</option>
                                    <option value="education">Education</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <textarea class="form-control" name="description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Closing Date</label>
                                <input type="text" class="form-control" name="closing_date" required>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <?php
                    if (isset($_POST['upload'])) {
                        // Connect to database
                        $db = mysqli_connect("localhost", "root", "", "gradalumni_db");
                    
                        if (!$db) {
                            die("Connection failed: " . mysqli_connect_error());
                        }
                    
                        $stmt = $db->prepare("INSERT INTO careers (company, location, job_title, description ,category, date_created , closing_date) VALUES (?, ?, ? ,?, ? ,?, ?)");
                        $stmt->bind_param("sssssss", $company, $location, $job_title, $description,$category, $date_created ,$closing_date);
                        
                        $company = $_POST['company'];
                        $location = $_POST['location'];
                        $job_title = $_POST['job_title'];
                        $description = $_POST['description'];
                        $category = $_POST['category'];
                        $closing_date =$_POST['closing_date'];
                        $date_created = date('Y-m-d H:i:s');

                        if ($stmt->execute()) {
                            echo "<h3>Job uploaded successfully!</h3>";
                        } else {
                            echo "<h3>Error: " . $stmt->error . "</h3>";
                        }

                        $stmt->close();
                        $db->close();
                    }
                    ?>
                    <hr>
                    <div>
                        <?php
                        // Connect to database
                        $db = mysqli_connect("localhost", "root", "", "gradalumni_db");

                        if (!$db) {
                            die("Connection failed: " . mysqli_connect_error());
                        }

                        $sql = "SELECT id, company, location, job_title, description , category , date_created , closing_date FROM careers ORDER BY id ASC";
                        $result = mysqli_query($db, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            echo '<table class="table table-striped">';
                            echo '<thead><tr><th>ID</th><th>Company</th><th>Location</th><th>Job Title</th><th>Description</th><th>Category</th><th>Date Created</th><th>Closing Date</th><th>Actions</th></tr></thead>';
                            echo '<tbody>';

                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . $row['id'] . '</td>';
                                echo '<td>' . $row['company'] . '</td>';
                                echo '<td>' . $row['location'] . '</td>';
                                echo '<td>' . $row['job_title'] . '</td>';
                                echo '<td>' . $row['description'] . '</td>';
                                echo '<td>' . $row['category'] . '</td>';
                                echo '<td>' . $row['date_created'] . '</td>';
                                echo '<td>' . $row['closing_date'] . '</td>';
                                echo '<td>';
                                echo '<a href="edit-jobs.php?id=' . $row['id'] . '">Edit</a> | ';
                                echo '<a href="delete-jobs.php?id=' . $row['id'] . '">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }

                            echo '</tbody></table>';
                        } else {
                            echo "<p>No jobs found.</p>";
                        }

                        mysqli_close($db);
                        ?>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script src="../gradalumni/script/script.js"></script>
    <script src="../gradalumni/script/sec.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

</body>
</html>
