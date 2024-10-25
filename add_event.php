<?php
require 'header.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'db_connect.php';

    $event_name = $_POST['event_name'];
    $event_date_start = $_POST['event_date_start'];
    $event_date_end = $_POST['event_date_end'];
    $description = $_POST['description'];
    $ticket_price = $_POST['ticket_price'];
    $event_time_start = $_POST['event_time_start'];
    $event_time_end = $_POST['event_time_end'];
    $event_location = $_POST['event_location'];
    $max_participants = $_POST['max_participants'];
    $event_pic = null;

    if (empty($event_name) || empty($event_date_start) || empty($event_date_end) || empty($description) || !isset($ticket_price) || empty($event_time_start) || empty($event_time_end) || empty($event_location) || empty($max_participants)) {
        echo "All fields must be filled!";
        var_dump($ticket_price);
        exit;
    }

    if (!empty($_FILES['event_pic']['name'])) {
        $target_dir = "uploads/";
        $original_filename = basename($_FILES["event_pic"]["name"]);
        $imageFileType = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
        $new_filename = pathinfo($original_filename, PATHINFO_FILENAME) . "_" . time() . "." . $imageFileType;
        $target_file = $new_filename;

        $allowed_types = array('jpg', 'jpeg', 'png');
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["event_pic"]["tmp_name"], 'uploads/' .  $target_file)) {
                $event_pic = $target_file;
            } else {
                echo "Error uploading file.";
                exit;
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
            exit;
        }
    }

    $stmt = $conn->prepare("INSERT INTO event (event_name, event_date_start, event_date_end, description, ticket_price, event_time_start, event_time_end, event_location, max_participants, event_pic) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $event_name, $event_date_start, $event_date_end, $description, $ticket_price, $event_time_start, $event_time_end, $event_location, $max_participants, $event_pic);

    if ($stmt->execute()) {
        echo "Event successfully added!";
        header("Location: admin_dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Event</title>
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Enter Event Details</h1>
    <form method="POST" action="add_event.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="event_name" class="form-label">Event Name</label>
            <input type="text" class="form-control" name="event_name" id="event_name" placeholder="Event name..." required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="event_date_start" class="form-label">Event Start Date</label>
                <input type="date" class="form-control" name="event_date_start" id="event_date_start" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="event_date_end" class="form-label">Event End Date</label>
                <input type="date" class="form-control" name="event_date_end" id="event_date_end" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Event Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Event description..." required></textarea>
        </div>

        <div class="mb-3">
            <label for="ticket_price" class="form-label">Ticket Price (Rp)</label>
            <input type="number" class="form-control" name="ticket_price" id="ticket_price" placeholder="Enter ticket price in Rp" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="event_time_start" class="form-label">Event Start Time</label>
                <input type="time" class="form-control" name="event_time_start" id="event_time_start" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="event_time_end" class="form-label">Event End Time</label>
                <input type="time" class="form-control" name="event_time_end" id="event_time_end" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="event_location" class="form-label">Event Location</label>
            <input type="text" class="form-control" name="event_location" id="event_location" required>
        </div>

        <div class="mb-3">
            <label for="max_participants" class="form-label">Maximum Number of Participants</label>
            <input type="number" class="form-control" name="max_participants" id="max_participants" required>
        </div>

        <div class="mb-3">
            <label for="event_pic" class="form-label">Upload Event Image (optional)</label>
            <input type="file" class="form-control" name="event_pic" accept=".jpg, .jpeg, .png">
            <small class="form-text text-muted">Only JPG, JPEG, and PNG are accepted.</small>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </form>
</div>

</body>
</html>
