<?php
session_start();
include 'db_connect.php';


$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['user_id'])) {
    $user_id = $data['user_id'];

    $sqlCheck = "SELECT role FROM users WHERE user_id = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("i", $user_id);
    $stmtCheck->execute();
    $stmtCheck->bind_result($role);
    $stmtCheck->fetch();
    $stmtCheck->close();

    if ($role === 'admin') {
        echo json_encode(["status" => "error", "message" => "Admin users cannot be deleted."]);
    } else {
        $sqlDelete = "DELETE FROM users WHERE user_id = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bind_param("i", $user_id);

        if ($stmtDelete->execute()) {
            echo json_encode(["status" => "success", "message" => "User successfully deleted."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting user."]);
        }
        $stmtDelete->close();
    }
} else {
    echo json_encode(["status" => "error", "message" => "User ID not provided."]);
}

$conn->close();
