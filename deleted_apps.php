<?php
    session_start();

    if(!isset($_SESSION['admin_name'])){
        header("Location: auth-normal-sign-in.php");
        exit();
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "app_management";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Failed to connect: " . mysqli_connect_error());
    }

    $sql2 = "SELECT * FROM tbl_data2 WHERE status = 0";
    $result2 = mysqli_query($conn, $sql2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DELETED APPS</title>
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
        <h3>App Management</h3>
        <!-- <a class="btn btn-dark float-end" href="add_app2.php"><i class="fa-solid fa-plus"></i> Add App</a> -->
        <table id="appTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>App Name</th>
                    <th>Package Name</th>
                    <th>Logo</th>
                    <!-- <th>Description</th> -->
                    <th>Downloads</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php while($data2 = mysqli_fetch_assoc($result2)){ ?>
                <tr>
                    <td><?php echo $data2['data2_id']; ?></td>
                    <td><?php echo $data2['app_name']; ?></td>
                    <td><?php echo $data2['pkg_name']; ?></td>
                    <td>
                        <img src="<?php echo $data2['logo']; ?>" alt="App logo" width="50" height="50">
                    </td>
                    <!-- <td><?php echo $data2['description']; ?></td> -->
                    <td><?php echo $data2['downloads']; ?></td>
                    <td>
                        <a class="btn btn-info text-white" href="restore_app.php?id=<?php echo $data2['data2_id']; ?>"><i class="fa-solid fa-trash-arrow-up"></i></a>
                        <a class="btn btn-danger text-white" href="permanant_delete.php?id=<?php echo $data2['data2_id']; ?>">DELETE</a>
                    </td>
                </tr><?php } ?>
            </tbody>
        </table>
    </div>
    
    <script>
        $(document).ready(function () {
            $('#appTable').DataTable();
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/brands.min.js" integrity="sha512-ILOQokRQNF0S8SKV6fnaLNj02CmZnDWmYUr3zlH4jwToep0lWc7twuTzF+Mm0cKPdszi0xe8KymVi2y7mAweVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/conflict-detection.min.js" integrity="sha512-K5+wFlOsuophh3a/Im5Xc/i3w5YnOJmfTS74GUNHUH0UPe2Y55Y8iLkFkLjYy6aJy999ZIoKjsmFJMhjq3MlHQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/fontawesome.min.js" integrity="sha512-j12pXc2gXZL/JZw5Mhi6LC7lkiXL0e2h+9ZWpqhniz0DkDrO01VNlBrG3LkPBn6DgG2b8CDjzJT+lxfocsS1Vw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/regular.min.js" integrity="sha512-yp4xbJGTx8AEOiU0F5fvbau3PajjDuxEwXpAPNVFtvJK52vjKuvxHLtOvxZFE6UBQr0hWvSciggEZJ82VwpkTQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/solid.min.js" integrity="sha512-H/FYzgm63CLJLwSgCNv7zmAHWnbw7GwOrnCjE15CD969yHWj7fGDiHHLZuZJLO9ZGIkBR/JL91/p/ddbtUUgQQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/v4-shims.min.js" integrity="sha512-Ny27nj/CA4kOUa/2b2bhjr8YiJ+OfttH2314Wg8drWh4z9JqGO1PVEqPvo/kM+PjN5UEY4gFxo+ADkhXoGiaSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>