<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "app_management";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_POST['username'];
    $uemail = $_POST['useremail'];
    $upass = $_POST['userpassword'];

    $checkUser = "SELECT * FROM tbl_users WHERE user_email = '$uemail'";
    $result = $conn->query($checkUser);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already registered! Try another.'); window.location.href='index.php';</script>";
    } else {
        $created_at=date("Y-m-d h:i:s");
        $updated_at=date("Y-m-d h:i:s");
        $sql = "INSERT INTO tbl_users (user_name, user_email, user_pass, created_at, updated_at) VALUES ('$uname', '$uemail', '$upass', '$created_at', '$updated_at')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration Successful! Please log in.'); window.location.href='index.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
$conn->close();
?>
