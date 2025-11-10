<?php
$servername = "localhost";
$username = "root";  // default XAMPP username
$password = "";      // default XAMPP password is empty
$dbname = "diecasthub"; // must match your database name in phpMyAdmin

$conn = new mysqli($servername, $username, $password, $dbname ,"8080");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

