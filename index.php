<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Authentication</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(215, 190, 190);
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 300px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 95%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #28a745;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }
        .toggle-btn {
            background-color: #007bff;
            margin-top: 10px;
        }
        .toggle-btn:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function toggleForm(type) {
            if (type === 'register') {
                document.getElementById('registerForm').style.display = 'block';
                document.getElementById('loginForm').style.display = 'none';
            } else {
                document.getElementById('registerForm').style.display = 'none';
                document.getElementById('loginForm').style.display = 'block';
            }
        }
    </script>
</head>
<body>

    <div class="container">
        <h2>User Authentication</h2>
        <!-- Register Form -->
        <div id="registerForm">
            <form action="register_user.php" method="POST">
                <input type="text" name="username" placeholder="Enter Username" required>
                <input type="email" name="useremail" placeholder="Enter Email" required>
                <input type="password" name="userpassword" placeholder="Enter Password" required>
                <button type="submit">Register</button>
            </form>
            <button class="toggle-btn" onclick="toggleForm('login')">Already have an account? Sign In</button>
        </div>
        <!-- Login Form (Hidden by Default) -->
        <div id="loginForm" style="display: none;">
            <form action="login_user.php" method="POST">
                <input type="email" name="useremail" placeholder="Enter Email" required>
                <input type="password" name="userpassword" placeholder="Enter Password" required>
                <button type="submit">Sign In</button>
            </form>
            <button class="toggle-btn" onclick="toggleForm('register')">New User? Register Here</button>
        </div>
    </div>
</body>
</html>