<?php

require __DIR__ . '/__connect_db.php';


$dir = __DIR__ . '/team_img/';

$pname = 'team';

unset($_SESSION['server']);


if (! isset($_SESSION['server'])){
    $_SESSION['server'] = $_SERVER['REQUEST_URI'];
}


if(! isset($_SESSION['user'])) {
    echo '<script>
                alert("請先登入會員!")
                window.location.href = "members.php";
            </script>';
//    header("Location:members.php");
}



//表格-------------------
if(!empty($_SESSION['team_members']) and !empty($_SESSION['user']) and !empty($_SESSION['team_img']) and !empty($_SESSION['team_bg_img'])) {

    if (isset($_POST['name'])) {


        //上傳圖片------
        //取檔案副檔名
//        $file_name = pathinfo($_SESSION["team_img"]["team_file"]["name"], PATHINFO_EXTENSION);
//        $file_title = iconv('UTF-8','big5//TRANSLIT//IGNORE',pathinfo($_SESSION["team_img"]["team_file"]["name"], PATHINFO_FILENAME));
//        $file_name_bg = pathinfo($_SESSION["team_bg_img"]["team_bg_file"]["name"], PATHINFO_EXTENSION);
//        $file_title_bg = iconv('UTF-8','big5//TRANSLIT//IGNORE',pathinfo($_SESSION["team_bg_img"]["team_bg_file"]["name"], PATHINFO_FILENAME));

//        echo $file_name;
//        echo $file_title;


//        $img_name = $_SESSION["team_img"]["team_file"]["name"];
//        $img_name_bg = $_SESSION["team_bg_img"]["team_bg_file"]["name"];

//        $target = $dir . $img_name;
//        $target_bg = $dir . $img_name_bg;

//        rename(iconv('UTF-8','big5',$target), iconv('UTF-8','big5',$dir . $file_title . '_' . $_POST['code'] . '.' . $file_name));
//        rename(iconv('UTF-8','big5',$target_bg),iconv('UTF-8','big5', $dir . $file_title_bg . '_bg_' . $_POST['code'] . '.' . $file_name_bg));


        $sql = sprintf("INSERT INTO `team`(`sid`,
            `name`, `code`, `public`, 
            `image`, `bg_image`, 
            `color`, `intorduction`, `motto`, 
            `created_at`, `leader_sid`) 
            VALUES ( NULL,  
             '%s', '%s', '%s', 
             '%s', '%s', 
             '%s', '%s', '%s',
             NOW(), '%s' )",
            $_POST['name'], $_POST['code'], $_POST['public'],
            $_SESSION["team_img"]["team_file"]["name"], $_SESSION["team_bg_img"]["team_bg_file"]["name"],
            $_POST['color'], $_POST['intorduction'], $_POST['motto'],
            $_SESSION['user']['sid']);


        if (isset($_POST['code'])){
                $image = $_SESSION["team_img"]["team_file"]["name"];
            $image_bg = $_SESSION["team_bg_img"]["team_bg_file"]["name"];

            $_SESSION['team_img'] = $_FILES;

            $code = $_POST['code'];

            if (is_dir($dir . $code)) {
    //            echo 'existed...<br>';
            } else {
                mkdir($dir . $code, 0777);
    //            echo 'not existed...<br>';
            }

            rename($dir . $image, $dir . $code . "/" . $image);


            $_SESSION['team_bg_img'] = $_FILES;

            $code = $_POST['code'];

            if (is_dir($dir . $code)) {
//            echo 'existed...<br>';
            } else {
                mkdir($dir . $code, 0777);
//            echo 'not existed...<br>';
            }

            rename($dir.$image_bg, $dir.$code."/".$image_bg);
        }


        $success = $mysqli->query($sql);
        $team_sid = $mysqli->insert_id;

        //一個人多團隊
//            $sids = array_keys($_SESSION['team_members']);
//            foreach ($sids as $sid):
//                $m_sql = sprintf("INSERT INTO `team_members`(`sid`, `team_sid`, `members_sid`)
//                                    VALUES (NULL, '%s', '%s')",$team_sid, $sid);
//                $mysqli->query($m_sql);
//            endforeach;
//
//        $o_sql = sprintf("INSERT INTO `team_members`(`sid`, `team_sid`, `members_sid`)
//                                VALUES (NULL, '%s', '%s')",$team_sid, $_SESSION['user']['sid']);
//        $o_success = $mysqli->query($o_sql);



        //一個人一團隊----------------
        $sids = array_keys($_SESSION['team_members']);
        $m_sql = sprintf("UPDATE `members` SET `team_sid` = '%s' WHERE `sid` IN (%s) ",
            $team_sid, implode(',', $sids) );
//            echo $sql;
//            exit;
        $m_success = $mysqli->query($m_sql);

        $o_sql = sprintf("UPDATE `members` SET `team_sid` = '%s' WHERE `sid` = '%s'",
            $team_sid, $_SESSION['user']['sid'] );
//        echo $m_sql;

        $o_success = $mysqli->query($o_sql);


        //隊員數量新增----------------
        $mqty_sql = sprintf("SELECT * FROM `members` WHERE `team_sid`='%s'",
            $team_sid );

        $mqty_result = $mysqli->query($mqty_sql);

        $mqty_row = $mqty_result->num_rows;


        $tmqty_sql = sprintf("UPDATE `team` SET `members_qty` = '%s' WHERE `sid` = '%s'",
            $mqty_row, $team_sid);

        $tmqty_success = $mysqli->query($tmqty_sql);



        if($success&&$m_success&&$o_success&&$tmqty_success){
            $sql = sprintf("SELECT * FROM `members` WHERE `sid`='%s' ",
                $_SESSION['user']['sid'] );

            $result = $mysqli->query($sql);
            if($result->num_rows){
                $row = $result->fetch_assoc();
                $_SESSION['user'] = $row;
            }
            unset($_SESSION['team_members']);
            unset($_SESSION['server']);
            if (! isset($_SESSION['create_team'])){
                $_SESSION['create_team'] = 1;
            }
//            echo '<script> alert("建立成功!") </script>';
            header("Location: team_info.php?sid=".$team_sid);

        }



    }
}


?>


<?php include __DIR__.'/__html_head.php'?>
<link rel="stylesheet" href="css/create_team.css">

<?php include __DIR__ . '/__navbar.php' ?>

<div class="creat_team_wrap">
    <!--<canvas></canvas>-->
<!--0418新增-->
    <div class="left_soilder_box"><img src="image/left_soilder_box-01.png" alt=""></div>
    <div class="right_soilder_box"><img src="image/right_soilder_box-01.png" alt=""></div>
    <div class="bottom_soilder_box"><img src="image/bottom_soilder_box-02.png" alt=""></div>

<!--end of 0418新增-->
    <div class="create_team_title flexbox">
        <div class="create_team_title_right "></div>
        <div class="create_team_title_left ">
            <h2>建立團隊</h2>
        </div>
        <div class="create_team_title_middle "></div>
    </div>
    <div class="create_team_content">
        <div class="create_team_content_inner flexbox">
            <form class="flexbox" name="form1" method="post" onsubmit="return checkForm();">
                <div class="top_info flexbox">
                    <div class="img_upload_group flexbox">
                        <div class="form-group img_upload_groupleft">
                            <h2>團隊基本資料</h2>
                            <div class="img_upload_review">
                                <img src="" alt="">
                            </div>
                            <div class="img_upload">
                                <div class="custom_img team_img flexbox">
                                    <span id="img_name" onkeyup="imgname(this.id)"></span>
                                    <p>檔案上傳</p>
                                </div>
                                <input class="img_file" type="file" name="team_file" id="team_file"><br>
                            </div>
                            <div class="img_upload_info flexbox">
                                <i class="fa fa-info-circle fa-2x"></i>
                                <span class="info">
                                    你可以上傳
                                    LOGO徽章
                                </span>
                            </div>
                        </div>
                        <div class="form-group img_upload_groupright">
                            <div class="form-group">
                                <label for="name">團隊名稱</label>
                                <div class="name_text_info flexbox">
                                    <input type="text" class="form-control" id="name" name="name" value="" onkeyup="testName(this.name)">
                                    <i class="fa fa-info-circle fa-2x"></i>
                                    <span class="info">請填寫團隊名稱</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="teamcode">團隊代號</label>
                                <div class="teamcode_text_info flexbox">
                                    <input type="text" class="form-control" id="teamcode" name="code" value="" onkeyup="upperCase(this.id)">
                                    <i class="fa fa-info-circle fa-2x"></i>
                                    <span class="info">請輸入1大寫英文字母+3位數字</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <section class="team_open_section">
                                    <div class="team_open_select">
                                        <input type="checkbox" class="check_item" name="public" value="private" id="checkbox-1">
                                        <label for="checkbox-1"><span class="checkbox">僅限邀請參加的私人團隊</span></label>
                                        <input type="checkbox" class="check_item" name="public" value="public" id="checkbox-2" checked>
                                        <label for="checkbox-2"><span class="checkbox">公開的團隊</span></label>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div> <!--end of img_upload_group flexbox-->
                    <div class="img_upload_groupbk flexbox">
                        <div class="form-group img_upload_groupbk_left">
                            <p>團隊背景照片</p>
                            <div class="img_upload_groupbk_review">
                                <img src="" alt="">
                            </div>
                            <div class="img_upload">
                                <div class="custom_img bg_img flexbox">
                                    <span id="bg_img_name"></span>
                                    <p>檔案上傳</p>
                                </div>
                                <input class="img_file" type="file" name="team_bg_file" id="groupbk_img_file"><br>
                            </div>
                        </div>
                        <div class="form-group img_upload_groupbk_right">
                            <div class="form-group1">
                                <div class="img_upload_groupbk_info flexbox">
                                    <i class="fa fa-info-circle fa-2x"></i>
                                    <span class="info">
                                                請選擇一張背景圖<br/>
                                                您可自訂上傳個人圖片<br/>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="img_upload_color_radio">
                                    <ul>
                                        <li>
                                            <input type="radio" id="a-option" name="color" value="rgba(255,0,46,.2)" checked>
                                            <label for="a-option"></label>
                                            <div class="check teamcolor_1"></div>
                                        </li>
                                        <li>
                                            <input type="radio" id="b-option" name="color" value="rgba(205,50,0,.2)">
                                            <label for="b-option"></label>
                                            <div class="check teamcolor_2">
                                                <div class="inside"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <input type="radio" id="c-option" name="color" value="rgba(255,155,0,.2)">
                                            <label for="c-option"></label>
                                            <div class="check teamcolor_3">
                                                <div class="inside"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <input type="radio" id="d-option" name="color" value="rgba(255,205,0,.2)">
                                            <label for="d-option"></label>
                                            <div class="check teamcolor_4">
                                                <div class="inside"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <input type="radio" id="e-option" name="color" value="rgba(0,110,64,.2)">
                                            <label for="e-option"></label>
                                            <div class="check teamcolor_5">
                                                <div class="inside"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <input type="radio" id="f-option" name="color" value="rgba(15,205,85,.2)">
                                            <label for="f-option"></label>
                                            <div class="check teamcolor_6">
                                                <div class="inside"></div>
                                            </div>
                                        </li>
                                        <!--後六個-->
                                        <li>
                                            <input type="radio" id="g-option" name="color" value="rgba(45,205,200,.2)">
                                            <label for="g-option"></label>
                                            <div class="check teamcolor_7"></div>
                                        </li>
                                        <li>
                                            <input type="radio" id="h-option" name="color" value="rgba(102,204,255,.2)">
                                            <label for="h-option"></label>
                                            <div class="check teamcolor_8">
                                                <div class="inside"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <input type="radio" id="i-option" name="color" value="rgba(0,105,115,.2)">
                                            <label for="i-option"></label>
                                            <div class="check teamcolor_9">
                                                <div class="inside"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <input type="radio" id="j-option" name="color" value="rgba(15,65,90,.2)">
                                            <label for="j-option"></label>
                                            <div class="check teamcolor_10">
                                                <div class="inside"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <input type="radio" id="k-option" name="color" value="rgba(222,222,222,.2)">
                                            <label for="k-option"></label>
                                            <div class="check teamcolor_11">
                                                <div class="inside"></div>
                                            </div>
                                        </li>
                                        <li>
                                            <input type="radio" id="l-option" name="color" value="rgba(143,143,143,.2)">
                                            <label for="l-option"></label>
                                            <div class="check teamcolor_12">
                                                <div class="inside"></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!--end of img_upload_groupbk flexbox-->
                    <div class="team_intorduction flexbox">
                        <label for="team_intorduction">團隊介紹</label>
                        <textarea id="team_intorduction" name="intorduction" cols="30" rows="10" placeholder="最多80字唷"></textarea>
                    </div>
                    <div class="team_slogan flexbox">
                        <label for="team_slogan">團隊座右銘</label>
                        <textarea id="team_slogan" name="motto" cols="30" rows="10" placeholder="最多20字唷"></textarea>
                    </div>
                    <div class="team_member_addlist flex-box">
                        <p class="team_member_addlist_title">團隊成員</p>
                        <div class="scroll_list_title_fixed flexbox">
                            <div class="scroll_list_title">隊員目前名單</div>
                            <div class="scroll_list_title">加入新團隊成員</div>
                        </div>
                        <div class="team_member_addlist_wrap flex-box">
                            <div class="scrollbar scrollbar_left" id="team_scroll_1">
                                <div class="set-overflow flex-box">
                                    <table id="remove_member" class="group_memberlist_already">
                                        <tr id="original">
                                            <td class="memberlist_username_id"><?=$_SESSION['user']['name']?></td>
<!--                                            <td id="remove_btn" class="memberlist_delete">剔除</td>-->
                                        </tr>
                                        <tbody id="append">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="scrollbar scrollbar_right" id="team_scroll_2">
                                <div class="set-overflow">
                                    <div>
                                        <input id="search-box" type="text" name="search-box"
                                               onkeyup="showResult(this.value)"
                                        placeholder="請輸入email"/>
                                    </div>
                                    <table id="find_member" class="group_memberlist_find">
<!--                                        <tr id="find">-->
<!--                                            <td class="memberlist_username_id_add">fhfgh</td>-->
<!--                                            <td class="add_btn memberlist_add">新增</td>-->
<!--                                        </tr>-->
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="btn flexbox">
                            <a class="btn1" href="team_list.php">返回團隊首頁</a>
                            <button type="submit" class="btn2">送出新增</button>
                        </div>
                    </div>
                </div>  <!--end of top_info-->
                <!--<div class="line"></div>-->
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script >






    //檢查表單-----------------------------------
    function checkForm(){
        var $img_name = $('#img_name');
        var $bg_img_name = $('#bg_img_name');
        var $name = $('#name');
        var $code = $('#teamcode');
//        var $intorduction = $('#team_intorduction');

        var items = [$img_name, $bg_img_name, $name, $code];

        var img_name = $img_name.text();
        var bg_img_name = $bg_img_name.text();
        var name = $name.val();
        var code = $code.val();
//        var intorduction = $intorduction.val();

        var i;
        var code_pattern = /^[A-Z]\d{3}$/;
        var isPass = true;

//        for(i=0; i<items.length; i++){
//            items[i].closest('.form-group').find('.info').text('');
//            $('.act_img_form').find('.info').text('');
//        }

//        if(! img_name){
//            $img_name.closest('.form-group').find('.img_upload_info').addClass("errorcolor");
//            $img_name.closest('.form-group').find('.img_upload_info span').text("請上傳logo");
//            isPass = false;
//        }

//        if(! bg_img_name){
//            $('.form-group1').find('.img_upload_groupbk_info').addClass("errorcolor");
//            $('.form-group1').find('.img_upload_groupbk_info span').text("請上傳背景圖片");
//            isPass = false;
//        }

        if(! name){
            $name.closest('.form-group').find('i').addClass("errorcolor");
            $name.closest('.form-group').find('span').addClass("errorcolor");
            $name.closest('.form-group').find('span').text("請填寫團隊名稱");
            isPass = false;
        }

        if(! code){
            $code.closest('.form-group').find('i').addClass("errorcolor");
            $code.closest('.form-group').find('span').addClass("errorcolor");
            $code.closest('.form-group').find('span').text("請填寫團隊代號");
            isPass = false;
        }

//        if(! code_pattern.test(code)){
//            $code.closest('.form-group').find('#teamcode').val("格式錯誤");
//            $code.closest('.form-group').find('span').removeClass("form_error");
//            isPass = false;
//        }


        $.get('aj_check_code.php', {code: code}, function(data){

            if(data=='1'){
                $code.closest('.form-group').find('i').removeClass("form_error");
                $code.closest('.form-group').find('i').addClass("errorcolor");
                $code.closest('.form-group').find('span').removeClass("form_error");
                $code.closest('.form-group').find('span').addClass("errorcolor");
                $code.closest('.form-group').find('span').text("此代號已有人使用");
                isPass = false;
            }

            if( code_pattern.test(code) ) {
                if (data == '0') {
                    $code.closest('.form-group').find('i').removeClass("form_error");
                    $code.closest('.form-group').find('i').removeClass("errorcolor");
                    $code.closest('.form-group').find('span').removeClass("form_error");
                    $code.closest('.form-group').find('span').removeClass("errorcolor");
                    $code.closest('.form-group').find('span').text("此代號可以使用唷！！！");
                }
            }

            if(isPass){
                document.form1.submit();
            }


        });

//          alert('123');

        return false;

    }


    //團隊代號檢查----------------
    function upperCase(x) {
        var $code = $('#teamcode');
        var code = $code.val();
        var code_pattern0 = /^[A-Z]$/;
        var code_pattern1 = /^[A-Z]\d{1}$/;
        var code_pattern2 = /^[A-Z]\d{2}$/;
        var code_pattern3 = /^[A-Z]\d{3}$/;

        var y=document.getElementById(x).value;
        document.getElementById(x).value=y.toUpperCase()

        $code.closest('.form-group').find('i').addClass("form_error");
        $code.closest('.form-group').find('span').addClass("form_error");
        $code.closest('.form-group').find('span').text("");

        if(code.length = 1) {
            if (!code_pattern0.test(code)) {
                $code.closest('.form-group').find('i').removeClass("form_error");
                $code.closest('.form-group').find('i').addClass("errorcolor");
                $code.closest('.form-group').find('span').removeClass("form_error");
                $code.closest('.form-group').find('span').addClass("errorcolor");
                $code.closest('.form-group').find('span').text("格式錯誤");
            } else {
                $code.closest('.form-group').find('i').addClass("form_error");
                $code.closest('.form-group').find('span').addClass("form_error");
            }
        }

        if(code.length > 1) {
            if (!code_pattern1.test(code)) {
                $code.closest('.form-group').find('i').removeClass("form_error");
                $code.closest('.form-group').find('i').addClass("errorcolor");
                $code.closest('.form-group').find('span').removeClass("form_error");
                $code.closest('.form-group').find('span').addClass("errorcolor");
                $code.closest('.form-group').find('span').text("格式錯誤");
            } else {
                $code.closest('.form-group').find('i').addClass("form_error");
                $code.closest('.form-group').find('span').addClass("form_error");
            }
        }

        if(code.length > 2) {
            if (!code_pattern2.test(code)) {
                $code.closest('.form-group').find('i').removeClass("form_error");
                $code.closest('.form-group').find('i').addClass("errorcolor");
                $code.closest('.form-group').find('span').removeClass("form_error");
                $code.closest('.form-group').find('span').addClass("errorcolor");
                $code.closest('.form-group').find('span').text("格式錯誤");
            } else {
                $code.closest('.form-group').find('i').addClass("form_error");
                $code.closest('.form-group').find('span').addClass("form_error");
            }
        }

        if(code.length > 3) {
            if (!code_pattern3.test(code)) {
                $code.closest('.form-group').find('i').removeClass("form_error");
                $code.closest('.form-group').find('i').addClass("errorcolor");
                $code.closest('.form-group').find('span').removeClass("form_error");
                $code.closest('.form-group').find('span').addClass("errorcolor");
                $code.closest('.form-group').find('span').text("格式錯誤");
            } else {
                $code.closest('.form-group').find('i').addClass("form_error");
                $code.closest('.form-group').find('span').addClass("form_error");
            }
        }

        if(! code) {
            $code.closest('.form-group').find('i').removeClass("form_error");
            $code.closest('.form-group').find('span').removeClass("form_error");
            $code.closest('.form-group').find('span').text("請填寫1大寫英文＋3位數字");
        }

        $.get('aj_check_code.php', {code: code}, function(data){

            if(data=='1'){
                $code.closest('.form-group').find('i').removeClass("form_error");
                $code.closest('.form-group').find('i').addClass("errorcolor");
                $code.closest('.form-group').find('span').removeClass("form_error");
                $code.closest('.form-group').find('span').addClass("errorcolor");
                $code.closest('.form-group').find('span').text("此代號已有人使用");
                isPass = false;
            }

            if( code_pattern3.test(code) ) {
                if (data == '0') {
                    $code.closest('.form-group').find('i').removeClass("form_error");
                    $code.closest('.form-group').find('i').removeClass("errorcolor");
                    $code.closest('.form-group').find('span').removeClass("form_error");
                    $code.closest('.form-group').find('span').removeClass("errorcolor");
                    $code.closest('.form-group').find('span').text("此代號可以使用唷！！！");
                }
            }


        });

    }

    //團隊名稱檢查----------------
    function testName() {
        var $name = $('#name');
        var name = $name.val();

        $name.closest('.form-group').find('i').addClass("form_error");
        $name.closest('.form-group').find('span').addClass("form_error");

        if(! name ) {
            $name.closest('.form-group').find('i').removeClass("form_error");
            $name.closest('.form-group').find('i').addClass("errorcolor");
            $name.closest('.form-group').find('span').removeClass("form_error");
            $name.closest('.form-group').find('span').addClass("errorcolor");
            $name.closest('.form-group').find('span').text("請填寫團隊名稱");
        } else {
            $name.closest('.form-group').find('i').addClass("form_error");
            $name.closest('.form-group').find('span').addClass("form_error");
        }

    }


    //移除隊員-----------------------
    $('#remove_member').on('click','.remove_btn',function(){
        var tr = $(this).closest('tr');
        var sid = $(this).attr('data-sid');
//            alert('商品已加入購物車');
        tr.remove();
        $.get('add_to_team.php', {sid:sid}, function(data){

        }, 'json');

    });


    //新增隊員-----------------------
//    $(function(){
        $('#find_member').on('click','.add_btn',function(){
//            alert('商品已加入購物車');

            var sid = $(this).attr('data-sid');
            var name = $(this).closest('#find').find('.member_name').text();
//            var qty = $(this).closest('.caption').find('.qty').val();

//            $.get('add_to_team.php', {sid:sid, qty:qty}, function(data){
            $.get('add_to_team.php', {sid:sid, name:name}, function(data){
                $('#append').html(data);

            });

        });
//    });



    //搜尋隊員----------------------

    function showResult(str) {


        var search = $('#search-box').val();

        if (search.length == 0) {
            $('#find_member').html("");
        } else {
            $.post('search_member_to_team.php', {search: search}, function (data) {
                $('#find_member').html(data);
            });
        }
    }


    //照片上傳-----------------------------------
    var team_file = $('#team_file');

    team_file.change(function(){
        var fd = new FormData();
        var file = $(this)[0].files[0];

        fd.append('team_file', file);

        $.ajax({
            url: 'team_file_upload.php',
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function ( data ) {
                $('.img_upload_review').css("background","none");
                $('.img_upload_review img').attr("src","team_img/" + data );
                $('.team_img span').text( data );
            }

        });

    });

    var team_bg_file = $('#groupbk_img_file');

    team_bg_file.change(function(){
        var fd = new FormData();
        var file = $(this)[0].files[0];

        fd.append('team_bg_file', file);

        $.ajax({
            url: 'team_bg_file_upload.php',
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function ( data ) {
                $('.img_upload_groupbk_review').css("background","none");
                $('.img_upload_groupbk_review img').attr("src","team_img/" + data );
                $('.bg_img span').text( data );
            }

        });

    });




    //增加遊戲模式-------------------------------
    $('.game_qty').change(function () {
        if ($('select[name="game_qty"] option[value="2"]').is(':selected')) {
            $('.more').addClass('active');
        } else {
            $('.more').removeClass('active');
        }
    });



    //選槍對比賽 團隊會出現-----------------------------
    $(".host").change(function () {
        if ($('select[name="host"] option[value="槍隊比賽"]').is(':selected')) {
            $('.group').addClass('active');
        } else {
            $('.group').removeClass('active');
        }
    });



    //表單 select變成單選----------------------------------------

    $('.check_item').on('change', function () {
        $('.check_item').not(this).prop('checked', false);
    });

    //----------------------------------------


</script>

<?php include __DIR__ . '/__html_foot.php' ?>