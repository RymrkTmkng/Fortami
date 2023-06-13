<?php
include 'backend.php';
$backend = new Backend;

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
                <h1><i class="bi bi-person-fill-up"> Edit Profile</i></h1>
            </div>
            <div class="col-md-5">
                <label for="role" class="form-label"><i>How do you intend to use Fortami?</i> </label>
                    <select class="form-select" aria-label="role" name="role" required>
                        <option selected disabled>Click to choose...</option>
                        <option value="Buyer" <?=($row['user_type'] == 'Buyer')?'Selected':''?>>Buy</option>
                        <option value="Seller" <?=($row['user_type'] == 'Seller')?'Selected':''?>>Sell</option>
                        <option value="Admin" <?=($row['user_type'] == 'Admin')?'Selected':''?>>Manage</option>
                    </select>
                <label for="profile" class="form-label my-1"><i>Profile Picture</i></label>
                <input type="file" class="form-control" name="profile"  required>
                <label for="Fname" class="form-label my-1"><i>First Name</i> </label>
                    <?php
                        if ($_SESSION['role'] == 'Admin') {
                    ?>
                        <input type="text" class="form-control" name="Fname" value="Fortami" disabled>
                        <label for="lname" class="form-label my-1"><i>Last Name</i> </label>
                        <input type="text" class="form-control" name="Lname" value="Admin" disabled>
                    <?php
                        }else{
                    ?>
                        <input type="text" class="form-control" name="Fname" value="<?=$row['user_fName']?>" required>
                        <label for="lname" class="form-label my-1"><i>Last Name</i> </label>
                        <input type="text" class="form-control" name="Lname" value="<?=$row['user_lName']?>" required>
                    <?php
                        }
                    ?>
                
            </div>
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <label for="email" class="form-label my-1"><i> Email</i></label>
                <input type="email" class="form-control" name="email" value="<?=$row['user_email']?>" required>
                <label for="uname" class="form-label my-1"><i>Username</i> </label>
                <input type="text" class="form-control" name="uname" value="<?=$row['user_userName']?>" required>
                <label for="pass" class="form-label my-1"><i>Confirm Password</i> </label>
                <input type="password" class="form-control" name="cpass"  required>
            </div>
            <div class="col-12">
                <button type="submit" name="savebtn" class="btn btn-success form-control">Save Changes</button>
                <a class="btn btn-danger form-control my-2" href="profile.php">Cancel</a>
            </div>
        </div>
        </form>
    </div>
    <?php
       if(isset($_POST['savebtn'])){
        $id = $_GET['user_id'];
        $pass = $row['user_password'];
        $cpass = $_POST['cpass'];
        $len = strlen($pass);
        //check if password length is more than 8
         if ($len >= 8 ) {
            //check if password and confirm password is equal
           if ( password_verify($cpass,$pass)) {
            if (isset($_POST['role'])&& isset($_FILES['profile'])) {
                $role = $_POST['role'];
                $profile_img = $_FILES['profile'];
                if ($_SESSION['role'] == 'Admin') {
                    $fn = "Fortami";
                    $ln = "Admin";
                }
                else {
                    $fn = $_POST['Fname'];
                    $ln = $_POST['Lname'];
                }
                $email = $_POST['email'];
                $uname = $_POST['uname'];

                $img_name = $_FILES['profile']['name'];
                $img_size = $_FILES['profile']['size'];
                $img_tmp = $_FILES['profile']['tmp_name'];
                $error = $_FILES['profile']['error'];

                    if ($error === 0) {
                        if ($img_size > 5000000) {
                            echo "Please upload an image not more than 5mb";
                        }
                        else {
                            $img_ext = pathinfo($img_name,PATHINFO_EXTENSION);
                            $img_ext_lower = strtolower($img_ext);//conversion of the extension to lowercase
                            $allowed_ext = array("jpg","jpeg","png");
                            
                            if (in_array($img_ext_lower,$allowed_ext)) {
                                $new_Name = uniqid("FORTAMI-",true).'.'.$img_ext_lower;
                                $upload_path = './src/uploads/profile/'.$new_Name;
                                move_uploaded_file($img_tmp,$upload_path);
                            }
                            else {
                                echo "File type not supported";
                            }
                        }
                    }
            }
            else {
                echo "<script>alert('Please check the form and fill all inputs.')</script>";
            }
            
            $backend->editProfile($id,$role,$new_Name,$fn,$ln,$email,$uname);
            //call update profile function
                if ($role === 'Admin') {
                    header('location:admin.php');
                }
                elseif ($role === 'Buyer') {
                    header('location:menu.php');
                }
                elseif ($role === 'Seller') {
                    header('location:product.php');
                }
           }
           else{
                echo "Please confirm your password! Password not equal.";
           }
         }
         else{
            echo "<p>Password must have 8 characters or more!</p>";
         }
       }
       if (isset($_POST['delbtn'])) {
            $id = $_GET['user_id'];
            
       }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>