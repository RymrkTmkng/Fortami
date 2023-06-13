<?php
    include 'backend.php';
    $backend = new Backend;
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $result = $backend->fetchProduct($id);
            if (!is_null($result)) {
                $row = mysqli_fetch_assoc($result);
            }else{
                $row = [];
            }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Update</title>
    <style>
        body{
            background-image:linear-gradient(#4990b5,skyblue);
        }
    </style>
</head>
<body>
<div class="container p-2 min-vh-100">
<form class="row g-3"style="padding:30px;" action="" method="post" enctype="multipart/form-data">
    <h1>Update Food Listing</h1>
    <div class="input-group" style="width:1000px;">
        <input type="hidden" name="foodIMG" value="<?=$row['food_pic']?>">
        <label class="input-group-text" for="inputGroupFile01">Upload Food Image</label>
        <input type="file" class="form-control" id="inputGroupFile01" name="foodpic">&nbsp;<span><?=$row['food_pic']?></span>
    </div>
    <div class="input-group" style="width:1000px;">
        <select class="form-select" aria-label="Default select example" name="category" required>
            <option value="<?=$row['category_id']?>" selected><?=$row['category_name']?></option>
            <?php $backend->categorylist();?>
        </select>
    </div>
    <div class="col-md-6" >
            <label for="food name" class="form-label">Food Name</label>
            <input type="text" class="form-control" id="foodname" name="foodname" value="<?=$row['food_name'];?>" required>
    </div>
    <div class="col-md-6">
        <label for="floatingTextarea">Description</label>
            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea" name="fooddesc" required><?=$row['food_description'];?></textarea>
    </div>
    <div class="col-md-3">
            <label for="food name" class="form-label">Serving Size</label>
            <input type="text" class="form-control" name="size" placeholder="Good for " value="<?=$row['serving_size']?>" required>
    </div>
    <div class="col-md-3">
            <label for="preparation" class="form-label">Preparation</label>
            <select name="prep" id="" class="form-select" required>
                <option value="" selected disabled>Choose....</option>
                <option value="Made to order" <?=($row['preparation'] == 'Made to order')?'Selected':''?>>Made to order</option>
                <option value="Fresh" <?=($row['preparation'] == 'Fresh')?'Selected':''?>>Fresh</option>
                <option value="Surplus" <?=($row['preparation'] == 'Surplus')?'Selected':''?>>Surplus</option>
            </select>
        </div>
    <div class="col-md-3">
        <label for="datetime" class="form-label">Preparation Time</label>
        <input type="datetime-local" class="form-control" id="inputAddress" name="creation" value="<?=$row['food_creation'];?>">
    </div>
    <div class="col-md-3">
            <label for="date" class="form-label">Expiration Date </label>
            <input type="date" class="form-control" id="inputAddress" name="expiration" value="<?=$row['food_expiration'];?>">
    </div>
    <div class="col-md-3">
        <label for="inputZip" class="form-label">Original Price</label>
        <input type="number" class="form-control" name="origprice" id="origprice" value="<?=$row['food_origPrice'];?>" required>
    </div>
    <div class="col-md-3">
        <label for="inputState" class="form-label">Discounted Price <?=($row['preparation'] == 'Surplus')?'(-30%)':''?></label>
        <input type="number" class="form-control" name="disprice" id="disprice" value="<?=$row['food_discountedPrice'];?>" <?=($row['preparation']=='Surplus')?'disabled':''?> >
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-success" name="editbtn">Save Changes</button>
        <a class="btn btn-danger" href="product.php">Cancel</a>
    </div>
</form>
    
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<?php
    if(isset($_POST['editbtn'])){
        if (isset($_POST['category']) && isset($_FILES['foodpic'])) {
            $food_id = $_GET['id'];
            $foodpic = $_FILES['foodpic'];
            $food_pic = $_POST['foodIMG'];
            $prep = $_POST['prep'];
            $category = $_POST['category'];
            $foodname = $_POST['foodname'];
            $desc = $_POST['fooddesc'];
            $size = $_POST['size'];
            $time = $_POST['creation'];
            $exp = new DateTime($_POST['expiration']);
            $expiration_date = $exp->format('Y-m-d');
            $orig = $_POST['origprice'];
            $prep = $_POST['prep'];
                if ($prep == 'Surplus') {
                    $dis = $orig * 0.30;
                    $disc = $orig - $dis;
                }else {
                   if ($_POST['disprice'] == 0) {
                    $disc = $orig;
                   }
                   else {
                    $disc = $_POST['disprice'];
                   }
                }

                $pic_name = $_FILES['foodpic']['name'];
                $pic_size = $_FILES['foodpic']['size'];
                $pic_tmp = $_FILES['foodpic']['tmp_name'];
                $error = $_FILES['foodpic']['error'];

                if ($error === 0) {
                    if ($pic_size > 1000000) {
                        echo "File size too large, please upload less than 1mb";
                    }
                    else {
                        $img_ext = pathinfo($pic_name,PATHINFO_EXTENSION);
                        $ext_lowercase = strtolower($img_ext);

                        $allowed_ext = array("jpg","jpeg","png");

                        if (in_array($img_ext,$allowed_ext)) {
                           $new_imgName = uniqid("FORTAMI-",true).'.'.$ext_lowercase;
                           $img_upload_path = './src/uploads/food_picture/'.$new_imgName;

                           move_uploaded_file($pic_tmp,$img_upload_path);
                        }else{
                            $new_imgName = "";
                            echo "<script>alert('File type not supported');</script>";
                        }
                    }
                }
                else {
                    echo "Unknown Error Occured, Please Try Again.";
                }

            $backend->editproduct($food_id,$category,$new_imgName,$foodname,$desc,$size,$prep,$time,$expiration_date,$disc,$orig);
        }
        else{
            echo "Please select food category and upload food image!";
        }

    }
?>
</body>
</html>