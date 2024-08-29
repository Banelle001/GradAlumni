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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
    /* Custom Styles */

    /* Header */
    header {
        margin-bottom: 20px;
        background-color: white;
    }

    body {
        background-color: rgb(237, 236, 236);
    }

    .stepwizard-step p {
        margin-top: 10px;
    }

    .stepwizard-row {
        display: table-row;
    }

    .stepwizard {
        display: table;
        width: 100%;
        position: relative;
    }

    .stepwizard-step button[disabled] {
        opacity: 1 !important;
        filter: alpha(opacity=100) !important;
    }

    .stepwizard-row:before {
        top: 14px;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 100%;
        height: 1px;
        background-color: #ccc;
        z-order: 0;

    }

    .stepwizard-step {
        display: table-cell;
        text-align: center;
        position: relative;
    }

    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        font-size: 12px;
        line-height: 1.428571429;
        border-radius: 15px;
        background-color: #ee930c;
    }


    .form-box-register {

        background-color: #f7f7f7;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 700px;
        margin: 2rem auto;
    }

    .form-container {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .form-container h2 {
        font-size: 1.8rem;
        font-weight: bold;
        color: #333;
    }


    .input-box {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .input-box .form-label {
        position: absolute;
        top: -10px;
        left: 15px;
        background: #fff;
        padding: 0 5px;
        font-size: 0.9rem;
        color: #666;
        transition: 0.3s ease;
        z-index: 1;
    }

    .input-box .form-control {
        padding: 0.75rem 1rem;
        border: 2px solid #ced4da;
        border-radius: 4px;
        font-size: 1rem;
        color: #495057;
    }

    .input-box .form-control:focus {
        border-color: #1e5785;
        box-shadow: none;
    }

    .input-box .form-control:focus+.form-label {
        color: #1e5785;
    }

    .input-box input[type="file"] {
        padding: 0.375rem 1rem;
    }

    .select-box select {
        padding: 0.75rem 1rem;
        border: 2px solid #ced4da;
        border-radius: 4px;
        font-size: 1rem;
        color: #495057;
    }

    .form-check-label a {
        color: #007bff;
        text-decoration: none;
    }

    .form-check-label a:hover {
        text-decoration: underline;
    }

    .btn-primary {
        background-color: #1e5785;
        ;
        border: none;

        font-size: 1rem;
        border-radius: 4px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #ee930c;
    }

    /* Error message styling */
    #error-message {
        color: #d9534f;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-box-register {
            padding: 1.5rem;

        }

        .form-container {
            padding: 1.5rem;
        }
    }

    /* Footer */
    footer {
        margin-top: 20px;
    }

    footer p {
        margin: 0;
        font-size: 0.9rem;
    }

    /* Media Queries */
    @media (max-width: 992px) {
        header .container {
            padding: 10px;
        }



        .nav-link {
            margin-right: 0;
            margin-bottom: 5px;
        }
    }

    .input-box {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        /* Ensure the parent container has a height */
    }

    .custom-file-upload {
        display: inline-block;
        width: 110px;
        height: 120px;
        border-radius: 50%;
        background-color: #f1f1f1;
        text-align: center;
        cursor: pointer;
        color: #555;
        font-size: 24px;
        transition: background-color 0.3s ease;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .custom-file-upload:hover {
        background-color: #e1e1e1;
    }
    </style>
</head>

<body>
    <!-- Header with Navigation -->
    <header>
        <nav class="navbar navbar-expand-lg ">
            <div class="container-fluid">

                <img src="../views/img/logo.png" style="width:170px;margin-bottom:30px">

        </nav>

    </header>

    <main>
        <div class="container" style="backround-color:#fff; padding-top:50px">


            <form id="regForm" action="../controller/Alumni/register.php" method="POST" enctype="multipart/form-data"
                style="width:60rem;  margin: auto;;padding: 10px">
                <!-- Step 1 -->
                <div class="form-container">
                    <div class="row setup-content" id="step-1">
                        <div class="col-xs-12">
                            <div class="col-md-12">
                                <h4>Create a profile</h4>
                                <div class="input-box">
                                    <input class="form-control" type="file" id="photo" name="photo" accept="image/*"
                                        autocomplete="off" style="display:none;">
                                    <label for="photo" class="custom-file-upload" id="photo-label">
                                        <i class="fas fa-camera"></i>
                                    </label>
                                </div>

                                <!-- row 1 -->
                                <div class="row g-3 row2">
                                    <div class="col-md-6 input-box">
                                        <input type="text" class="form-control" id="name" name="name"
                                            autocomplete="given-name" required>
                                        <label for="name" class="form-label">Name</label>
                                    </div>
                                    <div class="col-md-6 input-box">
                                        <input type="text" class="form-control" id="surname" name="surname"
                                            autocomplete="family-name" required>
                                        <label for="surname" class="form-label">Surname</label>
                                    </div>
                                </div>
                                <!-- row 2 -->
                                <div class="row g-3 row2">
                                    <div class="input-box">
                                        <input type="email" class="form-control" id="email" name="email"
                                            autocomplete="email" required>
                                        <label for="email" class="form-label">Email</label>
                                    </div>
                                    <div class="input-box">
                                        <select class="form-select" id="category" name="category" autocomplete="off"
                                            required>
                                            <option disabled selected>Choose affiliation</option>
                                            <option value="1">Alumni</option>
                                            <option value="2">Staff</option>
                                        </select>
                                        <label for="category" class="form-label">Affiliation</label>
                                    </div>
                                </div>
                                <!-- row 3: Date of Birth -->

                                <!-- row 4: Degree -->
                                <div class="row g-3 row2">
                                    <div class="input-box">
                                        <select class="form-select" id="degree" name="degree" required>
                                            <option disabled selected>Choose your degree</option>
                                            <option value="bachelor_science">Bachelor of Science</option>
                                            <option value="bachelor_arts">Bachelor of Arts</option>
                                            <option value="bachelor_law">Bachelor of Law</option>
                                            <option value="bachelor_technology">Bachelor of Technology</option>
                                        </select>
                                        <label for="degree" class="form-label">Degree</label>
                                    </div>
                                </div>

                                <!-- alumni fields -->
                                <div class="row g-3 row2" style="display: flex;">
                                    <div class="input-box alumni-fields" style="display: none; flex: 1;">
                                        <select class="form-control" id="graduationYear" name="graduationYear" required>
                                            <option value="" disabled selected>Select a year</option>
                                            <!-- Generate the years dynamically -->
                                            <?php
                                                for ($year = 2030; $year >= 2010; $year--) {
                                                    echo "<option value=\"$year\">$year</option>";
                                                }
                                            ?>
                                        </select>
                                        <label for="graduationYear" class="form-label">Graduation Year</label>
                                    </div>
                                    <div class="input-box alumni-fields" style="display:none; flex: 1;">
                                        <input type="number" class="form-control" id="studentNumber"
                                            name="studentNumber" autocomplete="off" required>
                                        <label for="studentNumber" class="form-label">Student Number</label>
                                    </div>
                                    <p id="student-error-message" style="display: none; color: red;">Student Number must
                                        be exactly 9 digits.</p>
                                </div>
                                <!-- admin fields -->
                                <div class="input-box admin-fields" style="display:none;">
                                    <input type="number" class="form-control" id="staffNumber" name="staffNumber"
                                        autocomplete="off" required>
                                    <label for="staffNumber" class="form-label">Staff Number</label>
                                </div>


                                <p id="staff-error-message" style="display: none; color: red;">Staff Number must be
                                    exactly 9 digits.</p>

                                <!-- row 7 -->
                                <div class="row g-3 row2">
                                    <div class="input-box">
                                        <input type="password" class="form-control" id="password" name="password"
                                            autocomplete="new-password" placeholder="Enter your password" required>
                                        <label for="password" class="form-label">Password</label>
                                        <span class="position-absolute top-50 end-0 translate-middle-y me-3"
                                            onclick="togglePasswordVisibility()">
                                            <i class="fa-solid fa-eye" id="togglePassword"></i>
                                        </span>
                                    </div>
                                    <div class="input-box">
                                        <input type="password" class="form-control" id="confirmPassword"
                                            name="confirmPassword" autocomplete="new-password"
                                            placeholder="Confirm your password" required>
                                        <label for="confirmPassword" class="form-label">Confirm Password</label>

                                    </div>
                                </div>

                                <div class="checkbox-container mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="terms" name="terms"
                                            required>
                                        <label class="form-check-label" for="terms">I agree to the <a href="#">terms and
                                                conditions</a></label>
                                    </div>
                                </div>

                                <button class="btn btn-primary nextBtn btn-lg pull-right"
                                    type="submit">Register</button>

                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </main>


</body>
<footer>
    <!-- place footer here -->
</footer>
<!-- Bootstrap JavaScript Libraries -->
<!--i could not link javascript to html file, so i wrote it in here-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var categorySelect = document.getElementById("category");
    var alumniFields = document.querySelectorAll(".alumni-fields");
    var graduationYearInput = document.getElementById("graduationYear");
    var studentNumberInput = document.getElementById("studentNumber");
    var adminFields = document.querySelectorAll(" .admin-fields");
    var staffNumberInput = document.getElementById("staffNumber");

    categorySelect.addEventListener("change", function() {
        if (categorySelect.value === "1") { // Alumni
            alumniFields.forEach(function(field) {
                field.style.display = "block";
            });
            graduationYearInput.disabled = false;
            studentNumberInput.disabled = false;

            adminFields.forEach(function(field) {
                field.style.display = "none";
            });
            staffNumberInput.disabled = true;
        } else if (categorySelect.value === "2") { // Admin
            alumniFields.forEach(function(field) {
                field.style.display = "none";
            });
            graduationYearInput.disabled = true;
            studentNumberInput.disabled = true;

            adminFields.forEach(function(field) {
                field.style.display = "block";
            });
            staffNumberInput.disabled = false;
        } else {
            alumniFields.forEach(function(field) {
                field.style.display = "none";
            });
            graduationYearInput.disabled = true;
            studentNumberInput.disabled = true;

            adminFields.forEach(function(field) {
                field.style.display = "none";
            });
            staffNumberInput.disabled = true;
        }
    });
});
</script>
<script>
document.getElementById('staffNumber').addEventListener('input', function() {
    const staffNumber = this.value;
    const errorMessage = document.getElementById('staff-error-message');

    if (staffNumber.length !== 9) {
        this.setCustomValidity('Staff Number must be exactly 9 digits.');
        errorMessage.style.display = 'block';
    } else {
        this.setCustomValidity('');
        errorMessage.style.display = 'none';
    }
});
</script>

<script>
document.getElementById('studentNumber').addEventListener('input', function() {
    const studentNumber = this.value;
    const errorMessage = document.getElementById('student-error-message');

    if (studentNumber.length !== 9) {
        this.setCustomValidity('Student Number must be exactly 9 digits.');
        errorMessage.style.display = 'block';
    } else {
        this.setCustomValidity('');
        errorMessage.style.display = 'none';
    }
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var photoInput = document.getElementById('photo');
    var photoLabel = document.getElementById('photo-label');

    photoInput.addEventListener('change', function(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();

            reader.onload = function(e) {
                photoLabel.style.backgroundImage = 'url(' + e.target.result + ')';
                photoLabel.style.backgroundSize = 'cover'; // Ensure the image covers the label area
                photoLabel.style.backgroundPosition = 'center'; // Center the image in the label
                photoLabel.style.backgroundRepeat = 'no-repeat'; // Do not repeat the image
                photoLabel.querySelector('i').style.display = 'none'; // Hide the icon
            };

            reader.readAsDataURL(file);
        } else {
            photoLabel.style.backgroundImage = ''; // Remove background image
            photoLabel.querySelector('i').style.display = 'block'; // Show the icon
        }
    });
});
</script>

<script>
function togglePasswordVisibility() {
    const passwordField = document.getElementById("password");
    const togglePasswordIcon = document.getElementById("togglePassword");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        togglePasswordIcon.classList.remove("fa-eye");
        togglePasswordIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        togglePasswordIcon.classList.remove("fa-eye-slash");
        togglePasswordIcon.classList.add("fa-eye");
    }
}
</script>

</body>

</html>