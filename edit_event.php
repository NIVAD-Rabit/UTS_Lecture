<?php
session_start();
include 'db_connect.php';
include 'header.php';


$event_id = $_GET['event_id'] ?? '';

if ($event_id) {

    $stmt = $conn->prepare("SELECT * FROM event WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
    } else {
        echo "Event tidak ditemukan!";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $event_name = $_POST['event_name'];
    $event_date_start = $_POST['event_date_start'];
    $event_date_end = $_POST['event_date_end'];
    $description = $_POST['description'];
    $ticket_price = $_POST['ticket_price'];
    $event_time_start = $_POST['event_time_start'];
    $event_time_end = $_POST['event_time_end'];
    $event_location = $_POST['event_location'];
    $max_participants = $_POST['max_participants'];
    $event_status = $_POST['event_status'];

    $event_pic = $event['event_pic'];
    var_dump($event_pic);
    if (!empty($_FILES['event_pic']['name'])) {
        $file_name = basename($_FILES['event_pic']['name']);
        $file_tmp = $_FILES['event_pic']['tmp_name'];
        $file_destination =  $file_name;
    

        $allowed_extensions = ['jpg', 'jpeg', 'png'];
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
        
        if (in_array($file_extension, $allowed_extensions)) {

            if (move_uploaded_file($file_tmp, 'uploads/' . $file_destination)) {
                $event_pic = $file_destination;
            } else {
                echo "Gagal mengunggah file!";
                exit();
            }
        } else {
            echo "Format gambar tidak valid!";
            exit();
        }
    }
    


    $stmt = $conn->prepare("UPDATE event SET event_name = ?, event_date_start = ?, event_date_end = ?, description = ?, ticket_price = ?, event_time_start = ?, event_time_end = ?, event_location = ?, max_participants = ?, event_status = ?, event_pic = ? WHERE event_id = ?");
    $stmt->bind_param("sssssssssssi", $event_name, $event_date_start, $event_date_end, $description, $ticket_price, $event_time_start, $event_time_end, $event_location, $max_participants, $event_status, $event_pic, $event_id);

    if ($stmt->execute()) {
        echo "Event berhasil diperbarui!";
        header("Location: event_detail.php?event_id=".$event_id);
        exit();
    } else {
        echo "Gagal memperbarui event!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Event</title>
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Edit Event</h1>
    <form method="POST" action="edit_event.php?event_id=<?php echo htmlspecialchars($event_id); ?>" enctype="multipart/form-data">
        <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['event_id']); ?>" readonly>

        <div class="mb-3">
            <label for="event_name" class="form-label">Event Name</label>
            <input type="text" class="form-control" name="event_name" value="<?php echo htmlspecialchars($event['event_name']); ?>" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="event_date_start" class="form-label">Event Start Date</label>
                <input type="date" class="form-control" name="event_date_start" value="<?php echo htmlspecialchars($event['event_date_start']); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="event_date_end" class="form-label">Event End Date</label>
                <input type="date" class="form-control" name="event_date_end" value="<?php echo htmlspecialchars($event['event_date_end']); ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Event Description</label>
            <textarea class="form-control" name="description" rows="4" required><?php echo htmlspecialchars($event['description']); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="ticket_price" class="form-label">Ticket Price (Rp)</label>
            <input type="number" class="form-control" name="ticket_price" value="<?php echo htmlspecialchars($event['ticket_price']); ?>" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="event_time_start" class="form-label">Event Start Time</label>
                <input type="time" class="form-control" name="event_time_start" value="<?php echo htmlspecialchars($event['event_time_start']); ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="event_time_end" class="form-label">Event End Time</label>
                <input type="time" class="form-control" name="event_time_end" value="<?php echo htmlspecialchars($event['event_time_end']); ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="event_location" class="form-label">Event Location</label>
            <input type="text" class="form-control" name="event_location" value="<?php echo htmlspecialchars($event['event_location']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="max_participants" class="form-label">Max Participants</label>
            <input type="number" class="form-control" name="max_participants" value="<?php echo htmlspecialchars($event['max_participants']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="event_status" class="form-label">Event Status</label><br>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="event_status" value="available" <?php echo ($event['event_status'] == 'available') ? 'checked' : ''; ?>>
                <label class="form-check-label">Available</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="event_status" value="full" <?php echo ($event['event_status'] == 'full') ? 'checked' : ''; ?>>
                <label class="form-check-label">Full</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="event_pic" class="form-label">Event Picture (if you want to change):</label><br>
            <?php echo '<img style="height: 200px; width: 354px; margin-bottom: 12px; object-fit: cover;" src="uploads/'.htmlspecialchars($event['event_pic']).'"/>' ; ?>
            <input type="file" class="form-control" name="event_pic" accept=".jpg, .jpeg, .png">
        </div>

        <button type="submit" class="btn btn-primary">Update Event</button>
        <a href="event_detail.php?event_id=<?php echo htmlspecialchars($event_id); ?> " class="btn btn-info">Back to Event</a>
        <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </form>
</div>

</body>
</html>
