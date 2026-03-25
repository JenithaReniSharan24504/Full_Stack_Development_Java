<?php
include 'db.php';

$name = $_POST['name'];
$email = $_POST['email'];
$dob = $_POST['dob'];
$department = $_POST['department'];
$phone = $_POST['phone'];

$sql = "INSERT INTO students (name, email, dob, department, phone)
        VALUES ('$name', '$email', '$dob', '$department', '$phone')";

if (mysqli_query($conn, $sql)) {
    echo "Registration Successful <br>";
    echo "<a href='index.html'>Go Back</a>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>
