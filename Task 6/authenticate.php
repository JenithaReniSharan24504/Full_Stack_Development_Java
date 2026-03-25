<?php
session_start();
include 'db.php';

$username = $_POST['username'];
$password = MD5($_POST['password']);
$ip = $_SERVER['REMOTE_ADDR'];

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['user'] = $username;

    // Log SUCCESS
    $conn->query("INSERT INTO login_logs (username, status, ip_address) 
                  VALUES ('$username', 'SUCCESS', '$ip')");

    header("Location: dashboard.php");
} else {
    // Log FAILED
    $conn->query("INSERT INTO login_logs (username, status, ip_address) 
                  VALUES ('$username', 'FAILED', '$ip')");

    echo "Invalid credentials!";
}
?>