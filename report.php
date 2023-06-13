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
    $issue = "";
    $trans = "";
    $shopName ="";
    $shopId = "";
    $date = "";
    $order = "";
    $food_id = "";
    if (isset($_POST['subbtn'])) {
        $issue = $_POST['issue'];
        $trans = $_POST['trans_id'];
        $shopName =$_POST['shop'];
        $shopId = $_POST['shop_id'];
        $date = $_POST['date'];
        $order = $_POST['order'];
    }
    if (isset($_POST['repbtn'])) {
        $issue = "I want to report this food";
        $trans = $_POST['trans_id'];
        $shopName = $_POST['shop'];
        $shopId = $_POST['shop_id'];
        $date = date("M d, Y h:i a");
        $order = "";
        $food_id = $_POST['food'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Support</title>
</head>
<body>
    <div class="container">
        <div class="row rounded shadow g-3 p-2">
            <div class="col-12 bg-danger bg-gradient text-light rounded p-2">
                <h2><i class="bi bi-flag"> Report</i></h2>
            </div>
            <div class="col-12">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="order" value=<?=$order?>>
                    <input type="hidden" name="buyer" value="<?=$_SESSION['id']?>">
                    <input type="hidden" name="food" value="<?=$food_id?>">
                    <input type="hidden" name="trans" value=<?=$trans?>>
                    <input type="hidden" name="sub" value="<?=$issue?>">
                    <label for="shopname" class="form-label">Shop</label>
                    <input type="text" class="form-control mb-1" value="<?=$shopName?>" disabled>
                    <label for="shopname" class="form-label">Date</label>
                    <input type="text" class="form-control mb-1" value="<?=$date?>" disabled>
                    <label for="subject" class="form-label">Issue</label>
                    <input type="text" class="form-control mb-2" name="subject" value="<?=$issue?>" disabled>
                    <label for="description" class="form-label">Description <small class="text-secondary"><i>(Please specify your concern)</i></small></label>
                    <textarea type="text" class="form-control mb-3" name="issuedesc" placeholder="Please describe your issue here..." required></textarea>
                    <label for="photo" class="form-label">Upload Photo</label>
                    <input type="file" name="photo" class="form-control mb-3" required>
                    <button type="submit" name="reportbtn" value="1" class="btn btn-warning">Report</button>
                    <a href="transactions.php" class="btn btn-danger">Cancel</a>
                </form>
            </div>
        </div>
    </div>
    <?php
        if (isset($_POST['reportbtn'])) {
           $buyer = $_POST['buyer'];
           $food = $_POST['food'];
           $subject = $_POST['sub'];
           $desc = $_POST['issuedesc'];

           $photoName = $_FILES['photo']['name'];
           $photoSize = $_FILES['photo']['size'];
           $photoTMP = $_FILES['photo']['tmp_name'];
           $photoErr = $_FILES['photo']['error'];

            if ($photoErr === 0) {
                if ($photoSize > 5000000) {
                    echo "<script>alert('Please upload photo less than 5mb');</script>";
                }
                else {
                    $photo_ext = pathinfo($photoName,PATHINFO_EXTENSION);
                    $ext_lower = strtolower($photo_ext);
                    $allowed = array("jpg","jpeg","png");

                        if (in_array($ext_lower,$allowed)) {
                            $new_Name = uniqid("FORTAMI",true).'.'.$ext_lower;
                            $path = './src/uploads/report/'.$new_Name;
                            move_uploaded_file($photoTMP,$path);
                        }
                        else {
                            echo "<script>alert('File type not supported');</script>";
                        }
                }
            }


           $report->reportTrans($food,$buyer,$subject,$desc,$new_Name);
        }
    ?>
</body>
</html>