<?php
include 'backend.php';
$backend = new Backend;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">    
    <title>Register</title>
    <style>
        body{
            background-image:linear-gradient(#4990b5,skyblue);
        }
    </style>
</head>
<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="row g-3 ">
            <div class="col-12 text-center text-light">
                <h1><i class="bi bi-geo-alt-fill"><?=($_SESSION['role'] == 'Seller')?' Business':' Recipient'?> Address</i></h1>
            </div>
            <div class="col-md-12">
                <label for="permit"><i><?=($_SESSION['role'] == 'Buyer')?'Valid ID':'Business Permit'?> <small class="text-danger">*</small></i></label>
                <input type="file" name="permit" class="form-control" required>
            </div>
            <?php
                if($_SESSION['role'] == 'Seller'){
                  ?>
                    <div class="col-md-12">
                        <label for="permit"><i>Sanitary Permit <small class="text-danger">*</small></i></label>
                        <input type="file" name="sanitary" class="form-control" required>
                    </div>
                  <?php  
                }
            ?>
            <div class="col-md-6">
                <label for="fname" class="form-label" value=""><i><?=($_SESSION['role'] == 'Seller')?'Shop Name':'Full Name'?><small class="text-danger"> *</small></i></label>
                <input type="text" class="form-control" name="fullname" required>
            </div>
            <div class="col-md-6">
                <label for="contact" class="form-label">Contact Number <small class="text-danger">*</small></label>
                <input type="tel" class="form-control" name="telnum" required>
            </div>
            <div class="col-12">
                <label for="address" class="form-label">Address <small class="text-danger">*</small></label>
                <input type="text" class="form-control" name="street" placeholder="street, apartment, studio or floor" required>
            </div>
            <div class="col-md-4">
                <label for="province" class="form-label">Province <small class="text-danger">*</small></label>
                <input type="text" class="form-control" name="province" required>
            </div>
            <div class="col-md-4">
                <label for="city" class="form-label">City <small class="text-danger">*</small></label>
                <input type="text" class="form-control" name="city" required>
            </div>
            <div class="col-md-4">
                <label for="brgy" class="form-label">Barangay <i><small class="text-secondary">(If not applicable write [N/a])</small></i></label>
                <input type="text" class="form-control" name="brgy" required>
            </div>
            <div class="col-md-4">
                <label for="zip" class="form-label">Zip <small class="text-danger">*</small></label>
                <input type="number" class="form-control" name="zip" required>
            </div>
            <div class="col-md-8">
                <label for="note" class="form-label">Note <small class="text-secondary"><i>(Optional)</i> </small></label>
                <input type="text" class="form-control" name="note">
            </div>
            <div class="col-12">
                <label for="label" class="form-label">Label Address as: </label>
                    <?php
                        if ($_SESSION['role'] == 'Seller') {
                            echo "<input class='form-check-input' type='radio' name='label' value='Pickup' id='flexRadioDefault1'>";
                            echo "<label class='form-check-label' for='flexRadioDefault1'>Pickup</label>";
                        }
                        else{
                            echo "<input class='form-check-input' type='radio' name='label' value='Home' id='flexRadioDefault1'>";
                            echo "<label class='form-check-label' for='flexRadioDefault1'>Home</label>";
                        }
                        if ($_SESSION['role'] == 'Buyer') {
                                echo "<input class='form-check-input' type='radio' value='Work' name='label' id='flexRadioDefault2'>";
                                echo "<label class='form-check-label' for='flexRadioDefault2'>Work</label>";
                        }
                    ?>
            </div>
            <div class="col-12">
            <label for="type" class="form-label">Save as: </label>
                    <input class="form-check-input" type="radio" name="address_type" value="Default" id="flexRadioDefault1"checked>
                    <label class="form-check-label" for="flexRadioDefault1" >
                        Default
                    </label>
            </div>
            <div class="col-12 text-center">
                <button type="submit" name="regbtn" class="btn btn-success"><h6>Save Address</h6></button>
                <a class="btn btn-danger" href="index.php"><h6>Cancel</h6></a>
            </div>
        </div>
        </form>
    </div>
    <?php
        if (isset($_POST['regbtn'])) {
            if (isset($_GET['user'])) {
                $id = $_GET['user'];
            }
            else {
                $id = $_SESSION['id'];
            }
            $name = $_POST['fullname'];
            $type = $_POST['address_type'];
            $con = $_POST['telnum'];
            $province = $_POST['province'];
            $city = $_POST['city'];
            $brgy = $_POST['brgy'];
            $street = $_POST['street'];
            $zip = $_POST['zip'];
            $note = $_POST['note'];
            $label = $_POST['label'];
            $backend->createAddress($id,$name,$type,$con,$province,$city,$brgy,$street,$zip,$note,$label);
            //upload business permit
            $permit = $_FILES['permit'];

            $permit_name = $_FILES['permit']['name'];
            $permit_size = $_FILES['permit']['size'];
            $permit_tmp = $_FILES['permit']['tmp_name'];
            $error = $_FILES['permit']['error'];

                if ($error === 0) {
                    if ($permit_size > 10000000) {
                        echo "Please upload a pic not more that 1mb";
                    }else{
                        $ext = pathinfo($permit_name,PATHINFO_EXTENSION);
                        $extlower = strtolower($ext);
                        $allowedext = array("png","jpg","jpeg");

                            if (in_array($extlower,$allowedext)) {
                                $permit_newName = uniqid("FORTAMI",true).'.'.$extlower;
                                $path = './src/uploads/business_permit/'.$permit_newName;
                                move_uploaded_file($permit_tmp,$path);

                                $backend->uploadPermit($permit_newName);
                            }
                            else {
                                echo "Unsupported Format";
                            }
                    }
                }else {
                    echo "Unknown Error Occured, Please Try Again";
                }
                //end of upload business permit
                //Sanitary permit upload
                $sanitary = $_FILES['sanitary'];

                $sanitary_name = $_FILES['sanitary']['name'];
                $sanitary_size = $_FILES['sanitary']['size'];
                $sanitary_tmp = $_FILES['sanitary']['tmp_name'];
                $sanitaryError = $_FILES['sanitary']['error'];

                if ($sanitaryError === 0) {
                    if ($sanitary_size > 10000000) {
                        echo "Please upload a pic not more that 1mb";
                    }else{
                        $exte = pathinfo($sanitary_name,PATHINFO_EXTENSION);
                        $extelower = strtolower($exte);
                        $allowedexte = array("png","jpg","jpeg");

                            if (in_array($extelower,$allowedexte)) {
                                $sanitary_newName = uniqid("FORTAMI",true).'.'.$extelower;
                                $newPath = './src/uploads/business_permit/'.$sanitary_newName;
                                move_uploaded_file($sanitary_tmp,$newPath);

                                $backend->uploadSanitary($sanitary_newName);
                            }
                            else {
                                echo "Unsupported Format";
                            }
                    }
                }else {
                    echo "Unknown Error Occured, Please Try Again";
                }
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>