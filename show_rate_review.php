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

    $sql_apps = "SELECT * FROM tbl_data2 WHERE status=1";
    $result_apps = mysqli_query($conn, $sql_apps);

    // Fetch all ratings and reviews by default
    $app_filter = "";
    if (isset($_GET['app_id']) && $_GET['app_id'] != "") {
        $app_filter = " WHERE r.data_id=" . intval($_GET['app_id']);
    }

    $sql_reviews = "SELECT r.r_id, d.app_name, r.ratings, r.reviews, r.status 
                    FROM tbl_ratings_reviews r 
                    JOIN tbl_data2 d ON r.data_id = d.data2_id" . $app_filter;

    $result_reviews = mysqli_query($conn, $sql_reviews);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Ratings & Reviews</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/brands.min.css" integrity="sha512-58P9Hy7II0YeXLv+iFiLCv1rtLW47xmiRpC1oFafeKNShp8V5bKV/ciVtYqbk2YfxXQMt58DjNfkXFOn62xE+g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/fontawesome.min.css" integrity="sha512-v8QQ0YQ3H4K6Ic3PJkym91KoeNT5S3PnDKvqnwqFD1oiqIl653crGZplPdU5KKtHjO0QKcQ2aUlQZYjHczkmGw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/regular.min.css" integrity="sha512-8hM9a+2hrLBhOuB3uiy+QIXBsu6Qk+snsP1CboFQW6pdt/yYz0IcDp/+CGv5m39r9doGUc/zw6aBpyLF6XFgzg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/solid.min.css" integrity="sha512-DzC7h7+bDlpXPDQsX/0fShhf1dLxXlHuhPBkBo/5wJWRoTU6YL7moeiNoej6q3wh5ti78C57Tu1JwTNlcgHSjg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/svg-with-js.min.css" integrity="sha512-vtbctC7BecZMHWPWej78RfcB9RmGpIx+G4+1IT2/Z9P7SIXApaI1XLOCrzpSKgNyTiw1VCmg/EkJXGo+LJYcpw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/v4-font-face.min.css" integrity="sha512-nzYdV58RidllZqhgtA0a+ghpP5e8Qq3oNNBXNp+ShDoU0FUxwRmEjQzsL72SShhjX2dcLeqpyZ/MDW43hWHo4w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/v4-shims.min.css" integrity="sha512-U+fiq69HDM4etLVUiZeQxmJE5AZoft4ti4TIM95MqXV0IjBXgT2oHw5cNeIFqz3OE/axTKQIR8e7zlm3xbOVmg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/v5-font-face.min.css" integrity="sha512-dC4AauJwDHOpEpJi2/BsDf/b9vyLVt79nmO0x5gQWbRm62Q/xFS9iZpzCOFNLjTQsAD4mp9jJel6nPAjnBN2Ag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        <h3>Ratings & Reviews</h3>
        <div class="table-container">
            <label for="appFilter">Filter by App:</label>
            <select id="appFilter" onchange="filterReviews()">
                <option value="">All Apps</option>
                <?php while ($app = mysqli_fetch_assoc($result_apps)) { ?>
                    <option value="<?php echo $app['data2_id']; ?>" 
                        <?php echo (isset($_GET['app_id']) && $_GET['app_id'] == $app['data2_id']) ? 'selected' : ''; ?>>
                        <?php echo $app['app_name']; ?>
                    </option>
                <?php } ?>
            </select>

            <table id="appTable" class="display">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>App Name</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($review = mysqli_fetch_assoc($result_reviews)) { ?>
                        <tr>
                            <td><?php echo $review['r_id']; ?></td>
                            <td><?php echo $review['app_name']; ?></td>
                            <td><?php echo $review['ratings']; ?></td>
                            <td>
                                <?php
                                    $fullReview = $review['reviews']; 
                                    $shortReview = substr($fullReview, 0, 40);
                                    if (strlen($fullReview) > 40) { 
                                        echo '<span class="short-text">'.$shortReview.'...</span>'; 
                                        echo '<span class="full-text d-none">'.$fullReview.'</span>';
                                        echo '<a href="javascript:void(0);" class="read-more" onclick="toggleReview(this)"> Read More</a>'; 
                                    } else { 
                                        echo $fullReview; 
                                    }
                                ?>
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a class="btn btn-info text-white mx-1" href="edit_ratings_reviews.php?id=<?php echo $review['r_id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a class="btn btn-danger text-white mx-1" href="delete_review.php?id=<?php echo $review['r_id']; ?>" onclick="return confirm('are you sure you want to delete this?');"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterReviews() {
            var appId = document.getElementById("appFilter").value;
            window.location.href = "show_rate_review.php" + (appId ? "?app_id=" + appId : "");
        }

        function toggleReview(element) {
            var td = element.parentElement;  // Get parent <td>
            var shortText = td.querySelector(".short-text");
            var fullText = td.querySelector(".full-text");

            if (fullText.classList.contains("d-none")) {
                shortText.classList.add("d-none"); 
                fullText.classList.remove("d-none"); 
                element.innerText = " Read Less";
            } else {
                shortText.classList.remove("d-none"); 
                fullText.classList.add("d-none"); 
                element.innerText = " Read More";
            }
        }
        
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#appTable').DataTable();
        });
    </script>
</body>
</html>