<?php
require __DIR__ . '/__connect_db.php';

$dir = __DIR__. '/user_img/';

//if (! isset($_SESSION['user_img_file'])){
//    $_SESSION['user_img_file']=array();
//}




    if (isset($_FILES["my_file"])) {

        $_SESSION['user_img_file'] = $_FILES;


        $hash = $_SESSION['user']['hash'];

        if(is_dir($dir . $hash)) {
//            echo 'existed...<br>';
        } else {
            mkdir($dir . $hash, 0700);
//            echo 'not existed...<br>';
        }








        $image = iconv('utf-8','big5',$_FILES["my_file"]["name"]);

        $target = $dir . $hash .'/'. $image;

//        echo $target;


        //副檔名
//        $file_name =  pathinfo($_FILES["my_file"]["name"], PATHINFO_EXTENSION);

//        $image = $_SESSION['user']['email'].'.'.$file_name;

//        $sql = " UPDATE `members` SET `image` = '$image' WHERE `sid` =". intval($_SESSION['user']['sid']);
//
//        $mysqli->query($sql);

//exit;

//        $img_name = $_SESSION['user']['email'];

//        if (file_exists($img_name.".jpg")) {
////            echo ".jpg";
//            unlink($img_name . ".jpg");
//        } else if(file_exists($img_name.'.png')){
////            echo"檔案為png檔";
//            unlink($img_name.'.png');
//        };


        if (move_uploaded_file($_FILES["my_file"]["tmp_name"], $target)) {

            echo $_FILES["my_file"]['name'];

//            echo "檔案名稱: " . $_FILES["my_file"]["name"]."<br/>";
//
//            echo "檔案類型: " . $_FILES["my_file"]["type"]."<br/>";
//
//            echo "檔案大小: " . ($_FILES["my_file"]["size"] / 1024)." Kb<br />";
//
//            echo "暫存名稱: " . $_FILES["my_file"]["tmp_name"];
//
//            echo "錯誤號碼: " . $_FILES["my_file"]["error"];



        } else {
            echo '上傳失敗';
        }

//        rename("$target", $dir.$img_name.'.'.$file_name);
    }
