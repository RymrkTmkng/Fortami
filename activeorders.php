<?php
    include 'backend.php';
    include 'buyerheader.php';
    $backend = new Backend;
    $notif = new Notification;
    $backend->checksession();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity</title>
</head>
<body>
    <div class="container p-5">
        <div class="row shadow g-3">
            <div class="col-12 p-2 bg-dark">
                <h2 class="text-light text-center">Ongoing Orders</h2>
            </div>
            <div class="col-12  text-end">
                <a href="transactions.php" class="btn btn-outline-dark"><i class="bi bi-clock-history"> Transaction History</i></a>
            </div>
                <div class="col-12 table-responsive">
                    <table class="table text-center table-striped">
                        <tr>
                            <th>Shop</th>
                            <th>Total Amount</th>
                            <th>Delivery Option</th>
                            <th>Order Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        <?php
                            $result = $backend->activeOrders();
                                if (!is_null($result)) {
                                    if ($result->num_rows > 0) {
                                        foreach ($result as $row){
                        ?>
                            <tr>
                                <td style="font-weight:bold;font-style:italic;"><?=$row['user_userName']?></td>
                                <td><?=$row['pay_amount']?></td>
                                <td><?=$row['delivery_option']?></td>
                                <td><?=$row['order_status']?></td>
                                <td>
                                    <form class="text-center" action="" method="post">
                                        <input type="hidden" name="trans" value="<?=$row['payTrans_id']?>">
                                        <button type="submit" name="cancelbtn" class="btn btn-danger" <?=($row['order_status'] == 'Pending')? '':'disabled'?>>Cancel</button>
                                        <button type="submit" name="rcvbtn" class="btn btn-success"  <?=($row['order_status'] == 'Pending' || $row['order_status'] == 'Preparing' )? 'disabled':''?>>Receive</button>
                                    </form>
                                </td>
                            </tr>
                    <?php
                            }
                        }
                    }
                    else {
                        echo "<h1 class='text-center'><i class='bi bi-bag-x'></i><br>No Orders Yet!</h1>";
                    }
                    ?>
                    </table>
                </div>
            </div>  
        </div>
    </div>
    <?php
        if (isset($_POST['rcvbtn'])) {
            $time = date("Y-m-d H:i:s");
            $trans= $_POST['trans'];
            $status = 'Received';
            $backend->orderStatus($trans,$status);
            $backend->receivedTime($time,$trans);
            $notif->newUserNotif(46,"New Successful Transaction with an ID of 2023$trans",'Unread');
            echo "<script>window.location.href='rate.php?trans=$trans';</script>";
        }   
        else {
            
        }
        
        if (isset($_POST['cancelbtn'])) {
            $trans= $_POST['trans'];
            $status = 'Cancelled';
            $backend->orderStatus($trans,$status);
            $backend->tranStatus($trans,$status);
            echo "<script>window.location.href='transactions.php?trans=$trans';</script>";
        }
    ?>
</body>
</html>