<?php
    include 'backend.php';
    
    if ($_SESSION['role'] == "Buyer") {
        include 'buyerheader.php';
    }
    elseif ($_SESSION['role'] == "Seller") {
        include 'sellerheader.php';
    }
    elseif ($_SESSION['role'] == "Admin") {
        include 'admin-header.php';
    }
    $backend = new Backend;
    $chat = new Chat;
    $message = $chat->viewMsg();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        p {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row row-gap-3 shadow">
            <div class="col-12 p-2 bg-dark bg-gradient text-light my-2 rounded shadow">
                <h1><i class="bi bi-chat-right-dots-fill"> Inbox</i> </h1>
            </div>
            <div class="col-12">
                    <a href="chat-sent.php" class="btn btn-warning"><i class="bi bi-send-check"> Sent Messages</i></a>
            </div>
            <div class="col-12 table-responsive">
                <table class="table table-warning align-middle">
                <?php
                    if (!is_null($message)) {
                        foreach ($message as $msg) {
                ?>
                    <tr>
                        <td><h6><?=($msg['status'] == 'Unread')?'<i class="bi bi-envelope-fill"></i>':'<i class="bi bi-envelope-open"></i>'?></h6></td>
                        <td><h6>
                            <?php
                                if ($_SESSION['role'] == 'Buyer') {
                                    $res = $backend->findAddress($msg['user_id']);
                                    $sender = mysqli_fetch_assoc($res);

                                    if (!is_null($sender)) {
                                        echo $sender['full_name'];
                                    }
                                    else {
                                        echo $msg['user_fName'].' '.$msg['user_lName'];
                                    }
                                }
                                else {
                                    echo $msg['user_fName'].' '.$msg['user_lName'];
                                }
                            ?>
                        </h6></td>
                        <td><p><?=$msg['content']?></p></td>
                        <td><small><?=$time = date("M d, Y h:i a", strtotime($msg['msg_datetime']))?></small></td>
                        <td>
                            <!-- <a href="" class="btn btn-dark"><i class="bi bi-envelope-open"></i></a>
                            <a href="" class="btn btn-danger"><i class="bi bi-trash"></i></a>      -->
                            <form action="chat-open.php" method="post">
                                <input type="hidden" name="msg_id" value="<?=$msg['msg_id']?>">
                                <input type="hidden" name="pic" value="<?=$msg['profile_pic']?>">
                                <input type="hidden" name="sender" value="<?=$msg['user_fName'].' '.$msg['user_lName']?>">
                                <input type="hidden" name="sender_id" value="<?=$msg['user_id']?>">
                                <input type="hidden" name="time" value="<?=$time?>">
                                <input type="hidden" name="content" value="<?=$msg['content']?>">
                                <button type="submit" class="btn btn-dark" value="open" name="read"><i class="bi bi-envelope-open"></i></button>
                                <button type="submit" class="btn btn-danger" value="delete" name="delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php
                        }
                    }
                ?>
                </div>
            </table>  
        </div>
    </div>
</body>
</html>