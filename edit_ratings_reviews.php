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
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Fetch existing app data
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_ratings_reviews WHERE r_id = $id";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
        $rating = $data['ratings'];
        $review = $data['reviews'];
        
        if(!$data){
            die("Ratings and reviews not found!");
        }
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $ratings = $_POST['rating'];
        $reviews = mysqli_real_escape_string($conn, $_POST['review']);

        $update = "UPDATE tbl_ratings_reviews
                    SET ratings='$ratings', reviews='$reviews'
                    WHERE r_id = $id";
        $update_result = mysqli_query($conn, $update);
        if($update_result){
            echo "<script>alert('Rating & Review updated successfully!'); 
              window.location.href='show_rate_review.php';</script>";
              exit();
        }
        else{
            echo "Something went wrong";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ratings & Reviews</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap-grid.min.css" integrity="sha512-i1b/nzkVo97VN5WbEtaPebBG8REvjWeqNclJ6AItj7msdVcaveKrlIIByDpvjk5nwHjXkIqGZscVxOrTb9tsMA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap-grid.rtl.min.css" integrity="sha512-V7mESobi1wvYdh9ghD/BDbehOyEDUwB4c4IVp97uL0QSka0OXjBrFrQVAHii6PNt/Zc1LwX6ISWhgw1jbxQqGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <h2>Edit Rating & Review for </h2>
        <form action="" method="POST">
            <label for="rating">Select Rating:</label>
            <select name="rating" id="rating" class="form-control" required>
                <option value="1" <?php echo ($rating == 1) ? 'selected' : ''; ?>>⭐ (1 Star)</option>
                <option value="2" <?php echo ($rating == 2) ? 'selected' : ''; ?>>⭐⭐ (2 Stars)</option>
                <option value="3" <?php echo ($rating == 3) ? 'selected' : ''; ?>>⭐⭐⭐ (3 Stars)</option>
                <option value="4" <?php echo ($rating == 4) ? 'selected' : ''; ?>>⭐⭐⭐⭐ (4 Stars)</option>
                <option value="5" <?php echo ($rating == 5) ? 'selected' : ''; ?>>⭐⭐⭐⭐⭐ (5 Stars)</option>
            </select>
            <br>
            <label for="review">Write Your Review:</label>
            <textarea name="review" id="review" class="form-control" rows="4"><?php echo htmlspecialchars($review); ?></textarea>
            <br>
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-dark" onclick="window.location.href='show_rate_review.php'">Back</button>
        </form>
    </div>
</body>
</html>