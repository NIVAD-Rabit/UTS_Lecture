<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_auth_db";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection fail: " . $conn->connect_error);
}
?>
