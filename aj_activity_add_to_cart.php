<?php
session_start();

if(! isset($_SESSION['activity_cart'])) {
    $_SESSION['activity_cart'] = array();
}

if(isset($_GET['sid'])){
    $sid = intval($_GET['sid']);
    $qty = isset($_GET['people_qty']) ? intval($_GET['people_qty']) : 0;

    if($qty==0){
        unset($_SESSION['activity_cart'][$sid]); // 刪除項目
    } else {
        $_SESSION['activity_cart'][$sid] = $qty; // 設定
    }

}

echo json_encode($_SESSION['activity_cart']); // 查詢



// 三個功能: 查詢, 設定, 刪除項目

