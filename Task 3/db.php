<?php
$conn = new mysqli("localhost", "root", "", "loginDB");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>