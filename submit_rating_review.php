<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "app_management";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $app_id = $_POST['app_id'];
    $rating = $_POST['rating'];
    $review = mysqli_real_escape_string($conn, $_POST['review']);

    
    $sql = "INSERT INTO tbl_ratings_reviews (data_id, ratings, reviews, created_at) VALUES ('$app_id', '$rating', '$review', NOW())";
    $result = mysqli_query($conn, $sql);
    // mysqli_stmt_bind_param($result, "iis", $app_id, $rating, $review);
    // mysqli_stmt_execute($result);
    if($result){
        echo "<script>alert('Rating submitted successfully!'); window.location.href='after.php';</script>";
    }
    else{
        echo "something went wrong";
    }
}

mysqli_close($conn);
?>
