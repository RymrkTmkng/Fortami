<?php
    include 'backend.php';
    include 'admin-header.php';

    $backend = new Admin;
    $sum = $backend->sumAmount();
    $amount = mysqli_fetch_assoc($sum);
    $total = number_format((float)$amount['total'],2,'.',',')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
</head>
<body>
    <div class="container">
        <div class="row g-3 p-5">
            <div class="col bg-dark text-center p-2"><h2 class="text-light"><i class="bi bi-clock-history"></i> Transactions</h2></div>
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th>Transaction Id</th>
                        <th>Shop</th>
                        <th>Recipient</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <?=(isset($_GET['commission']) ? '<th>Total</th>' : '')?>
                        <th>Receipt</th>
                        <th>Rating</th>
                    </tr>
                    <?php
                        $result = $backend->allTransaction();
                            if (!is_null($result)) {
                                    foreach ($result as $row) {
                    ?>
                    <tr 
                    >
                        <td>2023<?=$row['payTrans_id']?></td>
                        <td><?=$row['user_userName']?></td>
                        <td><?=$row['full_name']?></td>
                        <td><?=$row['order_status']?></td>
                        <td><?=date("M d, Y h:i a",strtotime($row['order_datetime']))?></td>
                        <?php
                            if (isset($_GET['commission'])) {
                                ?>
                                    <td>₱ <?=$row['pay_amount']?></td>
                                <?php
                            }
                        ?>
                        <td>
                            <form action="receipt.php" method="post">
                                <input type="hidden" name="trans_id" value="<?=$row['payTrans_id']?>">
                                <input type="hidden" name="shop" value="<?=$row['user_userName']?>">
                                <input type="hidden" name="shop_id" value="<?=$row['user_id']?>">
                                <input type="hidden" name="date" value="<?=$row['order_datetime']?>">
                                <input type="hidden" name="status" value="<?=$row['order_status']?>">
                                <input type="hidden" name="delivery" value="<?=$row['delivery_option']?>">
                                <input type="hidden" name="total" value="<?=$row['pay_amount']?>">
                                <input type="hidden" name="paystats" value="<?=$row['trans_status']?>">
                                <input type="hidden" name="method" value="<?=$row['paymethod_type']?>">
                                <button type="submit" name="receiptbtn" class="<?=($trans == $row['payTrans_id'])?'btn btn-outline-primary':'btn btn-outline-dark'?> text-center"><i class="bi bi-receipt"></i></button>
                            </form>
                        </td>
                        <td>
                            <a href="rate-history.php?trans=<?=$row['payTrans_id']?>&shop=<?=$row['user_userName']?>" class="btn btn-outline-warning"><i class="bi bi-star"></i></a>
                        </td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </table>
                <?php
                    if (isset($_GET['commission'])) {
                        echo "<h4>Total Commission: ₱ <i>$total</i></h4>";
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>