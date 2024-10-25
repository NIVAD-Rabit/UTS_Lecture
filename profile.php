<?php
session_start();
include 'db_connect.php';
include 'header.php';

$user_id = $_SESSION['user_id'];


$user_stmt = $conn->prepare("SELECT username, email, password_hash FROM users WHERE user_id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_stmt->bind_result($username, $email, $password_hash);
$user_stmt->fetch();
$user_stmt->close();


if (isset($_POST['update_profile'])) {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    

    if (!empty($_POST['password'])) {
        $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $update_stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, password_hash = ? WHERE user_id = ?");
        $update_stmt->bind_param("sssi", $new_username, $new_email, $new_password, $user_id);
    } else {

        $update_stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE user_id = ?");
        $update_stmt->bind_param("ssi", $new_username, $new_email, $user_id);
    }

    if ($update_stmt->execute()) {
        echo "<div class='alert alert-success'>Profile updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to update profile.</div>";
    }
    $update_stmt->close();
}


if (isset($_POST['delete_registration'])) {
    $registration_id = $_POST['registration_id'];
    $delete_stmt = $conn->prepare("DELETE FROM event_registration WHERE registration_id = ? AND user_id = ?");
    $delete_stmt->bind_param("ii", $registration_id, $user_id);

    if ($delete_stmt->execute()) {
        echo "<div class='alert alert-success'>Registration cancelled successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to cancel registration.</div>";
    }
    $delete_stmt->close();
}


$stmt = $conn->prepare("SELECT event_name, registration_date, registration_id, status FROM event_registration JOIN event ON event_registration.event_id = event.event_id WHERE event_registration.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($event_name, $registration_date, $registration_id, $status);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile</title>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Edit Profile</h2>

    <!-- Form untuk mengedit profil -->
    <form method="post" class="mb-5">
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New Password (leave blank to keep current password):</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
    </form>

    <h3>Registered Events:</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Event</th>
                <th>Registration Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        while ($stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($event_name) . "</td>";
            echo "<td>" . htmlspecialchars($registration_date) . "</td>";
            echo "<td>" . htmlspecialchars($status) . "</td>";
            echo "<td>";
            echo "<form method='post' class='d-inline' onsubmit='return confirm(\"Are you sure you want to cancel this registration?\");'>";
            echo "<input type='hidden' name='registration_id' value='" . htmlspecialchars($registration_id) . "'>";
            echo "<button type='submit' name='delete_registration' class='btn btn-danger btn-sm'>Cancel</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
</div>
</body>
</html>

<?php
$stmt->close();
?>
