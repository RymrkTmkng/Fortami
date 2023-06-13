<?php
    include 'backend.php';
    include 'sellerheader.php';

    $backend = new Backend;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
</head>
<body>
    <div class="container bg-body-secondary bg-gradient p-3 my-4 rounded shadow">
        <div class="row g-3">
            <div class="col-12 text-center bg-dark bg-gradient ">
                <h2 class="text-light">
                    <i class="bi bi-card-list"> 
                        Incoming Orders
                    </i>
                </h2>
            </div>
            <div class="col-12 table-responsive">
                <table class="table table-dark text-center table-striped">
                    <tr>
                        <th>Transaction No.</th>
                        <th>Recepient</th>
                        <th>Address</th>
                        <th>Delivery Option</th>
                        <th>Details</th>
                    </tr>
                    <?php
                        $result = $backend->sellerOrders();
                            if (!is_null($result)) {
                                foreach ($result as $order) {
                    ?>
                    <tr>
                        <td><?=$order['payTrans_id']?></td>
                        <td><?=$order['full_name']?></td>
                        <td><?=$order['street'].', '.$order['barangay'].', '.$order['city'].' City'?></td>
                        <td><?=$order['delivery_option']?></td>
                        <td class="w-25">
                            <form action="order-details.php" method="post">
                                <input type="hidden" name="address" value="<?=$order['street'].', '.$order['barangay'].', '.$order['city'].' City'?>">
                                <input type="hidden" name="trans_id" value="<?=$order['payTrans_id']?>">
                                <input type="hidden" name="buyer" value="<?=$order['full_name']?>">
                                <input type="hidden" name="total" value="<?=$order['pay_amount']?>">
                                <button type="submit" name="info" class="btn btn-outline-info"><i class="bi bi-card-checklist"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php
                            }
                        }
                    ?>
                </table>
            </div>
                <?=(is_null($result))?'<h3 class="text-dark text-center"><i class="bi bi-bag-x">No Pending Orders Yet</i></h3>':''?>
        </div>
    </div>
        
</body>
</html>