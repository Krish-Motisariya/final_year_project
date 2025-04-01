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

    // $sql = "SELECT * FROM tbl_data2 WHERE status = 1";
    // $result = mysqli_query($conn, $sql);
    // $apps = [];

    // while ($row = mysqli_fetch_assoc($result)) {
    //     $app_id = $row['data2_id'];

    //     // Get average rating
    //     $rating_query = "SELECT AVG(ratings) as avg_rating FROM tbl_ratings_reviews WHERE data_id = '$app_id'";
    //     $rating_result = mysqli_query($conn, $rating_query);
    //     $rating_row = mysqli_fetch_assoc($rating_result);
    //     $avg_rating = round($rating_row['avg_rating'], 1); // Round to 1 decimal place

    //     $row['avg_rating'] = $avg_rating ?: "N/A"; // If no ratings, show "N/A"
    //     $apps[] = $row;
    // }
    function formatDownloads($num) {
        if ($num >= 1000000000) {
            return round($num / 1000000000, 1) . "B+";
        } elseif ($num >= 1000000) {
            return round($num / 1000000, 1) . "M+";
        } elseif ($num >= 1000) {
            return round($num / 1000, 1) . "K+";
        } else {
            return $num . "+";
        }
    }
    
    // Fetch all active apps
    $sql = "SELECT * FROM tbl_data2 WHERE status = 1";
    $result = mysqli_query($conn, $sql);
    $apps = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $app_id = $row['data2_id'];
    
        // Get average rating
        $rating_query = "SELECT AVG(ratings) as avg_rating FROM tbl_ratings_reviews WHERE data_id = '$app_id'";
        $rating_result = mysqli_query($conn, $rating_query);
        $rating_row = mysqli_fetch_assoc($rating_result);
        $avg_rating = round($rating_row['avg_rating'], 1);
    
        $row['avg_rating'] = $avg_rating ?: "N/A";
        $row['formatted_downloads'] = formatDownloads($row['downloads']); // Convert downloads format
        $apps[] = $row;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .topbar {
            background-color: rgb(57, 83, 111);
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .logout-btn {
            background-color: white;
            color: black;
            padding: 5px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            position: absolute;
            right: 50px; /* Adjusted logout button position */
        }
        .container {
            margin-top: 70px;
            padding: 20px;
            text-align: center;
        }
        .app-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* 5 cards per row */
            gap: 20px; /* Spacing between cards */
            justify-content: center;
        }

        .app-card {
            width: 180px; /* Increased width */
            background-color: white;
            padding: 15px;
            border-radius: 15px;
            box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-top: 20px;
        }

        .app-logo {
            width: 100px; /* Increased logo size */
            height: 100px;
            border-radius: 15px;
            object-fit: cover;
        }

        .app-name {
            font-size: 14px; /* Larger app name */
            font-weight: bold;
            margin: 8px 0;
        }

        .app-info {
            font-size: 12px;
            color: #555;
            margin-top: 5px;
        }
        .app-rating {
            color: #777;
        }
        .app-downloads {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <h2>User Dashboard</h2>
        <div style="color: white; font-weight: bold; margin-right: 200px">Welcome, <?= htmlspecialchars($logged_user); ?></div>
        <form action="logout_user.php" method="POST">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
    <div class="container">
        <div class="app-grid">
            <?php foreach ($apps as $app) { ?>
                <div class="app-card">
                    <a href="app_details.php?id=<?php echo $app['data2_id'] ?>">
                        <img src="<?php echo htmlspecialchars($app['logo']); ?>" alt="App Logo" class="app-logo">
                    </a>
                    <div class="app-name"><?php echo htmlspecialchars($app['app_name']); ?></div>
                    <div class="app-info">
                        <span class="app-rating">⭐ <?php echo $app['avg_rating']; ?></span>
                        <span class="app-downloads"><?php echo $app['formatted_downloads']; ?> Downloads</span>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    </div>
</body>
</html>