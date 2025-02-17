<?php
$host = 'localhost'; // or your database host
$db = 'niswey'; // your database name
$user = 'root'; // your username
$pass = ''; // your password

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>