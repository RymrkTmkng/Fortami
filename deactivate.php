<?php
    include 'backend.php';
    $backend = new Backend;
    $backend->checksession();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">    
    <title>Deactivation</title>
</head>
<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="row bg-dark bg-gradient rounded-5 shadow p-3">
            <div class="col-md-12 text-danger text-center">
                <h1 class="text-start">Warning</h1>
                <p class="text-warning">Once an account is deleted, it is gone from the database and cannot be retrieved.</p>
                <button class="btn btn-warning" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    Continue
                </button>
                <a 
                href="<?php if($_SESSION['role'] === 'Admin'){
                        echo "admin.php";
                    }elseif($_SESSION['role'] === 'Buyer'){
                        echo "menu.php";
                    }else{
                        echo "product.php";
                    }?>"
                 class="btn btn-info">Cancel
                </a>
                <div class="collapse my-1" id="collapseExample" >
                    <div class="card card-body bg-dark bg-gradient rounded-3">
                       <form action="" method="post" >
                            <label for="pw" class="form-label text-light"><i>Please type your password to confirm</i></label>
                            <input type="hidden" name="id" value="<?php if(isset($_POST['deactbtn'])){ echo $_POST['id'];}?>">
                            <input class="form-control" type="password" placeholder="Password" name="pw">
                            <button type="submit" class="btn btn-danger form-control my-1" name="delbtn">Delete</button>
                       </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <?php

        if (isset($_POST['delbtn'])) {
            $pw = $_POST['pw'];
            $id = $_POST['id'];
            
            $result = $backend->usersearch($id);
            $data = mysqli_fetch_assoc($result);

            if (password_verify($pw,$data['user_password'])) {
                $backend->delUser($id);
            }
        }
        
        
    ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
</html>