<?php
include 'backend.php';
$backend = new Backend;

$backend->checksession();

    if (isset($_GET['editbtn'])) {
        $id = $_GET['user_id'];
    }
    $list = $backend->usersearch($id);
    $row = mysqli_fetch_assoc($list);
    $permit = $row['permit'];
    $sanitary = $row['sanitary'];

        if ($permit == '') {
            $verify = "No Permit Uploaded";
        }
        else{
           if ($row['user_type'] == 'Buyer') {
             $verify = "<a href='./src/uploads/business_permit/$permit' class='btn btn-warning form-control p-2'>View Valid ID</a>";
           }else{
             $verify = "<a href='./src/uploads/business_permit/$permit' class='btn btn-warning form-control p-2'>View Business Permit</a>";
             $permit = "<a href='./src/uploads/business_permit/$sanitary' class='btn btn-info form-control p-2'>View Sanitary Permit</a>";
           }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">    
    <title>Edit Profile</title>
    <style>
        body{
            background-image:linear-gradient(#4990b5,skyblue);
        }
    </style>
</head>
<body>
    <div class="container  min-vh-100 d-flex justify-content-center align-items-center">
        <form action="" method="post" enctype="multipart/form-data" class="rounded-5 shadow p-5 bg-dark bg-gradient">
        <div class="row g-3 text-light">
            <div class="col-12 text-center ">
                <img src="./src/uploads/profile/<?=$row['profile_pic']?>" class="img-thumbnail" alt="profile" style="max-width:200px;border:2px solid #4990b5">
            </div>
            <div class="col-md-6">
                <label for="role" class="form-label"><i>Role</i> </label>
                    <select class="form-select" aria-label="role" name="role" disabled>
                        <option selected disabled>Click to choose...</option>
                        <option value="Buyer" <?=($row['user_type'] == 'Buyer')?'Selected':''?>>Buy</option>
                        <option value="Seller" <?=($row['user_type'] == 'Seller')?'Selected':''?>>Sell</option>
                        <option value="Admin" <?=($row['user_type'] == 'Admin')?'Selected':'disabled'?>>Manage</option>
                    </select>
                <label for="Fname" class="form-label my-1"><i>First Name</i> </label>
                <input type="text" class="form-control" name="Fname" value="<?=$row['user_fName']?>" disabled>
                <label for="lname" class="form-label my-1"><i>Last Name</i> </label>
                <input type="text" class="form-control" name="Lname" value="<?=$row['user_lName']?>" disabled>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label my-1"><i> Email</i></label>
                <input type="email" class="form-control" name="email" value="<?=$row['user_email']?>" disabled>
                <label for="uname" class="form-label my-1"><i>Username</i> </label>
                <input type="text" class="form-control" name="uname" value="<?=$row['user_userName']?>" disabled>
            </div>
            <div class="col-12">
                <h6 class="text-center"><?=$verify?></h6>
                <h6 class="text-center"><?=$permit?></h6>
                <a class="btn btn-danger form-control my-2" href="user.php">Back</a>
            </div>
        </div>
        </form>
    </div>
    <?php
    //    if(isset($_POST['savebtn'])){
    //     $id = $_GET['user_id'];
    //     $len = strlen($pass);
    //     //check if password length is more than 8
    //      if ($len >= 8 ) {
    //         //check if password and confirm password is equal
            
    //         $backend->editProfile($id,$role,$fn,$ln,$email,$uname);
    //         //call update profile function
    //             if ($role === 'Admin') {
    //                 header('location:admin.php');
    //             }
    //             elseif ($role === 'Buyer') {
    //                 header('location:menu.php');
    //             }
    //             elseif ($role === 'Seller') {
    //                 header('location:product.php');
    //             }
    //        }
    //        else{
    //             echo "Please confirm your password! Password not equal.";
    //        }
    //      }
    //      else{
    //         echo "<p>Password must have 8 characters or more!</p>";
    //      }
    //    if (isset($_POST['delbtn'])) {
    //         $id = $_GET['user_id'];
            
    //    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>