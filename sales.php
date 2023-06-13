<?php
    include 'backend.php';
    include 'sellerheader.php';
    $backend = new Backend;
    $sales = new Sales;
    $totalSales = $sales->totalSales();
    $salesAmount = mysqli_fetch_assoc($totalSales);

    $user = $backend->userAddress();
    $data = mysqli_fetch_assoc($user);
    $shop_name = $data['full_name'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales</title>
</head>
<body>
    <div class="container bg-body-secondary p-2 my-3 shadow">
        <div class="row p-2 g-3">
            <div class="col-12 rounded bg-dark text-center">
                <h2 class="text-light">Sales History</h2>
            </div>
            <div class="col-md-6">
                <h5>Total Sales: ₱ <?=number_format((float)$salesAmount['sales'],2,'.',',')?></h5>
            </div>
            <div class="col-md-6 text-end">
                <h5 class="text-end"><button class="btn btn-outline-dark" id="transprint" onclick="printPage()"><i class="bi bi-printer"> Print</i></button></h5>
            </div>
            <div class="col-12 table-responsive">
                <table class="table text-center table-dark table-striped">
                    <tr>
                        <th>Transaction No.</th>
                        <th>Date</th>
                        <th>Recepient</th>
                        <th>Total</th>
                        <th>Delivery Option</th>
                        <th>Status</th>
                        <th class="confirm">Confirm</th>
                        <th class="rating">Rating</th>
                    </tr>
                    <?php
                        $list = $backend->saleHistory();
                            if (!is_null($list)) {
                                foreach($list as $row){
                        $date = date("M d, Y h:i a",strtotime($row['received_datetime']));
                    ?>
                    <tr>
                        <td>2023<?=$row['payTrans_id']?></td>
                        <td><?=$date?></td>
                        <td><?=$row['full_name']?></td>
                        <td>₱ <?=number_format((float)$row['pay_amount'],2,'.',',')?></td>
                        <td><?=$row['delivery_option']?></td>
                        <td><i><?=$row['order_status']?></i></td>
                        <td class="confirma">
                            <form action="confirmation.php" method="post">
                                <input type="hidden" name="buyer" value="<?=$row['full_name']?>">
                                <input type="hidden" name="buyer_id" value="<?=$row['user_id']?>">
                                <input type="hidden" name="trans_id" value="<?=$row['payTrans_id']?>">
                                <input type="hidden" name="address" value="<?=$row['street'].', '.$row['barangay'].', '.$row['city'].' City'?>">
                                <input type="hidden" name="total_payment" value="<?=$row['pay_amount']?>">
                                <input type="hidden" name="vat" value="<?=$row['vat']?>">
                                <input type="hidden" name="comm" value="<?=$row['commission']?>">
                                <input type="hidden" name="order_date" value="<?=$row['order_datetime']?>">
                                <input type="hidden" name="status" value="<?=$row['order_status']?>">
                                <input type="hidden" name="option" value="<?=$row['delivery_option']?>">
                                <input type="hidden" name="contact" value="<?=$row['contact']?>">
                                <input type="hidden" name="paystats" value="<?=$row['trans_status']?>">
                                <input type="hidden" name="shop_name" value="<?=$shop_name?>">
                                <input type="hidden" name="shop_contact" value="<?=$data['contact']?>">
                                <input type="hidden" name="shop_address" value="<?=$data['street'].', '.$data['barangay'].', '.$data['city'].' City'?>">
                                <button type="submit" name="receipt" class="btn btn-outline-light"><i class="bi bi-receipt"></i></button>
                            </form>
                        </td>
                        <td class="ratings">
                            <a href="rate-history.php?trans=<?=$row['payTrans_id']?>&shop=<?=$shop_name?>" class="btn btn-outline-warning"><i class="bi bi-star"></i></a>
                        </td>
                    </tr>
                    <?php
                                }
                            }
                           
                    ?>
                </table>
            </div>
        </div>
    </div>
    <script>
        function printPage(){
            var conf = document.querySelectorAll('.confirm');
            var rate = document.querySelectorAll('.rating');
            var confi = document.querySelectorAll('.confirma');
            var ratings = document.querySelectorAll('.ratings');
            var trans = document.querySelector('#transprint');

            trans.remove();

            for (var i = 0; i < conf.length; i++) {
                conf[i].remove();
            }
            for (var i = 0; i < rate.length; i++) {
                rate[i].remove();
            }
            for (var i = 0; i < confi.length; i++) {
                confi[i].remove();
            }
            for (var i = 0; i < ratings.length; i++) {
                ratings[i].remove();
            }
            window.print();
        }
    </script>
</body>
</html>