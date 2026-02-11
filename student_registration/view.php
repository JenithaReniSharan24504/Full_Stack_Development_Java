<?php  
include 'db.php';  
  
$sql = "SELECT * FROM students";  
$result = mysqli_query($conn, $sql);  
?>  
  
<!DOCTYPE html>  
<html>  
<head>  
    <title>Student List</title>  
    <style>  
        table {  
            border-collapse: collapse;  
            width: 80%;  
            margin: auto;  
        }  
        th, td {  
            border: 1px solid black;  
            padding: 8px;  
            text-align: center;  
        }  
        th {  
            background-color: #007BFF;  
            color: white;  
        }  
    </style>  
</head>  
<body>  
  
<h2 style="text-align:center;">Registered Students</h2>  
  
<table>  
    <tr>  
        <th>ID</th>  
        <th>Name</th>  
        <th>Email</th>  
        <th>DOB</th>  
        <th>Department</th>  
        <th>Phone</th>  
    </tr>  
  
    <?php  
    while ($row = mysqli_fetch_assoc($result)) {  
        echo "<tr>";  
        echo "<td>".$row['id']."</td>";  
        echo "<td>".$row['name']."</td>";  
        echo "<td>".$row['email']."</td>";  
        echo "<td>".$row['dob']."</td>";  
        echo "<td>".$row['department']."</td>";  
        echo "<td>".$row['phone']."</td>";  
        echo "</tr>";  
    }  
    ?>  
</table>  
  
</body>  
</html>