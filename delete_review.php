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
    
    if (isset($_GET['id'])) {
        $r_id = intval($_GET['id']);
    
        $sql = "DELETE FROM tbl_ratings_reviews WHERE r_id = $r_id";
        $result = mysqli_query($conn, $sql);

        if($result){
            header("Location: show_rate_review.php");
        }
        else{
            echo "cant delete sorry";
        }
    }
    else{
        echo "Invalid request";
    }
?>