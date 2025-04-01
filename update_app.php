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
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Fetch existing app data
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_data2 WHERE data2_id = $id";
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_assoc($result);
        
        if(!$data){
            die("App not found!");
        }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        $package_name = $_POST['package_name'];
        $app_name = $_POST['app_name'];
        $description = $_POST['description'];
        $downloads = $_POST['downloads'];
        $logo = $data['logo']; // Keep existing logo by default
    
        // Check if a new logo is uploaded
        if(!empty($_FILES["logo"]["name"])){
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
        }
        $updated_at=date("d-m-Y h:i:s");
        // Update query
        $sql = "UPDATE tbl_data2 SET 
                pkg_name='$package_name', 
                app_name='$app_name', 
                logo='$logo', 
                descriptions='$description', 
                downloads='$downloads',
                updated_at='$updated_at'
                WHERE data2_id='$id'";
    
        if(mysqli_query($conn, $sql)){
            header("Location: after.php");
        } else {
            echo '<div class="alert alert-danger" role="alert">
                    Record Not Updated!.....
                </div>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap-grid.min.css" integrity="sha512-i1b/nzkVo97VN5WbEtaPebBG8REvjWeqNclJ6AItj7msdVcaveKrlIIByDpvjk5nwHjXkIqGZscVxOrTb9tsMA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap-grid.rtl.min.css" integrity="sha512-V7mESobi1wvYdh9ghD/BDbehOyEDUwB4c4IVp97uL0QSka0OXjBrFrQVAHii6PNt/Zc1LwX6ISWhgw1jbxQqGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body { font-family: Arial, sans-serif; }
        .sidebar { width: 250px; background: #222; color: white; position: fixed; height: 100vh; padding: 20px; }
        .content { margin-left: 260px; padding: 20px; }
        .topbar { background: black; padding: 10px; color: white; display: flex; justify-content: space-between; align-items: center; }
        .sidebar a { display: block; color: white; text-decoration: none; padding: 10px; }
    </style>
</head>
<body>
    <div class="topbar">
        <button class="btn btn-light">☰</button>
        <div>
            <button class="btn btn-outline-light">🔄</button>
            <button class="btn btn-outline-light">⛶</button>
            <span><?php echo $_SESSION['admin_name']; ?></span>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <div class="sidebar">
        <h2>SDK</h2>
        <a href="after.php">App</a>
        <a href="#">Delete App</a>
    </div>
    <div class="content">
        <div class="container">
            <h2>Update App</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $data['data2_id']; ?>">

                <div class="row">
                    <div class="col-12 mb-2">
                        <label class="form-label">App Name</label>
                        <input class="form-control" type="text" name="app_name" value="<?php echo $data['app_name']; ?>" required>
                    </div>
                    <div class="col-12 mb-2">
                        <label class="form-label">Package Name</label>
                        <input class="form-control" type="text" name="package_name" value="<?php echo $data['pkg_name']; ?>" required>
                    </div>
                    <div class="col-12 mb-2">
                        <label class="form-label">Current Logo</label>
                        <img src="<?php echo $data['logo']; ?>" alt="Current Logo" width="80"><br>
                    </div>
                    <div class="col-12 mb-2">
                        <label class="form-label">New Logo (if changing)</label>
                        <input class="form-control" type="file" name="logo" accept="image/*">
                    </div>
                    <div class="col-12 mb-2">
                        <label class="form-label">Description</label>
                        <input class="form-control" type="text" name="description" value="<?php echo $data['descriptions']; ?>" required>
                    </div>
                    <div class="col-12 mb-2">
                        <label class="form-label">Downloads</label>
                        <input class="form-control" type="number" name="downloads" value="<?php echo $data['downloads']; ?>" required>
                    </div>
                    <div class="col-12 mb-2">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-dark" onclick="window.location.href='after.php'">Back</button>
                    </div>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js" integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>