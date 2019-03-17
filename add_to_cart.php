<?php
session_start();

if(! isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if(isset($_GET['sid'])){
    $sid = intval($_GET['sid']);
    $qty = isset($_GET['qty']) ? intval($_GET['qty']) : 0;

    if ($qty==0){
        unset($_SESSION['cart'][$sid]);
    } else {
        $_SESSION['cart'][$sid] = $qty;
    }

}

echo json_encode($_SESSION['cart']);


/*
if(! isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

if(isset($_GET['sid'])){
    $sid = intval($_GET['sid']);
    $qty = isset($_GET['qty']) ? intval($_GET['qty']) : 0;

    if($qty == 0){
        unset($_SESSION['cart'][$sid]);
    }else{
        $_SESSION['cart'][$sid] = $qty;
    }
}

echo json_encode($_SESSION['cart']);
*/