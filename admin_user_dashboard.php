<?php
session_start();
include 'header.php';
include 'db_connect.php';

$search = $_POST['search'] ?? '';

$sql = "SELECT user_id, username, email FROM users WHERE role = 'user' AND (username LIKE ? OR email LIKE ?)";
$searchTerm = "%" . $search . "%";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$stmt->bind_result($user_id, $username, $email);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Dashboard</title>
</head>
<body>
<div class="container my-5">
    <section>
        <h2 class="mb-4">User List</h2>
        
        <form method="POST" action="" class="input-group mb-4">
            <input type="text" class="form-control" name="search" placeholder="Search users..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        
        <div id="notification" style="display:none;" class="alert alert-success"></div>
        
        <div class="list-group" id="user-list">
            <?php
            while ($stmt->fetch()) {
                echo "<div class='list-group-item' id='user-$user_id'>";
                echo "<h5 class='mb-1'>" . htmlspecialchars($username) . "</h5>";
                echo "<p class='mb-1'>Email: " . htmlspecialchars($email) . "</p>";
                echo "<a href='profile_read.php?user_id=" . htmlspecialchars($user_id) . "' class='btn btn-sm btn-info me-2'>View Profile</a>";
                echo "<button onclick='deleteUser($user_id)' class='btn btn-sm btn-danger'>Delete</button>";
                echo "</div>";
            }
            ?>
        </div>
    </section>
</div>

<script>
    function deleteUser(userId) {
        if (confirm("Are you sure you want to delete this user?")) {
            fetch('delete_user.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    document.getElementById('user-' + userId).remove();

                    const notification = document.getElementById('notification');
                    notification.style.display = 'block';
                    notification.className = 'alert alert-success';
                    notification.textContent = data.message;
                    setTimeout(() => notification.style.display = 'none', 3000);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    }

</script>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
