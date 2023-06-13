<?php
    include 'backend.php';
    $chat = new Chat;

    if (isset($_POST['read'])) {
        $pic = $_POST['pic'];
        $id = $_POST['msg_id'];
        $sender =$_POST['sender'];
        $sender_id = $_POST['sender_id'];
        $time = $_POST['time'];
        $message = $_POST['content'];

        $chat->updateRead($id);
    }
    else {
        $pic = "";
        $id = "";
        $sender = "";
        $sender_id ="";
        $time = "";
        $message = "";
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
    <title>Message</title>
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
                <img src="./src/uploads/profile/<?=$pic?>" alt="profile" class="img-thumbnail" style="max-width:100px">
                &nbsp;&nbsp;<h3 class="text-light"><?=$sender?><br><small><i class="text-secondary"><?=($_SESSION['id']==$sender_id)?'':'(Sender)'?></i></small></h3> 
            </div>
            <div class="col-12 p-4 shadow bg-body-secondary">
                <h5><small class="text-secondary"><i>Message:</i></small>  <br><br>
                    <em><?=$message?></em>
                </h5>
                
            </div>
            <div class="col-12 p-2t">
                    <?php
                        if ($_SESSION['id'] == $sender_id) {
                           
                        }
                        else {
                    ?>
                        <a href="chat-create.php?receiver=<?=$sender_id?>&name=<?=$sender?>&pic=<?=$pic?>" class="form-control btn btn-success">Reply</a>
                    <?php
                        }
                    ?>
                    <a href="<?=($_SESSION['id'] == $sender_id)?'chat-sent.php':'chat.php'?>" class="btn btn-warning form-control my-2">Back</a>
                </form>
            </div>
            
        </div>
    </div>
    <?php
        if (isset($_POST['delete'])) {
            $id = $_POST['msg_id'];
            $chat->delMsg($id);
            echo "<script>window.location.href='chat.php';</script>";
        }
    ?>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
      crossorigin="anonymous"
    ></script>
</body>
</html>