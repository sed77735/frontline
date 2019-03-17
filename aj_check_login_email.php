<?php
require __DIR__ . '/__connect_db.php';

if(!isset($_GET['email_login'])){
    exit;
}




$email = $mysqli->escape_string($_GET['email_login']);

$password = sha1(($_GET['password_login']));


$sql = "SELECT 1 FROM `members` WHERE `email`='$email' AND `password` = '$password'";

$rs = $mysqli->query($sql);

//echo $sql;

echo $rs->num_rows;


