<?php
    include 'backend.php';
    include 'buyerheader.php';
    $backend = new Backend;
    
        $sum = $backend->total();
        $total = mysqli_fetch_assoc($sum);
    //quantity

    if (isset($_POST['delete'])) {
        $food_id = $_POST['food'];
        $buyer_id = $_SESSION['id'];
        
        $backend->delcart($food_id,$buyer_id);
    }

    if (isset($_POST['clearcart'])) {
        $backend->clearcart();
    }

    if (isset($_POST['saveqty'])) {
        $food= $_POST['food'];
        $buyer = $_SESSION['id'];
        $qty = $_POST['qty'];

        $backend->editcart($food,$buyer,$qty);
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fortami | Cart</title>
</head>
<body>
    <div class="container-fluid p-2 ">
        <div class="text-secondary text-center">
            <h1>
                <i class="bi bi-cart-fill">Cart</i>
            </h1>
        </div>
        <div>
            <?php
                $sell = $backend->getSellerId();
                if ($sell->num_rows > 0) {
                    $seller_id = mysqli_fetch_assoc($sell);
                    $address = $backend->sellerAddress($seller_id['user_id']);
                        if ($address->num_rows > 0) {
                            $info = mysqli_fetch_assoc($address);
                            echo "<h2><i class='bi bi-shop'> ".$info['full_name']."</i></h2>";
                        }
                }
            ?>
        </div>
        <?php
                $list = $backend->getcart();
                if ($list->num_rows > 0) {
                    while($row = $list->fetch_assoc()){
            ?>
        <form action="cart.php" method="post">
            <div class="card mb-1 w-100  text-center">
                <div class="row row-cols-1 row-cols-md-1 g-1 d-flex align-items-center">
                    <div class="col-md-2 text-center">
                        <img src="./src/uploads/food_picture/<?=$row['food_pic'];?>" class="img-fluid rounded-start" alt="..." style="max-width:50%; height:auto">
                    </div>
                    <div class="col-md-1">
                        <div class="card-body ">
                            <p class="card-text">
                                <h6 class="card-title"><?=$row['food_name'];?></h6>
                            </p>
                            
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card-body">
                            <p class="card-text" style="display: -webkit-box;
                                -webkit-box-orient: vertical;
                                -webkit-line-clamp: 3;
                                overflow: hidden;">
                                <?=$row['food_description'];?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="card-body">
                            <p class="card-text" style="display: -webkit-box;
                                -webkit-box-orient: vertical;
                                -webkit-line-clamp: 3;
                                overflow: hidden;">
                                <?=$row['preparation'];?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card-body text-center">
                            <p class="card-text">
                                <h4>
                                    <small>
                                        <s class="text-secondary mx-2">
                                        ₱<?=$row['food_origPrice'];?>
                                        </s>
                                    </small>
                                    ₱<?=$row['food_discountedPrice'];?>
                                </h4>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card-body">
                            <p class="card-text">
                                <h4>
                                    <small class="text-secondary"><?=$row['quantity'];?> <?=($row['quantity'] > 1)? 'orders' : 'order'?></small>
                                        <button class="btn btn-outline-dark" type="button"  style="border:none;" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <div class="collapse" id="collapseExample">
                                            <div class="card card-body">
                                                <input type="hidden" name="food" value="<?=$row['food_id'];?>">
                                                <input type="number" name="qty" class="form-control text-center" min="1" placeholder="Qty" style="margin:auto;" required>
                                                <button type='submit' name='saveqty' class='btn btn-warning my-2'>Save</button>
                                            </div>
                                        </div>
                                </h4>
                            </p>
                        </div>
                    </form>
                    </div>
                    <div class="col-md-2">
                        <div class="card-body">
                                <p class="card-text text-center">
                                    <form action="cart.php" method="post">
                                        <input type="hidden" name="food" value="<?=$row['food_id'];?>">
                                        <button class="btn btn-danger" type="submit" name="delete"><i class="bi bi-trash3"></i></button>
                                    </form> 
                                </p>
                        </div>
                    </div>
                
            </div>
        <?php
            }
        }
        else {
            echo "<h1 class='text-dark text-center p-5'><i class='bi bi-cart-x'>No Products added yet!</i> </h1>";
        }
        ?>
        </div>

        <div class="card mb-1 w-100  text-center">
            <div class="row row-cols-1 row-cols-md-1 g-1 d-flex align-items-center">
            <div class="col-md-2">
                    <div class="card-body">
                        <p class="card-text" >
                            <h3></h3>
                        </p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card-body">
                        <p class="card-text" >
                            <h3></h3>
                        </p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card-body">
                        <p class="card-text" >
                            <h3>Subtotal: </h3>
                        </p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card-body">
                        <p class="card-text" >
                            <small clas="text-secondary">
                            <h3>
                                <?php
                                    echo "₱".number_format((float)$total['total'], 2, '.', '');
                                ?>
                            </h3>
                            </small>
                        </p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card-body">
                        <p class="card-text" >
                            <a href="checkout.php?shop_id=<?=$seller_id['user_id']?>" class="btn btn-dark" style="max-width:100%;height:auto"><i class="bi bi-bag-check"></i> Checkout</a>
                        </p>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card-body">
                        <p class="card-text" >
                            <form action="" method="post">
                                <button type="submit" name="clearcart" class="btn btn-danger" style="max-width:100%;height:auto"><i class="bi bi-bag-x"></i> Clear Cart</button>
                            </form>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>