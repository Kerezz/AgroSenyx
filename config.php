<?php
// Database connection file

$host = "localhost";
$user = "root";
$pass = "";
$db = "agrosenyx";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

session_start();
?>