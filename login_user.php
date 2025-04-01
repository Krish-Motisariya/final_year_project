<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "app_management";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uemail = $_POST['useremail'];
    $upass = $_POST['userpassword'];

    $sql = "SELECT * FROM tbl_users WHERE user_email = '$uemail' AND user_pass = '$upass'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

    if ($result->num_rows > 0) {
        $_SESSION['user_name'] = $data['user_name'];
        echo "<script>alert('Login Successful!'); window.location.href='user_dashboard.php';</script>";
    } else {
        echo "<script>alert('Incorrect Password!'); window.location.href='index.php';</script>";
    }
}

$conn->close();
?>
