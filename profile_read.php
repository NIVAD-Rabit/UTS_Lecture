<?php
session_start();
include 'db_connect.php';
include 'header.php';


if (!isset($_GET['user_id'])) {
    echo "User ID tidak tersedia.";
    exit;
}

$user_id = $_GET['user_id'];


$stmt = $conn->prepare("SELECT username, email, created_at, updated_at, role FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email, $created_at, $updated_at, $role);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
</head>
<body>

<div class="container my-5">
    <h2 class="mb-4">Profil Pengguna</h2>
    <div class="card p-4">
        <div class="card-body">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Role:</strong> <?php echo ucfirst(htmlspecialchars($role)); ?></p>
            <p><strong>Dibuat Pada:</strong> <?php echo htmlspecialchars($created_at); ?></p>
            <p><strong>Diperbarui Pada:</strong> <?php echo htmlspecialchars($updated_at); ?></p>
        </div>
    </div>
    <a href="admin_user_dashboard.php" class="btn btn-secondary mt-3">Kembali ke Dashboard Pengguna</a>
</div>
</body>
</html>
