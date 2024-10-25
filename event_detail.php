<?php
session_start();
include 'db_connect.php';
include 'header.php';

$event_id = $_GET['event_id'];


$stmt = $conn->prepare("SELECT event_id, event_name, event_date_start, description, ticket_price, event_time_start, event_location, max_participants, event_status, event_pic, event_date_end, event_time_end FROM event WHERE event_id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$stmt->bind_result($event_id, $event_name, $event_date_start, $description, $ticket_price, $event_time_start, $event_location, $max_participants, $event_status, $event_pic, $event_date_end, $event_time_end);
$stmt->fetch();
$stmt->close();


$count_stmt = $conn->prepare("SELECT COUNT(*) FROM event_registration WHERE event_id = ?");
$count_stmt->bind_param("i", $event_id);
$count_stmt->execute();
$count_stmt->bind_result($registration_count);
$count_stmt->fetch();
$count_stmt->close();


$is_registered = false;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $check_registration = $conn->prepare("SELECT COUNT(*) FROM event_registration WHERE event_id = ? AND user_id = ?");
    $check_registration->bind_param("ii", $event_id, $user_id);
    $check_registration->execute();
    $check_registration->bind_result($is_registered);
    $check_registration->fetch();
    $check_registration->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $event_name; ?></title>
    <style>
        .event-img {
            width: 100%;
            height: 480px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card mb-4">
        <img src="uploads/<?php echo htmlspecialchars($event_pic); ?>" class="card-img-top event-img" alt="Event Picture">
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-7">
                    <h2 class="card-title"><?php echo htmlspecialchars($event_name); ?></h2>
                    <p class="card-text"><?php echo htmlspecialchars($description); ?></p>
                    <p><strong>Start:</strong> <?php echo htmlspecialchars($event_date_start) . " " . htmlspecialchars($event_time_start); ?></p>
                    <p><strong>End:</strong> <?php echo htmlspecialchars($event_date_end) . " " . htmlspecialchars($event_time_end); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($event_location); ?></p>
                    <p><strong>Price:</strong> <?php echo ($ticket_price == 0) ? 'Free' : 'Rp ' . number_format($ticket_price, 0, ','); ?></p>
                    <p><strong>Status:</strong> <?php echo strcmp($event_status,'full') == 0 ? 'Full' : 'Available' ?></p>
                    <strong>Attendees:</strong> <?php
                    echo strcmp($event_status,'full') === 0 ? htmlspecialchars($max_participants) : htmlspecialchars($registration_count);
                    echo "/" . htmlspecialchars($max_participants) ?>
                </div>

                <div class="col-md-5 d-flex flex-column align-items-end justify-content-start">
                    <?php if ($event_status === 'full'): ?>
                        <p class="text-danger"><strong>This event is full and cannot accept more registrations.</strong></p>
                    <?php else: ?>
                        <?php if ($is_registered): ?>
                            <button class="btn btn-secondary mb-3" disabled>Registered</button>
                        <?php else: ?>
                            <form method="post" action="register_event.php" class="mb-3">
                                <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event_id); ?>">
                                <button type="submit" name="register" class="btn btn-primary">Register</button>
                            </form>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <a href="edit_event.php?event_id=<?php echo htmlspecialchars($event_id); ?>" class='btn btn-warning mb-3'>Edit</a>
                        <a href="registrants_list.php?event_id=<?php echo htmlspecialchars($event_id); ?>" class="btn btn-info mb-3">View Registrants</a>
                    <?php endif; ?>
                    <a href="<?php echo isset($_SESSION['role']) && $_SESSION['role'] === 'admin' ? 'admin_dashboard.php' : 'index.php'; ?>" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
