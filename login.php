<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
        }

        .login-box {
            width: 350px;
            background: white;
            padding: 25px;
            margin: 100px auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px gray;
        }

        h2 {
            text-align: center;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background: #333;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: black;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 8px;
        }
    </style>
</head>

<body>

<div class="login-box">
    <h2>Login</h2>

    <form id="loginForm" action="login_process.php" method="POST" onsubmit="return validateForm()">
        
        <input type="email" name="email" id="email" placeholder="Enter Email">
        <div class="error" id="emailError"></div>

        <input type="password" name="password" id="password" placeholder="Enter Password">
        <div class="error" id="passwordError"></div>

        <div class="error" id="loginError">
            <?php
            if(isset($_GET['error'])) {
                echo $_GET['error'];
            }
            ?>
        </div>

        <button type="submit">Login</button>

    </form>
</div>

<script>
function validateForm() {
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    let emailError = document.getElementById("emailError");
    let passwordError = document.getElementById("passwordError");

    emailError.innerHTML = "";
    passwordError.innerHTML = "";

    let valid = true;

    // Email validation
    if(email === "") {
        emailError.innerHTML = "Email is required!";
        valid = false;
    }

    // Password validation
    if(password === "") {
        passwordError.innerHTML = "Password is required!";
        valid = false;
    }
    else if(password.length < 5) {
        passwordError.innerHTML = "Password must be at least 5 characters!";
        valid = false;
    }

    return valid;
}
</script>

</body>
</html>
