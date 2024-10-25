<?php
session_start();
include 'db_connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();

    if ($user_id) {
        $_SESSION['user_id'] = $user_id;
        header("Location: reset_password.php");
    } else {
        echo "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h2>Lupa Password</h2>
    <form method="post" action="forgot_password.php">
        <label for="email">Masukkan email Anda:</label>
        <input type="email" name="email" id="email" required>
        <button type="submit">Kirim</button>
    </form>
    <a href="login.php">
            <button >back</button>
        </a>
</body>
</html>
