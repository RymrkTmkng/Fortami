<?php
    include 'backend.php';
    include 'buyerheader.php';
    $backend = new Backend;

    $backend->checksession();
    if (isset($_GET['rate'])) {
        $rate = $_GET['rate'];
    }
    else {
        $rate = 0;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rate Product</title>
    <style type="text/css">
        .stars{
            display:flex;
        }
        .stars.disabled{
            pointer-events:none;
        }
        .stars a{
            opacity:50%;
            text-decoration:none;
        }
        .stars a:hover{
            opacity:100%;
        }
        .stars:hover a{
            opacity:100%;
        }
        .stars a:hover ~ a{
            opacity: 50%;
        }
        .stars a.active {
            opacity:100%;
        }
    </style>
</head>
<body>
    <div class="container p-5">
        <div class="row g-3">
            <div class="col-12 bg-dark bg-gradient text-center rounded shadow p-2">
                <h3 class="text-light">Rate Orders</h3>
            </div>
            <div class="col-12">
                <h5><i>Transaction #: 2023<?=$_GET['trans']?></i></h5>
            </div>
            <?php
                    if (isset($_GET['trans'])) {
                        $trans_id = $_GET['trans'];
                        $foods = $backend->toRate($trans_id);
                    }
                    else {
                        $trans_id = "";
                        $foods = [];
                    }
                    if (!is_null($foods)) {
                        foreach ($foods as $row) {
                ?>
            <div class="col-12">
                <div class="card mb-3 w-100">
                    <div class="row g-0">
                        <div class="card-header bg-body-secondary bg-gradient">
                            <h6>Order #: <?=$row['order_id']?></h6>
                        </div>
                        <div class="col-md-4">
                        <img src="./src/uploads/food_picture/<?=$row['food_pic']?>" class="img-thumbnail rounded-start ">
                        </div>
                        <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?=$row['food_name']?></h5>
                            <p class="card-text"><?=$row['preparation']?></p>
                            <hr>
                            <h6><p class="card-text"><small class="text-secondary">Order Date: </small><?=date("M d, Y h:i a",strtotime($row['order_datetime']))?></p></h6>
                            <h6><p class="card-text"><small class="text-secondary">Receive Date:  </small><?=date("M d, Y h:i a",strtotime($row['received_datetime']))?></p></h6>
                                <div class="stars">
                                    <h5 class="stars"><small class="text-secondary">Rate :</small>  
                                        <?=($rate == 0) ? "<a href='rate.php?trans=$trans_id&rate=1'>⭐</a><a href='rate.php?trans=$trans_id&rate=2' >⭐</a><a href='rate.php?trans=$trans_id&rate=3'>⭐</a><a href='rate.php?trans=$trans_id&rate=4' >⭐</a><a href='rate.php?trans=$trans_id&rate=5'>⭐</a>" : ""?>
                                        <?=($rate == 1) ? "<a href='rate.php?trans=$trans_id&rate=1' style='opacity:100%'>⭐</a><a href='rate.php?trans=$trans_id&rate=2'>⭐</a><a href='rate.php?trans=$trans_id&rate=3'>⭐</a><a href='rate.php?trans=$trans_id&rate=4'>⭐</a><a href='rate.php?trans=$trans_id&rate=5'>⭐</a>" : "";?>
                                        <?=($rate == 2) ? "<a href='rate.php?trans=$trans_id&rate=1' style='opacity:100%'>⭐</a><a href='rate.php?trans=$trans_id&rate=2' style='opacity:100%'>⭐</a><a href='rate.php?trans=$trans_id&rate=3'>⭐</a><a href='rate.php?trans=$trans_id&rate=4'>⭐</a><a href='rate.php?trans=$trans_id&rate=5'>⭐</a>" : "";?>
                                        <?=($rate == 3) ? "<a href='rate.php?trans=$trans_id&rate=1' style='opacity:100%'>⭐</a><a href='rate.php?trans=$trans_id&rate=2' style='opacity:100%'>⭐</a><a href='rate.php?trans=$trans_id&rate=3' style='opacity:100%'>⭐</a><a href='rate.php?trans=$trans_id&rate=4'>⭐</a><a href='rate.php?trans=$trans_id&rate=5' >⭐</a>" : "";?>
                                        <?=($rate == 4) ? "<a href='rate.php?trans=$trans_id&rate=1' style='opacity:100%'>⭐</a><a href='rate.php?trans=$trans_id&rate=2' style='opacity:100%'>⭐</a><a href='rate.php?trans=$trans_id&rate=3' style='opacity:100%'>⭐</a><a href='rate.php?trans=$trans_id&rate=4' style='opacity:100%'>⭐</a><a href='rate.php?trans=$trans_id&rate=5'>⭐</a>" : "";?>
                                        <?=($rate == 5) ? "<a href='rate.php?trans=$trans_id&rate=1' style='opacity:100%'>⭐</a><a href='rate.php?trans=$trans_id&rate=2' style='opacity:100%'>⭐</a><a href='rate.php?trans=$trans_id&rate=3' style='opacity:100%'>⭐</a><a href='rate.php?trans=$trans_id&rate=4' style='opacity:100%'>⭐</a><a href='rate.php?trans=$trans_id&rate=5' style='opacity:100%'>⭐</a>"  : "";?>
                                    </h5>
                                </div>
                            <form action="rate-success.php" method="GET">
                                <h5 class="card-title"><textarea class="form-control" name="comments" id="" cols="20" rows="5" placeholder="Comments..."></textarea></h5>
                                <input type="hidden" name="order" value="<?=$row['order_id']?>">
                                <input type="hidden" name="trans" value="<?=$trans_id?>">
                                <input type="hidden" name="rate" value="<?=$rate?>">
                                <input type="submit" name="savebtn" class="btn btn-success" value="Save">
                            </form>
                            
                        </div>
                        </div>
                    </div>
                </div>
            </div> 
            <?php
                        }
                    }
                    else{
                    }
            ?>
        </div>
    </div>
</body>
</html>