<?php
// Include the configuration file
include '../config/config.php';
require '../../model/conn.php';

// Check if the user is logged in

if (!isset($_SESSION['user_id'])) {
    echo "You need to log in to view your posts.";
    exit;
}

// Prepare SQL statement with error handling
$query = "
    SELECT 
    p.id, 
    p.user_id, 
    p.content, 
    p.created_at, 
    u.name AS user_name
FROM 
    posts p
JOIN 
    users u 
ON 
    p.user_id = u.id 
ORDER BY 
    p.created_at DESC;
";

$stmt = $conn->prepare($query);

if ($stmt === false) {
    // Prepare failed
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

// Execute SQL statement with error handling
if (!$stmt->execute()) {
    // Execute failed
    die('Execute failed: ' . htmlspecialchars($stmt->error));
}

$result = $stmt->get_result();

if ($result === false) {
    // Get result failed
    die('Get result failed: ' . htmlspecialchars($conn->error));
}
//query that fetches user data


// Query to fetch the event date from the database
$sql = "SELECT schedule, title FROM events ORDER BY schedule DESC Limit 4"; // Adjust the query as needed
$results = mysqli_query($conn, $sql);

$events = [];
if ($results) {
    while ($row = mysqli_fetch_assoc($results)) {
        $eventDate = new DateTime($row['schedule']); // Assuming the date is stored in YYYY-MM-DD format
        $day = $eventDate->format('d');
        $month = $eventDate->format('F'); // Full month name
        $events[] = [
            'day' => $day,
            'month' => $month,
            'name' => $row['title'],
            
        ];
    }
} else {
    // Handle the case where the query fails or no events are found
    $events = null;
}
?>



<!doctype html>
<html lang="en">
<head>
    <title>Alumni Dashboard</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/49d89f7fa2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/home2.css">
    <style>
        .custom-section {
            background-color: #fff;
            padding: 20px;
        }
        .h7 {
            font-size: 0.8rem;
        }
        .gedf-wrapper {
            margin-top: 0.97rem;
        }
        @media (min-width: 992px) {
            .gedf-main {
                padding-left: 4rem;
                padding-right: 4rem;
            }
            .gedf-card {
                margin-bottom: 2.77rem;
            }
        }
        .events{
    background-color: #fff;
    padding: 20px 25px 5px;
    margin: 15px 0 15px;
    display: flex;
    justify-content: space-between;
}

.event{
    display: flex;
    font-size: 14px;
    margin-bottom: 10px;
}
.left-event{
    border-radius: 10px;
    height:65px;
    width: 65px;
    margin-right: 15px;
    padding-top: 10px;
    text-align: center;
    position: relative;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.event p{
    font-size: 12px;
}
.event a{
    font-size: 12px;
    text-decoration: none;
    color: #1876f2;
}
.left-event span{
    position:absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    background: #1e5785;
    color: #ffff;
    font-size: 10px;
   
}
.right-sidebar{
    
  flex-basis:24% ;
  position:sticky;
  top:50px;
  align-self: flex-start;
  background: #ffff;
  padding: 20px;
  border-radius: 10px;
  color: #626262;
  

}
.member-list{
  display: flex
  
}
.member-list img{
  width: 20px;
  border-radius: 50%;

}
.image-grid {
  display: grid; 
  grid-template-columns: repeat(4, 1fr);
  grid-template-rows: repeat(4, 1fr);
  gap: 1px;
  padding: 5px;
}


.image-grid img {
  width: 50px;
  height: auto;
  display: block;
  border: 2px solid #ccc;
  border-radius:50%;
  border-bottom: 1px solid #ccc;
}
.main-content{
  
  flex-basis:60%
}
.link-container a{
  text-decoration: none;
  display: flex;
  align-items: center;
  margin-bottom: 30px;
  color: #626262;
  width: fit-content;
  margin-right: 15px;

}
.top-right-sidebar{
  margin-bottom: 10px;
}

.sidebar-title{
  display:flex;
 
  justify-content: space-between;
  margin-bottom: 6px;
  margin-top: 7px;

}
.sidebar-title h4{
  font-weight: 600;
  font-size: 14px;

}
.sidebar-title a{
  text-decoration: none;
  font-size: 12px;
}
    </style>
</head>

<body>
    <?php include '../includes/nav.php'; ?>

    <section class="custom-section">
        <div class="container-fluid gedf-wrapper">
            <div class="row">
                <!-- User Profile Section -->
                <div class="col-md-3">
                    <div class="card" style="padding-right:5px">
                        <div class="card-body">
                        <?php

                            $loggedInUserId = $_SESSION['user_id']; // Adjust 'user_id' to your session variable name

                            $SQL = "SELECT photo FROM users WHERE id=?";
                            $stmt = $conn->prepare($SQL);
                            $stmt->bind_param("i", $loggedInUserId); // Bind the logged-in user's ID
                            $stmt->execute();
                            $res = $stmt->get_result();

                            if ($res->num_rows > 0) {
                                while ($row = $res->fetch_assoc()) {
                                    $profileImage = $row['photo'];
                                    ?>
                                    <div class="text-center mb-3">
                                        <?php if (file_exists($profileImage)): ?>
                                            <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="User Photo" width="150">
                                        <?php else: ?>
                                            <img src="../img/pic2.png" width="150">
                                        <?php endif; ?>
                                    </div>
                                    <?php
                                }
                            } else {
                                echo "No users found.";
                            }

                            // Assuming you have user information stored in session or another source
                            $user_name = $_SESSION['user_name'];
                            $user_surname = $_SESSION['user_surname'];
                            $user_education = $_SESSION['user_education'];
                            $user_company = $_SESSION['user_company'];
                            ?>

                            <h5 class="text-center mb-1"><?php echo htmlspecialchars($user_name) . " " . htmlspecialchars($user_surname); ?></h5><br>
                            <ul class="list-group list-group-flush mb-0">
                                <li class="list-group-item">
                                    <h6 class="mb-1">
                                        <span class="bii bi-mortarboard-fill me-2"></span>
                                        Education
                                    </h6>
                                    <span><?php echo htmlspecialchars($user_education); ?></span>
                                </li>
                                <li class="list-group-item">
                                    <h6 class="mb-1">
                                        <span class="bii bi-building-fill-gear me-2"></span>
                                        Company
                                    </h6>
                                    <span><?php echo htmlspecialchars($user_company); ?></span>
                                </li>
                            </ul>


                        </div>
                    </div>
                </div>
                
                <!-- Posts Section -->
                <div class="col-md-6 gedf-main">
                    <div class="card gedf-card" >
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="posts-tab" data-bs-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">Make a Post</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                                    <div class="form-group">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#postModal" class="modal-trigger">What is on your mind?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-toolbar justify-content-between">
                                <div class="btn-group">
                                    <!-- Modal -->
                                    <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="postModalLabel">Create New Post</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <!-- Modal Body -->
                                                <div class="modal-body">
                                                    <form id="postForm" action="../../controller/Alumni/post.php" method="POST">
                                                        
                                                        <div class="mb-3">
                                                            <label for="postContent" class="form-label">Whats On Your Mind</label>
                                                            <textarea class="form-control" id="postContent" name="postContent" rows="4" placeholder="Enter content" required></textarea>
                                                        </div>
                                                        <!-- Modal Footer inside form -->
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" name="create">Post</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <p>Posts</p>
                    <!-- Post Listings -->
                    <div class="container mt-5">
                    <?php
                        // Prepare SQL statement with error handling
                        $query = "
                            SELECT 
                                p.id, 
                                p.user_id, 
                                p.content, 
                                p.created_at, 
                                u.name AS user_name
                            FROM 
                                posts p
                            JOIN 
                                users u 
                            ON 
                                p.user_id = u.id 
                            ORDER BY 
                                p.created_at DESC;
                        ";

                        $stmt = $conn->prepare($query);

                        if ($stmt === false) {
                            // Prepare failed
                            die('Prepare failed: ' . htmlspecialchars($conn->error));
                        }

                        // Execute SQL statement with error handling
                        if (!$stmt->execute()) {
                            // Execute failed
                            die('Execute failed: ' . htmlspecialchars($stmt->error));
                        }

                        $result = $stmt->get_result();

                        if ($result === false) {
                            // Get result failed
                            die('Get result failed: ' . htmlspecialchars($conn->error));
                        }
                        ?>

                        <div class="container mt-5">
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <div class="card gedf-card mb-3">
                                        <div class="card-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="mr-2">
                                                        <img class="rounded-circle" width="45" src="https://picsum.photos/50/50" alt="">
                                                    </div>
                                                    <div class="ml-2">
                                                        <div class="h5 m-0"><?php echo " ". htmlspecialchars($row['user_name']); ?></div>
                                                        <div class="h7 text-muted"><?php echo htmlspecialchars($row['created_at']); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text">
                                                <?php echo nl2br(htmlspecialchars($row['content'])); ?>
                                            </p>
                                        </div>
                                        <div class="card-footer">
                                            <a href="#" class="card-link"><i class="fa fa-gittip"></i> Like</a>
                                            <a href="#" class="card-link"><i class="fa fa-comment"></i> Comment</a>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <p>No posts found.</p>
                            <?php endif; ?>
                            <?php
                            // Close the statement and connection
                            $stmt->close();
                            $conn->close();
                            ?>
                        </div>

                    </div>
                        
                </div>
                
                <!-- Additional Cards Section -->
                <div class="col-md-3">
                <?php
                    // Make sure to include database connection file
                    include '../../model/conn.php'; // Adjust the path as needed

                    // Ensure the connection is open before using it
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Your HTML and PHP code
                    ?>
                    <div class="card gedf-card">
                        <div class="card" style="width: 22rem;">
                            <div class="card-header">
                               <a href="jobs.php"><h3> Latest job posts </h3></a>
                            </div>
                            <ul class="list-group list-group-flush">
                                <?php
                                // Query to fetch recent jobs
                                $query = "SELECT * FROM careers ORDER BY date_created DESC LIMIT 6";
                                $result = $conn->query($query);

                                if ($result === false) {
                                    echo '<li class="list-group-item">Error executing query: ' . htmlspecialchars($conn->error) . '</li>';
                                } elseif ($result->num_rows > 0) {
                                    // Output jobs
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<li class="list-group-item"><strong>' . htmlspecialchars($row['company']) . '</strong>  ' . htmlspecialchars($row['job_title']) . '</li>';
                                    }
                                } else {
                                    // No jobs available
                                    echo '<li class="list-group-item">No jobs available</li>';
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                   
                    <div class="card gedf-card" style="width: 22rem;">
                    <div class="card-body">
                        <div class="sidebar-title">
                            <h4>Recent Members</h4>
                        </div>

                        <?php 
                        $SQL = "SELECT id, photo, name, surname FROM users ORDER BY id DESC LIMIT 5";
                        $res = $conn->query($SQL);
                        
                        // Check if any users were found
                        if ($res->num_rows > 0) {
                            while ($row = $res->fetch_assoc()) {
                                $userId = $row['id']; // Add user ID
                                $profileImage = $row['photo'];
                                $firstName = $row['name'];
                                $lastName = $row['surname'];

                                // Check if the profile image exists
                                $displayImage = file_exists($profileImage) ? $profileImage : '../img/pic2.png';
                                ?>
                        
                                <div class="d-flex align-items-center" style="margin-bottom: 5px;">
                                    <div class="mr-1" style="padding:10px">
                                        <img class="rounded-circle" width="60" height="60" src="<?php echo htmlspecialchars($displayImage); ?>" alt="">
                                    </div>
                                    <div class="ml-2">
                                        <div class="d-flex align-items-center">
                                            <div class="h5 m-0"><?php echo htmlspecialchars($firstName); ?></div>
                                            <div class="h5 m-0">&nbsp;<?php echo htmlspecialchars($lastName); ?></div>
                                        </div>
                                        <div class="h7 text-muted">
                                            <button onclick="location.href='../public/message/users.php?id=<?php echo $userId; ?>';" style="background-color:#1e5785; font-size: 17px; color:#fff; padding-left:10px;padding-right:8px; border-radius:10px">Message</button>
                                        </div>
                                    </div>
                                </div>
                        
                                <?php
                            }
                        } else {
                            echo "No users found.";
                        }
                        ?>

                    </div>

            </div>

                        


             <div class="card gedf-card" style="width: 22rem;">
                <div class="card-body">
                    <div class="sidebar-title">
                        <h4>Events</h4>
              
                        <a href="events.php">See All</a>
                    </div>
                <?php if ($events): ?>
                    <?php foreach ($events as $event): ?>
                        <div class="event">
                            <div class="left-event">
                                <h3><?php echo $event['day']; ?></h3>
                                <span><?php echo $event['month']; ?></span>
                            </div>
                            <div class="right-event">
                                <p style="font-size: 14px; font-weight:bold; margin-bottom:-2px"><?php echo htmlspecialchars($event['name']); ?></p>
                            
                                <a href="../public/events.php">More Info</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No events found.</p>
                <?php endif; ?>

            </div>
                </div>
            </div>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
