<?php
require __DIR__ . '/__connect_db.php';

$dir = __DIR__. '/activity_img/';

    if(! isset($_SESSION['activity_img'])) {
        $_SESSION['activity_img'] = array();
    }


    if (isset($_FILES["act_file"])) {

        $_SESSION['activity_img'] = $_FILES;

//        $image = $_FILES['act_file']['name'];
//        $image = iconv('utf-8','big5//TRANSLIT//IGNORE',$_FILES["act_file"]["name"]);
//        echo $image;
        $target = $dir . $_FILES["act_file"]['name'];


        //取檔案副檔名
//        $file_name =  pathinfo($_FILES["act_file"]["name"], PATHINFO_EXTENSION);

//        $image = $_SESSION['user']['email'].'.'.$file_name;

//        $_SESSION['activity_img']['image_name'] = $image;

//        $sql = " UPDATE `images` SET `image` = '$image' WHERE 1";

//        $mysqli->query($sql);

//exit;

//        $img_name = $_SESSION['user']['email'];

//        if (file_exists($img_name.".jpg")) {
//            echo ".jpg";
//            unlink($img_name . ".jpg");
//        } else if(file_exists($img_name.'.png')){
//            echo"檔案為png檔";
//            unlink($img_name.'.png');
//        };


        if (move_uploaded_file($_FILES["act_file"]["tmp_name"], $target)) {

            echo $_FILES["act_file"]['name'];

        } else {
            echo 'error';
        }

//        rename("$target", $dir.$img_name.'.'.$file_name);
    }
