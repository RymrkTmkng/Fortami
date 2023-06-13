<?php
    include 'backend.php';
    include 'sellerheader.php';
    $backend = new Backend;
    $sales = new Sales;
    $backend->checksession();

    $sale = $sales->totalSales();
    $amount = mysqli_fetch_assoc($sale);

    $total = number_format((float)$amount['sales'],2,'.',',');

    $pend = $sales->totalPending();
    $pending = mysqli_fetch_assoc($pend);

    $transaction = $sales->totalTrans();
    $totalTrans = mysqli_fetch_assoc($transaction);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
<div class="container p-2 ">
      <div class="row column-gap-3 row-gap-3 d-flex align-items-center justify-content-center rounded shadow pb-3 bg-body-secondary">
        <div class="col-12 text-center bg-warning bg-gradient rounded shadow p-3">
          <h1><i>Dashboard</i></h1>
        </div>
        <div class="col-md-3 card border border-none rounded-5 shadow text-center" style="background-image:linear-gradient(to top right,#4990b5,skyblue)">
            <a href="sales-report.php" style="text-decoration:none;color:white">
              <div class="card-body">
                <h2 class="card-title"><i class="bi bi-graph-up-arrow"> Monthly Sales</i></h2>
                <hr>
                <p class="card-text"><h1><i>₱ <?=$total?></i></h1></p>
              </div>
            </a>
        </div>
        <div class="col-md-3 card border border-none rounded-5 shadow text-center" style="background-image:linear-gradient(to top right,#4990b5,skyblue)">
            <a href="delivery.php" style="text-decoration:none;color:white">
              <div class="card-body">
                <h2 class="card-title"> Ongoing Orders</h2>
                <hr>
                <p class="card-text"><h1><?=$pending['pending']?></h1></p>
              </div>
            </a>
        </div>
        <div class="col-md-4 card border border-none rounded-5 shadow text-center" style="background-image:linear-gradient(to top right, #4990b5,skyblue);">
            <a href="sales.php" style="text-decoration:none;color:white">
              <div class="card-body">
                <h2 class="card-title"> Completed Transactions</h2>
                <hr>
                <p class="card-text"><h1><?=$totalTrans['totalTrans']?></h1></p>
              </div>
            </a>
        </div>
        <div class="col-12 bg-warning bg-gradient text-center rounded p-3">
            <h3><i class="bi bi-fire"> In Demand Foods Today!</i></h3>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">
          <?php
            $list = $backend->demandProducts();
              if (!is_null($list)) {
                foreach ($list as $data) {
          ?>
          <div class="col-md-3 text-center">
            <div class="card h-100">
              <img src="./src/uploads/food_picture/<?=$data['food_pic']?>" class="card-img-top" alt="Food picture" style="max-width:100%;height:250px">
              <div class="card-body">
                <h5 class="card-title"><?=$data['food_name']?></h5>
                <p class="card-text">
                  <?php
                    $perProd = $backend->countSalesperProduct($data['food_id']);
                    $product = mysqli_fetch_assoc($perProd);
                      if (!is_null($product)) {
                        if ($product['foodCount'] > 1) {
                          echo "<strong>".$product['foodCount']."</strong> orders for today";
                        }
                        else {
                          echo "<strong>".$product['foodCount']."</strong> order for today";
                        }
                      }
                  ?>
                </p>
              </div>
              <div class="card-footer">
                <small class="text-body-secondary">
                  <?php 
                    $rate = $backend->viewRating($data['food_id']);
                    $rating = mysqli_fetch_assoc($rate);
                      if (!is_null($rating)) {
                        $star = "<i class='bi bi-star-fill text-warning'></i>";
                        $noStar =  "<i class='bi bi-star text-warning'></i>";
                        $halfstar = "<i class='bi bi-star-half text-warning'></i>";
                        $rateRes = $rating['rate'];
                        $rateRound = floor($rateRes);
                        $blankStar = 5 - $rateRound;

                        for ($i=0; $i < $rateRound; $i++) { 
                          echo $star;
                          
                        }
                        for ($j=0; $j < $blankStar ; $j++) { 
                          echo $noStar;
                          
                        }
                        echo " (".$rateRound."/5)";
                      }
                  ?>
                </small>
              </div>
            </div>
          </div>
        <?php
                }
              }
        ?>
        </div>
      </div>
    </div>
</body>
</html>