<?php
    include 'backend.php';
    include 'sellerheader.php';
    $backend = new Backend;

        $status = "";
        $address= "";
        $buyer = "";
        $trans_id = "";
        $total ="";

    if (isset($_POST['info'])) {
        $status = "Preparing";
        $address= $_POST['address'];
        $buyer = $_POST['buyer'];
        $trans_id = $_POST['trans_id'];
        $total = $_POST['total'];

        $backend->orderStatus($trans_id,$status);
    }
    else {
        header('location: delivery.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
</head>
<body>
    <div class="container bg-body-tertiary p-2 my-3 shadow">
        <div class="row p-2 g-3">
            <div class="col-12 rounded bg-dark text-center">
                <h2 class="text-light">Order Specifications</h2>
            </div>
            <div class="col-md-8"><h5 class="text-secondary"><i>Recepient:</i>  </h5><h4><?=$buyer?></h4></div>
            <div class="col-md-4"><h5 class="text-secondary"><i>Option:</i>  </h5><h4>Delivery</h4></div>
            <div class="col-md-8"><h5 class="text-secondary"><i>Address:</i>  </h5><h4><?=$address?></h4></div>
            <div class="col-md-4"><h5 class="text-secondary"><i>Total Payment:</i>  </h5><h4>₱ <?=$total?>( <i class="text-secondary"><small>Paid</small></i> )</h4></div>


            <div class="col-12">
                <table class="table table-dark table-striped">
                    <tr>
                        <th>Image</th>
                        <th>Food</th>
                        <th>Quantity</th>
                    </tr>
                    <tr>
                        <?php
                            $foods = $backend->foodBought($trans_id);
                                if (!is_null($foods)) {
                                    foreach ($foods as $row) {    
                        ?>
                        <td><img src="./src/uploads/food_picture/<?=$row['food_pic']?>" class="img-thumbnail" style="max-width:100px"></td>
                        <td><?=$row['food_name']?></td>
                        <td><?=$row['quantity']?></td>
                    </tr>
                    <?php
                                }
                            }
                    ?>
                </table>
            </div>
            <div class="col-12 text-center">
                <form action="delivery.php" method="post">
                    <input type="hidden" name="trans_id" value="<?=$trans_id?>">
                    <button type="submit" name="ready" class="btn btn-success"><i class="bi bi-check-lg">Ready</i></button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>