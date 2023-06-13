<?php
    require_once 'backend.php';
    $backend = new Backend;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@600&display=swap" rel="stylesheet">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
      crossorigin="anonymous"
    />
    <style>
        body{
            background-image: linear-gradient(#4990b5,skyblue);
        }
    </style>
    <title>Login</title>
</head>
<body>
    <div class="container text-center min-vh-100 d-flex justify-content-center align-items-center" >
        <div class="row bg-dark bg-gradient g-3 p-2 rounded-5 shadow">
            <div class="col-12">
                <img src="./src/FortamiLogo.png" class="img-fluid" style="max-width:150px">
            </div>
            <div class="col-12">
                <form action="" method="post">
                    <input class="form-control my-2 p-2" type="text" name="username" placeholder="Username" required>
                    <input class="form-control my-2 p-2" type="password" name="pword" placeholder="Password" required>
                    <input class="form-control btn btn-dark my-2" type="submit" name="login" value="Login" style="background-color:#4990b5;border:none;font-size:3vmin">
                </form>
            </div>
             <div class="col-12">
                <a class="forget" href="">Forgot Password?</a>
             </div>   
             <div class="col-12">
                    <p class='text-light'>No account? <a href="./register.php">Register here</a></p>
             </div>
        </div>
    </div>
   <?php
    //login code
    if(isset($_POST['login'])){
        $uname = $_POST['username'];
        $pass = $_POST['pword'];
        $backend->login($uname,$pass);
    }
   ?>
      <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
      crossorigin="anonymous"
    ></script>
</body>
</html>