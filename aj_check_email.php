<?php
require __DIR__ . '/__connect_db.php';

if(!isset($_GET['email'])){
    exit;
}


$email = $mysqli->escape_string($_GET['email']);

$rs = $mysqli->query("SELECT 1 FROM `members` WHERE `email`='$email'");

echo $rs->num_rows;


