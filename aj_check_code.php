<?php
require __DIR__ . '/__connect_db.php';

if(!isset($_GET['code'])){
    exit;
}


$code = $mysqli->escape_string($_GET['code']);

$rs = $mysqli->query("SELECT 1 FROM `team` WHERE `code`='$code'");

echo $rs->num_rows;


