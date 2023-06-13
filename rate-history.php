<?php
    include 'backend.php';
    if ($_SESSION['role'] == 'Buyer') {
        include 'buyerheader.php';
    }
    else {
        include 'sellerheader.php';
    }
    $backend = new Backend;
    $rating = new Rating;
    
    $backend->checksession();

    if (isset($_GET['trans'])) {
        $trans_id = $_GET['trans'];
        $shop = $_GET['shop'];

        $result = $rating->listRating($trans_id);
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating History</title>
</head>
<body>
    <div class="container p-5">
        <div class="row">
            <div class="col-12 bg-warning bg-gradient rounded shadow text-light p-3 text-center">
                <h3><i class="bi bi-star-fill text-light"> Rating History</i></h3>
            </div>
            <div class="col-12 my-2 table-responsive">
                <a href="<?php if($_SESSION['role'] == 'Seller'){ echo 'sales.php';}elseif($_SESSION['role'] == 'Buyer'){echo 'transactions.php';}else{echo 'admin-transaction.php';}?>" class="btn btn-outline-dark"><i class="bi bi-arrow-bar-left">Back</i></a>
                <table class="table table-dark table-striped text-center my-2">
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Food</th>
                        <th>Quantity</th>
                        <th>Shop</th>
                        <th>Recipient</th>
                        <th>Rate</th>
                        <th>Comment</th>
                        <?=($_SESSION['role']=='Buyer')?'<th>Report</th>':''?>
                    </tr>
                        <?php
                            if (!is_null($result)) {
                                foreach ($result as $rate) {  
                        ?>
                    <tr>
                        <td><?=$rate['food_id']?></td>
                        <td><img src="./src/uploads/food_picture/<?=$rate['food_pic']?>" class="img-thumbnail" alt="food" style="max-width:100px"></td>
                        <td><?=$rate['food_name']?></td>
                        <td><?=$rate['quantity']?></td>
                        <td><?=$shop?></td>
                        <td><?=$rate['full_name']?></td>
                        <td><?php
                                $rating = $rate['rating'];
                                $unfill = 5 - $rating;
                                
                                for ($i=0; $i < $rating; $i++) { 
                                    echo "<i class='bi bi-star-fill text-warning p-1'></i>";
                                }
                                for ($i=0; $i < $unfill; $i++) { 
                                    echo "<i class='bi bi-star text-warning p-1'></i>";
                                }
                            ?>
                        </td>
                        <td><?=$rate['comment']?></td>
                        <?php
                            if ($_SESSION['role'] == 'Buyer') {
                                ?>
                                    <td>
                                        <form action="report.php" method="post">
                                            <input type="hidden" name="food" value="<?=$rate['food_id']?>">
                                            <input type="hidden" name="foodname" value="<?=$rate['food_name']?>">
                                            <input type="hidden" name="shop" value="<?=$shop?>">
                                            <input type="hidden" name="shop_id" value="<?=$_GET['shop_id']?>">
                                            <input type="hidden" name="trans_id" value="<?=$trans_id?>">
                                            <button type="submit" name="repbtn" class="btn btn-danger"><i class="bi bi-flag"></i></button>
                                        </form>
                                    </td>
                                <?php
                            }
                        ?>
                    </tr>
                        <?php
                                }
                            }
                        ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>