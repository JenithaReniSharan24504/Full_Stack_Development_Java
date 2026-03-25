<?php
session_start();
include("config.php");

$score = 0;

if(isset($_POST['answer'])) {
    foreach($_POST['answer'] as $question_id => $selected_option) {
        $question_id = (int)$question_id;
        $query = mysqli_query($conn, "SELECT correct_option FROM questions WHERE id = $question_id");
        $row = mysqli_fetch_assoc($query);

        if($selected_option == $row['correct_option']) {
            $score++;
        }
    }
}

$_SESSION['score'] = $score;

$statusColor = "red";
$statusText = "FAILED - NO CERTIFICATE";

if ($score >= 3) {
    $statusColor = "green";
    $statusText = "PASSED - CERTIFICATE AVAILABLE";
} elseif ($score == 2) {
    $statusColor = "orange";
    $statusText = "NEEDS IMPROVEMENT";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Result</title>
<style>
body {
    background: #060913;
    color: white;
    font-family: Arial;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.card {
    background: rgba(255,255,255,0.05);
    padding: 40px;
    border-radius: 15px;
    text-align: center;
    width: 400px;
}
.score {
    font-size: 60px;
    color: <?php echo $statusColor; ?>;
}
.status {
    margin: 20px 0;
    color: <?php echo $statusColor; ?>;
    font-weight: bold;
}
button {
    padding: 12px;
    width: 100%;
    background: #00f3ff;
    border: none;
    cursor: pointer;
    font-weight: bold;
}
</style>
</head>

<body>

<div class="card">
    <h2>Your Score</h2>

    <div class="score"><?php echo $score; ?>/5</div>

    <div class="status"><?php echo $statusText; ?></div>

    <p>User: <?php echo htmlspecialchars($_SESSION['username']); ?></p>
    <p>Accuracy: <?php echo ($score / 5) * 100; ?>%</p>

    <?php if ($score >= 3): ?>
        <form action="certificate.php">
            <button type="submit">Download Certificate</button>
        </form>
    <?php else: ?>
        <p style="color:red;">Minimum score 3 required for certificate</p>
    <?php endif; ?>

</div>

</body>
</html>