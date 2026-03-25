<?php
session_start();
include("config.php");

$_SESSION['category_id'] = $_POST['category_id'];

$query = mysqli_query($conn, "SELECT * FROM questions WHERE category_id=" . $_SESSION['category_id'] . " ORDER BY RAND() LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Assessment - Automated Quiz</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --neon-blue: #00f3ff;
            --neon-purple: #9d00ff;
            --dark-bg: #060913;
            --card-bg: rgba(10, 14, 23, 0.65);
            --option-bg: rgba(255, 255, 255, 0.03);
            --option-hover: rgba(0, 243, 255, 0.08);
            --option-selected: rgba(0, 243, 255, 0.15);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
            background-color: var(--dark-bg);
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(0, 243, 255, 0.08), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(157, 0, 255, 0.08), transparent 25%),
                linear-gradient(rgba(0, 243, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 243, 255, 0.03) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 40px 40px, 40px 40px;
            font-family: 'Outfit', sans-serif;
            color: #ffffff;
            position: relative;
        }

        .orb {
            position: fixed;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            filter: blur(100px);
            z-index: 0;
            animation: float 12s infinite alternate ease-in-out;
            pointer-events: none;
        }

        .orb-1 {
            background: rgba(0, 243, 255, 0.15);
            top: -10%;
            left: 10%;
        }

        .orb-2 {
            background: rgba(157, 0, 255, 0.15);
            bottom: -10%;
            right: 10%;
            animation-delay: -6s;
        }

        @keyframes float {
            0% { transform: translateY(0) translateX(0) scale(1); }
            100% { transform: translateY(-40px) translateX(40px) scale(1.05); }
        }

        .card {
            position: relative;
            z-index: 1;
            background: var(--card-bg);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            padding: 40px 50px;
            width: 100%;
            max-width: 800px;
            border-radius: 20px;
            border: 1px solid rgba(0, 243, 255, 0.15);
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.5), 
                        inset 0 0 20px rgba(0, 243, 255, 0.05);
            transition: box-shadow 0.4s ease, border-color 0.4s ease;
        }

        .card:hover {
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.6), 
                        0 0 40px rgba(0, 243, 255, 0.15),
                        inset 0 0 30px rgba(0, 243, 255, 0.1);
            border-color: rgba(0, 243, 255, 0.4);
        }

        .cyber-lines {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 20px;
            pointer-events: none;
            overflow: hidden;
        }

        .cyber-line {
            position: absolute;
            background: linear-gradient(90deg, transparent, var(--neon-blue), transparent);
            height: 1px;
            width: 100%;
            opacity: 0.5;
        }

        .cyber-line.top { top: 0; left: -100%; animation: scan-horizontal 5s linear infinite; }
        .cyber-line.bottom { bottom: 0; right: -100%; background: linear-gradient(-90deg, transparent, var(--neon-blue), transparent); animation: scan-horizontal-reverse 5s linear infinite; animation-delay: 2.5s; }

        @keyframes scan-horizontal {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        @keyframes scan-horizontal-reverse {
            0% { right: -100%; }
            100% { right: 100%; }
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0, 243, 255, 0.2);
            position: relative;
        }
        
        .header-container::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100px;
            height: 2px;
            background: var(--neon-blue);
            box-shadow: 0 0 10px var(--neon-blue);
        }

        h2 {
            font-family: 'Orbitron', sans-serif;
            color: #ffffff;
            font-size: 24px;
            letter-spacing: 2px;
            font-weight: 700;
            text-transform: uppercase;
            margin: 0;
        }
        
        h2 span {
            color: var(--neon-blue);
            text-shadow: 0 0 10px rgba(0, 243, 255, 0.5);
        }

        .status-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(0, 243, 255, 0.1);
            border: 1px solid var(--neon-blue);
            padding: 6px 12px;
            border-radius: 6px;
            font-family: 'Orbitron', sans-serif;
            font-size: 12px;
            letter-spacing: 1px;
            color: var(--neon-blue);
            box-shadow: 0 0 10px rgba(0, 243, 255, 0.2);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: var(--neon-blue);
            border-radius: 50%;
            box-shadow: 0 0 5px var(--neon-blue);
            animation: blink 1.5s infinite alternate;
        }

        @keyframes blink {
            0% { opacity: 0.3; }
            100% { opacity: 1; }
        }

        .question-block {
            margin-bottom: 40px;
            position: relative;
            padding-left: 20px;
            border-left: 2px solid rgba(255, 255, 255, 0.1);
            transition: border-color 0.3s ease;
        }

        .question-block:hover {
            border-left-color: var(--neon-blue);
        }

        .question-text {
            font-size: 18px;
            font-weight: 400;
            line-height: 1.6;
            margin-bottom: 20px;
            color: #fff;
        }

        .q-number {
            font-family: 'Orbitron', sans-serif;
            color: var(--neon-blue);
            font-weight: 700;
            margin-right: 10px;
            text-shadow: 0 0 5px rgba(0, 243, 255, 0.5);
            font-size: 20px;
        }

        .options {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .options label {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            background: var(--option-bg);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 15px;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .options label::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, rgba(0, 243, 255, 0.1), transparent);
            transition: width 0.3s ease;
            z-index: 0;
        }

        .options label:hover {
            background: var(--option-hover);
            border-color: rgba(0, 243, 255, 0.3);
            transform: translateX(5px);
        }

        .options label:hover::before {
            width: 100%;
        }

        /* Custom Radio Button Styles */
        .options input[type="radio"] {
            display: none;
        }

        .radio-custom {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            margin-right: 15px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
            flex-shrink: 0;
        }

        .radio-custom::after {
            content: '';
            width: 10px;
            height: 10px;
            background: var(--neon-blue);
            border-radius: 50%;
            transform: scale(0);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 0 8px var(--neon-blue);
        }

        .options input[type="radio"]:checked + .radio-custom {
            border-color: var(--neon-blue);
            box-shadow: 0 0 10px rgba(0, 243, 255, 0.3);
        }

        .options input[type="radio"]:checked + .radio-custom::after {
            transform: scale(1);
        }

        .options input[type="radio"]:checked ~ .option-text {
            color: var(--neon-blue);
            font-weight: 600;
            text-shadow: 0 0 5px rgba(0, 243, 255, 0.3);
        }

        .option-content {
            display: flex;
            align-items: center;
            position: relative;
            z-index: 1;
            width: 100%;
        }

        .option-text {
            transition: color 0.3s ease;
        }

        /* Group selected state for the label wrapper */
        .options label:has(input[type="radio"]:checked) {
            background: var(--option-selected);
            border-color: var(--neon-blue);
            box-shadow: 0 0 15px rgba(0, 243, 255, 0.1);
        }

        button {
            width: 100%;
            padding: 18px;
            margin-top: 30px;
            background: rgba(0, 243, 255, 0.05);
            color: var(--neon-blue);
            border: 1px solid var(--neon-blue);
            border-radius: 10px;
            font-family: 'Orbitron', sans-serif;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 3px;
            cursor: pointer;
            text-transform: uppercase;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 0 20px rgba(0, 243, 255, 0.15), inset 0 0 10px rgba(0, 243, 255, 0.05);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
        }

        button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 243, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        button:hover {
            background: rgba(0, 243, 255, 0.15);
            box-shadow: 0 0 30px rgba(0, 243, 255, 0.4), inset 0 0 15px rgba(0, 243, 255, 0.2);
            text-shadow: 0 0 10px rgba(0, 243, 255, 0.8);
            transform: translateY(-2px);
        }

        button:hover::before {
            left: 100%;
        }

        button svg {
            width: 24px;
            height: 24px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            transition: transform 0.3s ease;
        }
        
        button:hover svg {
            transform: translateX(5px);
        }

        .progress-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: var(--neon-blue);
            width: 100%;
            box-shadow: 0 0 10px var(--neon-blue);
            border-radius: 0 0 20px 20px;
        }

    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div class="card">
    <div class="cyber-lines">
        <div class="cyber-line top"></div>
        <div class="cyber-line bottom"></div>
    </div>
    
    <div class="header-container">
        <h2>Active <span>Assessment</span></h2>
        <div class="status-badge">
            <div class="status-dot"></div>
            SYSTEM RECORDING
        </div>
    </div>

    <form method="POST" action="result.php">

<?php 
$i = 1;
while ($row = mysqli_fetch_assoc($query)) { 
?>

<div class="question-block">
    <div class="question-text">
        <span class="q-number">Q<?php echo sprintf("%02d", $i); ?>.</span>
        <?php echo htmlspecialchars($row['question']); ?>
    </div>

    <div class="options">
        <label>
            <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="1" required>
            <div class="option-content">
                <span class="radio-custom"></span>
                <span class="option-text"><?php echo htmlspecialchars($row['option1']); ?></span>
            </div>
        </label>

        <label>
            <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="2">
            <div class="option-content">
                <span class="radio-custom"></span>
                <span class="option-text"><?php echo htmlspecialchars($row['option2']); ?></span>
            </div>
        </label>

        <label>
            <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="3">
            <div class="option-content">
                <span class="radio-custom"></span>
                <span class="option-text"><?php echo htmlspecialchars($row['option3']); ?></span>
            </div>
        </label>

        <label>
            <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="4">
            <div class="option-content">
                <span class="radio-custom"></span>
                <span class="option-text"><?php echo htmlspecialchars($row['option4']); ?></span>
            </div>
        </label>
    </div>
</div>

<?php 
$i++;
} 
?>

<button type="submit">
    Transmit Data
</button>

</form>
    
    <div class="progress-bar"></div>
</div>

</body>
</html>