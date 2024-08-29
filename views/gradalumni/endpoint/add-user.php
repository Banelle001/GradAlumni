<?php
include('connection.php');

$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$contactNumber = $_POST['contact_number'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Hash the password before storing it
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

try {
    $stmt = $conn->prepare("SELECT `first_name`, `last_name` FROM `tbl_user` WHERE `first_name` = :first_name AND `last_name` = :last_name");
    $stmt->execute([
        'first_name' => $firstName,
        'last_name' => $lastName
    ]);
    $nameExist = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($nameExist)) {
        $conn->beginTransaction();

        $insertStmt = $conn->prepare("INSERT INTO `tbl_user` (`id`, `first_name`, `last_name`, `contact_number`, `email`, `username`, `password`) VALUES (NULL, :first_name, :last_name, :contact_number, :email, :username, :password)");
        $insertStmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $insertStmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $insertStmt->bindParam(':contact_number', $contactNumber, PDO::PARAM_INT);
        $insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
        $insertStmt->bindParam(':username', $username, PDO::PARAM_STR);
        $insertStmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR); // Use the hashed password
        $insertStmt->execute();

        echo "
        <script>
            alert('Registered Successfully');
            window.location.href = '../index.php';
        </script>
        ";

        $conn->commit();
    } else {
        echo "
        <script>
            alert('User Already Exist');
            window.location.href = '../index.php';
        </script>
        ";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
