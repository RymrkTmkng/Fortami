<?php
    include 'backend.php';
    $backend = new Backend;
    $backend->checksession();
    $result= $backend->total();
    $subtotal = mysqli_fetch_assoc($result);
    $total = number_format((float)$subtotal['total'], 2, '.', ',');
    $pay_amount = number_format((float)$subtotal['total'], 2, '.', '');
    $fee = $pay_amount * 0.10;
    $vat = $fee * 0.12;
    $pay = $pay_amount + $fee + $vat;
    $payment = number_format((float)$pay,2,'.',',');

    if (isset($_GET['trans_id'])) {
        $transaction = $_GET['trans_id'];

        $backend->orderAgain($transaction);
        
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">    
    <style>
        body{
            background-image:linear-gradient(#4990b5,skyblue);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row p-3 g-1">
            <?php   
                    $list = $backend->userAddress();
                       //variables
                        if (!(is_null($list))) {
                            if (!isset($_SESSION['option'])) {
                                $_SESSION['option'] = "Delivery";
                            }
                            $row = mysqli_fetch_assoc($list);
                            $name = $row['full_name'];
                            $contact = $row['contact'];
                            $province = $row['province'];
                            $city = $row['city'];
                            $brgy = $row['barangay'];
                            $street = $row['street'];
                            $zip = $row['zip'];
                            $address_type = $row['address_type'];
                            $note = $row['note'];
                            $_SESSION['address_id'] = $row['address_id'];
                            
                        }
                        if (isset($_POST['home'])) {
                            $_SESSION['option'] = "Delivery";
                            $row = mysqli_fetch_assoc($list);
                                if (!is_null($row)) {
                                    if ($row['label'] === 'Home' ) {
                                        $name = $row['full_name'];
                                        $contact = $row['contact'];
                                        $province = $row['province'];
                                        $city = $row['city'];
                                        $brgy = $row['barangay'];
                                        $street = $row['street'];
                                        $zip = $row['zip'];
                                        $address_type = $row['address_type'];
                                        $note = $row['note'];
                                        $_SESSION['address_id'] = $row['address_id'];
                                    }
                                }
                        }
                        if(isset($_POST['work'])) {
                            $_SESSION['option'] = "Delivery";
                            $row = mysqli_fetch_assoc($list);
                                if (!is_null($row)) {
                                    if ($row['label'] === 'Work'){
                                        $name = $row['full_name'];
                                        $contact = $row['contact'];
                                        $province = $row['province'];
                                        $city = $row['city'];
                                        $brgy = $row['barangay'];
                                        $street = $row['street'];
                                        $zip = $row['zip'];
                                        $address_type = $row['address_type'];
                                        $note = $row['note'];
                                        $_SESSION['address_id'] = $row['address_id'];
                                    }
                                }
                        }

                    if (isset($_POST['deletebtn'])) {
                        $address_id = $_POST['address_id'];
                        $backend->delAddress($address_id);
                    }
                    
                    if (isset($_POST['pickup'])) {
                        $_SESSION['option'] = "Pick-up";
                        if (isset($_GET['shop_id'])) {
                            $shopId = $_GET['shop_id'];
                            $sellAd = $backend->sellerAddress($shopId);
                            $address = mysqli_fetch_assoc($sellAd);
                                if (!is_null($address)) {
                                    $name = $address['full_name'];
                                    $contact = $address['contact'];
                                    $province = $address['province'];
                                    $city = $address['city'];
                                    $brgy = $address['barangay'];
                                    $street = $address['street'];
                                    $zip = $address['zip'];
                                    $note = $address['note'];
                                }
                        }
                    }
            ?>
                <div class="col-12 p-2  rounded-start" >
                    <div class="row g-3 ">
                        <div class="col-12 text-center">
                            <h1><i class="bi bi-person-fill-up"></i> Delivery Address</h1>
                        </div>
                        <div class="col-12">                           
                                <form action="" method = "post">
                                    <button class="btn btn-primary" type="submit" name="home" value="Home">Home</button>
                                    <button class="btn btn-secondary" type="submit" name="work" value="Work">Work</button>
                                    <button class="btn btn-warning" type="submit" name="pickup" value="Pick-up">Pick-up</button>
                                    <a href="address.php" class="btn btn-success"><i class="bi bi-house-add-fill"> Add Address</i></a>
                                </form>
                        </div>
                        <div class="col-md-6">
                            <label for="fname" class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="fullname" value="<?=$name?>" disabled>
                        </div>
                        <div class="col-md-6">
                            <label for="contact" class="form-label">Contact Number</label>
                            <input type="tel" class="form-control" name="telnum" value="<?=$contact?>" disabled>
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" name="ad" placeholder="street, apartment, studio or floor" value="<?=$street?>"disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="province" class="form-label">Province</label>
                            <input type="text" class="form-control" name="province" value="<?=$province?>"disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" name="city" value="<?=$city?>"disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="brgy" class="form-label">Barangay</label>
                            <input type="text" class="form-control" name="brgy" value="<?=$brgy?>"disabled>
                        </div>
                        <div class="col-md-4">
                            <label for="zip" class="form-label">Zip</label>
                            <input type="number" class="form-control" name="zip" value="<?=$zip?>"disabled>
                        </div>
                        <div class="col-md-8">
                            <label for="note" class="form-label">Note <small class="text-secondary"><i>(Optional)</i> </small></label>
                            <input type="text" class="form-control" name="note" value="<?=$note?>"disabled>
                        </div>
                        <div class="col-12">
                            <label for="type" class="form-label">Save as: </label>
                                <input class="form-check-input" type="radio" name="address_type" value="Default" id="flexRadioDefault1" value = "<?=$address_type?>" checked>
                                <label class="form-check-label" for="flexRadioDefault1" >
                                    Default
                                </label>
                        </div>
                        <div class="col-12">
                            <form action="" method="post">
                                <a href="address-edit.php?id=<?=$_SESSION['address_id']?>" class="btn btn-warning <?=($_POST['pickup'])?'disabled':''?>"><i class="bi bi-pencil-square"></i> Edit</a>
                                <input type="hidden" name="address_id" value="<?=$_SESSION['address_id']?>">
                                <button class="btn btn-danger <?=($_POST['pickup'])?'disabled':''?>" type="submit" name="deletebtn"><i class="bi bi-trash3"></i> Delete</button>
                            </form>
                        </div>
                    </div>
                    
                </div>
                <div class="col-12 p-2 bg-secondary bg-gradient rounded table-responsive">
                    <i><h3>Your Order</h3></i>
                    <table class="table table-dark table-striped ">
                        
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Total</th>
                        </tr>
                        <?php
                            $list = $backend->getcart();
                            if (!is_null($list)) {
                                if ($list->num_rows > 0) {
                                    foreach ($list as $row) {
                        ?>
                        <tr>
                            <td><?=$row['food_name']?></td>
                            <td class="text-center"><?=$row['quantity']?></td>
                            <td class="text-center"><?=$row['food_discountedPrice']?></td>
                            <td class="text-center"><?=$row['food_discountedPrice']*$row['quantity']?></td>
                        </tr>
                        <?php
                                }
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="3">Subtotal</td>
                            <td class="text-center">₱ <?=$pay_amount?></td>
                        </tr>
                        <tr>
                            <td colspan="3">Processing Fee</td>
                            <td class="text-center">₱ <i><?=$fee?></i></td>
                        </tr>
                        <tr>
                            <td colspan="3" >VAT(12%)</td>
                            <td class="text-center">₱ <?=$vat?></td>
                        </tr>
                        <tr >
                            <td class="text-warning">Total: </td>
                            <td></td>
                            <td></td>
                            <td class="text-warning text-center">₱  <?=$payment?></td>
                        </tr>
                    </table>
                    <br>
                    <div class="col-12">
                        <a href="payment.php?shop=<?=$_GET['shop_id']?>" class="btn btn-warning p-2 w-100">
                            <img src="./src/epay.png" style="max-width:100px;" class="img-fluid">
                        </a>
                    </div>
                    <div class="col-12">
                        <p>
                            <button class="btn btn-dark p-2 w-100 my-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                <img src="./src/creditcard.png" alt="Credit Card" class="img-fluid" style="max-width:100px">
                            </button>
                        </p>
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body">
                               <form action="" method="post">
                               <input type="hidden" name="method" value="4">
                                    <div class="row g-2">
                                        <div class="col-sm-12">
                                            <input class="form-control" type="text" name="cardowner" placeholder="Name on Card" required>
                                        </div>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="text" name="cardnum" placeholder="Card Number" required>
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control" type="text" name="exp" placeholder="01/23" required>
                                        </div>
                                        <div class="col-sm-2">
                                            <input class="form-control" type="password" name="cvv" placeholder="CVV" required>
                                        </div>
                                        <div class="col-sm-12">
                                            <button class="form-control btn btn-success" type="submit" name="paybtn">Pay Now</button>
                                        </div>
                                    </div>     
                               </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <a href="cart.php" class="btn btn-danger w-100 p-2"><i class="bi bi-pencil-fill"></i> Edit Cart</a>
                    </div>
                </div>
            </div>
        </div>
        <?php
            if (isset($_POST['paybtn'])) {
              $time = date('Y-m-d H:i:s');
              $method = $_POST['method'];
              $user = $_SESSION['id'];
              $status = 'Successful';
              $option = $_SESSION['option'];
                if (isset($_SESSION['address_id'])) {
                    $address = $_SESSION['address_id'];
                    $backend->payment($user,$method,$pay,$vat,$fee,$option,$status);//inserting the payment to payment db
                
                    $getpayment = $backend->getpayment($user,$time);//get trans_id
                        if ($getpayment->num_rows > 0) {
                            $paymentList = mysqli_fetch_assoc($getpayment);
                            $trans_id = $paymentList['payTrans_id'];//declaration of variable that holds paytrans Id
                            $_SESSION['trans_id'] = $trans_id;

                            $cart = $backend->getcart();//getting cart to insert every foods in order table
                                if ($cart->num_rows > 0) {
                                        foreach ($cart as $cartRow) {
                                            $backend->order($cartRow['food_id'],$address,$trans_id,'Pending',$cartRow['quantity']);
                                        }
                                        $shop = $_GET['shop_id'];
                                        $shopfunc = $backend->sellerAddress($shop);
                                        $shopData = mysqli_fetch_assoc($shopfunc);
                                        $shopName = $shopData['full_name'];
                                        $notif = new Notification;
                                        $notif->newUserNotif($user,"You have ordered from $shopName with a total amount of ₱$total","Unread");
                                        $notif->newUserNotif($shop,"Hooray!, you have a new order,open the Orders tab to view pending orders.","Unread");
                                        $backend->clearcart();
                                }
                    }
                }
                else {
                    echo "<script>alert('Please input delivery address first!');</script>";
                }
            }

        ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>