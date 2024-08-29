<?php
// Include your database connection
include '../config/config.php';
require '../../model/conn.php';

// Check if the form is submitted
if (isset($_POST['search'])) {
    $searchTerm = trim($_POST['search']);

    // Validate search term
    if (empty($searchTerm)) {
        echo "Please enter a search term.";
        exit();
    }

    $searchTerm = '%' . $searchTerm . '%';

    // Prepare the SQL query to search in multiple tables
    $query = "
    SELECT 'alumni' as table_name, user_id as id, CONCAT('User ID: ', user_id, ', Graduation Year: ', graduation_year, ', Student Number: ', student_number) as result
    FROM alumni
    WHERE graduation_year LIKE ? OR student_number LIKE ?

    UNION ALL

    SELECT 'careers' as table_name, id, CONCAT('Company: ', company, ', Location: ', location, ', Job Title: ', job_title) as result
    FROM careers
    WHERE company LIKE ? OR location LIKE ? OR job_title LIKE ? OR description LIKE ?

    UNION ALL

    SELECT 'posts' as table_name, id, CONCAT('Title: ', title, ', Content: ', content) as result
    FROM posts
    WHERE title LIKE ? OR content LIKE ?

    UNION ALL

    SELECT 'users' as table_name, id, CONCAT('Name: ', name, ' ', surname, ', Email: ', email) as result
    FROM users
    WHERE name LIKE ? OR surname LIKE ? OR email LIKE ?
    ";

    // Prepare statement
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $params = [
        $searchTerm, $searchTerm,
        $searchTerm, $searchTerm, $searchTerm, $searchTerm,
        $searchTerm, $searchTerm,
        $searchTerm, $searchTerm, $searchTerm
    ];

    $types = str_repeat('s', count($params)); // 's' for string types

    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<strong>Table:</strong> " . htmlspecialchars($row['table_name']) . "<br>";
            echo "<strong>Result:</strong> " . htmlspecialchars($row['result']) . "<br>";
            echo "</div><hr>";
        }
    } else {
        echo "No results found.";
    }
} else {
    echo "Search is still under construction... kidding";
}
?>
