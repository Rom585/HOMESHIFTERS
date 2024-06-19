<?php
    
    if (!isset($_SESSION['customer_id'])){
        header("Location: login.php");
    }
?>