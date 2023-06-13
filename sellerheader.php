<?php
  $backend = new Backend;
  $backend->checksession();
  $disabled = (isset($_SESSION['id'])) ?: 'disabled';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
      crossorigin="anonymous"
    />
    <link rel="shortcut icon" type="image" href="./src/FortamiLogo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@600&display=swap"
      rel="stylesheet"
    />
    
  </head>
  <body>
    <nav class="navbar navbar-expand-md" style="background-color: #4990b5">
      <div class="container">
        <a
          class="navbar-brand"
          href="#"
          style="font-family: 'Montserrat Alternates', sans-serif; color: white"
          >Fortami</a
        >
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="dashboard.php" style="color: white">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="profile.php" style="color: white">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="product.php"style="color: white">Foods</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="order.php"style="color: white">Orders</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="delivery.php"style="color: white">Sales</a>
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                style="color: white"
              >
                <?php
                  if (isset($_SESSION['user'])) {
                    echo $_SESSION['user'];
                  }else{
                    echo 'Account';
                  }
                ?>
              </a>
              <ul class="dropdown-menu">
              <li>
                  <?php
                    if (isset($_SESSION['user'])) {
                      $user_id = $_SESSION['id'];
                      $result = $backend->findAddress($user_id);
                      $address = mysqli_fetch_assoc($result);
                      $id = $address['address_id'];
                      echo "<a href='address-edit.php?id=$id' class='dropdown-item'>Address</a>";
                    }else{
                      
                    }
                  ?>
                </li>
                <li><a <?=(isset($_SESSION['user']))?'class="dropdown-item disabled"':'class="dropdown-item"'?> href="login.php" >Login</a></li>
                <li><a <?=(isset($_SESSION['user']))?'class="dropdown-item"':'class="dropdown-item disabled"'?> href="logout.php">Logout</a></li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <a <?=(isset($_SESSION['user']))?'class="dropdown-item disabled"':'class="dropdown-item"'?> href="./register.php">Create Account</a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="chat.php" class="nav-link active position-relative <?=$disabled?> mx-2" style="color:white;">
                <h5><i class="bi bi-envelope"></i></h5>
                <h6>
                  <small class="text-secondary">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger my-2">
                      <?php
                        $backend = new Chat;
                        if (isset($_SESSION['id'])) {
                          $count = $backend->countMsg();
                          $msg = mysqli_fetch_assoc($count);
                          echo $msg['msg'];
                        }
                        else {
                          echo "0";
                        }
                      ?>
                      <span class="visually-hidden">Cart</span>
                    </span>
                  </small>
                </h6>
                  
              </a>
            </li>
            <li class="nav-item">
              <a href="notification.php" class="nav-link active position-relative <?=$disabled?>" style="color:white;">
                <i class="bi bi-bell"></i>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger my-2">
                    <?php
                          if (isset($_SESSION['id'])) {
                            $notif = new Notification;
                            $notify = $notif->countNotif();
                            $notifs = mysqli_fetch_assoc($notify);
                            if (is_null($notifs)) {
                              echo "0";
                            }
                            else {
                              echo $notifs['count'];
                            }
                          }else{
                            echo 0;
                          }
                      ?>
                    <span class="visually-hidden">New alerts</span>
                </span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
