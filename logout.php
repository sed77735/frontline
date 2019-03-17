<?php
require __DIR__ . '/__connect_db.php';

unset($_SESSION['user']);

if (isset($_SESSION['server'])){
    unset($_SESSION['server']);
}

header('Location: members.php');


