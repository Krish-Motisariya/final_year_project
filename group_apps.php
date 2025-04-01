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
    die("Failed to connect: " . mysqli_connect_error());
}

$sql = "SELECT * FROM tbl_groups";
$result = mysqli_query($conn, $sql);

$sql2 = "SELECT ga.id, g.group_name, a.app_name FROM tbl_grouped_apps ga JOIN tbl_groups g ON ga.id = g.group_id JOIN tbl_data2 a ON ga.app_id = a.data2_id";

$result2 = mysqli_query($conn, $sql2);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group App</title>
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
        <a href="group_apps.php">Group Apps</a>
        <a href="deleted_apps.php">Delete App</a>
    </div>

    <div class="content">
        <a class="btn btn-dark float-end" href="add_group.php"><i class="fa-solid fa-plus"></i> Add Group</a>
        <h3>App Groups</h3>
        <table id="groupTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Group ID</th>
                    <th>Group Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($group = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $group['group_id']; ?></td>
                        <td><?php echo $group['group_name']; ?></td>
                        <td>
                            <a class="btn btn-info" href="assign_app_to_group.php?grp_id=<?php echo $group['group_id']; ?>">Assign Apps</a>
                            <a class="btn btn-danger" href="delete_group.php?grp_id=<?php echo $group['group_id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h3 class="mt-4">Grouped Apps</h3>
        <table id="groupedAppsTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Group Name</th>
                    <th>App Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($grouped_app = mysqli_fetch_assoc($result2)) { ?>
                    <tr>
                        <td><?php echo $grouped_app['id']; ?></td>
                        <td><?php echo $grouped_app['group_name']; ?></td>
                        <td><?php echo $grouped_app['app_name']; ?></td>
                        <td>
                            <a class="btn btn-danger" href="remove_app_from_group.php?id=<?php echo $grouped_app['id']; ?>">Remove</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>