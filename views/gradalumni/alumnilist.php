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
    <title>Alumni-list | GradConnect</title>
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
                    <!-- Update Modal -->                 
                    <div class="main">
                        <div class="content">
                            <h2>Alumni List</h2>
                            <hr>
                                <div class="search-box pull-left">
                                    <form action="search.php" method="GET">
                                        <input type="text" name="search" placeholder="Search alumni..." required>
                                        <i class="ti-search"></i>
                                    </form>
                                </div>
                            <hr>
                            <table class="table table-hover table-collapse">
                                <thead>
                                    <tr>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Employment Status </th>
                                    <th scope="col">Job</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Degree</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php 
                                    
                                        $stmt = $conn->prepare("SELECT * FROM `users`");
                                        $stmt->execute();

                                        $result = $stmt->fetchAll();

                                        foreach ($result as $row) {
                                            $userID = $row['id'];
                                            $firstName = $row['name'];
                                            $lastName = $row['surname'];
                                            $employment_status = $row['employment_status'];
                                            $job = $row['job'];
                                            $email = $row['email'];
                                            $degree = $row['degree'];

                                        ?>

                                        <tr>
                                            <td id="firstName-<?= $userID ?>"><?php echo $firstName ?></td>
                                            <td id="lastName-<?= $userID ?>"><?php echo $lastName ?></td>
                                            <td id="employment_status-<?= $userID ?>"><?php echo $employment_status ?></td>
                                            <td id="job-<?= $userID ?>"><?php echo $job ?></td>
                                            <td id="email-<?= $userID ?>"><?php echo $email ?></td>
                                            <td id="degree-<?= $userID ?>"><?php echo $degree ?></td>
                                            <td>
                                                <button id="deleteBtn" onclick="delete_user(<?php echo $userID ?>)">&#128465;</button>
                                            </td>
                                        </tr>    

                                        <?php
                                        }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <script>
                        // Update user
                        function update_user(id) {
                            $("#updateUserModal").modal("show");

                            let updateUserID = $("#userID-" + id).text();
                            let updateFirstName = $("#firstName-" + id).text();
                            let updateLastName = $("#lastName-" + id).text();
                            let updateContactNumber = $("#contactNumber-" + id).text();
                            let updateEmail = $("#email-" + id).text();
                            let updateUsername = $("#username-" + id).text();
                            let updatePassword = $("#password-" + id).text();

                            console.log(updateFirstName);
                            console.log(updateLastName);

                            $("#updateUserID").val(updateUserID);
                            $("#updateFirstName").val(updateFirstName);
                            $("#updateLastName").val(updateLastName);
                            $("#updateContactNumber").val(updateContactNumber);
                            $("#updateEmail").val(updateEmail);
                            $("#updateUsername").val(updateUsername);
                            $("#updatePassword").val(updatePassword);

                        }

                        // Delete user
                        function delete_user(id) {
                            if (confirm("Do you want to delete this user?")) {
                                window.location = "./endpoint/delete-user.php?user=" + id;
                            }
                        }


                    </script>
                    </div>

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
