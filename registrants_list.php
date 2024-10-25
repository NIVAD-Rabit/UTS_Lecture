<?php
session_start();
include 'db_connect.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$event_id = $_GET['event_id'] ?? '';

if (empty($event_id)) {
    echo "Event ID tidak ditemukan!";
    exit();
}

$stmt = $conn->prepare("SELECT users.user_id, users.username, users.email, event_registration.registration_date
                        FROM users 
                        JOIN event_registration ON users.user_id = event_registration.user_id
                        WHERE event_registration.event_id = ?");

$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>List of Registrants</title>
</head>
<body>
    <div class="container my-5">
        <h1 class="mb-4">List of Registrants for Event ID: <?php echo htmlspecialchars($event_id); ?></h1>

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Registration Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['registration_date']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>Tidak ada pendaftar</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <form method="post" action="export_registrants.php?event_id=<?php echo htmlspecialchars($event_id); ?>" class="mb-3">
            <button type="submit" name="export_csv" class="btn btn-primary">Export to CSV</button>
        </form>
        <a href="event_detail.php?event_id=<?php echo htmlspecialchars($event_id); ?> " class="btn btn-info mb-3">Back to Event</a><br>
        <a href="admin_dashboard.php" class="btn btn-secondary mb-3">Back to dashboard</a>
    </div>
</body>
</html>
