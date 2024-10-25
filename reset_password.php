<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: forgot_password.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $user_id = $_SESSION['user_id'];

    
    $stmt = $conn->prepare("UPDATE users SET password_hash = ? WHERE user_id = ?");
    $stmt->bind_param("si", $new_password, $user_id);
    $stmt->execute();

    
    unset($_SESSION['user_id']);

    echo "Password berhasil direset. Silakan coba<a href=login.php> login</a> ulang.";

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="post" action="reset_password.php">
        <label for="new_password">Masukkan password baru:</label>
        <input type="password" name="new_password" id="new_password" required>
        <button type="submit">Reset Password</button>
    </form>
    <a href="forgot_password.php">
            <button >Cancel</button>
        </a>
</body>
</html>
