<?php
require __DIR__ . '/__connect_db.php';

if(!isset($_GET['email_login'])){
    exit;
}

$result = array(
    'success' => true,
    'info' => array()
);

$email = $mysqli->escape_string($_GET['email_login']);
$rs = $mysqli->query("SELECT 1 FROM `members` WHERE `email`='$email'");
$row = $rs->fetch_array();

if($rs->num_rows==0){
    $result['success'] = false;

    $result['info']['email'] = array(
        'num_rows' => $rs->num_rows,
        'msg' => '電子信箱錯誤',
    );
}else{
    $result['info']['email'] = array(
        'num_rows' => 1,
    );
}

if(! ($_GET['password_login'] == $row['password']) ){
    $result['success'] = false;

    $result['info']['password'] = array(
        'msg' => '密碼輸入錯誤',
    );
} else {
    $result['info']['password'] = array(
    );
}


echo json_encode($result, JSON_UNESCAPED_UNICODE);







