<?php
    include 'backend.php';
    $chat = new Chat;
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

    <title>Chat</title>
    <style>
        body{
            background-image: linear-gradient(#4990b5,skyblue);
        }
    </style>
</head>
<body>
    <div class="container min-vh-100">
        <div class="row row-gap-4 shadow rounded">
            <div class="col-12 bg-dark bg-gradient d-flex align-items-center p-3">
                <img src="./src/uploads/profile/<?=$_GET['pic']?>" alt="profile" class="img-thumbnail" style="max-width:100px">
                &nbsp;&nbsp;<h3 class="text-light"><?=$_GET['name']?><br><small><i class="text-secondary">(Receiver)</i></small></h3> 
            </div>
            <div class="col-12 p-2">
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Receiver :</span>
                        <input type="hidden" name="rcvr_id" value="<?=$_GET['receiver']?>">
                        <input type="text" class="form-control" placeholder="Username" value="<?=$_GET['name']?>" aria-label="Username" aria-describedby="basic-addon1" disabled>
                    </div>
                    <textarea name="msg" class="form-control" rows="10" placeholder="Message here..." required></textarea>
                    <hr>
                    <button type="submit" name="send" value="true"  class="btn btn-success my-2 form-control p-2">Send</button>
                    <a href="chat.php" class="btn btn-danger form-control">Cancel</a>
                </form>
            </div>
            
        </div>
    </div>
    <?php
        if (isset($_POST['send'])) {
            $receiver = $_POST['rcvr_id'];
            $sender = $_SESSION['id'];
            $msg = $_POST['msg'];
            $message = $chat->createMsg($sender,$receiver,$msg);

            if ($_SESSION['role'] == 'Buyer') {
                echo "<script>window.location.href='chat.php';</script>";
            }
            elseif ($_SESSION['role'] == 'Seller') {
                echo "<script>window.location.href='chat.php';</script>";
            }
            if ($_SESSION['role'] == 'Admin') {
                echo "<script>window.location.href='chat.php';</script>";
            }
        }
    ?>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
      crossorigin="anonymous"
    ></script>
</body>
</html>