<?php
    include 'backend.php';
    include 'admin-header.php';
    $backend = new Backend;

    $backend->checksession();
    $method = $backend->listMethod();
    $category = $backend->listCategory();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting</title>
</head>
<body>
    <div class="container p-2">
        <div class="row column-gap-3 row-gap-3 d-flex align-items-center justify-content-center rounded shadow pb-3">
            <div class="col-12 text-center bg-warning bg-gradient rounded shadow p-3">
                <h1><i class="bi bi-gear-fill"></i></h1>
            </div>
            <div class="col-md-2 card p-3 bg-dark bg-gradient text-light rounded-5 shadow text-center">
                <a href="settings-other.php?btn=payment" style="text-decoration:none;color:white">
                    <div class="card-body">
                        <h2 class="card-title"><i class="bi bi-coin"> Payment</i></h2>
                    </div>
                </a>
            </div>
            <div class="col-md-2 card p-3 bg-dark bg-gradient text-light rounded-5 shadow text-center">
                <a href="settings-other.php?btn=category" style="text-decoration:none;color:white">
                    <div class="card-body">
                        <h2 class="card-title"><i class="bi bi-tags"> Category</i></h2>
                    </div>
                </a>
            </div>
            <?php
                if (isset($_GET['btn'])) {
                    if ($_GET['btn'] == 'payment') {
                    //payment table
            ?>
                <div class="col-12 ">
                    <table class="table table-dark table-striped ">
                            <tr>
                                <th>Id</th>
                                <th>Method</th>
                                <th>Action</th>
                            </tr>
                            <?php
                                if (!is_null($method)) {
                                foreach($method as $row) {
                            ?>
                            <tr>
                                <td><?=$row['paymethod_id']?></td>
                                <td><?=$row['paymethod_type']?></td>
                                <td>
                                        <a href='settings-payment.php?btn=edit&id=<?=$row['paymethod_id']?>&name=<?=$row['paymethod_type']?>' class="btn btn-warning"><i class="bi bi-pencil-fill"></i></a>
                                        <a href='settings-payment.php?btn=del&id=<?=$row['paymethod_id']?>' class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                </td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                            <tr>
                                <td><a href="settings-payment.php?btn=add" class="btn btn-success"><i class="bi bi-plus-circle"> Method</i></a></td>
                                <td></td>
                                <td></td>
                            </tr>
                    </table>
                </div>
            <?php
                    }
                    elseif($_GET['btn'] == 'category'){
                    //category table
            ?>
            <div class="col-12 ">
                    <table class="table table-dark table-striped ">
                            <tr>
                                <th>Id</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            <?php
                                if (!is_null($category)) {
                                foreach($category as $row) {
                            ?>
                            <tr>
                                <td><?=$row['category_id']?></td>
                                <td><?=$row['category_name']?></td>
                                <td><?=$row['category_description']?></td>
                                <td>
                                        <a href='settings-category.php?btn=edit&id=<?=$row['category_id']?>&name=<?=$row['category_name']?>&desc=<?=$row['category_description']?>' class="btn btn-warning"><i class="bi bi-pencil-fill"></i></a>
                                        <a href='settings-category.php?btn=del&id=<?=$row['category_id']?>' class="btn btn-danger"><i class="bi bi-trash"></i></href='settings-category.php'>
                                </td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                            <tr>
                                <td><a href="settings-category.php?btn=add" class="btn btn-success"><i class="bi bi-plus-circle"> Category</i></a></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                    </table>
                </div>
            <?php
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>