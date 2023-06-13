<?php
include 'backend.php';
include 'buyerheader.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <div class="container">
      <br><br>
      <div class="row">
        <div class="col d-flex justify-content-end align-items-center" >
            <h1 style="text-align:end;font-size:10vmin;">
              Don't Starve
              <div class="row">
              <small class="text-muted">Just Order</small>
              <a href="login.php" class="btn btn-primary" style="background-color:#4990b5;border:none">Order Now</a>
              </div>
            </h1>
        </div>
        <div class="col">
            <img src="./src/Food-Delivery-Service-PNG-Photo.png" class="round float-start" alt="">
        </div>
      </div>
      <hr class="text-info">
      <div class="row g-3 p-2">
        <div class="col-12 text-center">
          <h1 style="font-family: 'Montserrat Alternates', sans-serif;color:#4990b5;">Fortami</h1>
            <h3 class="text-secondary"><i>Food for your tummy</i></h3>
        </div>
      </div>
      <hr class="text-info">
      <div class="row">
        <div class="col"><img src="./src/foodshop.png" class="round float-end" alt=""></div>
        <div class="col d-flex justify-content-start align-items-center" >
            <h1 style="text-align:start;font-size:10vmin;">
              More Customers
              <div class="row">
              <small class="text-muted">More Sales</small>
              <a href="login.php" class="btn btn-success">Sell Now</a>
              </div>
            </h1>
        </div>
      </div>
    </div>
</body>
</html>