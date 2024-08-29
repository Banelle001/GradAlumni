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
    <title>RSVP List | GradConnect</title>
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
                    <div class="main">
                        <div class="content">
                            <h2>RSVP List</h2>
                            <hr>
                            <table class="table table-hover table-collapse">
                                <thead>
                                    <tr>
                                        <th scope="col">RSVP ID</th>
                                        <th scope="col">Event ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Guests</th>
                                        <th scope="col">Special Requirements</th>
                                        <th scope="col">RSVP Date</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php 
                                    
                                        $stmt = $conn->prepare("SELECT * FROM `rsvps`");
                                        $stmt->execute();

                                        $result = $stmt->fetchAll();

                                        foreach ($result as $row) {
                                            $rsvpID = $row['id'];
                                            $eventID = $row['event_id'];
                                            $name = $row['name'];
                                            $email = $row['email'];
                                            $guests = $row['guests'];
                                            $requirements = $row['requirements'];
                                            $rsvpDate = $row['rsvp_date'];

                                        ?>

                                        <tr>
                                            <td><?php echo $rsvpID ?></td>
                                            <td><?php echo $eventID ?></td>
                                            <td><?php echo $name ?></td>
                                            <td><?php echo $email ?></td>
                                            <td><?php echo $guests ?></td>
                                            <td><?php echo $requirements ?></td>
                                            <td><?php echo $rsvpDate ?></td>
                                        </tr>    

                                        <?php
                                        }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <script>
                    </script>
                </div>
            </section>
        </main>
    </div>
    <script src="../gradalumni/script/script.js"></script>
    <script src="../gradalumni/script/sec.js"></script>

    <!-- Bootstrap Js -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
