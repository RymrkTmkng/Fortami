<?php
    include 'backend.php';
    include 'admin-header.php';
    $backend = new Backend;
    $backend->checksession();

    $admin = new Admin;

    if (isset($_GET['sort'])) {
        $sort = $_GET['sort'];
        
        if ($sort == 'id') {
            $result = $admin->listUser("user_id");
        }
        elseif ($sort == 'role') {
            $result = $admin->listUser("user_type");
        }
        elseif ($sort == 'buyer') {
            $result = $admin->listBuyer();
        }
        elseif ($sort == 'seller') {
            $result = $admin->listSeller();
        }
     }
     else {
        $result = $admin->listUser("user_id");
     }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
</head>
<body>
    <div class="container p-5 table-responsive">
        <h1 class="text-center bg-warning bg-gradient p-2 rounded-5 shadow"><i class="bi bi-gear-fill"> Account</i></h1>
            <div class="dropdown">
                <a href="admin.php" class="btn btn-dark"><i class="bi bi-arrow-bar-left">Back</i></a>
                <a class="btn btn-dark dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-filter">Sort by</i>
                </a>
                <a href="" class="btn btn-dark"><i class="bi bi-envelope"></i></a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="user.php?sort=id">ID</a></li>
                    <li><a class="dropdown-item" href="user.php?sort=role">Role</a></li>
                    <li><a class="dropdown-item" href="user.php?sort=buyer">Buyer only</a></li>
                    <li><a class="dropdown-item" href="user.php?sort=seller">Seller only</a></li>
                </ul>
            </div>
        <table class="table table-dark table-striped my-2 text-center">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Role</th>
                <th>Verification</th>
                <th>Action</th>
            </tr>
            <?php
                
                if (!is_null($result)) {
                    foreach ($result as $row) {
            ?>
            <tr>
                <td><?=$row['user_id']?></td>
                <td><img src="./src/uploads/profile/<?=$row['profile_pic']?>" alt="profile" class="img-thumbnail" style="max-width:100px"></td>
                <td><?=$row['user_fName'].' '.$row['user_lName']?></td>
                <td><?=$row['user_type']?></td>
                <td><?php
                        if ($row['verification'] == '') {
                            ?>
                                <form action="" method="post">
                                    <input type="hidden" name="userID" value=<?=$row['user_id']?>>
                                    <button type="submit" name="verify" class="btn btn-secondary"><i class="bi bi-shield-check"> Verify Now</i></button>
                                </form>
                            <?php
                        }else{
                            echo "<i class='bi bi-shield-fill-check'> ".$row['verification']."</i>";
                        }
                    ?>
                </td>
                <td>
                    <form action="user-edit.php">
                        <input type="hidden" name="user_id" value="<?=$row['user_id']?>">
                        <button type="submit" name="editbtn" class="btn btn-outline-success" value="true"><i class="bi bi-eye-fill"></i></button>                        
                        <a href="chat-create.php?receiver=<?=$row['user_id']?>&name=<?=$row['user_fName'].' '.$row['user_lName']?>&pic=<?=$row['profile_pic']?>" class="btn btn-outline-info" value="true"><i class="bi bi-envelope-fill"></i></a>
                    </form>
                </td>
            </tr>
            <?php
                    }
                }
                if (isset($_POST['verify'])) {
                    $id = $_POST['userID'];

                    $backend->verifyUser($id);
                }
            ?>
        </table>
    </div>
</body>
</html>