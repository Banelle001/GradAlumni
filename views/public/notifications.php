<?php
session_start();

// Include database connection
include '../../model/conn.php'; 

// Check if user is logged in and retrieve user ID
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Fetch user_id based on email stored in the session
    $email = $_SESSION['email']; // Assuming the email is stored in the session

    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    if (!$user_id) {
        die("User not found.");
    }
}

// Fetch unread notification count
$sql_unread_count = "SELECT COUNT(*) as unread_count FROM notifications WHERE user_id = ? AND is_read = 0";
$stmt_unread = $conn->prepare($sql_unread_count);
$stmt_unread->bind_param("i", $user_id);
$stmt_unread->execute();
$result_unread = $stmt_unread->get_result();
$unread_count = $result_unread->fetch_assoc()['unread_count'];

// Fetch latest event_id and job_id
$sql_event = "SELECT id FROM events ORDER BY date_created DESC LIMIT 1";
$result_event = $conn->query($sql_event);
$event_id = $result_event->fetch_assoc()['id'] ?? null;

$sql_job = "SELECT id FROM careers ORDER BY date_created DESC LIMIT 1";
$result_job = $conn->query($sql_job);
$job_id = $result_job->fetch_assoc()['id'] ?? null;

// Add notifications if job_id exists
if ($job_id) {
    $title = "New Job Posted";
    $message = "A new job has been posted. Click to view details.";
    $type = "job";
    $url = "jobs.php?job_id=" . $job_id;

    $check_sql = "SELECT id FROM notifications WHERE related_id = ? AND type = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $job_id, $type);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows == 0) {
        $sql_notification = "INSERT INTO notifications (user_id, related_id, titles, message, type, url) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_notification);
        $stmt->bind_param("isssss", $user_id, $job_id, $title, $message, $type, $url);
        $stmt->execute();
        $stmt->close();
    }
    $check_stmt->close();
}

// Add notifications if event_id exists
if ($event_id) {
    $title = "New Event Posted";
    $message = "A new event has been posted. Click to view details.";
    $type = "event";
    $url = "events.php?event_id=" . $event_id;

    $check_sql = "SELECT id FROM notifications WHERE related_id = ? AND type = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $event_id, $type);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows == 0) {
        $sql_notification = "INSERT INTO notifications (user_id, related_id, titles, message, type, url) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_notification);
        $stmt->bind_param("isssss", $user_id, $event_id, $title, $message, $type, $url);
        $stmt->execute();
        $stmt->close();
    }
    $check_stmt->close();
}

// Fetch notifications for display
$sql = "SELECT id, titles, message, url, created_at, is_read, type FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/49d89f7fa2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/home2.css">
    <style>
        .modal-dialog {
            margin: auto; 
            margin-top: 100px; 
        }
        .modal-right {
            margin-left: auto;
            margin-right: 0;
            margin-top: 100px;
        }

        .modal-content {
          background-color: #efefef;
          margin: auto;
          padding-top: 8px;
          padding-left: 8px;
          border: 1px solid #888;
          width: 70%;
          overflow: hidden;
          box-shadow: 0 0 6px rgba(0, 0, 0, 0.5);
        }

        .modal-body {
            max-height: 550px; 
            overflow-y: auto; 
        }

        .notification {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }

        .notification p {
            margin-bottom: -10px;
        }

        .notification.unread {
            background-color: #e7f3fe;
        }

        .notification h3 {
            margin: 0;
            font-size: 15px;
            font-weight: bold;
        }

        .notification time {
            font-size: 0.9em;
            color: #777;
        }

        .badge {
            position: absolute;
            top: -20px;
            right: 23px;
            padding: 5px 10px;
            border-radius: 50%;
            background-color: red;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<?php include '../includes/nav.php'; ?>

<body>
  

    <!-- Notifications Modal -->
    <div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-right">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationsModalLabel">Notifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $is_read = $row['is_read'] ? '' : 'unread';
                            echo "<div class='notification $is_read'>";
                            echo "<h3>" . htmlspecialchars($row['titles']) . "</h3>";
                            echo "<p>" . htmlspecialchars($row['message']) . "</p>";
                            echo "<p><a href='" . htmlspecialchars($row['url']) . "'>Go to Page</a></p>";
                            echo "<time>" . htmlspecialchars($row['created_at']) . "</time>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>No notifications found.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('notificationIcon').addEventListener('click', function () {
            const unreadBadge = document.getElementById('unreadBadge');
            if (unreadBadge) {
                unreadBadge.style.display = 'none'; 
            }

            // Make an AJAX call to update the notifications
            fetch('update_notifications.php', { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Notifications updated successfully.');
                    } else {
                        console.error('Error updating notifications:', data.error);
                    }
                })
                .catch(error => console.error('Fetch error:', error));
        });

        // Function to handle new notifications
        function newNotificationReceived() {
            const unreadBadge = document.getElementById('unreadBadge');
            if (unreadBadge) {
                let currentCount = parseInt(unreadBadge.textContent);
                unreadBadge.textContent = currentCount + 1;
                unreadBadge.style.display = 'inline'; // Make sure the badge is visible
            } else {
                // Create a new badge if it doesn't exist
                const icon = document.getElementById('notificationIcon');
                const newBadge = document.createElement('span');
                newBadge.className = 'badge';
                newBadge.id = 'unreadBadge';
                newBadge.textContent = '1';
                icon.appendChild(newBadge);
            }
        }
    </script>
</body>
</html>
