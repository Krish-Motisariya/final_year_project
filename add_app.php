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
    if(!$conn){
        die("we failed to connect: ". mysqli_connect_error());
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $package_name = $_POST['package_name'];
        $app_name = $_POST['app_name'];
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $downloads = $_POST['downloads'];

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["logo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($imageFileType, $allowed_types) && move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            $logo = $target_file;
        } else {
            echo "<script>alert('Error uploading image. Only JPG, JPEG, PNG, and GIF allowed.');</script>";
            exit;
        }
        $created_at=date("Y-m-d h:i:s");
        $updated_at=date("Y-m-d h:i:s");
        
        if($package_name && $app_name && $logo && $description && $downloads){
            $sql="INSERT INTO tbl_data2(pkg_name, app_name, logo, descriptions, downloads, created_at, updated_at) VALUES('$package_name','$app_name','$logo','$description','$downloads', '$created_at', '$updated_at')";
            $result = mysqli_query($conn, $sql);
            if($result){
                header("Location: after.php");
                exit();
            }
            else{
                echo '<div class="alert alert-danger" role="alert">
                    Record Not Inserted!.....
                </div>';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert app</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap-grid.min.css" integrity="sha512-i1b/nzkVo97VN5WbEtaPebBG8REvjWeqNclJ6AItj7msdVcaveKrlIIByDpvjk5nwHjXkIqGZscVxOrTb9tsMA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap-grid.rtl.min.css" integrity="sha512-V7mESobi1wvYdh9ghD/BDbehOyEDUwB4c4IVp97uL0QSka0OXjBrFrQVAHii6PNt/Zc1LwX6ISWhgw1jbxQqGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <div class="container">
            <h2>Add App</h2>
            <form method="POST" action="#" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12 mb-2">
                        <label class="form-label">App Name</label>
                        <input class="form-control" type="text" name="app_name" required>
                    </div>
                    <div class="col-12 mb-2">
                        <label class="form-label">Package Name</label>
                        <input class="form-control" type="text" name="package_name" required>
                    </div>
                    <div class="col-12 mb-2">
                        <label class="form-label">Logo</label>
                        <input class="form-control" type="file" name="logo" accept="image/*" required>
                    </div>
                    <div class="col-12 mb-2">
                        <label class="form-label">Description</label>
                        <input class="form-control" type="text" name="description" required>
                    </div>
                    <div class="col-12 mb-2">
                        <label class="form-label">Downloads</label>
                        <input class="form-control" type="number" name="downloads" required>
                    </div>
                    <div class="col-12 mb-2">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-dark" onclick="window.location.href='after.php'">Back</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js" integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>