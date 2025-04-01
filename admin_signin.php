<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(215, 190, 190);
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 350px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            display: block;
        }
        button {
            width: 95%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        hr {
            margin-top: 15px;
            border: none;
            height: 1px;
            background: #ddd;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Admin Authentication</h2>
        <hr/>
        <form action="login.php" method="POST">
            <input type="email" name="email" placeholder="Your Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign In</button>
        </form>
    </div>

</body>
</html>
