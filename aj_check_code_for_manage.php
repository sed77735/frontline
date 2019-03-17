<?php
require __DIR__ . '/__connect_db.php';

if(!isset($_GET['code'])){
    exit;
}


$code = $mysqli->escape_string($_GET['code']);
$ori_code = $mysqli->escape_string($_GET['ori_code']);

//$rs = $mysqli->query("SELECT 1 FROM `team` WHERE `code` NOT IN ('$code')");
$sql = sprintf("SELECT 1 FROM `team` WHERE `code`='$code' AND `code` != '$ori_code'");

$rs = $mysqli->query($sql);

//echo $sql;

echo $rs->num_rows;


