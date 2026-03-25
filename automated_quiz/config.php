<?php
$conn = new mysqli("localhost","root","","automated_quiz_db");

if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}
?>