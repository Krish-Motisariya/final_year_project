<?php
// ob_start();
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "app_management";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if(!$conn){
        die("we failed to connect : ".mysqli_connect_error());
    }
    else{
        // echo "connected succesfuly";
    }

    if(isset($_GET['id'])){
        $delete_id = $_GET['id'];
        // echo "the redirected id for delete is : ". $delete_id;

        $sql = "DELETE FROM `tbl_data2` WHERE data2_id='$delete_id'";
        // $sql = "UPDATE tbl_data2 SET status=0 WHERE data2_id = '$delete_id'";
        $result = mysqli_query($conn, $sql);

        if($result){
            header("Location: deleted_apps.php");
        }
        else{
            echo '<div class="alert alert-danger" role="alert">
                    Record Not Deleted!.....
                </div>';
        }
    }
    else{
        echo "Invalid OUtput";
    }

    

?>