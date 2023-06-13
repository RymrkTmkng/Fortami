<?php
     include 'backend.php';
     $backend = new Backend;
     $report  = new Report;
     $backend->checksession();
     if (isset($_SESSION['role'])) {
         if ($_SESSION['role'] == 'Buyer') {
             include 'buyerheader.php';
         }elseif ($_SESSION['role'] == 'Seller') {
             include 'sellerheader.php';
         }elseif($_SESSION['role'] == 'Admin'){
             include 'admin-header.php';
         }
     }
     $list = $report->viewAllReports();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
</head>
<body>
    <div class="container">
        <div class="row g-3 p-2">
            <div class="col-12 bg-danger text-light bg-gradient rounded shadow p-2">
                <h2><i class="bi bi-flag-fill"> Reports</i></h2>
            </div>
            <div class="col-12 table-responsive">
                <table class="table table-warning">
                    <?php
                        if (!is_null($list)) {
                            foreach ($list as $row) {
                    ?>
                        <tr>
                            <td><?=$row['user_fName'].' '.$row['user_lName']?></td>
                            <td><?=$row['issue']?></td>
                            <td><?=$row['description']?></td>
                            <td><?=date("M d, Y h:i a",strtotime($row['report_datetime']))?></td>
                            <td>
                                <form action="report-view.php" method="post">
                                    <input type="hidden" name="food_name" value="<?=$row['food_name']?>">
                                    <input type="hidden" name="food_id" value="<?=$row['food_id']?>">
                                    <input type="hidden" name="reportId" value="<?=$row['report_id']?>">
                                    <input type="hidden" name="senderId" value="<?=$row['user_id']?>">
                                    <input type="hidden" name="photo" value="<?=$row['photo']?>">
                                    <input type="hidden" name="sender" value="<?=$row['user_fName'].' '.$row['user_lName']?>">
                                    <input type="hidden" name="issue" value="<?=$row['issue']?>">
                                    <input type="hidden" name="description" value="<?=$row['description']?>">
                                    <button type="submit" name="viewbtn" value="1" class="btn btn-dark"><i class="bi bi-eye-fill"></i></button>
                                    <button type="submit" name="viewbtn" value="1" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
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