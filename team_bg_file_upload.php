<?php
require __DIR__ . '/__connect_db.php';

$dir = __DIR__. '/team_img/';

    if(! isset($_SESSION['team_bg_img'])) {
        $_SESSION['team_bg_img'] = array();
    }


    if (isset($_FILES["team_bg_file"])) {

        $_SESSION['team_bg_img'] = $_FILES;

        $image = iconv('utf-8','big5',$_FILES['team_bg_file']['name']);

        $target = $dir . $image;


//        $target = $dir . $_FILES["team_bg_file"]["name"];


        //取檔案副檔名
//        $file_name =  pathinfo($_FILES["act_file"]["name"], PATHINFO_EXTENSION);

//        $image = $_SESSION['user']['email'].'.'.$file_name;

//        $_SESSION['team_bg_img']['image_name'] = $image;

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


        if (move_uploaded_file($_FILES["team_bg_file"]["tmp_name"], $target)) {

            echo $_FILES["team_bg_file"]['name'];

        } else {
            echo 'error';
        }

//        rename("$target", $dir.$img_name.'.'.$file_name);
    }
