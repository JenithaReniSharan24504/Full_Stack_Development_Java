<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Automated Quiz</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --neon-blue: #00f3ff;
            --neon-purple: #9d00ff;
            --dark-bg: #060913;
            --card-bg: rgba(10, 14, 23, 0.65);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--dark-bg);
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(0, 243, 255, 0.08), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(157, 0, 255, 0.08), transparent 25%),
                linear-gradient(rgba(0, 243, 255, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0, 243, 255, 0.03) 1px, transparent 1px);
            background-size: 100% 100%, 100% 100%, 40px 40px, 40px 40px;
            font-family: 'Outfit', sans-serif;
            color: #ffffff;
            overflow: hidden;
            position: relative;
        }

        .orb {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            filter: blur(100px);
            z-index: 0;
            animation: float 12s infinite alternate ease-in-out;
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
            padding: 50px 40px;
            width: 420px;
            border-radius: 20px;
            border: 1px solid rgba(0, 243, 255, 0.15);
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.5), 
                        inset 0 0 20px rgba(0, 243, 255, 0.05);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), 
                        box-shadow 0.4s ease, border-color 0.4s ease;
        }

        .card:hover {
            transform: translateY(-8px);
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

        .cyber-line.top { top: 0; left: -100%; animation: scan-horizontal 4s linear infinite; }
        .cyber-line.bottom { bottom: 0; right: -100%; background: linear-gradient(-90deg, transparent, var(--neon-blue), transparent); animation: scan-horizontal-reverse 4s linear infinite; animation-delay: 2s; }
        
        .cyber-line-v {
            position: absolute;
            background: linear-gradient(180deg, transparent, var(--neon-purple), transparent);
            width: 1px;
            height: 100%;
            opacity: 0.5;
        }

        .cyber-line-v.left { left: 0; top: -100%; animation: scan-vertical 4s linear infinite; animation-delay: 1s; }
        .cyber-line-v.right { right: 0; bottom: -100%; background: linear-gradient(-180deg, transparent, var(--neon-purple), transparent); animation: scan-vertical-reverse 4s linear infinite; animation-delay: 3s; }

        @keyframes scan-horizontal {
            0% { left: -100%; }
            100% { left: 100%; }
        }
        @keyframes scan-horizontal-reverse {
            0% { right: -100%; }
            100% { right: 100%; }
        }
        @keyframes scan-vertical {
            0% { top: -100%; }
            100% { top: 100%; }
        }
        @keyframes scan-vertical-reverse {
            0% { bottom: -100%; }
            100% { bottom: 100%; }
        }

        .icon-container {
            display: flex;
            justify-content: center;
            margin-bottom: 25px;
            position: relative;
        }

        .hexagon {
            width: 70px;
            height: 80px;
            background: rgba(0, 243, 255, 0.1);
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid var(--neon-blue);
            box-shadow: 0 0 15px rgba(0, 243, 255, 0.3);
            position: relative;
        }
        
        .hexagon::before {
            content: '';
            position: absolute;
            inset: 2px;
            background: var(--dark-bg);
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            z-index: -1;
        }

        .icon-container svg {
            width: 34px;
            height: 34px;
            stroke: var(--neon-blue);
            stroke-width: 1.5;
            fill: none;
            filter: drop-shadow(0 0 5px var(--neon-blue));
            animation: pulse-glow 2s infinite alternate;
        }

        @keyframes pulse-glow {
            0% { filter: drop-shadow(0 0 3px var(--neon-blue)); }
            100% { filter: drop-shadow(0 0 10px var(--neon-blue)); stroke: #fff; }
        }

        h2 {
            text-align: center;
            margin-bottom: 35px;
            font-family: 'Orbitron', sans-serif;
            color: #ffffff;
            font-size: 26px;
            letter-spacing: 3px;
            font-weight: 700;
            text-transform: uppercase;
        }
        
        h2 span {
            color: var(--neon-blue);
            text-shadow: 0 0 15px rgba(0, 243, 255, 0.6);
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
        }

        .input-group input {
            width: 100%;
            padding: 16px 16px 16px 48px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            letter-spacing: 0.5px;
            outline: none;
            transition: all 0.3s ease;
        }

        .input-group input:focus {
            border-color: var(--neon-blue);
            background: rgba(0, 243, 255, 0.03);
            box-shadow: 0 0 20px rgba(0, 243, 255, 0.15);
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.3);
            font-weight: 300;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }
        
        .input-icon svg {
            width: 20px;
            height: 20px;
            stroke: rgba(255, 255, 255, 0.4);
            stroke-width: 2;
            fill: none;
            transition: all 0.3s ease;
        }

        .input-group input:focus + .input-icon svg,
        .input-group input:not(:placeholder-shown) + .input-icon svg {
            stroke: var(--neon-blue);
            filter: drop-shadow(0 0 5px rgba(0, 243, 255, 0.6));
        }

        button {
            width: 100%;
            padding: 16px;
            margin-top: 10px;
            background: rgba(0, 243, 255, 0.05);
            color: var(--neon-blue);
            border: 1px solid var(--neon-blue);
            border-radius: 10px;
            font-family: 'Orbitron', sans-serif;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 2px;
            cursor: pointer;
            text-transform: uppercase;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(0, 243, 255, 0.1), inset 0 0 10px rgba(0, 243, 255, 0.05);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
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
            box-shadow: 0 0 25px rgba(0, 243, 255, 0.4), inset 0 0 15px rgba(0, 243, 255, 0.2);
            text-shadow: 0 0 10px rgba(0, 243, 255, 0.8);
            transform: translateY(-2px);
        }

        button:hover::before {
            left: 100%;
        }

        button svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            transition: transform 0.3s ease;
        }
        
        button:hover svg {
            transform: translateX(5px);
        }

        .dots {
            position: absolute;
            display: flex;
            gap: 4px;
        }
        .dots-tr { top: 20px; right: 20px; }
        .dots-bl { bottom: 20px; left: 20px; }
        
        .dot {
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        .card:hover .dot { background: var(--neon-blue); box-shadow: 0 0 5px var(--neon-blue); }
        .card:hover .dot:nth-child(1) { transition-delay: 0.1s; }
        .card:hover .dot:nth-child(2) { transition-delay: 0.2s; }
        .card:hover .dot:nth-child(3) { transition-delay: 0.3s; }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div class="card">
    <div class="cyber-lines">
        <div class="cyber-line top"></div>
        <div class="cyber-line bottom"></div>
        <div class="cyber-line-v left"></div>
        <div class="cyber-line-v right"></div>
    </div>
    
    <div class="dots dots-tr">
        <div class="dot"></div><div class="dot"></div><div class="dot"></div>
    </div>
    <div class="dots dots-bl">
        <div class="dot"></div><div class="dot"></div><div class="dot"></div>
    </div>

    <div class="icon-container">
        <div class="hexagon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
        </div>
    </div>

    <h2>Auto <span>Quiz</span></h2>

    <form method="POST" action="category.php">
        <div class="input-group">
            <input type="text" name="username" id="username" placeholder="IDENTIFICATION: NAME" required autocomplete="off">
            <div class="input-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
        </div>

        <div class="input-group">
            <input type="email" name="email" id="email" placeholder="COMM LINK: EMAIL" required autocomplete="off">
            <div class="input-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
            </div>
        </div>

        <button type="submit">
            Initialize
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <line x1="5" y1="12" x2="19" y2="12"></line>
                <polyline points="12 5 19 12 12 19"></polyline>
            </svg>
        </button>
    </form>
</div>

</body>
</html>