<?php
    session_start();
    if (!isset($_SESSION['user_name'])) {
        header("Location: index.php");
        exit();
    }
    
    $logged_user = $_SESSION['user_name'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "app_management";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (!isset($_GET['id'])) {
        echo "Invalid app ID.";
        exit();
    }

    $app_id = $_GET['id'];

    $sql = "SELECT * FROM tbl_data2 WHERE data2_id = '$app_id'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

    $sql2 = "SELECT * FROM tbl_ratings_reviews WHERE data_id = '$app_id'";
    $result2 = mysqli_query($conn, $sql2);
    // $data2 = mysqli_fetch_assoc($result2);

    // $reviews = [];
    // while ($row = mysqli_fetch_assoc($result2)) {
    //     $reviews[] = $row;
    // }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['app_name'] ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .topbar {
            background-color: #2c3e50;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            box-sizing: border-box;
        }

        .topbar h2 {
            margin: 0;
            font-size: 20px;
        }

        .topbar .logout-btn {
            background: white;
                color: rgb(57, 83, 111);
                padding: 8px 15px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-weight: bold;
                text-decoration: none;
                position: absolute;
                right: 20px;  /* ✅ Keeps the button 50px from the right */
                top: 50%; /* ✅ Centers vertically */
                transform: translateY(-50%); /* ✅ Adjusts centering */
        }

        .topbar .logout-btn:hover {
            background: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: auto;
            margin-top: 80px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .app-logo {
            width: 120px;
            height: 120px;
            border-radius: 15px;
        }

        .app-name {
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
        }

        .rating {
            font-size: 18px;
            color: #ff9800;
        }

        .review-container {
            margin-top: 20px;
            text-align: left;
        }

        .review {
            background: #f9f9f9;
            padding: 10px;
            border-radius: 5px;
            margin-top: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .no-reviews {
            font-style: italic;
            color: gray;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <h2>User Dashboard</h2>
        <div style="color: white; font-weight: bold;">Welcome, <?= htmlspecialchars($logged_user); ?></div>
        <form action="logout_user.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
    <div class="container">
        <img src="<?= htmlspecialchars($data['logo']) ?>" class="app-logo" alt="App Logo">
        <h2 class="app-name"><?= htmlspecialchars($data['app_name']) ?></h2>

        <!-- Ratings & Reviews -->
        <div class="review-container">
            <h3>User Reviews</h3>
            <?php while($data2 = mysqli_fetch_assoc($result2)){ ?>
                <div class="review">
                    <strong>⭐ <?= $data2['ratings'] ?></strong>
                    <p><?= htmlspecialchars($data2['reviews']) ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>