<!DOCTYPE html>
<html data-bs-theme="dark" lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("modules/header.php"); ?>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🚀 ULTIMATE BUDGET TRACKING EXPERIENCE 🚀</title>
    <link rel="shortcut icon" href="/Group_Project/GroupProject_Group12/images/favicon.png">
    <style>
        .bananas {
            margin: 0 ;
            height: 100vh ;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(270deg, #ff0000, #ff7300, #ffeb00, #47ff00, #00ffd5, #0066ff, #9400ff, #ff0099) ;
            background-size: 1600% 1600% ;
            animation: insanity 1s infinite linear ;
            text-align: center ;
            color: white ;
            overflow: hidden ;
            font-family: 'Comic Sans MS', cursive, sans-serif ;
        }
        @keyframes insanity {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .container {
            color: white;
            text-shadow: 0 0 10px black, 0 0 20px white;
            font-size: 2rem;
            animation: shake 0.25s infinite alternate;
        }
        @keyframes shake {
            0% { transform: rotate(-4deg) scale(0.95); }
            100% { transform: rotate(4deg) scale(1.1); }
        }
        .epic-button {
            display: inline-block;
            padding: 15px 30px;
            margin-top: 20px;
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            background: linear-gradient(45deg, #ff0000, #ff7300, #ffeb00, #47ff00, #00ffd5, #0066ff, #9400ff, #ff0099) !important;
            background-size: 300% 300%;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            animation: buttonAnimation 0.25s infinite linear;
        }
        .epic-button:hover {
            transform: scale(2);
            animation: spin 0.25s linear infinite;
        }

        @keyframes spin {
            from {
                transform: scale(1) rotate(0deg);
                box-shadow: 0;
            }
            to {
                transform: scale(2) rotate(-360deg);
                box-shadow: 0 0 40px white;
            }
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }
    </style>
</head>
<body>
    <div class="bananas">
        <div class="container">
            <h1>🚀 WELCOME TO THE ULTIMATE ENERGY ADMINISTRATION EXPERIENCE 🚀</h1>
            <p>Prepare yourself. Click below to enter the domain of EMNERGY wisdom. 💰</p>
            <button class="epic-button" onclick="window.location.href='/Group_Project/GroupProject_Group12/pages/home.php'">💸 UNLEASH THE CHAOS 💸</button>
        </div>
    </div>
</body>
</html>