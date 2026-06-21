<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "job_portal_db"; // Make sure to create this database in phpMyAdmin

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
