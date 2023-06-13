<?php
    include 'backend.php';
    $backend = new Backend;
    
     if (isset($_GET['savebtn'])) {
        if (isset($_GET['comments']) && $_GET['order'] && $_GET['trans'] && $_GET['rate'] && $_GET['trans']) {
            $order = $_GET['order'];
            $trans = $_GET['trans'];
            $rate = $_GET['rate'];
            $cmnt = $_GET['comments'];

            $backend->ratingStatus($order);
            $result = $backend->rateOrder($order,$rate,$cmnt,$trans);
            
        }
    }
?>