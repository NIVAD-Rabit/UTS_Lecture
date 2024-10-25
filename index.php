<?php
session_start();
include 'header.php';
include 'db_connect.php';

$search = $_POST['search'] ?? '';

$sql = "SELECT event_id, event_name, event_pic FROM event WHERE event_name LIKE ?";
$searchTerm = "%".$search."%";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$stmt->bind_result($event_id, $event_name, $event_pic);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Daftar Event</h2>
    
    <form method="POST" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search events..." value="<?= htmlspecialchars($search) ?>">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>
    
    <div class="row">
        <?php
        while ($stmt->fetch()) {
            echo "<div class='col-md-4 mb-4'>";
            echo    "<div class='card'>";
            echo        "<img src='uploads/" . htmlspecialchars($event_pic) . "' class='card-img-top w-100' style='max-height: 200px; object-fit: cover;' alt='Event Picture'>";
            echo        "<div class='card-body'>";
            echo            "<h5 class='card-title'>" . htmlspecialchars($event_name) . "</h5>";
            echo            "<a href='event_detail.php?event_id=" . htmlspecialchars($event_id) . "' class='btn btn-info'>Lihat Detail</a>";
            echo        "</div>";
            echo    "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<?php
    $stmt->close();
    $conn->close();
?>

</body>
</html>
