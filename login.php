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
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM `tbl_admin` WHERE admin_email='$email' AND admin_pass='$pass'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['admin_name'] = $data['admin_name'];
        header("Location: after.php");
        exit();
    } else {
        header("Location: admin_signin.php");
        exit();
    }
}
?>