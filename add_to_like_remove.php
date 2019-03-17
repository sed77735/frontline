<?php
require __DIR__ . '/__connect_db.php';


if(! isset($_SESSION['like'])) {
    $_SESSION['like'] = array();
}

if(isset($_GET['sid'])){
    $sid = intval($_GET['sid']);


    $sql = sprintf("DELETE FROM `like_products` WHERE sid=$sid");

    $rs = $mysqli->query($sql);

}

echo json_encode($_SESSION['like']);
