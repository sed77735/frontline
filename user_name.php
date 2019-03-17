<?php
require __DIR__ . '/__connect_db.php';


if (isset($_POST["name"])) {

    $stmt = $mysqli->prepare(" UPDATE `members` SET 
        `name`= ?
        WHERE `sid` = ?");

    $stmt->bind_param('si',
        $_POST['name'],
        $_SESSION['user']['sid']
    );

    $success = $stmt->execute();
    $affected = $stmt->affected_rows;

    $name = $_POST['name'];

    if($affected==1){
        $_SESSION['user']['name'] = $_POST['name'];
    }


    echo $name;
}




