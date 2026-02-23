<?php
include "db.php";

// Sorting values
$sort = isset($_GET['sort']) ? $_GET['sort'] : "name";
$order = isset($_GET['order']) ? $_GET['order'] : "ASC";

// Filter value
$departmentFilter = isset($_GET['department']) ? $_GET['department'] : "";

// Base query
$sql = "SELECT * FROM employees WHERE 1";

// Filter condition
if (!empty($departmentFilter)) {
    $sql .= " AND department = '$departmentFilter'";
}

// Sorting condition
if ($sort == "name") {
    $sql .= " ORDER BY name $order";
} else if ($sort == "date") {
    $sql .= " ORDER BY dob $order";
}

$result = $conn->query($sql);

// Department dropdown values
$deptQuery = "SELECT DISTINCT department FROM employees";
$deptResult = $conn->query($deptQuery);

// Count of employees per department
$countQuery = "SELECT department, COUNT(*) AS total FROM employees GROUP BY department";
$countResult = $conn->query($countQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
            padding: 30px;
        }

        h2 {
            text-align: center;
        }

        .filter-box {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        select, button {
            padding: 8px;
            margin: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #333;
            color: white;
        }

        .count-box {
            margin-top: 25px;
            background: white;
            padding: 15px;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <p style="text-align:right;">
    Welcome, <b><?php echo $_SESSION['username']; ?></b> |
    <a href="logout.php">Logout</a>
</p>


<h2>Student / Employee Dashboard</h2>

<!-- FILTER + SORT FORM -->
<div class="filter-box">
    <form method="GET">

        <label><b>Filter by Department:</b></label>
        <select name="department">
            <option value="">All</option>

            <?php while($dept = $deptResult->fetch_assoc()) { ?>
                <option value="<?php echo $dept['department']; ?>"
                    <?php if($departmentFilter == $dept['department']) echo "selected"; ?>>
                    <?php echo $dept['department']; ?>
                </option>
            <?php } ?>
        </select>

        <label><b>Sort by:</b></label>
        <select name="sort">
            <option value="name" <?php if($sort=="name") echo "selected"; ?>>Name</option>
            <option value="date" <?php if($sort=="date") echo "selected"; ?>>DOB</option>
        </select>

        <label><b>Order:</b></label>
        <select name="order">
            <option value="ASC" <?php if($order=="ASC") echo "selected"; ?>>Ascending</option>
            <option value="DESC" <?php if($order=="DESC") echo "selected"; ?>>Descending</option>
        </select>

        <button type="submit">Apply</button>

    </form>
</div>

<!-- MAIN TABLE -->
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>DOB</th>
        <th>Department</th>
        <th>Phone</th>
        <th>Created At</th>
    </tr>

    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".$row['id']."</td>
                    <td>".$row['name']."</td>
                    <td>".$row['email']."</td>
                    <td>".$row['dob']."</td>
                    <td>".$row['department']."</td>
                    <td>".$row['phone']."</td>
                    <td>".$row['created_at']."</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No Records Found</td></tr>";
    }
    ?>
</table>

<!-- COUNT TABLE -->
<div class="count-box">
    <h3>Count of Students/Employees Per Department</h3>

    <table>
        <tr>
            <th>Department</th>
            <th>Total</th>
        </tr>

        <?php while($countRow = $countResult->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $countRow['department']; ?></td>
                <td><?php echo $countRow['total']; ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
