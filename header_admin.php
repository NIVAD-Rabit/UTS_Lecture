<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div id="top">
    <div id="logo">
        <a href="admin_dashboard.php">
            <img src="uploads/logo.pn" id="pokedex" alt="Logo" />
        </a>
    </div>
    <div><h2>Admin Dashboard</h2></div>
    <div>
        <form method="post" action="admin_dashboard.php">
            <input type="text" name="search" id="search" placeholder="Search Event">
            <button type="submit">Search</button>
        </form>
    </div>
    <div id="user-management">
        <a href="add_event.php">Add New Event</a> | 
        <a href="admin_dashboard.php">Manage Event</a> |
        <a href="admin_user_dashboard.php">Manage User</a> |
        <a href="logout.php">Log Out</a>
    </div>
</div>
