<?php
  include 'backend.php';
  include 'admin-header.php';
  $backend = new Backend;
  $backend->checksession();
  $admin = new Admin;
  $users = $admin->totalUser();
  $data = mysqli_fetch_assoc($users);

  //total buyers
  $Countbuyer = $admin->totalBuyer();
  $buyer = mysqli_fetch_assoc($Countbuyer);

  //total sellers
  $Countseller = $admin->totalSeller();
  $seller = mysqli_fetch_assoc($Countseller);

  //total food listing
  $foods = $admin->totalFood();
  $food = mysqli_fetch_assoc($foods);

  //total amount of transaction
    $sum = $admin->sumAmount();
    $amount = mysqli_fetch_assoc($sum);
    $total = number_format((float)$amount['total'],2,'.',',')
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <style>
    .dash{
      background-image:linear-gradient(to top right, #4990b5,skyblue);
      border:none;
    }
  </style>
</head>
<body>
    <div class="container p-2 ">
      <div class="row column-gap-3 row-gap-3 d-flex align-items-center justify-content-center rounded shadow pb-3">
        <div class="col-12 text-center bg-warning bg-gradient rounded shadow p-3">
          <h1><i>Dashboard</i></h1>
        </div>
        <div class="col-md-2 card p-3 rounded-5 shadow text-center dash">
              <div class="card-body">
                <h2 class="card-title"><i class="bi bi-people"><?=($data['users'] > 1)?'Users':'User'?></i></h2>
                <hr>
                <p class="card-text"><h1><?=$data['users']?></h1></p>
              </div>
        </div>
        <div class="col-md-2 card p-3 rounded-5 shadow text-center dash">
              <div class="card-body">
                <h2 class="card-title"><i class="bi bi-people"> <?=($buyer['buyers'] > 1)?'Buyers':'Buyer'?></i></h2>
                <hr>
                <p class="card-text"><h1><?=$buyer['buyers']?></h1></p>
              </div>
        </div>
        <div class="col-md-2 card p-3  rounded-5 shadow text-center dash">
              <div class="card-body">
                <h2 class="card-title"><i class="bi bi-people"><?=($seller['sellers'] > 1)?'Sellers':'Seller'?></i></h2>
                <hr>
                <p class="card-text"><h1><?=$seller['sellers']?></h1></p>
              </div>
        </div>
        <div class="col-md-3 card p-3 rounded-5 shadow text-center dash">
              <div class="card-body">
                <h2 class="card-title"><i class="bi bi-egg-fried"><?=($food['foods'] > 1)?'Food Listings':'Food Listing'?></i></h2>
                <hr>
                <p class="card-text"><h1><?=$food['foods']?></h1></p>
              </div>
        </div>
        <div class="col-md-6 card p-3  rounded-5 shadow text-center dash">
            <a href="admin-transaction.php?commission=show" style="text-decoration:none;color:black">
              <div class="card-body">
                <h2 class="card-title"><i class="bi bi-cash-coin"> Commission</i></h2>
                <hr>
                <p class="card-text"><h1>₱ <?=$total?></h1></p>
              </div>
            </a>
        </div>
        <hr>
        <div class="col-md-3 card p-3 bg-dark bg-gradient text-light rounded-5 shadow text-center">
            <a href="chat.php" style="text-decoration:none;color:white">
              <div class="card-body">
                <h2 class="card-title"><i class="bi bi-gear-fill"> Message</i></h2>
              </div>
            </a>
        </div>
        <div class="col-md-3 card p-3 bg-dark bg-gradient text-light rounded-5 shadow text-center">
            <a href="user.php" style="text-decoration:none;color:white">
              <div class="card-body">
                <h2 class="card-title"><i class="bi bi-gear-fill"> Account</i></h2>
              </div>
            </a>
        </div>
        <div class="col-md-3 card p-3 bg-dark bg-gradient text-light rounded-5 shadow text-center">
            <a href="product-admin.php" style="text-decoration:none;color:white">
              <div class="card-body">
                <h2 class="card-title"><i class="bi bi-gear-fill"> Product</i></h2>
              </div>
            </a>
        </div>
        <div class="col-md-3 card p-3 bg-dark bg-gradient text-light rounded-5 shadow text-center">
            <a href="admin-transaction.php" style="text-decoration:none;color:white">
              <div class="card-body">
                <h2 class="card-title"><i class="bi bi-gear-fill"> Transaction</i></h2>
              </div>
            </a>
        </div>
        <div class="col-md-3 card p-3 bg-dark bg-gradient text-light rounded-5 shadow text-center">
            <a href="report-list.php" style="text-decoration:none;color:white">
              <div class="card-body">
                <h2 class="card-title"><i class="bi bi-gear-fill"> Reports</i></h2>
              </div>
            </a>
        </div>
        <div class="col-md-3 card p-3 bg-dark bg-gradient text-light rounded-5 shadow text-center">
            <a href="settings-other.php" style="text-decoration:none;color:white">
              <div class="card-body">
                <h2 class="card-title"><i class="bi bi-gear-fill"> Others</i></h2>
              </div>
            </a>
        </div>
      </div>
    </div>
</body>
</html>