<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
}
?>

<h2>Welcome <?php echo $_SESSION['user']; ?></h2>

<a href="logs.php">View Login Logs</a><br><br>
<a href="logout.php">Logout</a>