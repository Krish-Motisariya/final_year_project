<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "app_management";
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Failed to connect: " . mysqli_connect_error());
    }

    if(isset($_GET['id'])){
        $restore_id = $_GET['id'];

        $sql = "UPDATE tbl_data2 SET status=1 WHERE data2_id='$restore_id'";
        $result = mysqli_query($conn, $sql);

        if($result){
            header("Location: deleted_apps.php");
        }
        else{
            echo '<div class="alert alert-danger" role="alert">
                    Failed to restore record!
                </div>';
        }
    }
    else{
        echo "invalid request";
    }

?>