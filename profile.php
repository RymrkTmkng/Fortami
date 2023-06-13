<?php
    include 'backend.php';
    
    $backend = new Backend;
    $backend->checksession();
    
    $list = $backend->usersearch($_SESSION['id']);
    $row = mysqli_fetch_assoc($list);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">    
    <title>Profile</title>
    <style>
        body{
            background-image:linear-gradient(#4990b5,skyblue);
        }
    </style>
</head>
<body>
<div class="container  min-vh-100 d-flex justify-content-center align-items-center">
        <form action="profile-edit.php" class="rounded-5 shadow p-5 bg-dark bg-gradient">
        <h1><i class="bi bi-person-fill-up text-light"> Profile</i></h1>
        <div class="row g-3 text-light">
            <div class="col-12 text-center ">
                <img src="./src/uploads/profile/<?=$row['profile_pic']?>" class="img-thumbnail" alt="profile-picture" style="max-width:200px;border-radius:50px;border:4px solid #4990b5;">
            </div>
            <div class="col-md-5">
                <label for="role" class="form-label"><i>Role</i> </label>
                    <input type="text" class="form-control" value="<?=$row['user_type']?>" disabled>
                <label for="Fname" class="form-label my-1"><i>First Name</i> </label>
                <input type="text" class="form-control" value="<?=$row['user_fName']?>" disabled>
                <label for="lname" class="form-label my-1"><i>Last Name</i> </label>
                <input type="text" class="form-control" value="<?=$row['user_lName']?>" disabled>
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <label for="email" class="form-label my-1"><i> Email</i></label>
                <input type="text" class="form-control" value="<?=$row['user_email']?>" disabled>
                <label for="uname" class="form-label my-1"><i>Username</i> </label>
                <input type="text" class="form-control" value="<?=$row['user_userName']?>" disabled>
            </div>
            <div class="col-12 text-center">
                <input type="hidden" name="user_id" value="<?=$row['user_id']?>">
                <button type="submit" name="editbtn" class="btn btn-warning form-control p-2" value="true">Edit Profile</button>
                </form>
                <form action="deactivate.php" method = "post">
                    <input type="hidden" name="id" value="<?=$row['user_id']?>">
                    <button class="btn btn-danger form-control my-2" type="submit" name="deactbtn" value="true">Deactivate</button>
                </form>
                <?php
                    $role = $row['user_type'];
                    if ($role === 'Admin') {
                        echo "<a href='admin.php' style='text-decoration:none;font-size:3vmin'><i class='bi bi-arrow-return-left'>Back</i></a>";
                    }
                    elseif ($role === 'Buyer') {
                        echo "<a href='menu.php' style='text-decoration:none;font-size:3vmin'><i class='bi bi-arrow-return-left'>Back</i></a>";
                    }
                    elseif ($role === 'Seller') {
                        echo "<a href='dashboard.php' style='text-decoration:none;font-size:3vmin'><i class='bi bi-arrow-return-left'>Back</i></a>";
                    }
                ?>
            </div>
        </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>