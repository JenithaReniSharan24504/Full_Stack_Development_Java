<?php
include 'db.php';

$result = $conn->query("SELECT * FROM login_logs ORDER BY login_time DESC");
?>

<h2>Login Activity Logs</h2>

<table border="1">
<tr>
    <th>Username</th>
    <th>Status</th>
    <th>IP Address</th>
    <th>Time</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['username']; ?></td>
    <td><?php echo $row['status']; ?></td>
    <td><?php echo $row['ip_address']; ?></td>
    <td><?php echo $row['login_time']; ?></td>
</tr>
<?php } ?>

</table>