<?php
include 'backend.php';
$backend = new Backend;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">    
    <title>Register</title>
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
                <h1><i class="bi bi-person-fill-up"></i> Admin Registery</h1>
            </div>
            <div class="col-md-6">
                <label for="role" class="form-label"><i>How do you intend to use Fortami?</i> </label>
                    <select class="form-select" aria-label="role" name="role" required>
                        <option value="Admin" selected>Manage</option>
                    </select>
                <label for="profile" class="form-label my-1"><i>Profile Picture</i> </label>
                <input type="file" class="form-control" name="profile" required>
                <label for="Fname" class="form-label my-1"><i>First Name</i> </label>
                <input type="text" class="form-control" name="Fname" value="Fortami" disabled>
                <label for="lname" class="form-label my-1"><i>Last Name</i> </label>
                <input type="text" class="form-control" name="Lname" value="Admin"disabled>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label my-1"><i> Email</i></label>
                <input type="email" class="form-control" name="email" required>
                <label for="uname" class="form-label my-1"><i>Username</i> </label>
                <input type="text" class="form-control" name="uname" required>
                <label for="pass" class="form-label my-1"><i>Password</i> </label>
                <input type="password" class="form-control" name="pass" required>
                <label for="pass" class="form-label my-1"><i>Confirm Password</i> </label>
                <input type="password" class="form-control" name="cpass" required>
            </div>
            <div class="col-12">
                <button type="submit" name="regbtn" class="btn btn-success form-control">Register</button>
                <a class="btn btn-danger form-control my-2" href="index.php">Cancel</a>
            </div>
        </div>
        </form>
    </div>
    <?php
       if(isset($_POST['regbtn'])){
        $pass = $_POST['pass'];
        $cpass = $_POST['cpass'];
        $len = strlen($pass);
        //check if password length is more than 8
         if ($len >= 8 ) {
            //check if password and confirm password is equal
           if ( $pass == $cpass) {
            if (isset($_POST['role'])&& isset($_FILES['profile'])) {
                $role = $_POST['role'];
                $profile_img = $_FILES['profile'];
                $fn = $_POST['Fname'];
                $ln = $_POST['Lname'];
                $email = $_POST['email'];
                $uname = $_POST['uname'];

                $img_name = $_FILES['profile']['name'];
                $img_size = $_FILES['profile']['size'];
                $img_tmp = $_FILES['profile']['tmp_name'];
                $error = $_FILES['profile']['error'];

                    if ($error === 0) {
                        if ($img_size > 1000000) {
                            echo "Please upload an image not more than 1mb";
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
            
            $backend->registerUser($role,$new_Name,$fn,$ln,$email,$uname,$pass);
            //call register function
           }
           else{
                echo "Please confirm your password! Password not equal.";
           }
         }
         else{
            echo "<p>Password must have 8 characters or more!</p>";
         }
       }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>