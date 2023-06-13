<?php
    include 'backend.php';
    $notifs = new Notification;

    if (isset($_POST['view'])) {
        $id = $_POST['notif_id'];
        $notify = $notifs->readNotif($id);
        $notif = mysqli_fetch_assoc($notify);
    }
    elseif(isset($_POST['delbtn'])){
        $id = $_POST['notif_id'];
        $notifs->delNotif($id);
        header('location:notification.php');
    }
    else {
        $notif = [];
        $notify = "";
        $id = "";
        $notif['notif_details'] = "";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@600&display=swap"
      rel="stylesheet"
    />
    <title>Notification</title>
    <style>
        body{
            background-image: linear-gradient(#4990b5,skyblue);
        }
    </style>
</head>
<body>
    <div class="container min-vh-100 p-3">
        <div class="row row-gap-4 shadow rounded bg-body-tertiary">
            <div class="col-12 bg-dark bg-gradient d-flex align-items-center text-light p-3">
                <h1><i class="bi bi-bell-fill"> Notification</i></h1>
            </div>
            <div class="col-12 p-4 shadow bg-body-secondary">
                <h5><small class="text-secondary"><i>Content:</i></small>  <br><br>
                    <em><?=$notif['notif_details']?></em>
                </h5>
                
            </div>
            <div class="col-12 p-2t">
                    
                    <a href="notification.php" class="btn btn-warning form-control my-2">Back</a>
                </form>
            </div>
            
        </div>
    </div>
    <?php

        
    ?>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
      crossorigin="anonymous"
    ></script>
</body>
</html>