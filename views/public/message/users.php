<?php
session_start();
include 'conn.php'; // Adjust path if necessary

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Alumni_dash.php"); 
    exit();
}

$userId = $_SESSION['user_id']; // Get the logged-in user ID

// Handle search functionality
if (isset($_POST['search'])) {
    $searchTerm = mysqli_real_escape_string($conn, $_POST['search']);
    $searchQuery = "SELECT id, name, surname, status, photo FROM users WHERE name LIKE '%$searchTerm%' OR surname LIKE '%$searchTerm%'";
    $searchResult = mysqli_query($conn, $searchQuery);

    // Base URL or path to the images
    $baseUrl = '../../uploads/'; // Path relative to the location of messaging.php

    while ($row = mysqli_fetch_assoc($searchResult)) {
        $photoUrl = $baseUrl . htmlspecialchars($row['photo']);
        echo "<div onclick='startChat(" . $row['id'] . ")' class='user-profile'>";
        echo "<img src='" . $photoUrl . "' class='profile-img' alt='" . htmlspecialchars($row['name']) . " " . htmlspecialchars($row['surname']) . "' />";
        echo "<span>" . htmlspecialchars($row['name']) . " " . htmlspecialchars($row['surname']) . " - " . htmlspecialchars($row['status']) . "</span>";
        echo "</div>";
    }
    exit(); // Stop further execution after search results are returned
}

// Handle sending messages
if (isset($_POST['message']) && isset($_POST['receiver_id'])) {
    $receiverId = mysqli_real_escape_string($conn, $_POST['receiver_id']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $sendQuery = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$userId', '$receiverId', '$message')";
    
    if (mysqli_query($conn, $sendQuery)) {
        echo "<div class='sent-message'>" . htmlspecialchars($message) . "</div>";
    } else {
        echo "Error sending message: " . mysqli_error($conn);
    }
    exit();
}

// Handle fetching messages
if (isset($_GET['receiver_id'])) {
    $receiverId = mysqli_real_escape_string($conn, $_GET['receiver_id']);
    $fetchQuery = "SELECT * FROM messages WHERE (sender_id = '$userId' AND receiver_id = '$receiverId') OR (sender_id = '$receiverId' AND receiver_id = '$userId') ORDER BY timestamp ASC";
    $fetchResult = mysqli_query($conn, $fetchQuery);
    
    while ($row = mysqli_fetch_assoc($fetchResult)) {
        echo "<div class='" . ($row['sender_id'] == $userId ? "sent" : "received") . "-message'>" . htmlspecialchars($row['message']) . "</div>";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="users.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

    <title>GradChat</title>
    <style>
        /* Basic styles for the messaging interface */
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        #search { width: 100%; padding: 10px; margin-bottom: 10px; }
        #search-results { margin-bottom: 20px; }
        #search-results div { padding: 10px; border: 1px solid #ddd; margin-bottom: 5px; cursor: pointer; }
        #chat-box { border: 1px solid #ddd; padding: 10px; background: #fff; }
        #messages { height: 300px; overflow-y: scroll; border-bottom: 1px solid #ddd; margin-bottom: 10px; }
        .sent-message { text-align: right; color: #333; margin-bottom: 10px; }
        .received-message { text-align: left; color: #007bff; margin-bottom: 10px; }
        #message { width: calc(100% - 100px); padding: 10px; }
        button { padding: 10px; background: #007bff; color: #fff; border: none; cursor: pointer; }
    </style>
    <script>
        var receiverId = null;

        function searchUsers() {
            var searchTerm = document.getElementById('search').value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'users.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                document.getElementById('search-results').innerHTML = this.responseText;
            };
            xhr.send('search=' + searchTerm);
        }

        function startChat(userId) {
            receiverId = userId;
            fetchMessages();
        }

        function sendMessage() {
            var message = document.getElementById('message').value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'users.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                document.getElementById('messages').innerHTML += this.responseText;
                document.getElementById('message').value = '';
            };
            xhr.send('message=' + message + '&receiver_id=' + receiverId);
        }

        function fetchMessages() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'users.php?receiver_id=' + receiverId, true);
            xhr.onload = function() {
                document.getElementById('messages').innerHTML = this.responseText;
            };
            xhr.send();
        }

        setInterval(fetchMessages, 2000); // Fetch messages every 2 seconds
    </script>
</head>
<body>

    <div class="container">
        <h1>GradChat</h1>
        <div>
            <a href="../Alumni_dash.php"><button>Back to dashboard</button></a>
        </div>
        <input type="text" id="search" placeholder="Search users..." onkeyup="searchUsers()">
        <div id="search-results"></div>

        <div id="chat-box" style="display: flex; flex-direction: row;">
    <!-- Left Container for Recent Messages History -->
    <div id="recent-messages" style="flex: 1; border-right: 1px solid #ccc; padding: 10px;">
        <!-- Recent messages history will be displayed here -->
    </div>

    <!-- Right Container for Message Box and Text Field -->
    <div id="message-box" style="flex: 2; display: flex; flex-direction: column; padding: 10px;">
        <div id="messages" style="flex: 1; overflow-y: auto; margin-bottom: 10px;">
            <!-- Messages will be displayed here -->
        </div>
        <div>
            <textarea id="message" placeholder="Type your message..." style="width: 100%;"></textarea>
            <button onclick="sendMessage()" style="margin-top: 10px;">Send</button>
        </div>
    </div>
</div>

    </div>
    <script src="script.js"></script> <!-- Update with the correct path -->
</body>
</html>