<?php
session_start();
include 'db_connect.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];


    $stmt = $conn->prepare("SELECT event_pic FROM event WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->bind_result($event_pic);
    $stmt->fetch();
    $stmt->close();


    if (!empty($event_pic) && file_exists('uploads/' . $event_pic)) {
        unlink('uploads/' . $event_pic);
    }


    $stmt = $conn->prepare("DELETE FROM event WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Event berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus event!";
    }

    $stmt->close();
    header("Location: admin_dashboard.php");
    exit();
} else {
    echo "Event ID tidak ditemukan!";
}
?>
