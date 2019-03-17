<?php

require __DIR__ . '/__connect_db.php';

$pname = 'activity';

unset($_SESSION['server']);

if (! isset($_SESSION['server'])){
    $_SESSION['server'] = $_SERVER['REQUEST_URI'];
}

if (isset($_SESSION['team_members'])){
    unset($_SESSION['team_members']);
}



if(! isset($_SESSION['user'])) {
    echo '<script>
                alert("請先登入會員!")
                window.location.href = "members.php";
            </script>';
//    header("Location:members.php");
}


//篩選鈕

$people_sql = 'SELECT `people`, `people_value` FROM `activity_categories` WHERE `sid` != 1 AND `sid` != 6';

$people_rs = $mysqli->query($people_sql);


$date_sql = 'SELECT `date`, `date_value` FROM `activity_categories` WHERE `sid` != 1';

$date_rs = $mysqli->query($date_sql);


$ground_sql = 'SELECT * FROM `activity_selected` LIMIT 0,4';

$ground_rs = $mysqli->query($ground_sql);


$mode_sql = 'SELECT `mode`, `mode_value` FROM `activity_categories` WHERE `sid` != 1';

$mode_rs = $mysqli->query($mode_sql);

$mode2_sql = 'SELECT `mode2`, `mode_value` FROM `activity_categories` WHERE `sid` != 1';

$mode2_rs = $mysqli->query($mode2_sql);


$host_sql = 'SELECT `host`, `host_value` FROM `activity_categories` WHERE `sid` != 1 AND `sid` !=2 AND `sid` != 6';

$host_rs = $mysqli->query($host_sql);



//團隊--------------------
if (isset($_SESSION['user']['team_sid'])) {
    $allm_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` =" . $_SESSION['user']['team_sid']);

    $allm_result = $mysqli->query($allm_sql);
}

//表格--------------------

if (isset($_POST['name'])) {
    if ($_POST['game_qty']=='1'){  //只選一種遊戲模式--------------


//上傳圖片------
             //取檔案副檔名
//        $file_name =  pathinfo($_SESSION['activity_img']['act_file']['name'], PATHINFO_EXTENSION);
//        $file_title =  pathinfo($_SESSION['activity_img']['act_file']['name'], PATHINFO_FILENAME);

//        echo $file_name;
//        echo $file_title;

        $dir = __DIR__. '/activity_img/';

        $img_name = $_SESSION['activity_img']['act_file']['name'];

//        echo $img_name;

        $target = $dir . $img_name;

//        echo $target;

        rename(iconv('UTF-8','big5',$target), iconv('UTF-8','big5',$dir.$_POST['name'].'_'.$img_name));

        if (isset($_SESSION['sel_members'])) {  //有選對員join_members_sid------
                $sids = array_keys($_SESSION['sel_members']);

                $m_sid = implode(',', $sids);

                $sql = sprintf("INSERT INTO `products`(`sid`, `type`, 
            `name`, `price`, `intorduction`, 
            `head_image`, `date`, `ground`,
            `game_qty`, `mode`, 
            `people`, `host`, 
            `equip_limit`, `active_note`, `activated`, `join_members_sid`, `members_sid`, `team_sid`, `created_at`) 
            VALUES ( NULL, 0, 
             '%s', '400', '%s', 
             '%s', '%s', '%s',  
             '1', '%s',
             '%s', '%s',
             '%s', '%s', '1','%s','%s','%s', NOW() )",
                    $_POST['name'],$_POST['intorduction'],
                    $_POST['name'].'_'.$img_name, $_POST['date'], $_POST['ground'],
                    $_POST['mode'],
                    $_POST['people'], $_POST['host'],
                    $_POST['equip_limit'], $_POST['active_note'], $m_sid, $_SESSION['user']['sid'], $_SESSION['user']['team_sid'] );

//              echo $sql;
//              exit;


                $success = $mysqli->query($sql);


                if ($success) {
                    unset($_SESSION['sel_members']);
                    unset($_SESSION['server']);
    //                echo '<script>alert("舉辦成功!")</script>';
                    echo '<script>
                            alert("舉辦成功!")
                            window.location.href = "activity_list.php";
                        </script>';
    //                header("Location: activity_list.php");
                };
            } else {    //沒選對員join_members_sid------

                $sql = sprintf("INSERT INTO `products`(`sid`, `type`, 
                `name`, `price`, `intorduction`, 
                `head_image`, `date`, `ground`,
                `game_qty`, `mode`, 
                `people`, `host`, 
                `equip_limit`, `active_note`, `activated`, `members_sid`, `team_sid`, `created_at`) 
                VALUES ( NULL, 0, 
                 '%s', '400', '%s', 
                 '%s', '%s', '%s',  
                 '1', '%s',
                 '%s', '%s',
                 '%s', '%s', '1','%s','%s',NOW() )",
                    $_POST['name'],$_POST['intorduction'],
                    $_POST['name'].'_'.$img_name, $_POST['date'], $_POST['ground'],
                    $_POST['mode'],
                    $_POST['people'], $_POST['host'],
                    $_POST['equip_limit'], $_POST['active_note'], $_SESSION['user']['sid'], $_SESSION['user']['team_sid'] );

//                          echo $sql;
//                          exit;


                $success = $mysqli->query($sql);


                if ($success) {
                    unset($_SESSION['sel_members']);
                    unset($_SESSION['server']);
                    //                echo '<script>alert("舉辦成功!")</script>';
                    echo '<script>
                                alert("舉辦成功!")
                                window.location.href = "activity_list.php";
                            </script>';
                    //                header("Location: activity_list.php");
                };
        }

    } else {   //選兩種遊戲模式--------------

        //上傳圖片------
        //取檔案副檔名
//        $file_name =  pathinfo($_SESSION['activity_img']['act_file']['name'], PATHINFO_EXTENSION);
//        $file_title =  pathinfo($_SESSION['activity_img']['act_file']['name'], PATHINFO_FILENAME);

//        echo $file_name;
//        echo $file_title;

        $dir = __DIR__. '/activity_img/';

        $img_name = $_SESSION['activity_img']['act_file']['name'];

//        echo $img_name;

        $target = $dir . $img_name;

//        echo $target;

        rename(iconv('UTF-8','big5',$target), iconv('UTF-8','big5',$dir.$_POST['name'].'_'.$img_name));

        if (isset($_SESSION['sel_members'])) {   //有選對員join_members_sid------
            $sids = array_keys($_SESSION['sel_members']);

            $m_sid = implode(',', $sids);

            $sql = sprintf("INSERT INTO `products`(`sid`, `type`, 
        `name`, `price`, `intorduction`, 
        `head_image`, `date`, `ground`,
        `game_qty`, `mode`, `mode2`, 
        `people`, `host`, 
        `equip_limit`, `active_note`, `activated`, `join_members_sid`,`members_sid`,`team_sid`, `created_at`) 
        VALUES ( NULL, 0, 
         '%s', '600', '%s', 
         '%s', '%s', '%s',  
         '2', '%s', '%s',
         '%s', '%s',
         '%s', '%s', '1', '%s', '%s', '%s', NOW() )",
                $_POST['name'], $_POST['intorduction'],
                $_POST['name'].'_'.$img_name, $_POST['date'], $_POST['ground'],
                $_POST['mode'], $_POST['mode2'],
                $_POST['people'], $_POST['host'],
                $_POST['equip_limit'], $_POST['active_note'], $m_sid, $_SESSION['user']['sid'], $_SESSION['user']['team_sid']);

//          echo $sql;
//          exit;

            $success = $mysqli->query($sql);


            if ($success) {
//            echo '<script>alert("舉辦成功!")</script>';
                unset($_SESSION['sel_members']);
                unset($_SESSION['server']);
                echo '<script>
                        alert("舉辦成功!")
                        window.location.href = "activity_list.php";
                    </script>';
//            header("Location: activity_list.php");
            };
        }else{   //沒選對員join_members_sid------
            $sql = sprintf("INSERT INTO `products`(`sid`, `type`, 
        `name`, `price`, `intorduction`, 
        `head_image`, `date`, `ground`,
        `game_qty`, `mode`, `mode2`, 
        `people`, `host`, 
        `equip_limit`, `active_note`, `activated`,`members_sid`,`team_sid`, `created_at` ) 
        VALUES ( NULL, 0, 
         '%s', '600', '%s', 
         '%s', '%s', '%s',  
         '2', '%s', '%s',
         '%s', '%s',
         '%s', '%s', '1', '%s', '%s',NOW() )",
                $_POST['name'], $_POST['intorduction'],
                $_POST['name'].'_'.$img_name, $_POST['date'], $_POST['ground'],
                $_POST['mode'], $_POST['mode2'],
                $_POST['people'], $_POST['host'],
                $_POST['equip_limit'], $_POST['active_note'], $_SESSION['user']['sid'], $_SESSION['user']['team_sid']);

//          echo $sql;
//          exit;

            $success = $mysqli->query($sql);


            if ($success) {
//            echo '<script>alert("舉辦成功!")</script>';
                unset($_SESSION['sel_members']);
                unset($_SESSION['server']);
                echo '<script>
                        alert("舉辦成功!")
                        window.location.href = "activity_list.php";
                    </script>';
//            header("Location: activity_list.php");
            };
        }
    }
}
?>


<?php include __DIR__.'/__html_head.php'?>
    <link rel="stylesheet" type="text/css" href="datepic/jquery.datetimepicker.css"/>
<link rel="stylesheet" href="css/create_activity.css">
    <style>

        body {
            font-family: Microsoft JhengHei;
        }

    </style>

<?php include __DIR__ . '/__navbar.php' ?>

    <div class="activity_wrap">

            <div class="create_activity_title flexbox">
                <div class="create_activity_title_left"></div>
                <div class="create_activity_title_right flexbox">
                    <img src="image/create_activity_bg.jpg" alt="">
                </div>
                <div class="create_activity_title_text flexbox">
                    <h2>發起活動</h2>
                    <p>創建你的團隊,<br/>舉辦活動</p>
                </div>
            </div>

        <div class="join_content">


            <div class="join_content_inner flexbox">
                <form class="flexbox" name="form1" method="post" enctype="multipart/form-data" onsubmit="return checkForm();">
                    <div class="top_info">
                        <div class="form-group">
                            <label for="name">活動名稱</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="最多七個字唷!" value="">
                            <span class="info error-color"></span>
                        </div>

                        <div class="form-group">
                            <label for="ground">場地類型選擇</label>
                            <select class="ground" name="ground" onchange="Change_people(this.value);">
                                <?php while ($ground_row = $ground_rs->fetch_assoc()): ?>
                                    <option value="<?= $ground_row['sid'] ?>"><?= $ground_row['ground'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="map">
                            <img src="image/野地叢林.jpg" alt="">
                        </div>

                        <div class="form-group">
                            <label for="date">活動日期</label>
                            <input class="input date" type="text" name="date" id="datetimepicker_dark"/>
                            <span class="info error-color"></span>
                        </div>

                        <div class="form-group">
                            <label for="people">活動人數</label>
                            <select id="people" class="people" name="people">
                                <?php while ($people_row = $people_rs->fetch_assoc()): ?>
                                    <option value="<?= $people_row['people'] ?>"><?= $people_row['people'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="game_qty">遊戲場數</label>
                            <select class="game_qty" name="game_qty">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>

                        <div class="mode form-group">
                            <label for="mode">遊戲模式</label>
                            <select class="mode mode_sel" name="mode">
                                <?php while ($mode_row = $mode_rs->fetch_assoc()): ?>
                                    <option value="<?= $mode_row['mode'] ?>"><?= $mode_row['mode'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mode more transition form-group">
                            <label for="mode2">遊戲模式 2</label>
                            <select class="mode2 mode_sel" name="mode2">
                                <?php while ($mode2_row = $mode2_rs->fetch_assoc()): ?>
                                    <option value="<?= $mode2_row['mode2'] ?>"><?= $mode2_row['mode2'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="intorduction form-group">
                            <label for="intorduction">活動內容</label>
                            <textarea id="intorduction" name="intorduction" cols="30" rows="10" placeholder="(範例一)
團隊死鬥 > 野地叢林
內容
美國與俄國為了戰略與經濟利益在此爭奪此場地，將敵人消滅並佔領這個戰略要地，不給敵人任何機會。
裝備限制 :
美軍方面請配合使用美軍風格的裝備、北約盟國所使用的武器。
俄軍方面請配合使用俄系風格的裝備、前蘇聯等國所使用的武器。
請勿使用地雷、詭雷等裝備，禁止使用閃光彈。
備註:
美軍方面參戰美軍方面請配合穿著美軍風格或北約的服裝。
俄軍方面請配合穿著俄系風格的服裝。
禁止自己以為英文很溜，但是只會講單字，可以不用講俄語。

(範例二)
搶奪旗幟 > 街道巷戰
內容
雙方部隊的情報顯示，敵對陣營擁有一份有利於我們贏的勝利的機密裝備、前往竊取敵方陣營的軍旗帶回基地，取得勝利。
裝備限制 :
參加玩家沒有任何武器裝備限制。
備註:
參加的玩家沒有任何服裝限制。

(範例三)
人質營救 > 建築肅清
內容
攻擊方的特種部隊在建築物外部集結，準備強型攻堅搶奪防守方的重要人士。
裝備限制 :
雙方的玩家禁止使用狙擊槍，禁止使用手榴彈，禁止使用地雷，禁止使用煙霧彈。
備註:
攻擊方的玩家可以穿著特種部隊服裝，防守方沒有限制穿著。
禁止駭客任務的尼歐在場地中閃躲子彈、被打到就要陣亡出場。
"></textarea>
                            <br/><span class="info limit_text"><i class="fa fa-info-circle fa-lg fa-fw" aria-hidden="true"></i>120字為限</span>
                        </div>

                        <div class="equip_limit form-group">
                            <label for="equip_limit">裝備限制</label>
                            <textarea id="equip_limit" name="equip_limit" cols="30" rows="10" placeholder="填寫希望限制的武器類型:
手槍、衝鋒槍、步槍、機槍、狙擊槍、手榴彈等其他配件。"></textarea>
                            <span class="info limit_text"><i class="fa fa-info-circle fa-lg fa-fw" aria-hidden="true"></i>120字為限</span>
                        </div>

                        <div class="form-group">
                            <label for="host">開放報名限制</label>
                            <select class="host" name="host">
                                <?php while ($host_row = $host_rs->fetch_assoc()): ?>
                                    <option value="<?= $host_row['host'] ?>"><?= $host_row['host'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="act_img_form form-group">
                            <label for="act_file">活動圖片</label>
                            <div id='img_activity_div' class="img_upload_groupbk_review">
                                <img src="image/add_groupbk_photo.png" alt="">
                            </div>

                            <div class="img_upload form-group">
                                <div class="custom_img flexbox">
                                    <span id="img_name"></span>
                                    <p>檔案上傳</p>
                                <input class="img_file" type="file" name="act_file" id="act_file"><br>
                                </div>
                            </div>
                            <span class="info error-color"></span>
                        </div>
                    </div>

                    <div class="line"></div>
                    <div class="group transition">
                    <?php if (isset($_SESSION['user']['team_sid'])): ?>


                        <h2>參加隊員</h2>
                        <div style="height: 140px;">
                            <div class="member_head add_group_member_wrap flexbox">
                                <div class="add_group_member_show">
                                    <div class="add_group_member"><img src="image/plus_member.png" alt="">
                                    </div>
                                    <p class="add_group_member_username">USERNAME</p>
                                </div>
                            </div>
                        </div>
                        <div class="team_member_addlist flex-box">
                            <div class="scroll_list_title_fixed flexbox">
                                <div class="scroll_list_title"><i class="fa fa-check" aria-hidden="true"></i>遊戲參加成員(已加入)</div>
                                <div class="scroll_list_title"><i class="fa fa-th-list" aria-hidden="true"></i>團隊成員列表</div>
                            </div>
                            <div class="team_member_addlist_wrap flex-box">
                                <div class="scrollbar scrollbar_left" id="team_scroll_1">
                                    <div id="append" class="set-overflow flex-box">
                                        <table id="remove_member" class="group_memberlist_already">
<!--                                            <tr>-->
<!--                                                <td class="memberlist_username_id">USERNAME ID</td>-->
<!--                                                <td class="memberlist_delete">剔除</td>-->
<!--                                            </tr>-->
                                        </table>
                                    </div>
                                </div>
                                <div class="scrollbar scrollbar_right" id="team_scroll_2">
                                    <div class="set-overflow">
                                        <table id="find_member" class="group_memberlist_find">
                                            <?php while ($allm_row = $allm_result->fetch_assoc()): ?>
                                            <tr class="find">
                                                <td class="member_name memberlist_username_id_add"><?= $allm_row['name'] ?></td>
                                                <td class="add_btn memberlist_add" data-sid="<?= $allm_row['sid'] ?>">新增</td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>

                    <!--0418新增　　無團隊無法選擇遊戲模式-->
                    <div class="no_team_nogame">

                        <i class="fa fa-exclamation-triangle fa-ban" aria-hidden="true"></i>
                        </span>

                        OOPS!

                        由於您尚未加入任何團隊,無法選擇此遊戲模式!
                        <i class="fa fa-exclamation-triangle fa-ban" aria-hidden="true"></i>
                    </div>

                    <!--　－－－－－－－－－－－－－－－－－－　　-->

                    <?php endif; ?>
            </div>
                    <div class="line"></div>

                    <div class="active_note form-group">
                        <label for="active_note">備註</label>
                        <textarea id="active_note" name="active_note" cols="30" rows="10" placeholder="請填寫活動的主題或者期望的服裝風格。"></textarea>
                        <span class="info limit_text"><i class="fa fa-info-circle fa-lg fa-fw" aria-hidden="true"></i>120字為限</span>
                    </div>

                    <div class="btn flexbox">
                        <a class="btn1" href="single_activity.php">返回活動首頁</a>
                        <button type="submit" class="btn2">送出新增</button>
                    </div>
                </form>

            </div>

        </div>




    </div>


    <script src="datepic/jquery.js"></script>
    <script src="datepic/jquery.datetimepicker.full.js"></script>
<script>

    //移除隊員-----------------------
    $('#remove_member').on('click','.remove_btn',function(){
        var tr = $(this).closest('tr');
        var sid = $(this).attr('data-sid');
        var member_head = $('.member_head').html();
        var head = $(this).closest('.group').find('.add_group_member_show');

        tr.remove();

        if(! member_head){
//            $('.member_head').html(data);
            $('.member_head').html('<div class="add_group_member_show"><div class="add_group_member"><img src="image/plus_member.png" alt=""></div> <p class="add_group_member_username">USERNAME</p></div>')
        }


        $.get('add_to_activity_team.php', {sid:sid}, function(data){

        }, 'json');

        $.get('add_to_activity_team_head.php', {sid:sid, name:name}, function(data){
            head.remove();

            if(data){
                $('.member_head').html(data);
                } else {
                $('.member_head').html('<div class="add_group_member_show"><div class="add_group_member"><img src="image/plus_member.png" alt=""></div> <p class="add_group_member_username">USERNAME</p></div>')
            }

        });

//        $.get('add_back_to_activity_team.php', {sid:sid, name:name}, function(data){
//            $('#find_member').html(data);
//
//        });

    });


    //新增隊員-----------------------

    $('#find_member').on('click','.add_btn',function(){
//        var tr = $(this).closest('tr');
        var sid = $(this).attr('data-sid');
        var name = $(this).closest('.find').find('.member_name').text();

//        tr.remove();

        $.get('add_to_activity_team.php', {sid:sid, name:name}, function(data){
            $('#remove_member').html(data);

        });

        $.get('add_to_activity_team_head.php', {sid:sid, name:name}, function(data){
            $('.member_head').html(data);

        });

    });






    //照片上傳-----------------------------------
    var act_file = $('#act_file');

    act_file.change(function(){
        var fd = new FormData();
        var file = $(this)[0].files[0];

        fd.append('act_file', file);

        $.ajax({
            url: 'act_file_upload.php',
            data: fd,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function ( data ) {
                $('#img_activity_div img').attr("src","activity_img/" + data );
                $('#img_name').text( data );
            }

        });

    });


    //檢查表單-----------------------------------
    function checkForm(){
        var $name = $('#name');
        var $date = $('#datetimepicker_dark');
        var $intorduction = $('#intorduction');
        var $img_name = $('#img_name');

        var items = [$name, $date, $intorduction, $img_name];

        var name = $name.val();
        var date = $date.val();
        var intorduction = $intorduction.val();
        var img_name = $img_name.text();

        var i;
        var isPass = true;

        for(i=0; i<items.length; i++){
            items[i].closest('.form-group').find('.info').text('');
            $('.act_img_form').find('.info').text('');
        }

//        alert("1111");
        if(name.length > 7){
            $name.closest('.form-group').find('.info').html('<i class="fa fa-info-circle fa-2x fa-fw" aria-hidden="true"></i> 最多七個字唷!!!');
            isPass = false;
        }

        if(name.length < 1){
            $name.closest('.form-group').find('.info').html('<i class="fa fa-info-circle fa-2x fa-fw" aria-hidden="true"></i> 請填寫活動名稱');
            isPass = false;
        }

        if(date.length < 1){
            $date.closest('.form-group').find('.info').html('<i class="fa fa-info-circle fa-2x fa-fw" aria-hidden="true"></i> 請選擇日期');
            isPass = false;
        }


        if(img_name==''){
            $('.act_img_form').find('.info').html('<i class="fa fa-info-circle fa-2x fa-fw" aria-hidden="true"></i> 請上傳圖片');
            isPass = false;
        }

//        if(! intorduction){
//            $intorduction.attr("placeholder","&#xf05a; 請填寫活動內容!!!!!");
//            isPass = false;
//        }

//        alert('123');
        return isPass;

    }





    //datepicker--------------------------------
    $('#datetimepicker_dark').datetimepicker({theme:'dark'});

    $('#datetimepicker_dark').datetimepicker({

        allowTimes:[
            '9:00','10:00','11:00','12:00', '13:00','14:00', '15:00',
            '16:00','17:00', '18:00', '19:00', '20:00', '21:00'
        ]
    });


    //篩選連動下拉式選單-----------------------------------------------
    function Change_people() {
        var ground = $('.ground').val();

        console.log(ground);

        $.post('change_select_people.php', { ground:ground }, function (data) {
            $('#people').html(data);
        });

        $.post('change_select_mode.php', { ground:ground }, function (data) {
            $('.mode_sel').html(data);
        });

        if (ground=="1") {
            $('.map').find('img').attr('src', 'image/野地叢林.jpg')
        }

        if (ground=="2") {
            $('.map').find('img').attr('src', 'image/街道巷戰.jpg')
        }

        if (ground=="3") {
            $('.map').find('img').attr('src', 'image/路障廣場.jpg')
        }

        if (ground=="4") {
            $('.map').find('img').attr('src', 'image/建築肅清.jpg')
        }
    }





    //增加遊戲模式-------------------------------
    $('.game_qty').change(function () {
       if ($('select[name="game_qty"] option[value="2"]').is(':selected')){
           $('.more').addClass('active');
       } else {
           $('.more').removeClass('active');
       }
    });


    //選槍對比賽 團隊會出現-----------------------------
    $(".host").change(function(){
        if($('select[name="host"] option[value="槍隊比賽"]').is(':selected')){
            $('.group').addClass('active');
        } else {
            $('.group').removeClass('active');
        }
    });





</script>

<?php include __DIR__ . '/__html_foot.php' ?>