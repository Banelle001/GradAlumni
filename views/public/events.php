<?php 
// Start PHP session if not already started
session_start(); 

// Include navigation
include '../includes/nav.php'; 

// Connect to database
$db = mysqli_connect("localhost", "root", "", "gradalumni_db");
// Check if connection was successful
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL query to fetch events from the events table
$sql = "SELECT id, title, content, venue, schedule, banner FROM events ORDER BY schedule DESC";
$result = mysqli_query($db, $sql);

// Store events in an array
$events = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $events[] = $row;
    }
}

// Close database connection
mysqli_close($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/49d89f7fa2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/home2.css">
    <link rel="stylesheet" href="../css/events.css"> 
    <style>
.container {
    padding: 20px;
}

.grid-container {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.grid-item {
    border: 1px solid #ddd;
    padding: 15px;
    box-shadow: 2px 2px 8px rgba(0,0,0,0.1);
    border-radius: 8px;
    background-color: #f9f9f9;
    text-align: center;
}

.event-banner {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 10px;
}

.grid-item h3 {
    margin-bottom: 10px;
    font-size: 1.5em;
    color: #333;
}

.rsvp-button {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.rsvp-button:hover {
    background-color: #0056b3;
}

/* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0,0,0);
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 8px;
    text-align: left;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

input[type="text"],
input[type="email"],
input[type="number"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
}
</style>
</head>
<body>
    <div>
        <h1 style="text-align: center;">Events</h1>
    </div>
    <div class="container mt-5">
    <?php if (!empty($events)): ?>
        <div class="grid-container">
            <?php foreach ($events as $event): ?>
                <div class="grid-item">
                    <?php 
                    $eventImage = "../gradalumni/assets/uploads/events/" . $event['banner'];
                    $defaultImage = "../img/eventdefault.jpeg";
                    ?>
                    <div class="text-center mb-3">
                        <?php if (file_exists($eventImage) && !empty($event['banner'])): ?>
                            <img src="<?php echo htmlspecialchars($eventImage); ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" class="event-banner" style="width: 200px; height: 200px;">
                        <?php else: ?>
                            <img src="<?php echo htmlspecialchars($defaultImage); ?>" alt="Default Image" class="event-banner" style="width: 200px; height: 200px;">
                        <?php endif; ?>
                    </div>
                    <h3><?php echo htmlspecialchars($event['title']); ?></h3>
                    <p><?php echo htmlspecialchars($event['content']); ?></p>
                    <p><strong>Venue: </strong><?php echo htmlspecialchars($event['venue']); ?></p>
                    <p><strong>Date & Time:</strong> <?php echo htmlspecialchars($event['schedule']); ?></p>
                    <button class="rsvp-button" data-event-id="<?php echo htmlspecialchars($event['id']); ?>">RSVP</button>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No upcoming events found.</p>
    <?php endif; ?>
</div>


    <!-- RSVP Modal -->
    <div id="rsvpModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>RSVP for Event</h2>
            <form id="rsvpForm" method="POST" action="submit-rsvp.php">
                <input type="hidden" id="event_id" name="event_id">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="guests">Number of Guests:</label>
                <input type="number" id="guests" name="guests" min="0" required>
                
                <label for="requirements">Special Requirements:</label>
                <textarea id="requirements" name="requirements"></textarea>
                
                <button type="submit" class="rsvp-button">Submit RSVP</button>
            </form>
        </div>
    </div>

    <script>
    // Get modal element
    var modal = document.getElementById("rsvpModal");

    // Get close button element
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal 
    document.querySelectorAll(".rsvp-button").forEach(button => {
        button.addEventListener("click", function() {
            var event_id = this.getAttribute('data-event-id');
            document.getElementById("event_id").value = event_id;
            modal.style.display = "block";
        });
    });

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>
</body>
<?php include '../includes/footer.php'; ?>
</html>
