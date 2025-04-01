<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header("Location: auth-normal-sign-in.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "app_management";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get app ID from URL
if (!isset($_GET['app_id'])) {
    die("Invalid request!");
}
$app_id = $_GET['app_id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { font-family: Arial, sans-serif; }
        .sidebar {
            width: 250px;
            background: #222;
            color: white;
            position: fixed;
            top: 60px; /* Start right below the topbar */
            left: 0;
            height: calc(100% - 60px); /* Take remaining height */
            padding: 20px;
            overflow-y: auto;
            z-index: 999; /* Keep sidebar below topbar */
        }
        .content {
            margin-left: 250px;
            margin-top: 60px; /* Ensure content starts below topbar */
            padding: 20px;
        }
        .topbar {
            width: 100%;
            height: 60px;
            background: #333;
            color: white;
            position: fixed;
            justify-content: space-between;
            top: 0;
            z-index: 1000; /* Ensure topbar stays above sidebar */
            display: flex;
            align-items: center;
            padding: 0 20px;
        }
        .dataTables_wrapper { margin-top: 20px; }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
        }
    </style>
</head>
<body>
<div class="topbar">
        <button class="btn btn-light">☰</button>
        <div>
            <h3>App Management</h3>
        </div>
        <div>
            <span> <?php echo $_SESSION['admin_name']; ?> </span>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
    
    <div class="sidebar">
        <h2>SDK</h2>
        <a href="after.php">App</a>
        <a href="show_rate_review.php">Rate & Reviews</a>
        <a href="deleted_apps.php">Delete App</a>
    </div>
    <div class="content">
        <h2>Rate the App</h2>
        <form action="submit_rating_review.php" method="POST">
            <input type="hidden" name="app_id" value="<?php echo $app_id; ?>">
            
            <label for="rating">Select Rating:</label>
            <select name="rating" id="rating" class="form-control" required>
                <option value="">-- Choose --</option>
                <option value="1">⭐ (1 Star)</option>
                <option value="2">⭐⭐ (2 Stars)</option>
                <option value="3">⭐⭐⭐ (3 Stars)</option>
                <option value="4">⭐⭐⭐⭐ (4 Stars)</option>
                <option value="5">⭐⭐⭐⭐⭐ (5 Stars)</option>
            </select>
            <br><br>
            <label for="review">Write Your Review:</label>
            <textarea name="review" id="review" class="form-control" rows="4"></textarea>
            <br><br>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-dark" onclick="window.location.href='after.php'">Back</button>
        </form>
    </div>
</body>
</html>
