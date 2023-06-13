<?php
    include 'backend.php';
    include 'sellerheader.php';
    $backend = new Backend;


    if (isset($_POST['ready'])) {
        $trans = $_POST['trans_id'];
        $status = "Ready";

        $backend->orderStatus($trans,$status);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery</title>
</head>
<body>
    <div class="container bg-body-secondary p-3 my-4 shadow rounded">
        <div class="row p-2 g-3">
            <div class="col-12 rounded bg-dark bg-gradient text-center">
                <h2 class="text-light">Sales</h2>
            </div>
            <div class="col-12 text-end">
                <a href="sales.php" class="btn btn-outline-dark"><i class="bi bi-clock-history"> Sales History</i></a>
            </div>
            <div class="col-12 table-responsive">
                <table class="table text-center table-dark table-striped">
                    <tr>
                        <th>Transaction No.</th>
                        <th>Recepient</th>
                        <th>Address</th>
                        <th>Delivery Option</th>
                        <th>Status</th>
                        <th>Confirm</th>
                    </tr>
                    <?php
                        $list = $backend->waitingList();
                            if (!is_null($list)) {
                                foreach($list as $row){
                    ?>
                    <tr>
                        <td>2023<?=$row['payTrans_id']?></td>
                        <td><?=$row['full_name']?></td>
                        <td><?=$row['street'].', '.$row['barangay'].', '.$row['city'].' City'?></td>
                        <td><?=$row['delivery_option']?></td>
                        <td><i><?=$row['order_status']?></i></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="buyer" value="<?=$row['full_name']?>">
                                <input type="hidden" name="buyer_id" value="<?=$row['user_id']?>">
                                <input type="hidden" name="trans_id" value="<?=$row['payTrans_id']?>">
                                <input type="hidden" name="address" value="<?=$row['street'].', '.$row['barangay'].', '.$row['city'].' City'?>">
                                <input type="hidden" name="payment" value="<?=$row['pay_amount']?>">
                                <input type="hidden" name="received_date" value="<?=$row['received_datetime']?>">
                                <input type="hidden" name="status" value="<?=$row['order_status']?>">
                                <input type="hidden" name="contact" value="<?=$row['contact']?>">
                                <input type="hidden" name="paystats" value="<?=$row['trans_status']?>">
                                <?php
                                    if ($row['order_status'] == 'On The Way') {
                                        echo "<i class='text-warning'>Waiting for Confirmation</i>";
                                        
                                    }elseif ($row['order_status'] == 'Ready' && $row['delivery_option'] == 'Pick-up'){
                                        echo "<i class='text-warning'>Waiting for Pick-up</i>";
                                    }elseif ($row['order_status'] == 'Ready' && $row['delivery_option'] == 'Delivery'){
                                        echo "<button type='submit' name='confirm' class='btn btn-success'>On The Way</button>";
                                    }
                                    else {
                                        echo "<button type='submit' name='confirm' class='btn btn-success' disabled>On The Way</button>";
                                    }
                                ?>
                                
                            </form>
                        </td>
                    </tr>
                    <?php
                                }
                            }
                            
                    if (isset($_POST['confirm'])) {
                        $status = "On The Way";

                        $address = $_POST['address'];
                        $buyer = $_POST['buyer'];
                        $payment =  $_POST['trans_id'];

                        $backend->orderStatus($payment,$status);
                        echo "<meta http-equiv='refresh' content='0'>";
                    }   
                    ?>
                </table>
                <?=(mysqli_num_rows($list) == 0)?'<h3 class="text-dark text-center"><i class="bi bi-bag-x">No Pending Orders Yet</i></h3>':''?>
            </div>
        </div>
    </div>
</body>
</html>