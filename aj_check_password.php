<?php
require __DIR__ . '/__connect_db.php';

if(!isset($_GET['old_password'])){
    exit;
}


$oldpassword = $mysqli->escape_string($_GET['old_password']);

$rs = $mysqli->query("SELECT 1 FROM `members` WHERE `email` = '".$_SESSION['user']['email']."' AND `password` = SHA1('$oldpassword')");

echo $rs->num_rows;


