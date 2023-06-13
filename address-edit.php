<?php
    include 'backend.php';
    $backend = new Backend;
        $name = "";
        $contact = "";
        $province = "";
        $city = "";
        $brgy = "";
        $street = "";
        $zip = "";
        $label = "";
        $address_type = "";

        if (isset($_GET['id'])) {
            $address_id=$_GET['id'];

            $list = $backend->searchaddress($address_id);
            if (mysqli_num_rows($list) > 0) {
                $row = mysqli_fetch_assoc($list);
                    $name = $row['full_name'];
                    $contact = $row['contact'];
                    $province = $row['province'];
                    $city = $row['city'];
                    $brgy = $row['barangay'];
                    $street = $row['street'];
                    $zip = $row['zip'];
                    $note = $row['note'];
                    $address_type = $row['address_type'];

            }
        }
        else {
        }

        if (isset($_POST['editbtn'])) {
            $id = $_GET['id'];
            $name = $_POST['fullname'];
            $contact = $_POST['telnum'];
            $province = $_POST['province'];
            $city = $_POST['city'];
            $brgy = $_POST['brgy'];
            $street = $_POST['street'];
            $zip = $_POST['zip'];
            $note = $_POST['note'];
            $label = $_POST['label'];

            $backend->editAddress($id,$name,$contact,$province,$city,$brgy,$street,$zip,$note,$label);
        }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css"> 
    <title>Edit Address</title>
    <style>
        body{
            background-image:linear-gradient(#4990b5,skyblue);
        }
    </style>
</head>
<body>
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <form action="" method="post">
        <div class="row g-3 p-5 ">
            <div class="col-12 text-center text-light">
                <h1><i class="bi bi-person-fill-up"> Delivery Address</i></h1>
            </div>
            <div class="col-md-6">
                <label for="fname" class="form-label" ><i><?=($_SESSION['role'] == 'Seller')?'Shop Name':'Full Name'?></i></label>
                <input type="text" class="form-control" name="fullname" value="<?=$name?>" required>
            </div>
            <div class="col-md-6">
                <label for="contact" class="form-label">Contact Number</label>
                <input type="tel" class="form-control" name="telnum" value="<?=$contact?>" required>
            </div>
            <div class="col-12">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" name="street" value="<?=$street?>" placeholder="street, apartment, studio or floor" required>
            </div>
            <div class="col-md-4">
                <label for="province" class="form-label">Province</label>
                <input type="text" class="form-control" value="<?=$province?>" name="province" required>
            </div>
            <div class="col-md-4">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control" value="<?=$city?>" name="city" required>
            </div>
            <div class="col-md-4">
                <label for="brgy" class="form-label">Barangay</label>
                <input type="text" class="form-control" name="brgy" value="<?=$brgy?>" required>
            </div>
            <div class="col-md-4">
                <label for="zip" class="form-label">Zip</label>
                <input type="number" class="form-control" name="zip" value="<?=$zip?>" required>
            </div>
            <div class="col-md-8">
                <label for="note" class="form-label">Note <small class="text-secondary"><i>(Optional)</i> </small></label>
                <input type="text" class="form-control" name="note" value="<?=$note?>">
            </div>
            <div class="col-12">
                <label for="label" class="form-label">Label Address as: </label>
                    <?php
                        if ($_SESSION['role'] == 'Seller') {
                            if ($row['label']=='Pickup') {
                                echo "<input class='form-check-input' type='radio' name='label' value='Pickup' id='flexRadioDefault1' checked>";
                                echo "<label class='form-check-label' for='flexRadioDefault1'>Pickup</label>";
                            }else{
                                echo "<input class='form-check-input' type='radio' name='label' value='Pickup' id='flexRadioDefault1'>";
                                echo "<label class='form-check-label' for='flexRadioDefault1'>Pickup</label>";
                            }
                        }
                        else{
                            echo "<input class='form-check-input' type='radio' name='label' value='Home' id='flexRadioDefault1' checked>";
                            echo "<label class='form-check-label' for='flexRadioDefault1'>Home</label>";
                        }
                        if ($_SESSION['role'] == 'Buyer') {
                            if ($row['label'] == 'Work') {
                               echo "<input class='form-check-input' type='radio' value='Work' name='label' id='flexRadioDefault2' checked>";
                               echo "<label class='form-check-label' for='flexRadioDefault2'>Work</label>";
                            }else{
                                echo "<input class='form-check-input' type='radio' value='Work' name='label' id='flexRadioDefault2'>";
                                echo "<label class='form-check-label' for='flexRadioDefault2'>Work</label>";
 
                            }
                            
                        }
                    ?>
            </div>
            <div class="col-12 my-5 text-center">
                <button type="submit" name="editbtn" class="btn btn-primary">Save Address</button>
                <a class="btn btn-secondary" href="<?=($_SESSION['role'] == 'Buyer')?'checkout.php':'dashboard.php'?>" style="background-color:red;border:none">Cancel</a>
            </div>
        </div>
        </form>
    </div>
</body>
</html>