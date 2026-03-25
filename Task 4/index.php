<?php
$conn = new mysqli("localhost", "root", "", "orderdb");

$sql = "SELECT c.name, p.product_name, o.quantity, p.price,
        (o.quantity * p.price) AS total_amount, o.order_date
        FROM Orders o
        JOIN Customers c ON o.customer_id = c.customer_id
        JOIN Products p ON o.product_id = p.product_id
        ORDER BY o.order_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Customer Order History</h2>

<table>
<tr>
    <th>Name</th>
    <th>Product</th>
    <th>Qty</th>
    <th>Price</th>
    <th>Total</th>
    <th>Date</th>
</tr>

<?php while($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['name']; ?></td>
    <td><?php echo $row['product_name']; ?></td>
    <td><?php echo $row['quantity']; ?></td>
    <td><?php echo $row['price']; ?></td>
    <td><?php echo $row['total_amount']; ?></td>
    <td><?php echo $row['order_date']; ?></td>
</tr>
<?php } ?>

</table>

</body>
</html>