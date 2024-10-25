<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['register'])) {
    $user_id = $_SESSION['user_id'];
    $event_id = $_POST['event_id'];

   
    $stmt = $conn->prepare("SELECT count(*) FROM event_registration WHERE user_id = ? AND event_id = ?");
    $stmt->bind_param("ii", $user_id, $event_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $_SESSION['error'] = "Anda sudah terdaftar di event ini!";
    } else {

        $stmt = $conn->prepare("INSERT INTO event_registration (user_id, event_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $event_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Pendaftaran event berhasil!";
        } else {
            $_SESSION['error'] = "Pendaftaran gagal!";
        }
        $stmt->close();
    }
    header("Location: event_detail.php?event_id=" . $event_id);
    exit();
}
?>
