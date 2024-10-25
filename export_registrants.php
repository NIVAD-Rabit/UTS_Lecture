<?php
session_start();
include 'db_connect.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$event_id = $_GET['event_id'] ?? '';

if (empty($event_id)) {
    echo "Event ID tidak ditemukan!";
    exit();
}

if (isset($_POST['export_csv'])) {

    $stmt = $conn->prepare("SELECT users.user_id, users.username, users.email, event_registration.registration_date 
                            FROM users 
                            JOIN event_registration ON users.user_id = event_registration.user_id 
                            WHERE event_registration.event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();


    $filename = "registrants_event_" . $event_id . ".csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $output = fopen('php://output', 'w');

    $delimiter = ';';


    fputcsv($output, array('User ID', 'Username', 'Email', 'Registration Date'), $delimiter);


    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row, $delimiter);
    }
    
    fclose($output);
    exit();
}
?>
