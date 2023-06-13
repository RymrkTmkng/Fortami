<?php
    include 'backend.php';
    include 'buyerheader.php';
    $wallet = new Wallet();
    if (isset($_GET['shop'])) {
        if (isset($_POST['selectbtn'])) {
            $shop = $_GET['shop'];
            $method = $_POST['wallet'];
            $find = $wallet->findWallet($method,$shop);
            $data = mysqli_fetch_assoc($find);
            
        }else{
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Payment</title>
</head>
<body>
    <div class="container text-center my-5 d-flex justify-content-center">
        <div class="row g-3 p-2 shadow rounded">
            <h1 class="bg-warning rounded p-2"><i>E-Wallet Payment</i></h1>
            <form action="" method="post">
                <div class="col-12">
                    <select class="form-control" name="wallet" required>
                        <option value="" selected disabled>-- Select a Payment Method Below --</option>
                        <option value="1">Gcash</option>
                        <option value="2">Maya</option>
                        <option value="3">Coinsph</option>
                    </select>
                </div><br>
                <div class="col-12">
                    <button type="submit" name="selectbtn" class="btn btn-success">Select Payment</button>
                </div>
            </form>
            <?php
            ?>
            <div class="col-12">
                <h6><i>You can scan the QR Code</i></h6>
            </div>
            <div class="col-12">
                <h6 class="text-secondary"><i>Account Name</i></h6>
                <h6></h6>
            </div>
            <div class="col-12">
                <h6 class="text-secondary"><i>Account Number</i></h6>
                <h6></h6>
            </div>
            <?php
                
            ?>
        </div>
    </div>
    <?php 
    ?>
</body>
</html>