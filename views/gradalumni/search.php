<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gradalumni_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM users WHERE name LIKE '%$searchTerm%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    echo "<h4> <a href=\"alumnilist.php\">Return Back</a></h4>";

    echo "<h2>Search Results:</h2>";
    echo "<table>";
    echo "<thead>
            <tr>
                <th scope='col'>User ID</th>
                <th scope='col'>First Name</th>
                <th scope='col'>Last Name</th>
                <th scope='col'>Job</th>
                <th scope='col'>Email</th>
                <th scope='col'>Degree</th>
                <th scope='col'>Action</th>
            </tr>
          </thead>
          <tbody>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['surname'] . "</td>
                <td>" . $row['job'] . "</td>
                <td>" . $row['email'] . "</td>
                <td>" . $row['education'] . "</td>
                <td>
                    <button id='deleteBtn' onclick='delete_user(" . $row['id'] . ")'>&#128465;</button>
                </td>   
              </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "<h6> <a href=\"alumnilist.php\">Return Back</a></h6>";
    echo "No results found";
}

$conn->close();
?>

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
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>