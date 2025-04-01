<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "app_management");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $app_id = intval($_POST['app_id']);
    $review = trim($_POST['review']);

    if (empty($review)) {
        echo "Review cannot be empty!";
        exit();
    }

    $sql = "INSERT INTO tbl_ratings_reviews (app_id, rating, review, created_at) VALUES (?, NULL, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "is", $app_id, $review);

    if (mysqli_stmt_execute($stmt)) {
        echo "Review submitted successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
