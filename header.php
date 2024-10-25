<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="uploads/logo.png" id="pokedex" alt="Logo" style="width: 50px; height: 50px;" class="me-2">
            <span>EventDex</span>
        </a>

        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="index.php">Home</a>
            <?php
            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                echo '<a class="nav-link" href="add_event.php">Add New Event</a>'; 
                echo '<a class="nav-link" href="admin_dashboard.php">Manage Events</a>';
                echo '<a class="nav-link" href="admin_user_dashboard.php">Manage Users</a>';
            }
            if (isset($_SESSION['user_id'])) {
                echo '<a class="nav-link" href="profile.php">Profile</a>';
                echo '<a class="nav-link" href="logout.php">Log Out</a>';
            } else {
                echo '<a class="nav-link" href="login.php">Log In</a>';
                echo '<a class="nav-link" href="register.php">Register</a>';
            }
            ?>
        </div>
    </div>
</nav>
