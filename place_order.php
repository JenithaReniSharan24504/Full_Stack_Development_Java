<?php
$conn = new mysqli("localhost", "root", "", "dashboard");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if (isset($_POST['place_order'])) {

    $customer_id = $_POST['customer_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check Stock
    $checkStockQuery = "SELECT stock FROM products WHERE product_id = $product_id";
    $stockResult = $conn->query($checkStockQuery);
    $stockRow = $stockResult->fetch_assoc();

    $availableStock = $stockRow['stock'];

    if ($quantity > $availableStock) {
        $message = "<p style='color:red;'>❌ Not enough stock available!</p>";
    } else {

        // Insert Order
        $insertOrderQuery = "INSERT INTO orders (customer_id, product_id, quantity, order_date)
                             VALUES ($customer_id, $product_id, $quantity, CURDATE())";

        if ($conn->query($insertOrderQuery) === TRUE) {

            // Update Stock
            $newStock = $availableStock - $quantity;
            $updateStockQuery = "UPDATE products SET stock = $newStock WHERE product_id = $product_id";
            $conn->query($updateStockQuery);

            $message = "<p style='color:green;'>✅ Order Placed Successfully!</p>";
        } else {
            $message = "<p style='color:red;'>❌ Error placing order!</p>";
        }
    }
}

// Fetch Customers
$customerQuery = "SELECT customer_id, name FROM customers";
$customerResult = $conn->query($customerQuery);

// Fetch Products
$productQuery = "SELECT product_id, product_name, stock FROM products";
$productResult = $conn->query($productQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Place Order</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            padding: 30px;
        }

        .box {
            width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
        }

        select, input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: blue;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 6px;
        }

        button:hover {
            background: darkblue;
        }
    </style>
</head>

<body>

<div class="box">
    <h2>🛒 Place Order</h2>

    <?php
    if (isset($message)) {
        echo $message;
    }
    ?>

    <form method="POST">
        <label>Select Customer:</label>
        <select name="customer_id" required>
            <option value="">--Select Customer--</option>
            <?php
            while ($cust = $customerResult->fetch_assoc()) {
                echo "<option value='{$cust['customer_id']}'>{$cust['name']}</option>";
            }
            ?>
        </select>

        <br><br>

        <label>Select Product:</label>
        <select name="product_id" required>
            <option value="">--Select Product--</option>
            <?php
            while ($prod = $productResult->fetch_assoc()) {
                echo "<option value='{$prod['product_id']}'>{$prod['product_name']} (Stock: {$prod['stock']})</option>";
            }
            ?>
        </select>

        <br><br>

        <label>Enter Quantity:</label>
        <input type="number" name="quantity" min="1" required>

        <br><br>

        <button type="submit" name="place_order">Place Order</button>
    </form>
</div>

</body>
</html>
