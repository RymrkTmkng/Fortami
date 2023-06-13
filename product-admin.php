<?php
    include 'backend.php';
    include 'admin-header.php';
    $backend = new Backend;
    $result = $backend->getproduct();
    $rating = new Rating;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
</head>
<body>
    <div class="container p-5">
        <div class="row g-3 p-2">
            <div class="col-12 bg-warning rounded shadow p-2">
                <h2 class="text-center">Fortami Products</h2>
            </div>
            <div class="col-3">
                <a href="admin.php" class="btn btn-outline-dark"><i class="bi bi-arrow-bar-left">Back</i></a>
            </div>
            <div class="col-12 table-responsive">
                <table class="table table-dark table-striped text-center">
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Food</th>
                        <th>Shop</th>
                        <th>Delete</th>
                    </tr>
                        <?php
                            if (!is_null($result)) {
                            foreach ($result as $row) {
                        ?>
                    <tr>
                        <td><?=$row['food_id']?></td>
                        <td><img src="./src/uploads/food_picture/<?=$row['food_pic']?>" class="img-thumbnail" alt="food" style="max-width:100px"></td>
                        <td><?=$row['food_name']?></td>
                        <td><?=$row['user_userName']?></td>
                        <td>
                            <form action="">
                                <input type="hidden" name="food_id" value="<?=$row['food_id']?>">
                                <button type="submit" name="delbtn" class="btn btn-danger" value="clicked"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                        
                    </tr>
                        <?php
                                }
                            }
                            if (isset($_GET['delbtn'])) {
                                $food = $_GET['food_id'];
                                
                                $backend->pendingProduct($food);
                            }
                        ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>