<?php
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT `password` FROM `tbl_user` WHERE `username` = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch();
        $stored_password = $row['password'];

        if (password_verify($password, $stored_password)) {
            echo "
            <script>
                alert('Login Successfully!');
                window.location.href = '../home.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Login Failed, Incorrect Password!');
                window.location.href = '../index.php';
            </script>
            ";
        }
    } else {
        echo "
            <script>
                alert('Login Failed, User Not Found!');
                window.location.href = '../index.php';
            </script>
            ";
    }
}
?>
