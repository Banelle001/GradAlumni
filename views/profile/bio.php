<!-- views/Alumni_dash.php -->
<?php
// Include the configuration file
require '../config/config.php';
include '../../model/conn.php'; // Adjust this path according to your folder structure

// Assume user ID is stored in session or passed as a parameter
$userId = $_SESSION['user_id']; // Replace with appropriate user ID source

// Prepare and execute the query
$stmt = $conn->prepare("SELECT photo, name, surname, job, education, company, email, about, employment_status FROM Users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->bind_result($photoPath, $user_name, $user_surname, $user_job, $user_education, $user_company, $user_email, $user_about, $employment_status);
$stmt->fetch();
$stmt->close();
$conn->close();

?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/49d89f7fa2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/home2.css">
    <link rel="stylesheet" href="../css/profile.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #343a40;
        }

        h5 {
            font-weight: 500;
            margin-bottom: 1rem;
        }

        p {
            font-size: 1rem;
        }

        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, .15);
        }

        .card-title {
            color: #007bff;
            font-size: 1.25rem;
            font-weight: 500;
        }

        .nav-tabs .nav-link {
            color: #007bff;
            font-weight: 500;
            border: none;
            background-color: transparent;
            padding: 0.75rem 1.5rem;
            transition: background-color 0.3s, color 0.3s;
        }

        .nav-tabs .nav-link.active {
            color: #fff;
            background-color: #007bff;
            border-radius: 0.25rem;
        }

        .nav-tabs .nav-link:hover {
            color: #0056b3;
        }

        .tab-content {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-top: none;
            padding: 1.5rem;
            border-radius: 0 0 0.25rem 0.25rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, .15);

        }

        @media (max-width: 768px) {
            .col-md-3 {
                margin-bottom: 1.5rem;
            }
        }
        </style>
</head>

<body>

    <?php include '../includes/nav.php'; ?>

    <main>

        <!-- Profile 1 - Bootstrap Brain Component -->
        <section class=" bg-light py-3 py-md-5 py-xl-8 style: background-color:#fbf2e4; ">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
                        <h2 class="mb-4 display-5 text-center">Profile</h2>

                        <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
                    </div>
                </div>
            </div>

            <!--profile card ends here-->

                <div class="container">
                  <div class="row gy-4 gy-lg-0">
                    <div class="col-12 col-lg-4 col-xl-3">
                        <div class="row gy-4">
                        <div class="col-12">
                            <div class="card widget-card border-light shadow-sm">
                                <div class="card-body">
                                    <!-- User profile image -->
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
                        ?>
                        <h5 class="text-center mb-1">
                            <?php echo htmlspecialchars($user_name) . " " . htmlspecialchars($user_surname); ?>
                        </h5>
                        <p class="text-center text-secondary mb-4">
                            <?php echo htmlspecialchars($user_job); ?>
                        </p>
                        <ul class="list-group list-group-flush mb-4">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h6 class="m-0">Followers</h6>
                                <span>****</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h6 class="m-0">Following</h6>
                                <span>****</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h6 class="m-0">Friends</h6>
                                <span>****</span>
                            </li>
                        </ul>
                        <div class="d-grid m-0">
                            <!-- Additional content here -->
                            </div>
                        </div>
                    </div>
                </div>


                            <!--profile card ends here-->


                            <div class="col-12">
                                <div class="card widget-card border-light shadow-sm">
                                    <div class="card-header text-bg-primary">About Me</div>
                                    <div class="card-body">
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
                            <div class="col-12">
                                <div class="card widget-card border-light shadow-sm">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8 col-xl-9">
                        <div class="card widget-card border-light shadow-sm">
                            <div class="card-body p-4">
                                <ul class="nav nav-tabs" id="profileTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="overview-tab" data-bs-toggle="tab"
                                            data-bs-target="#overview-tab-pane" type="button" role="tab"
                                            aria-controls="overview-tab-pane" aria-selected="true">Overview</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#profile-tab-pane" type="button" role="tab"
                                            aria-controls="profile-tab-pane" aria-selected="false">Profile</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="email-tab" data-bs-toggle="tab"
                                            data-bs-target="#email-tab-pane" type="button" role="tab"
                                            aria-controls="email-tab-pane" aria-selected="false">Emails</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="password-tab" data-bs-toggle="tab"
                                            data-bs-target="#password-tab-pane" type="button" role="tab"
                                            aria-controls="password-tab-pane" aria-selected="false">Password</button>
                                    </li>
                                </ul>
                                <div class="tab-content pt-4" id="profileTabContent">
                                    <div class="tab-pane fade show active" id="overview-tab-pane" role="tabpanel"
                                        aria-labelledby="overview-tab" tabindex="0">
                                        <h5 class="mb-3">About</h5>
                                        <p class="lead mb-3"><?php echo htmlspecialchars($user_about) ?></p>
                                        <h5 class="mb-3">Profile</h5>
                                        <div class="row g-0">
                                            <div class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                                <div class="p-2">First Name</div>
                                            </div>
                                            <div
                                                class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                                <div class="p-2"><?php echo htmlspecialchars($user_name) ?></div>
                                            </div>
                                            <div class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                                <div class="p-2">Last Name</div>
                                            </div>
                                            <div
                                                class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                                <div class="p-2"><?php echo htmlspecialchars($user_surname) ?></div>
                                            </div>
                                            <div class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                                <div class="p-2">Education</div>
                                            </div>
                                            <div
                                                class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                                <div class="p-2"><?php echo htmlspecialchars($user_education) ?></div>
                                            </div>

                                            <div class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                                <div class="p-2">Employment Status</div>
                                            </div>
                                            <div
                                                class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                                <div class="p-2"><?php echo htmlspecialchars($employment_status) ?></div>
                                            </div>

                                            <div class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                                <div class="p-2">Job</div>
                                            </div>
                                            <div
                                                class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                                <div class="p-2"><?php echo htmlspecialchars($user_job) ?></div>
                                            </div>
                                            <div class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                                <div class="p-2">Company</div>
                                            </div>
                                            <div
                                                class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                                <div class="p-2"><?php echo htmlspecialchars($user_company) ?></div>
                                            </div>
                                            <div class="col-5 col-md-3 bg-light border-bottom border-white border-3">
                                                <div class="p-2">Email</div>
                                            </div>
                                            <div
                                                class="col-7 col-md-9 bg-light border-start border-bottom border-white border-3">
                                                <div class="p-2"><?php echo htmlspecialchars($user_email) ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel"
                                        aria-labelledby="profile-tab" tabindex="0">

                                        <form action="../../controller/Alumni/update_profile.php" method="POST"
                                            enctype="multipart/form-data" class="row gy-3 gy-xxl-4">
                                            <div class="col-12">
                                                <div class="row gy-2">
                                                    <label class="col-12 form-label m-0">Add Profile Image</label>
                                                    
                                                    <div class="col-12">
                                                        <input type="file" class="form-control" name="profile_image">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <label for="inputFirstName" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="inputFirstName"
                                                    name="first_name"
                                                    value="<?php echo htmlspecialchars($user_name); ?>" required>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="inputLastName" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="inputLastName"
                                                    name="last_name"
                                                    value="<?php echo htmlspecialchars($user_surname); ?>" required>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="inputEducation" class="form-label">Education</label>
                                                <input type="text" class="form-control" id="inputEducation"
                                                    name="education"
                                                    value="<?php echo htmlspecialchars($user_education); ?>">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="inputSkills" class="form-label">Skills</label>
                                                <input type="text" class="form-control" id="inputSkills" name="skills"
                                                    value="<?php echo htmlspecialchars($user_skills); ?>">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="inputEmplymentStatus" class="form-label">Employment Status</label>
                                                <select class="form-control" id="inputEmplymentStatus" name="employment_status" required>
                                                    <option value="Employed" <?php echo ($employment_status === 'Employed') ? 'selected' : ''; ?>>Employed</option>
                                                    <option value="Unemployed" <?php echo ($employment_status === 'Unemployed') ? 'selected' : ''; ?>>Unemployed</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="inputJob" class="form-label">Job</label>
                                                <input type="text" class="form-control" id="inputJob" name="job"
                                                    value="<?php echo htmlspecialchars($user_job); ?>">
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="inputCompany" class="form-label">Company</label>
                                                <input type="text" class="form-control" id="inputCompany" name="company"
                                                    value="<?php echo htmlspecialchars($user_company); ?>">
                                            </div>
                                            <div class="col-12">
                                                <label for="inputEmail" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="inputEmail" name="email"
                                                    value="<?php echo htmlspecialchars($user_email); ?>">
                                            </div>
                                            <div class="col-12">
                                                <label for="inputAbout" class="form-label">About</label>
                                                <textarea class="form-control" id="inputAbout"
                                                    name="about"><?php echo htmlspecialchars($user_about); ?></textarea>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="email-tab-pane" role="tabpanel"
                                        aria-labelledby="email-tab" tabindex="0">
                                        <form action="#!">
                                            <fieldset class="row gy-3 gy-md-0">
                                                <legend class="col-form-label col-12 col-md-3 col-xl-2">Email Alerts
                                                </legend>
                                                <div class="col-12 col-md-9 col-xl-10">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="emailChange">
                                                        <label class="form-check-label" for="emailChange">
                                                            Email Change
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="passwordChange">
                                                        <label class="form-check-label" for="passwordChange">
                                                            Password Change
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="weeklyNewsletter">
                                                        <label class="form-check-label" for="weeklyNewsletter">
                                                            Weekly Newsletter
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="productPromotions">
                                                        <label class="form-check-label" for="productPromotions">
                                                            Product Promotions
                                                        </label>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mt-4">Save
                                                        Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane fade" id="password-tab-pane" role="tabpanel"
                                        aria-labelledby="password-tab" tabindex="0">
                                        <form action="../../controller/Alumni/change_password.php" method="POST">
                                            <div class="row gy-3 gy-xxl-4">
                                                <div class="col-12">
                                                    <label for="currentPassword" class="form-label">Current
                                                        Password</label>
                                                    <input type="password" class="form-control" id="currentPassword"
                                                        name="currentPassword" required>
                                                </div>
                                                <div class="col-12">
                                                    <label for="newPassword" class="form-label">New Password</label>
                                                    <input type="password" class="form-control" id="newPassword"
                                                        name="newPassword" required>
                                                </div>
                                                <div class="col-12">
                                                    <label for="confirmPassword" class="form-label">Confirm
                                                        Password</label>
                                                    <input type="password" class="form-control" id="confirmPassword"
                                                        name="confirmPassword" required>
                                                </div>
                                                <div class="col-12">
                                                    <input type="checkbox" id="showPasswords"
                                                        onclick="togglePasswordVisibility()">
                                                    <label for="showPasswords" class="form-label">Show Passwords</label>
                                                </div>
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary">Change
                                                        Password</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </main>


    <?php include '../includes/footer.php'; ?>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script>
    function togglePasswordVisibility() {
        var currentPassword = document.getElementById('currentPassword');
        var newPassword = document.getElementById('newPassword');
        var confirmPassword = document.getElementById('confirmPassword');
        var showPasswords = document.getElementById('showPasswords');

        if (showPasswords.checked) {
            currentPassword.type = 'text';
            newPassword.type = 'text';
            confirmPassword.type = 'text';
        } else {
            currentPassword.type = 'password';
            newPassword.type = 'password';
            confirmPassword.type = 'password';
        }
    }
    </script>
</body>

</html>