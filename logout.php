<?php
session_start();

    if (isset($_SESSION['user'])) {
        if (session_destroy()) {
            header('location:index.php');
        }
        else{
    
        }
    }
    else {
        echo "<script>alert('Please Login First!');</script>";
    }
?>