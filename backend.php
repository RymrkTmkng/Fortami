<?php
session_start();
    class Database{
      public $host = 'localhost';
      public $user = 'root';
      public $pass = '';
      public $db = 'fortami';
      public $conn;

      //database connection

      function __construct(){
        
        $this->conn = new mysqli($this->host,$this->user,$this->pass,$this->db);

        if ($this->conn->connect_error) {
          die("Connection Failed:".$this->conn->connect_error);
        }

      }//end of db construct

      function getConnection(){
        return $this->conn;
      }
      function closeConnection(){
        return $this->conn->close();
      }
    }//end of Class Database
    
    class Account{
      //Account Management 
      function login($uname,$pw){
        $sql = "SELECT * from user WHERE user_userName = '$uname'";
        $result = mysqli_query($this->con,$sql);
        if ($result) {
          if ($result->num_rows > 0) {
              $row = mysqli_fetch_assoc($result);

              if(password_verify($pw,$row['user_password'])){
                $_SESSION['user'] = $uname;
                $_SESSION['id'] = $row['user_id'];
                $_SESSION['role'] = $row['user_type'];
                  if ($row['user_type'] == 'Seller') {
                    echo "<script>alert('Welcome Back!'); window.location.href = 'dashboard.php'";
                    echo "</script>";
                  }
                  elseif ($row['user_type'] == 'Buyer') {
                    echo "<script>alert('Welcome Back!'); window.location.href = 'menu.php'";
                    echo "</script>";
                  }
                  elseif ($row['user_type'] == 'Admin'){
                    echo "<script>alert('Welcome Back!'); window.location.href = 'admin.php'";
                    echo "</script>";
                  }
                  else{
                    echo "Error in ".$this->con->error;
                  }
              }
              else {
                echo "<script>alert('Invalid Credentials!');";
                echo "</script>";
              }
                
          }
          else {
            echo "<script>alert('No user found!');";
            echo "</script>";
          }
        }
      }//end of login function

      function checksession(){
        if(isset($_SESSION['user'])){
          $this->userAddress();
        }
        else{
          echo "<script>alert('Please Login First!');window.location.href='login.php';</script>";
        }
      }//checksession end

      function registerUser($role,$pic,$fn,$ln,$em,$un,$pass){
        $sql = "SELECT * from user WHERE user_userName = '$un'";
        $result = mysqli_query($this->con,$sql);
          if($result){
            if ($result->num_rows > 0) {
              echo "User Already Exist!";
            }
            else {
              $hashpass = password_hash($pass,PASSWORD_DEFAULT);
              $query = "INSERT INTO user(user_type,profile_pic,user_fName,user_lName,user_email,user_userName,user_password) 
              values('$role','$pic','$fn','$ln','$em','$un','$hashpass')";
              $reg = mysqli_query($this->con,$query);
                if($reg){
                  echo "<script>alert('Registered Successfully!');";
                  echo "window.location.href = 'login.php';";
                  echo "</script>";
                }
                else{
                  echo "error in $reg".$this->con->error;
                }
            }
          }//end of register user function
      }//end of register user function

      function editProfile($id,$role,$new_Name,$fn,$ln,$email,$uname){
        $query = "UPDATE user SET user_type='$role', profile_pic= '$new_Name', 
                  user_fName='$fn', user_lName='$ln', user_email = '$email', 
                  user_userName = '$uname' WHERE user_id = $id";
        $result = $this->con->query($query);

          if ($result) {
           echo "<script>alert('Profile Successfully Updated!');</script>";
          }
      }// end of edit profile

      function delUser($id){
        $query = "DELETE FROM user WHERE user_id = $id";
        $result = $this->con->query($query);

          if ($result) {
            echo "<script>alert('Profile Successfully Deleted!');</script>";
            echo "<script>window.location.href='logout.php';</script>";
          }
      }

      function usersearch($id){
        $query = "SELECT * FROM user WHERE user_id = $id";
        $result = $this->con->query($query);
          if ($result) {
            return $result;
          }
      }//end of search user function

      function listSellers(){
        $query = "SELECT * FROM user WHERE user_type = 'Seller' AND verification = 'Verified'";
        $result = $this->con->query($query);
          if ($result) {
            return $result;
          }
      }//end of list seller function

      function getSellerId(){
        $user = $_SESSION['id'];
        $query = "SELECT food_product.user_id FROM cart JOIN food_product ON food_product.food_id = cart.food_id 
                  INNER JOIN user ON user.user_id = food_product.user_id WHERE cart.user_id = $user GROUP BY user_id";
        $result = $this->con->query($query);
          if ($result) {
            return $result;
          }
      }//end of function get seller ID

      function verifyUser($user_id){
        $query = "UPDATE user SET verification = 'Verified' WHERE user_id = $user_id";
        $result =$this->con->query($query);

        if ($result) {
          echo "<meta http-equiv='refresh' content='0'>";
        }
      }//end of function verify user
      
      function sellerId($food_id){
        $query = "SELECT user_id FROM food_product WHERE food_id = $food_id";
        $result = $this->con->query($query);
          if ($result) {
            return $result;
          }
      }//end of function get seller ID from food product

    }//end of class Account

    class Admin extends Account{
      public $con;

      function __construct(){
        $db = new Database;
        $this->con = $db->getConnection();
      }

      function totalUser(){
        $query  = "SELECT COUNT(user_id) AS users FROM user";
        $result =  $this->con->query($query);

        if ($result) {
          return $result;
        }
      }//end of total user function
      
      function totalSeller(){
        $query = "SELECT COUNT(user_id) AS sellers FROM user WHERE user_type = 'Seller'";
        $result = $this->con->query($query);
        
        if ($result) {
          return $result;
        }
      }//end of total seller function

      function totalBuyer(){
        $query = "SELECT COUNT(user_id) AS buyers FROM user WHERE user_type = 'Buyer'";
        $result = $this->con->query($query);
        
        if ($result) {
          return $result;
        }
      }//end of total buyer function

      function listBuyer(){
        $query = "SELECT * FROM user WHERE user_type = 'Buyer'";
        $result = $this->con->query($query);

          if ($result) {
            return $result;
          }
      }//end of function list all buyers

      function listUser($sort){
        $query = "SELECT * FROM user WHERE user_type != 'Admin' ORDER BY $sort";
        $result = $this->con->query($query);

          if ($result) {
            return $result;
          }
      }//end of list User function

      function listSeller(){
        $query = "SELECT * FROM user WHERE user_type = 'Seller'";
        $result = $this->con->query($query);

          if ($result) {
            return $result;
          }
      }//End of function list all sellers

      function totalFood(){
        $query = "SELECT COUNT(food_id) AS foods FROM food_product";
        $result = $this->con->query($query);

        if ($result) {
          return $result;
        }
      }//end of function totalFood

      function allTransaction(){
          $query = "SELECT * FROM food_order
                    JOIN payment_transaction ON payment_transaction.payTrans_id = food_order.payTrans_id
                    JOIN food_product ON food_product.food_id = food_order.food_id
                    JOIN address ON address.address_id = food_order.address_id
                    INNER JOIN user ON user.user_id = food_product.user_id 
                    INNER JOIN payment_method ON payment_method.paymethod_id = payment_transaction.paymethod_id 
                    GROUP BY food_order.payTrans_id ORDER BY food_order.payTrans_id DESC";
          $result = $this->con->query($query);
  
            if ($result) {
              return $result;
            }
      }//end of all transaction function

      function sumAmount(){
        $query = "SELECT SUM(pay_amount) AS total FROM food_order JOIN payment_transaction ON payment_transaction.payTrans_id = food_order.payTrans_id";
        $result = $this->con->query($query);
          if ($result) {
            return $result;
          }
      }//end of sum amount function

    }//end of class Admin

    class Address extends Account{
        function userAddress(){
          $id = $_SESSION['id'];
          $query = "SELECT * FROM address WHERE user_id = $id";
          $result = $this->con->query($query);
          if ($result) {
              if ($result->num_rows > 0) {
                return $result;
              }
              else {
                $info = $this->usersearch($id);
                $data = mysqli_fetch_assoc($info);

                if ($data['user_type'] == 'Admin') {
                  # do nothing
                }else{
                  echo "<script>alert('Please add an address first!');window.location.href='address.php?user=$id';</script>";
                }
              }
          }//end of search userAddress function
          
        }//end of address function

        function searchaddress($address_id){
          $query = "SELECT * FROM address WHERE address_id = $address_id";
          $result = $this->con->query($query);

          if ($result) {
            return $result;
          }
        }//end of searchaddress function

        function findAddress($user_id){
          $query = "SELECT * FROM address JOIN user ON address.user_id = user.user_id WHERE address.user_id = $user_id";
          $result = $this->con->query($query);
            if ($result) {
              return $result;
            }
        }//end of function find user address

        function sellerAddress($seller_id){
          $query = "SELECT * FROM address WHERE user_id = $seller_id";
          $result = $this->con->query($query);

            if ($result) {
              return $result;
            }
        }//end 

        function delAddress($id){
          $query = "DELETE FROM address WHERE address_id = $id";
          $result = $this->con->query($query);
          
          if ($result) {
            echo "<script>alert('Address Deleted successfully!');window.location.href = 'checkout.php';</script>";
          }
        }

        function editAddress($id,$name,$con,$province,$city,$brgy,$street,$zip,$note,$label){
          $query = "UPDATE address SET full_name = '$name', contact = '$con' ,
          province = '$province', city = '$city', barangay = '$brgy', street = '$street', zip = '$zip',note='$note',label='$label' 
          WHERE address_id = $id";
          $result = $this->con->query($query);
          if ($result) {
            $notify = new Notification;
            $search = $this->searchaddress($id);
            $list = mysqli_fetch_assoc($search);
            echo "<script>alert('Address updated successfully!');</script>";
            $notify->newUserNotif($list['user_id'],'You have successfully edited your address.','Unread');
              if ($_SESSION['role'] == 'Seller') {
                echo "<script>window.location.href = 'dashboard.php';</script>";
              }
              else {
                echo "<script>window.location.href = 'checkout.php';</script>";
              }
          }
          else {

          }
        }

        function createAddress($user_id,$name,$type,$con,$province,$city,$brgy,$street,$zip,$note,$label){
          $userSearch = $this->userSearch($user_id);
          $user = mysqli_fetch_assoc($userSearch);
          $role = $user['user_type'];
          $query = "INSERT INTO address(user_id,full_name,address_type,contact,province,city,barangay,street,zip,note,label) values($user_id,'$name','$type','$con','$province','$city','$brgy','$street','$zip','$note','$label')";
          $result = $this->con->query($query);
            if ($result) {
              if ($role === 'Seller') {
                echo "<script>alert('Address saved successfully!');</script>";
              }
              else {
                echo "<script>alert('Address saved successfully!');window.location.href = 'menu.php';</script>";
              }
              }
        }//end of addAddress
    }//end of class Address
    
    class Backend extends Address{
      public $con;

      function __construct(){
        $database = new Database;
        $this->con = $database->getConnection();
      }

      //Food Management
      function categorylist(){
        $query = "SELECT * FROM category";
        $result = $this->con->query($query);
          if($result){
            if($result->num_rows > 0){
              while($row = $result->fetch_assoc()){
                echo "<option value=".$row['category_id'].">".$row['category_name']."</option>";
              }
            }
          }
      }//end of category list function

      function addproduct($catid,$pic,$foodname,$desc,$size,$preparation,$time,$expire,$discount,$price){
        $id = $_SESSION['id'];
        $query = "INSERT INTO food_product(user_id,category_id,food_pic,food_name,food_description,serving_size,preparation
        ,food_creation,food_expiration,food_discountedPrice,food_origPrice) values('$id','$catid','$pic','$foodname','$desc','$size','$preparation',
        '$time','$expire','$discount','$price')";

        $result = $this->con->query($query);

        if ($result) {
          if ($result) {
            echo "<script>alert('Successfuly Saved!');</script>";
          }
          else{
            echo "error in $db".$this->con->error;
          }
        }
        echo "<meta http-equiv='refresh' content='0'>";
      }// end of add product function

      function editproduct($food_id,$catid,$pic,$name,$desc,$size,$prep,$date,$exp,$discprice,$origprice){
        $id = $_SESSION['id'];//user_id
        $query = "UPDATE food_product SET category_id ='$catid',food_pic = '$pic', food_name='$name',food_description='$desc',serving_size = '$size',preparation='$prep',food_creation='$date',
        food_expiration='$exp',food_discountedPrice = '$discprice', food_origPrice = '$origprice' WHERE user_id = '$id' AND food_id='$food_id'";
        $result = $this->con->query($query);
        if ($result) {
          echo "<script>alert('Updated Successfuly!');window.location.href='product.php';</script>";
        }
        else {
          echo "Error in $query".$this->con->error;
        }
        // echo "<meta http-equiv='refresh' content='0'>";
      }// end of edit product function

      function pendingProduct($food_id){
        $query = "SELECT * FROM food_order WHERE food_id = $food_id AND order_status = 'Pending' OR order_status = 'Ready' OR order_status = 'Preparing' OR order_status = 'On The Way'";
        $result = $this->con->query($query);

        if ($result) {
          if ($result->num_rows > 0) {
            echo "<script>alert('Cannot delete a product with a pending transaction');</script>";
          }else{
              if ($_SESSION['role'] == 'Admin') {
                $act = new Account;
                $backend = new Backend;
                $prodInfo = $backend->fetchProduct($food_id);
                $prod = mysqli_fetch_assoc($prodInfo);
                $seller_id = $act->sellerId($food_id);
                $seller = mysqli_fetch_assoc($seller_id);
                  if (!is_null($seller)){
                    $sellad = $act->findAddress($seller['user_id']);
                    $shop = $sellad['full_name'];
                    $notif = new Notification;
                    $note = "Your Product ".$prod['food_name']." was deleted by the Admin, because it's content can confusion/false advertisement";
                    $notif->newUserNotif($seller_id,$note,"Unread");
                    $this->deleteproduct($food_id);
                    header('admin.php');
                }
              }elseif($_SESSION['role'] == 'Buyer'){
                $this->deleteproduct($food_id);
                header('location:menu.php');
              }else{
                $this->deleteproduct($food_id);
              }
            
          }
        }

      }//end of pending product function
      function deleteproduct($food_id){
        $query = "DELETE FROM food_product WHERE food_id = $food_id";
        $result = $this->con->query($query);
          if($result){
              $notify = new Notification;
              $notify->newUserNotif($_SESSION['id'],'You have successfully deleted a product.','Unread');
              echo "<script>alert('Deleted Successfully');</script>";
            }
            else {
              echo "error ".$this->con->error;
            }
      }//end of delete product function

      function listproduct(){
          $user = $_SESSION['id'];
          $sql = "SELECT * FROM food_product JOIN category ON food_product.category_id = category.category_id 
                  WHERE food_product.user_id = $user ORDER BY food_id";
          $result = $this->con->query($sql);
          return $result;
      }//end of list product function

      function fetchProduct($id){
        $query = "SELECT * FROM food_product JOIN category ON category.category_id = food_product.category_id WHERE food_id = $id";
        $result = $this->con->query($query);
          if ($result) {
            return $result;
          }
      }//end of function searchProduct
      
      function getproduct(){
        $query = "SELECT * FROM food_product JOIN user ON food_product.user_id = user.user_id WHERE user.verification = 'Verified'";
        $result = $this->con->query($query);
        if ($result) {
            return $result;
        }
        else {
          echo "No item found!";
        }
      }//end of get product function

      function productFilter($query){
        $result = $this->con->query($query);
        if ($result) {
            return $result;
        }
        else {
          echo "No item found!";
        }
      }//end of function product filter

      function viewProduct($id){
        $query = "SELECT * FROM food_product WHERE user_id = $id";
        $result = $this->con->query($query);
          if ($result) {
            return $result;
          }
      }//end of view product function

      function hotProducts(){
        $date = date('Y-m-d');
        $query = "SELECT * FROM food_order JOIN food_product ON food_product.food_id = food_order.food_id WHERE rating_status = 'Done' AND order_datetime LIKE '%$date%' GROUP BY food_order.food_id ORDER BY COUNT(food_order.food_id) DESC";
        $result = $this->con->query($query);

          if ($result) {
            return $result;
          }
      }//end of hot products function

      function demandProducts(){
        $id = $_SESSION['id'];
        $date = date("Y-m-d");
        $query = "SELECT * FROM food_order JOIN food_product ON food_product.food_id = food_order.food_id
                  INNER JOIN user ON food_product.user_id = user.user_id WHERE food_product.user_id = $id AND order_datetime LIKE '%$date%'
                  GROUP BY food_order.food_id ORDER BY COUNT(food_order.food_id) DESC";
        $result = $this->con->query($query);
        if ($result) {
          return $result;
        }
      }//end of in demand product function

      function countSalesperProduct($food_id){
        $date = date("Y-m-d");
        $query = "SELECT COUNT(food_id) as foodCount FROM food_order WHERE food_id = $food_id AND order_datetime LIKE '%$date%'";
        $result = $this->con->query($query);

        if ($result) {
          return $result;
        }
      }//end of count sales per product function

      //end of food management

      //cart management
      function checkcart($food,$user){
        $query = "SELECT * FROM cart WHERE food_id = $food AND user_id = $user";
        $result = $this->con->query($query);
        if ($result) {
          return $result;
        }
        
      }
      function getcart(){
        $user_id = $_SESSION['id'];
        $query = "SELECT cart.food_id,food_product.food_pic,food_product.food_name,food_product.food_description,food_product.preparation,quantity,
                        food_product.food_creation,food_product.food_discountedPrice,food_product.food_origPrice,user.user_userName,food_product.user_id
                  FROM cart 
                  JOIN food_product 
                  ON food_product.food_id = cart.food_id
                  INNER JOIN user ON food_product.user_id = user.user_id
                  WHERE cart.user_id = $user_id";

        $result = $this->con->query($query);
          if ($result) {
              return $result;
          }
      }//end of get cart function

      function total(){
        $user_id = $_SESSION['id'];
        $query = "SELECT sum(food_product.food_discountedPrice * cart.quantity) AS total FROM cart
                  JOIN food_product ON food_product.food_id = cart.food_id WHERE cart.user_id = $user_id";
        $result = $this->con->query($query);
          if ($result) {
            return $result;
          }
      }
      
      function addtocart($food,$user,$qty){
          $query = "INSERT INTO cart(food_id,user_id,quantity) VALUES('$food','$user','$qty')";
          $result = $this->con->query($query);
            if ($result) {
              echo "<script>alert('Added Successfully');</script>";
            }
      }//end of add to cart function

      function editcart($food,$user,$qty){
        $query = "UPDATE cart SET quantity = $qty WHERE food_id =$food AND user_id = $user";
        $result = $this->con->query($query);

        if ($result) {
          echo "<script>alert('Quantity Successfully Changed');</script>";
        }
        else {
          echo "Error in $query".$this->con->error;
        }
        echo "<meta http-equiv='refresh' content='0'>";
      }

      function delcart($food,$user){
        $query = "DELETE FROM cart WHERE food_id = $food AND user_id = $user";
        $result = $this->con->query($query);
        if ($result) {
            echo "<script>alert('Deleted Successfully!');</script>";
        }
        else {
          echo "Error in $query".$this->con->error;
        }
        echo "<meta http-equiv='refresh' content='0'>";
      }

      function clearcart(){
        $query = "DELETE FROM cart";
        $result = $this->con->query($query);

          if ($result) {
          }
          echo "<meta http-equiv='refresh' content='0'>";
      }//end of clear cart function

      function countcart($user_id){
        $query = "SELECT * FROM cart WHERE user_id = $user_id";
        $result = $this->con->query($query);
          if ($result) {
            if ($result->num_rows > 0) {
              $count = $result->num_rows;
            }
            else {
              $count = '0';
            }
          }
          else{
            
          }
          return $count;
      }//end of countcart

      //end of cart management

      //start of payment management

      function payment($user,$method,$amount,$vat,$com,$opt,$status){
        $query = "INSERT INTO payment_transaction(user_id,paymethod_id,pay_amount,vat,commission,delivery_option,trans_status) values($user,$method,'$amount','$vat','$com','$opt','$status')";
        $result = $this->con->query($query);
          if ($result) {
            echo "<script>alert('Payment Successful, Order is being processed');window.location.href='activeorders.php';</script>";
          }
      }//end of payment

      function listMethod(){
        $query = "SELECT * FROM payment_method";
        $result = $this->con->query($query);

          if ($result) {
            return $result;
          }
      }//end of list method function

      function addMethod($name){
        $query = "INSERT INTO payment_method(paymethod_type) VALUES('$name')";
        $result = $this->con->query($query);

        if ($result) {
          echo "<script>alert('Payment Method Added Successfully!');window.location.href='settings-other.php';</script>";
        }
      }//end of function add payment method

      function editMethod($name,$id){
        $query = "UPDATE payment_method SET paymethod_type = '$name' WHERE paymethod_id = $id";
        $result = $this->con->query($query);

        if ($result) {
          echo "<script>alert('Method Edited Successfully');window.location.href='settings-other.php';</script>";
        }
      }//end of edit method function

      function delMethod($id){
        $query = "DELETE FROM payment_method WHERE paymethod_id = $id";
        $result = $this->con->query($query);

        if ($result) {
          echo "<script>alert('Method Deleted Successfully');window.location.href='settings-other.php';</script>";
        }
      }// end of delete method function

      function listCategory(){
        $query ="SELECT * FROM category";
        $result = $this->con->query($query);
          if ($result) {
            return $result;
          }
      }//end of list category

      function addCategory($name,$desc){
        $query = "INSERT INTO category(category_name,category_description) VALUES('$name','$desc')";
        $result = $this->con->query($query);

        if ($result) {
          echo "<script>alert('Category Added Successfully!');window.location.href='settings-other.php';</script>";
        }
      }//end of function add payment method

      function editCategory($id,$name,$desc){
        $query = "UPDATE category SET category_name = '$name',category_description = '$desc' WHERE category_id = $id";
        $result = $this->con->query($query);

        if ($result) {
          echo "<script>alert('Category Edited Successfully');window.location.href='settings-other.php';</script>";
        }
      }//end of edit category function

      function delCategory($id){
        $query = "DELETE FROM category WHERE category_id = $id";
        $result = $this->con->query($query);

        if ($result) {
          echo "<script>alert('Category Deleted Successfully');window.location.href='settings-other.php';</script>";
        }
      }// end of delete method function


      function transaction(){
        $query = "SELECT payTrans_id,pay_amount,quantity,trans_status,pay_datetime,user.user_userName,address.full_name,address.contact,address.region,address.city,address.barangay,address.street,address.zip,address.label,
                  payment_transaction.food_id,food_product.food_name,food_product.food_discountedPrice,payment_transaction.address_id,payment_method.paymethod_type FROM payment_transaction
                  JOIN food_product ON payment_transaction.food_id = food_product.food_id
                  INNER JOIN user ON food_product.user_id = user.user_id
                  JOIN address ON payment_transaction.address_id = address.address_id
                  JOIN payment_method ON payment_transaction.paymethod_id = payment_method.paymethod_id";
        $result = $this->con->query($query);

          if ($result) {
            return $result;
          }
      }// end of transaction

      function getpayment($user,$time){
        $user = $_SESSION['id'];
        $query = "SELECT * FROM payment_transaction WHERE user_id = $user AND pay_datetime = '$time'";
        $result = $this->con->query($query);

          if ($result) {
            return $result;
          }
      }//end of function getpayment

      function paymentTotal($id){
        $query = "SELECT sum(pay_amount) as total FROM payment_transaction WHERE user_id = $id ";
        $result = $this->con->query($query);
          if ($result) {
            return $result;
          }
      }// end of payment
      
      //end of payment management

      //start of order management

      function order($food,$address,$payTrans_id,$status,$qty){
        $query = "INSERT into food_order(food_id,address_id,payTrans_id,order_status,quantity) values($food,$address,$payTrans_id,'$status','$qty')";
        $result = $this->con->query($query);

          if ($result) {

          }
      }//end of creating order function

      function countOrder($trans){
        $query = "SELECT sum(quantity) AS count FROM food_order WHERE payTrans_id = $trans AND order_status = 'Pending' OR order_status= 'Preparing'";
        $result = $this->con->query($query);

        if ($result) {
          return $result;
        }
      }//end of count order function

      function activeOrders(){
        $user = $_SESSION['id'];
        $query = "SELECT * FROM food_order
                  JOIN food_product ON food_product.food_id = food_order.food_id
                  INNER JOIN user ON user.user_id = food_product.user_id
                  JOIN payment_transaction ON food_order.payTrans_id = payment_transaction.payTrans_id 
                  WHERE payment_transaction.user_id = $user AND order_status = 'Pending' OR order_status = 'Preparing' OR order_status = 'On The Way' OR order_status = 'Ready' GROUP BY user.user_userName";
        $result = $this->con->query($query);

          if ($result) {
            return $result;
          }

      }//end of buyer view active orders

      function orderStatus($id,$status){
        $query = "UPDATE food_order SET order_status = '$status' WHERE payTrans_id = $id";
        $result = $this->con->query($query);
          if ($result) {
            echo "<script>alert('Order $status');</script>";
          }
      }//end of order status function

      function tranStatus($id,$status){
        $query = "UPDATE payment_transaction SET trans_status = '$status' WHERE payTrans_id = $id";
        $result = $this->con->query($query);
          if ($result) {
            echo "<script>alert('Payment $status');</script>";
          }
      }

      function receivedTime($time,$id){
        $query = "UPDATE food_order SET received_datetime = '$time' WHERE payTrans_id=$id";
        $return = $this->con->query($query);

        if ($return) {
          # code...
        }
      }

      function foodBought($id){
        $query = "SELECT * FROM food_order JOIN food_product ON food_order.food_id = food_product.food_id
                  WHERE food_order.payTrans_id = $id";
        $result = $this->con->query($query);

        if ($result) {
          return $result;
        }
      }//end of shop details function

      function viewHistory(){
        $user = $_SESSION['id'];
        $query = "SELECT * FROM food_order
                  JOIN payment_transaction ON payment_transaction.payTrans_id = food_order.payTrans_id
                  JOIN food_product ON food_product.food_id=food_order.food_id
                  INNER JOIN user ON user.user_id = food_product.user_id 
                  INNER JOIN payment_method ON payment_method.paymethod_id = payment_transaction.paymethod_id 
                  WHERE payment_transaction.user_id = $user 
                  AND order_status = 'Received' OR order_status = 'Cancelled' GROUP BY food_order.payTrans_id ORDER BY food_order.payTrans_id DESC";
        $result = $this->con->query($query);

          if ($result) {
            return $result;
          }
        }//end of list transaction history function

        function sellerOrders(){
          $seller_id = $_SESSION['id'];
          $query = "SELECT * FROM food_order 
                    JOIN food_product ON food_product.food_id = food_order.food_id 
                    JOIN address ON food_order.address_id = address.address_id 
                    JOIN payment_transaction ON payment_transaction.payTrans_id = food_order.payTrans_id 
                    WHERE (SELECT food_product.user_id FROM food_order JOIN food_product ON food_order.food_id = food_product.food_id 
                            INNER JOIN user ON user.user_id = food_product.user_id WHERE order_status = 'Pending' OR order_status= 'Preparing' AND food_product.user_id = $seller_id GROUP BY food_product.user_id) = $seller_id AND order_status = 'Pending' OR order_status = 'Preparing' GROUP BY food_order.payTrans_id";
          $result = $this->con->query($query);
            if ($result) {
              return $result;
            }
        }//end of seller order list

        function waitingList(){
          $seller_id = $_SESSION['id'];
          $query = "SELECT * FROM food_order 
                    JOIN food_product ON food_product.food_id = food_order.food_id 
                    JOIN address ON food_order.address_id = address.address_id 
                    JOIN payment_transaction ON payment_transaction.payTrans_id = food_order.payTrans_id 
                    WHERE (SELECT food_product.user_id FROM food_order JOIN food_product ON food_order.food_id = food_product.food_id 
                            INNER JOIN user ON user.user_id = food_product.user_id WHERE order_status = 'Pending' OR order_status= 'Preparing' GROUP BY food_product.user_id) = $seller_id AND order_status = 'Preparing' OR order_status = 'On The Way' OR order_status = 'Ready' GROUP BY food_order.payTrans_id ORDER BY food_order.payTrans_id DESC";
          $result = $this->con->query($query);
            if ($result) {
              return $result;
            }
        }//end of order waiting list function

        function saleHistory(){
          $seller_id = $_SESSION['id'];
          $query = "SELECT * FROM food_order 
                    JOIN food_product ON food_product.food_id = food_order.food_id 
                    JOIN address ON food_order.address_id = address.address_id 
                    JOIN payment_transaction ON payment_transaction.payTrans_id = food_order.payTrans_id 
                    WHERE (SELECT food_product.user_id FROM food_order JOIN food_product ON food_order.food_id = food_product.food_id 
                            INNER JOIN user ON user.user_id = food_product.user_id WHERE order_status = 'Received' AND food_product.user_id = $seller_id GROUP BY food_product.user_id) = $seller_id AND order_status = 'Received' OR order_status = 'Cancelled' GROUP BY food_order.payTrans_id ORDER BY food_order.payTrans_id DESC";
          $result = $this->con->query($query);
            if ($result) {
              return $result;
            }
        }// end of saleHistory


        function orderAgain($trans_id){
          $foods = $this->foodBought($trans_id);
          $user = $_SESSION['id'];
            foreach ($foods as $row) {
              $food = $row['food_id'];
              $qty = $row['quantity'];
              $total = $row['food_discountedPrice'] * $row['quantity'];
              $query = "INSERT INTO cart values($food,$user,$qty)";
              $result = $this->con->query($query);

              if ($result) {
                echo "<meta http-equiv='refresh' content='0'>";
              }
            }
        }//end of order again function

        function rateOrder($order,$rate,$comment,$trans){
          $query = "INSERT INTO rating(order_id,rating,comment) VALUES($order,'$rate','$comment')";
          $result = $this->con->query($query);
            if ($result) {
              echo "<script>alert('Rated Successfully!');window.location.href='rate.php?trans=$trans';</script>";
            }
        }//end of function Order Rating

        function toRate($trans){
          $query = "SELECT * FROM food_order JOIN food_product ON food_order.food_id = food_product.food_id
                  WHERE food_order.payTrans_id = $trans AND rating_status IS NULL";
          $result = $this->con->query($query);

          if ($result) {
            if ($result->num_rows > 0) {
              return $result;
            }
            else {
              echo "<h1 class='text-center'><i class='bi bi-check-circle-fill'>Done Rating! <br><br> <h3><a class='btn btn-outline-info' href='transactions.php?trans=$trans'>View Receipt</a></h3></i></h1>";
            }
          }
        }//end of function toRate

        function ratingStatus($order){
          $query = "UPDATE food_order SET rating_status = 'Done' WHERE order_id = $order";
          $result = $this->con->query($query);

            if ($result) {
              
            }
            else{
              echo "Error in changing rating status";
            }
        }

        function viewRating($food_id){
          $query = "SELECT AVG(rating) AS rate FROM rating JOIN food_order ON food_order.order_id = rating.order_id
                    INNER JOIN food_product ON food_product.food_id = food_order.food_id WHERE food_order.food_id = $food_id";
          $result = $this->con->query($query);
            if ($result) {
              return $result;
            }
        }//end of done rating

        function uploadPermit($permit){
          $id = $_SESSION['id'];
          $query = "UPDATE user SET permit = '$permit' WHERE user_id = $id";
          $result = $this->con->query($query);
          
            if ($result) {
              echo "<script>window.location.href='dashboard.php';</script>";
            }
        }//end of upload permit for sellers

        function uploadSanitary($sanitary){
          $id = $_SESSION['id'];
          $query = "UPDATE user SET sanitary = '$sanitary' WHERE user_id = $id";
          $result = $this->con->query($query);
          
            if ($result) {
              echo "<script>window.location.href='dashboard.php';</script>";
            }
        }//end of upload sanitary permit function
    }//end of class backend

    class Rating {
      public $con;

      function __construct(){
        $db = new Database;
        $this->con = $db->getConnection();
      }//end of function construct

      function listRating($trans){
        $id = $_SESSION['id'];
        $query = "SELECT * FROM rating JOIN food_order ON food_order.order_id = rating.order_id
                  INNER JOIN food_product ON food_product.food_id = food_order.food_id
                  JOIN payment_transaction ON payment_transaction.payTrans_id = food_order.payTrans_id
                  JOIN address on address.address_id = food_order.address_id
                  WHERE food_order.payTrans_id = $trans ORDER BY rating_id";
        $result = $this->con->query($query);

        if ($result) {
          return $result;
        }
      }//end of view rating function

      function shopRating($shop_id){
        $query = "SELECT * FROM rating JOIN food_order ON food_order.order_id = rating.order_id JOIN food_product ON food_product.food_id = food_order.food_id
                  INNER JOIN user ON food_product.user_id = user.user_id WHERE food_product.user_id = $shop_id ORDER BY rating_id DESC";
        $result = $this->con->query($query);

        if ($result) {
          return $result;
        }
      }//end of shop Rating function

      function foodRating($food_id){
        $query = "SELECT * FROM rating JOIN food_order ON rating.order_id = food_order.order_id
                  INNER JOIN food_product ON food_product.food_id = food_order.food_id WHERE food_order.food_id = $food_id";
        $result = $this->con->query();
          if ($result) {
            return $result;
          }
      }//end of function food rating

      function avgRating($food_id){
        $query = "SELECT AVG(rating) AS rate FROM rating JOIN food_order ON rating.order_id = food_order.order_id
                  WHERE food_order.food_id = $food_id";
        $result = $this->con->query($query);

        if ($result) {
          return $result;
        }
      }//end of average rating function

    }//end of rating class

    class Chat extends Account{
        public $con;
  
        function __construct(){
          $db = new Database;
          $this->con = $db->getConnection();
        }//end of function construct

        //start of chat functions

        function countMsg(){
          $user_id = $_SESSION['id'];
          $query = "SELECT COUNT(msg_id) AS msg FROM message WHERE receiver_id = $user_id AND status = 'Unread'";
          $result = $this->con->query($query);

            if ($result) {
              return $result;
            }
        }// end of count message function for unread messages

        function createMsg($user,$receiver,$content){
          $query = "INSERT INTO message(user_id,receiver_id,content,status) VALUES($user,$receiver,'$content','Unread')";
          $result = $this->con->query($query);

            if ($result) {
              echo "<script>alert('Message Sent');</script>";
            }
        }//end of message creation function

        function viewMsg(){
          $receiver = $_SESSION['id'];
          $query = "SELECT * FROM message JOIN user ON message.user_id = user.user_id WHERE receiver_id = $receiver ORDER BY msg_datetime DESC";
          $result = $this->con->query($query);

            if ($result) {
              return $result;
            }
        }//end of view message function

        function updateRead($id){
          $query = "UPDATE message SET status = 'Read' WHERE msg_id = $id";
          $result = $this->con->query($query);

          if ($result) {
            
          }
        }//end of function update status to read

        function delMsg($id){
          $query = "DELETE FROM message WHERE msg_id = $id";
          $result = $this->con->query($query);

          if ($result) {
            echo "<script>alert('Message Deleted Successfully!');</script>";
          }
        }//end of delete message function

        function viewSent(){
          $sender = $_SESSION['id'];
          $query = "SELECT * FROM message JOIN user ON message.user_id = user.user_id
                    WHERE message.user_id = $sender ORDER BY msg_datetime DESC";
          $result = $this->con->query($query);

            if ($result) {
              return $result;
            }
        }//end of view message the user sent

        function viewDetails($msg_id,$user){
          $query = "SELECT * FROM message JOIN user ON user.user_id = message.user_id WHERE receiver_id = $user";
          $result = $this->con->query($query);

          if ($result) {
            return $result;
          }
        }//end of function view sender/receiver details
    }//end of chat class

    class Sales{
      public $con;

      function __construct(){
        $db = new Database;
        $this->con = $db->getConnection();
      }//end of function construct

      function totalSales(){
        $id = $_SESSION['id'];
        $query = "SELECT SUM(pay_amount) AS sales FROM food_order 
                  JOIN payment_transaction ON food_order.payTrans_id = payment_transaction.payTrans_id
                  JOIN food_product ON food_product.food_id = food_order.food_id WHERE food_product.user_id = $id AND payment_transaction.trans_status='Successful'";
        $result = $this->con->query($query);

        if ($result) {
          return $result;
        }
      }//end of total sales function

      function totalPending(){
        $seller_id = $_SESSION['id'];
        $query = "SELECT COUNT(order_id) AS pending FROM food_order JOIN food_product ON food_product.food_id = food_order.food_id
                  WHERE food_product.user_id = $seller_id AND order_status != 'Received' AND order_status != 'Cancelled'";
        $result = $this->con->query($query);
        
          if ($result) {
            return $result;
          }
      }// end of total pending transaction

      function salesReport($month,$year){
        $user = $_SESSION['id'];
        $query = "SELECT WEEK(pay_datetime) AS week,SUM(pay_amount) AS weeklySales FROM `food_order` JOIN food_product ON food_product.food_id = food_order.food_id 
                  INNER JOIN user ON user.user_id = food_product.user_id 
                  JOIN payment_transaction ON payment_transaction.payTrans_id = food_order.payTrans_id 
                  WHERE food_product.user_id = $user AND MONTH(pay_datetime) = $month AND YEAR(pay_datetime)=$year GROUP BY week";
        $result = $this->con->query($query);

          if ($result) {
            return $result;
          }
      }//end of sales report function

      function totalTrans(){
        $user = $_SESSION['id'];
        $query = "SELECT COUNT(payment_transaction.payTrans_id) AS totalTrans FROM `food_order` JOIN food_product ON food_product.food_id = food_order.food_id 
                  INNER JOIN user ON user.user_id = food_product.user_id 
                  JOIN payment_transaction ON payment_transaction.payTrans_id = food_order.payTrans_id 
                  WHERE food_product.user_id = $user";
        $result = $this->con->query($query);
          if ($result) {
            return $result;
          }
      }//end of total transaction function

    }//end of class sales

    class Notification extends Backend{
      
      function newUserNotif($user_id,$details,$status){
        $query = "INSERT INTO notification(user_id,notif_details,notif_status) VALUES($user_id,'$details','$status')";
        $result = $this->con->query($query);
          if ($result) {
          }
          else{
            echo "Error in ".$this->con->error;
          }
      }//end of  function add notification

      function getAdminId(){
        $sql = "SELECT user_id FROM user WHERE user_type = 'Admin'";
        $res = $this->con->query($sql);
          if ($res) {
            return $res;
          }
          else{
            echo "Error in ".$this->con->error;
          }
      }//end of function get admin Ids

      function newAdminNotif($details,$status){
        $ids = $this->getAdminId();
          if (!is_null($ids)) {
            foreach ($ids as $id) {
              $this->newUserNotif($id,$details,$status);
            }
          }
          else{
            echo $this->con->error();
          }
      }//end of admin notification
      
      function viewNotif(){
        $user_id = $_SESSION['id'];
        $query = "SELECT * FROM notification WHERE user_id = $user_id ORDER BY notif_status DESC";
        $result = $this->con->query($query);

          if ($result) {
            return $result;
          }
      }//end of view notification function

      function readNotif($notif_id){
        $query = "SELECT * FROM notification WHERE notification_id = $notif_id ";
        $result = $this->con->query($query);

          if ($result) {
            $this->markRead($notif_id);
            return $result;
          }
      }//end of read notification function


      function delNotif($notif_id){
        $query = "DELETE FROM notification WHERE notification_id = $notif_id";
        $result = $this->con->query($query);

        if ($result) {
          echo "<meta http-equiv='refresh' content='0'>";
        }
      }//end of delete notifation function

      function countNotif(){
        $user = $_SESSION['id'];
        $query = "SELECT COUNT(notification_id) AS count FROM notification WHERE user_id = $user AND notif_status = 'Unread' ";
        $result = $this->con->query($query);

        if ($result) {
          return $result;
        }
      }//end of count notification function

      function markRead($id){
        $query = "UPDATE notification SET notif_status = 'Read' WHERE notification_id = $id";
        $result = $this->con->query($query);

        if ($result) {
          
        }
      }//end of mark as read function

      function clearNotif(){
        $id = $_SESSION['id'];
        $query = "DELETE FROM notification WHERE user_id = $id";
        $result = $this->con->query($query);

        if ($result) {
          echo "<script>alert('Notifications successfully cleared'!);</script>";
        }
      }//end of clear notifications
    }//end of class notification

    class Search extends Backend{
      
      function applyFilter($search){
        $query = "SELECT * FROM food_product JOIN user ON food_product.user_id = user.user_id
                  JOIN address ON address.user_id = food_product.user_id WHERE food_name LIKE '%$search%'
                  OR preparation LIKE '%$search%' OR city LIKE '%$search%' OR barangay LIKE '%$search%' AND user.verification = 'Verified'";

        $result = $this->con->query($query);

        if ($result) {
          return $result;
        }
      }//end of apply filter function
      
    }//end of search class

    class Wallet extends Account{
      public $con;

      function __construct(){
        $db = new Database;
        $this->con = $db->getConnection();
      }//end of function construct
      
      function findWallet($methodId,$shop){
        $query = "SELECT * FROM wallet JOIN payment_method ON payment_method.paymethod_id = wallet.payment_method WHERE wallet.payment_method = $methodId AND wallet.user_id = $shop";
        $result = $this->con->query($query);
          if ($result) {
            return $result;
          }
      }//end of function find wallet

      function addWallet($user_id,$payment_method,$acc_name,$acc_num){
        $query = "INSERT INTO wallet values()";
        $result = $this->con->query($query);
          if ($result) {
          }
      }//end of function add wallet

      function cashinWallet(){

      }//end of function cashin wallet

      function cashoutWallet(){

      }//end of cashout wallet function

      function sendMoney(){

      }//end of function send money

    }//end of class Wallet

    class Report extends Notification{
      public $con;

      function __construct(){
        $db = new Database;
        $this->con = $db->getConnection();
      }//end of function construct

      function reportTrans($food,$buyer,$issue,$desc,$photo){
        $query = "INSERT INTO report(food_id,user_id,issue,description,photo) VALUES($food,$buyer,'$issue','$desc','$photo')";
        $result = $this->con->query($query);
          if ($result) {
            $this->newUserNotif($buyer,'You have reported a food, thank you for your feedback','Unread');
            $this->newUserNotif(46,"You have a new report pending",'Unread');
            echo "<script>alert('Your report has been send to the admin, thank you!');window.location.href='transactions.php?report=trans';</script>";
          }
      }//end of function reportTrans

      function viewAllReports(){
        $query = "SELECT * FROM report JOIN user ON user.user_id = report.user_id JOIN food_product
                  ON food_product.food_id = report.food_id ORDER BY report_datetime";
        $result = $this->con->query($query);
          if ($result) {
            return $result;
          }
      }//end of function view all reports

      function viewReport($id){
        $query = "SELECT * FROM report WHERE report_id = $id";
        $result =$this->con->query($query);
          if ($result) {
            return $result;
          }
      }//end of view report function

      function banProd($food_id){
        $query = "DELETE FROM food_product WHERE food_id = $food_id";
        $result = $this->con->query($query);
          if ($result) {
            
          }
      }//end of function del product

    }
?>