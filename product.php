<?php
include 'backend.php';
include 'sellerheader.php';

$backend = new Backend;
$backend->checksession();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Fortami | Product</title>
</head>
<body>
    <?php
        $list = $backend->listproduct();
    ?>
    
    <div class="container-fluid p-5 table-responsive" >
        <div class="col-12"><h1 class=" text-center "><i>Your Food Listing</i></h1></div>
        <table class="table table-dark shadow table-striped text-center">
            <tr>
                <th>Photo</th>
                <th>Category</th>
                <th>Food</th>
                <th>Description</th>
                <th>Serving Size</th>
                <th>Preparation</th>
                <th>Date Prepared</th>
                <th>Consume Before</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php
                foreach($list as $data){
            ?>
            <tr>
                <td><img src="./src/uploads/food_picture/<?=$data['food_pic']?>" class="img-fluid" alt="Food Image" style="max-width:100px"></td>
                <td><?=$data['category_name']?></td>
                <td><?=$data['food_name']?></td>
                <td><?=$data['food_description']?></td>
                <td><?=$data['serving_size']?></td>
                <td><?=$data['preparation']?></td>
                <td><?php 
                        if($data['food_creation'] == '0000-00-00 00:00:00'){
                            echo "-";
                        }
                        else {
                            echo date("M d, Y | h:i a",strtotime($data['food_creation']));
                        }
                    ?>
                </td>
                <td>
                    <?php 
                        if($data['food_expiration'] == '0000-00-00'){
                            echo "-";
                        }
                        else {
                            echo date("M d, Y",strtotime($data['food_expiration']));
                        }
                    ?>
                </td>
                <td><?="<small><s class='text-secondary'>₱ ".$data['food_origPrice']."</s></small>"." ₱".$data['food_discountedPrice'];?></td>
                <td>
                    <form action="" method="post">
                        <a class="btn btn-warning" href="./edit.php?id=<?=$data['food_id']?>" ><i class="bi bi-pencil-fill"></i></a>
                            <input type="hidden" name="food_id" value="<?=$data['food_id']?>">
                            <button type="submit" value="clicked" name="delbtn" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            <?php
                }
                if (isset($_POST['delbtn'])) {
                    $food_id = $_POST['food_id'];
                    $backend->pendingProduct($food_id);
                }
                
            ?>
            <tr>
                <td><a class="btn btn-success text-center" href="./addfood.php"><i class="bi bi-plus-square-dotted"> Food</i> </a></td>
            </tr>
        </table>
    </div>
</body>
</html>