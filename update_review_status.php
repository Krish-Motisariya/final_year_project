<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "app_management";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if(isset($_POST['id']) && isset($_POST['status'])){
        $id = $_POST['id'];
        $status = $_POST['status'];

        $sql = "UPDATE tbl_ratings_reviews SET status = $status WHERE r_id = $id";
        $result = mysqli_query($conn, $sql);

        if($result){
            echo "status updated successfully";
        }
        else{
            echo "something went wrong";
        }
    }  
?>