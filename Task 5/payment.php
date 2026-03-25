<?php
$conn = new mysqli("localhost", "root", "", "dashboard");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$message = "";

// Fetch Users
$userQuery = "SELECT * FROM users";
$userResult = $conn->query($userQuery);

// Fetch Merchants
$merchantQuery = "SELECT * FROM merchants";
$merchantResult = $conn->query($merchantQuery);

if (isset($_POST['pay_now'])) {

    $user_id = $_POST['user_id'];
    $merchant_id = $_POST['merchant_id'];
    $amount = $_POST['amount'];

    // Start Transaction
    $conn->begin_transaction();

    try {

        // Step 1: Check User Balance
        $checkBalanceQuery = "SELECT balance FROM users WHERE user_id = $user_id";
        $balanceResult = $conn->query($checkBalanceQuery);
        $balanceRow = $balanceResult->fetch_assoc();

        $userBalance = $balanceRow['balance'];

        if ($amount > $userBalance) {
            throw new Exception("❌ Insufficient Balance!");
        }

        // Step 2: Deduct from User Account
        $deductQuery = "UPDATE users SET balance = balance - $amount WHERE user_id = $user_id";
        if (!$conn->query($deductQuery)) {
            throw new Exception("❌ Failed to deduct money from user.");
        }

        // Step 3: Add to Merchant Account
        $addQuery = "UPDATE merchants SET balance = balance + $amount WHERE merchant_id = $merchant_id";
        if (!$conn->query($addQuery)) {
            throw new Exception("❌ Failed to add money to merchant.");
        }

        // Step 4: Insert Payment Record
        $paymentInsertQuery = "INSERT INTO payments (user_id, merchant_id, amount, status)
                               VALUES ($user_id, $merchant_id, $amount, 'SUCCESS')";

        if (!$conn->query($paymentInsertQuery)) {
            throw new Exception("❌ Payment record insertion failed.");
        }

        // If everything is successful
        $conn->commit();
        $message = "<p style='color:green;'>✅ Payment Successful! Amount ₹$amount transferred.</p>";

    } catch (Exception $e) {

        // If any step fails
        $conn->rollback();

        // Insert failed payment record
        $conn->query("INSERT INTO payments (user_id, merchant_id, amount, status)
                      VALUES ($user_id, $merchant_id, $amount, 'FAILED')");

        $message = "<p style='color:red;'>".$e->getMessage()."</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payment Simulation</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            padding: 30px;
        }
        .box {
            width: 450px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        select, input {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
        }
        button {
            width: 100%;
            padding: 12px;
            background: green;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 6px;
        }
        button:hover {
            background: darkgreen;
        }
    </style>
</head>

<body>

<div class="box">
    <h2>💳 Online Payment Simulation</h2>

    <?php echo $message; ?>

    <form method="POST">
        <label>Select User:</label>
        <select name="user_id" required>
            <option value="">-- Select User --</option>
            <?php while ($row = $userResult->fetch_assoc()) { ?>
                <option value="<?php echo $row['user_id']; ?>">
                    <?php echo $row['name']; ?> (Balance: ₹<?php echo $row['balance']; ?>)
                </option>
            <?php } ?>
        </select>

        <br><br>

        <label>Select Merchant:</label>
        <select name="merchant_id" required>
            <option value="">-- Select Merchant --</option>
            <?php while ($mrow = $merchantResult->fetch_assoc()) { ?>
                <option value="<?php echo $mrow['merchant_id']; ?>">
                    <?php echo $mrow['merchant_name']; ?> (Balance: ₹<?php echo $mrow['balance']; ?>)
                </option>
            <?php } ?>
        </select>

        <br><br>

        <label>Enter Amount:</label>
        <input type="number" name="amount" min="1" required>

        <br><br>

        <button type="submit" name="pay_now">Pay Now</button>
    </form>
</div>

</body>
</html>