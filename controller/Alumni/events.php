<?php
include '../model/conn.php'; // Include your database connection file

$sql = "SELECT * FROM events ORDER BY date_created DESC LIMIT 3";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">';
        echo '<div class="events-item">';
        echo '<img src="../../grad/views/gradalumni/assets/uploads/events/' . $row['banner'] . '" class="img-fluid" alt="..." style="width: 70%; height: 60%;">';
        echo '<div class="events-content">';
        echo '<div class="d-flex justify-content-between align-items-center mb-3">';
        echo '</div>';
        echo '<h3><a href="events.php?id=' . $row['id'] . '">' . $row['title'] . '</a></h3>';
        echo '<p class="description">' . $row['content'] . '</p>';
        echo '<p class="schedule">Scheduled on: ' . $row['schedule'] . '</p>'; // Optionally display the schedule
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No events found.";
}

$conn->close();
?>
