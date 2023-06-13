<?php
    include 'backend.php';
    $backend = new Backend;
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
    <div class="container min-vh-100 d-flex justify-content-center align-items-start p-3">
        <div class="row g-3 shadow rounded">
            <div class="col-12 bg-warning bg-gradient shadow rounded">
                <h2><i class="bi bi-headset"> Help Center</i></h2>
            </div>
            <div class="col-12">
                <a href="transactions.php?report=trans" class="card bg-secondary bg-gradient text-light mb-1 p-2" style="text-decoration:none"><h6>I'd like to report a transaction</h6></a>
                <a href="" class="card bg-secondary bg-gradient text-light mb-1 p-2" style="text-decoration:none"><h6>I'd like to report a Seller</h6></a>
                <a href="" class="card bg-secondary bg-gradient text-light mb-1 p-2" style="text-decoration:none"><h6>I'd like to ask help for my payment</h6></a>
                <a href="" class="card bg-secondary bg-gradient text-light mb-1 p-2" style="text-decoration:none"><h6>I'd like to ask help for my account</h6></a>
            </div>
        </div>
    </div>
</body>
</html>