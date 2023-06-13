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
    $backend->checksession();
    $notification = new Notification;
    $notify = $notification->viewNotif();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
</head>
<body>
    <div class="container">
        <div class="row row-gap-3 shadow">
            <div class="col-12 p-2 bg-dark bg-gradient text-light my-2 rounded shadow">
                <h1><i class="bi bi-bell-fill"> Notifications</i></h1>
            </div>
            <div class="col-12">
                <a href="<?php if($_SESSION['role'] == 'Admin'){echo "admin.php";}elseif($_SESSION['role']=='Buyer'){echo "menu.php";}else{echo "dashboard.php";}?>" class="btn btn-warning"><i class="bi bi-arrow-bar-left"> Back</i></a>
                <a href='?clear=true' class="btn btn-danger float-end"><i class="bi bi-trash"> Clear Notifications</i></a>
                <?php
                    if (isset($_GET['clear'])) {
                        $notification->clearNotif();
                        echo "<meta http-equiv='refresh' content='0'>";
                    }
                ?>
            </div>
            <div class="col-12 table-responsive">
                <table class="table table-warning align-middle">
                <?php
                    if (!is_null($notify)) {
                        foreach ($notify as $notif) {
                ?>
                    <a href="menu.php"><tr>
                        <td><h6><?=($notif['notif_status'] == 'Unread')?'<i class="bi bi-bell-fill"></i>':'<i class="bi bi-bell"></i>'?></h6></td>
                        <td><h6></h6></td>
                        <td><p><?=$notif['notif_details']?></p></td>
                        <td><small><?=$time = date("M d, Y h:i a", strtotime($notif['notif_datetime']))?></small></td>
                        <td>
                            <form action="notif-view.php" method="post">
                                <input type="hidden" name="notif_id" value="<?=$notif['notification_id']?>">
                                <button class="btn btn-dark" type="submit" name="view" value="1"><i class="bi bi-eye-fill"></i></button>
                                <button type="submit" name="delbtn" value="1" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr></a>
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