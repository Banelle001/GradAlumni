<?php
// Include the configuration file and database connection
include '../config/config.php';
require '../../model/conn.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You need to log in to view your posts.";
    exit;
}

$user_id = $_SESSION['user_id'];

?>

<!doctype html>
<html lang="en">
<head>
    <title>Jobs</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/49d89f7fa2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/home2.css">

    <style>
        .custom-section {
            padding: 20px;
            background-color: #fff;
        }
        .content-row {
            display: flex;
            width: 100%;
        }
        .left-sidebar {
            width: 250px;
            background-color: #fff;
            border-right: 1px solid #e0e0e0;
            padding: 10px;
            border-radius: 30px;
        }
        .link-container {
            display: flex;
            flex-direction: column;
            height: 20px;
        }
        .link-container a {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            text-decoration: none;
            color: #1e5785;
            font-size: 16px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .link-container a:hover {
            background-color: #ee930c;
            color: #1e5785;
        }
        .link-container i {
            margin-right: 10px;
            font-size: 22px;
        }
        .middle-card {
            flex: 1;
            padding: 10px;
            background-color: #fff;
        }
        .card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .card hr {
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <?php include '../includes/nav.php'; ?>

    <section class="custom-section">
        <div class="container">
            <div>
                <h1 style="text-align: center;">Jobs</h1>
            </div>
            <div style="display: flex; justify-content: center; padding: 10px; background-color: #f8f9fa;">
                <nav style="display: flex; list-style: none; gap: 15px;">
                    <li class="nav-item"><a href="#technology" class="nav-link" style="text-decoration: none; color: #007bff;">Technology</a></li>
                    <li class="nav-item"><a href="#agriculture" class="nav-link" style="text-decoration: none; color: #007bff;">Agriculture</a></li>
                    <li class="nav-item"><a href="#education" class="nav-link" style="text-decoration: none; color: #007bff;">Education</a></li>
                    <li class="nav-item"><a href="#other" class="nav-link" style="text-decoration: none; color: #007bff;">Other</a></li>
                </nav>
            </div>

            <div class="content-row">
                
                <div class="middle-card">
                    <!-- Dynamic Job Listings -->
                    <?php
                    $categories = ['Technology', 'Agriculture', 'Education', 'Other'];
                    foreach ($categories as $category) {
                        // Assign an ID based on the category name (lowercase, no spaces)
                        $category_id = strtolower(str_replace(' ', '', $category));
                        echo '<div id="' . htmlspecialchars($category_id) . '" class="container section-title" data-aos="fade-up">';
                        echo '<h2>' . htmlspecialchars($category) . '</h2>';
                        echo '</div><!-- End Section Title -->';

                        $stmt = $conn->prepare("SELECT company, location, job_title, description, date_created ,closing_date FROM careers WHERE category = ? ORDER BY date_created DESC");
                        if (!$stmt) {
                            die("Prepare failed: " . $conn->error);
                        }
                        $stmt->bind_param("s", $category);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        echo '<div class="row">';
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $company = htmlspecialchars($row['company']);
                                $location = htmlspecialchars($row['location']);
                                $job_title = htmlspecialchars($row['job_title']);
                                $description = htmlspecialchars($row['description']);
                                $date_created = htmlspecialchars($row['date_created']);
                                $closing_date = htmlspecialchars($row['closing_date']);

                                echo '<div class="col-sm-6 mb-4">';
                                echo '<div class="card">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-title"><strong>' . $job_title . '</strong></h5>';
                                echo '<h6 class="card-subtitle mb-2 text-muted"><strong>Company:</strong> ' . $company . '</h6>';
                                echo '<p class="card-text"><strong>Location:</strong> ' . $location . '</p>';
                                echo '<p class="card-text"><strong>Description:</strong> ' . $description . '</p>';
                                echo '<p class="card-text"><strong>Date Created:</strong> ' . $date_created . '</p>';
                                echo '<p class="card-text"><strong>Closing Date:</strong> ' .$closing_date . '</p>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                               
                            }
                        } else {
                            echo '<div class="col-12"><h4>No jobs available for this category.</h4></div>';
                            echo '<br>';
                            echo '<br>';
                            echo '<br>';
                            echo '<br>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
