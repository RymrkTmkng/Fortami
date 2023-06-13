<?php
    include 'backend.php';
    include 'buyerheader.php';
    $backend = new Backend;
    $backend->checksession();
    $list= $backend->listproduct();

    if(isset($_POST['addcart'])){
        $food_id = $_POST['food_id'];
            if (isset($_SESSION['id'])) {
                $user_id = $_SESSION['id'];
                $qty = $_POST['qty'];

            $check = $backend->checkcart($food_id,$user_id);
                if ($check->num_rows>0) {
                    echo "<script>alert('Already in cart!');</script>";
                }
                else {
                    $backend->addtocart($food_id,$user_id,$qty);
                    echo "<meta http-equiv='refresh' content='0'>";
                }
            }
            else {
                echo "<script>alert('Please Login First!');window.location.href='login.php';</script>";
            }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image" href="./src/FortamiLogo.png">
    <title>Fortami | Menu</title>
</head>
<body>
    <div class="container p-3">
        <div class="row">
            <div class="col-12 p-2">
                <form action="" class="d-flex justify-content-center align-items-center" role="search">
                    <a class="btn btn-outline-dark" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                        <i class="bi bi-funnel"></i>
                    </a>
                    <input class="form-control mx-2 w-50" type="search" name="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit" name="searchbtn" value="true">Search</button>
                </form>
            </div>
            <div class="col-12">
                <!-- <div class="ratio" style="--bs-aspect-ratio: 10%;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d251170.46572903!2d123.70620748661054!3d10.378734102357448!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a999258dcd2dfd%3A0x4c34030cdbd33507!2sCebu%20City%2C%20Cebu!5e0!3m2!1sen!2sph!4v1681223016091!5m2!1sen!2sph" width="600" height="450" style="border:1px solid black;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div> -->
            </div>
            <div class="col-md-3 ">
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Filter Setting</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <form action="menu.php">
                                <h6>Select filters below:</h6><br>
                                <select class="form-select" name="food_category" >
                                    <option selected Disabled>Food Category</option>
                                    <option value="any">Any</option>
                                    <?=$backend->categorylist()?>
                                </select>
                                <select class="form-select my-2" name="rating">
                                    <option selected Disabled>Ratings</option>
                                    <option value="any">Any</option>
                                    <option value="1">1 Star</option>
                                    <option value="2">2 Star</option>
                                    <option value="3">3 Star</option>
                                    <option value="4">4 Star</option>
                                    <option value="5">5 Star</option>
                                </select>
                                <select class="form-select my-2" name="location">
                                    <option selected Disabled>Location</option>
                                    <option value="Cebu">Cebu City</option>
                                    <option value="Mandaue">Mandaue City</option>
                                    <option value="Talisay">Talisay City</option>
                                    <option value="Lapulapu">Lapulapu City</option>
                                    <option value="Other">Other</option>
                                </select>
                                <select class="form-select my-2" name="price">
                                    <option selected Disabled>₱rice Range</option>
                                    <option value="any">Any</option>
                                    <option value="250">₱ 0 - 250</option>
                                    <option value="500">₱ 250 - 500</option>
                                    <option value="750">₱ 500 - 750</option>
                                    <option value="1000">₱750 - 1000</option>
                                    <option value="1000+">₱1,000+</option>
                                </select>
                                <select class="form-select my-2" name="preparation">
                                    <option selected Disabled>Food Preparation</option>
                                    <option value="any">Any</option>
                                    <option value="fresh">Fresh</option>
                                    <option value="surplus">Surplus</option>
                                    <option value="madetoorder">Made to order</option>
                                </select>
                                <select class="form-select my-2" name="delivery">
                                    <option selected Disabled>Delivery Option</option>
                                    <option value="any">Any</option>
                                    <option value="pickup">Pick-up</option>
                                    <option value="deliver">Deliver</option>
                                </select>
                            <input type="submit" class="btn btn-warning form-control" name="applybtn" value="Apply">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END OF FILTERING FUNCTION -->
    <div class="container text-center ">
        <h4 class="p-3 bg-warning bg-gradient rounded shadow"><i>Food Shops</i> </h4>
        <br>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
                if (isset($_GET['searchbtn'])) {
                    $search = $_GET['search'];
        
                    $find = new Search;
        
                    $list = $find->applyFilter($search);
                }else{
                    $list = $backend->listSellers();
                }
                    if(!is_null($list)){
                    foreach ($list as $row) {
            ?>
            
            <div class="col-md-3">
                <div class="card h-100">
                <a href="foodshop.php?shop_id=<?=$row['user_id']?>"><img src="./src/uploads/profile/<?=$row['profile_pic']?>" class="card-img-top" style='max-width:100%;height:250px'></a>
                        <div class="card-body ">
                            <h5 class="card-title"><b><?=$row['user_userName']?></b></h5>
                            <p class="card-text"><i><?=$row['tagline']?></i></p>
                            <?php
                                $seller = $backend->findAddress($row['user_id']);
                                $find = mysqli_fetch_assoc($seller);
                            ?>
                            <p class="card-text"><?=$find['street'].', '.$find['barangay'].', '.$find['city'].' City'?></i></p>
                            <?php
                                if ($row['verification'] == 'Verified') {
                                    echo "<i class='bi bi-shield-fill-check'>".$row['verification']."</i>";
                                }
                                else {
                                    echo "<i class='bi bi-shield-exclamation'> Unverified</i>";
                                }
                            ?>
                        </div>
                    <div class="card-footer">
                    <small class="text-body-secondary">Last updated 3 mins ago</small>
                    </div>
                </div>
            </div>
            <?php
                } 
            }else{
                echo "<h1><i class='bi bi-bag-x-fill'> No Product Found!</i></h1>";
            }     
            ?>
        </div>
    </div>
    
    <!-- END OF FOOD SHOPS -->
    <br>
    <div class="container text-center">
    <h4 class="p-3 bg-warning bg-gradient rounded shadow"> <i class="bi bi-fire"> Hot Picks For Today!</i></h4>
    <div class="row row-cols-1 row-cols-md-4 g-4 p-2">
        <?php
            $list = $backend->hotProducts();
            if ($list->num_rows > 0) {
                while($row= $list->fetch_assoc()){
        ?>
        <div class='col'>
                    <div class='card h-100'>
                        <img src='./src/uploads/food_picture/<?=$row['food_pic'];?>' class='card-img-top' alt='food pic' style='max-width:100%;height:100px'>
                      <div class='card-body'>
                        <h5 class='card-title'><?=$row['food_name'];?></h5>
                        <h6>
                          <small><s class='text-secondary'>₱<?=$row['food_origPrice'];?></s></small>
                          <span class='price'>₱<?=$row['food_discountedPrice'];?></span>
                        </h6>
                        <p class='card-text'><?=$row['food_description']?></p>
                      </div>
                      
                      <div class='card-footer'>
                      <div class ='text-center '>
                        <form action='menu.php' method='post'>  
                          <input type="number" name="qty" class="form-control text-center" min="1" placeholder="Quantity" style="width:50%;margin:auto;" required>
                          <button type='submit' name='addcart' class='btn btn-warning my-2'>Add to cart <i class='bi bi-bag-heart'></i></button>
                          <input type='hidden' name='food_id' value='<?=$row['food_id'];?>'>
                          </form>
                        </div>
                        <small class='text-muted'>
                            <?php 
                                if($row['food_creation'] == '0000-00-00 00:00:00'){
                                    echo $row['preparation'];
                                }
                                else {
                                    echo "<small class='text-secondary'>(".$row['preparation'].") ".$row['food_creation']."</small>" ;
                                }
                            ?>
                        </small>
                      </div>
                    </div>
                  </div>
            <?php
                    }
                }


            ?>
        </div>  
    </div>
</body>
</html>