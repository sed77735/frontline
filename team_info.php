<?php
require __DIR__ . '/__connect_db.php';

$dir = __DIR__. '/user_img/';

$pname = 'team';

if (isset($_SESSION['server'])){
    unset($_SESSION['server']);
}

if (isset($_SESSION['team_info'])){
    unset($_SESSION['team_info']);
}

if (isset($_SESSION['create_team'])&&$_SESSION['create_team']==1){
    echo '<script> alert("建立成功!") </script>';
    unset($_SESSION['create_team']);
}
if (isset($_SESSION['create_team'])&&$_SESSION['create_team']==2){
    echo '<script> alert("修改成功!") </script>';
    unset($_SESSION['create_team']);
}

if (isset($_SESSION['team_members'])){
    unset($_SESSION['team_members']);
}



//團隊資訊--------------
$t_sql = sprintf("SELECT m.name as mname FROM `team` t JOIN `members` m ON 
                        m.team_sid = t.sid WHERE t.sid =". $_GET['sid'] );

$t_result = $mysqli->query($t_sql);


$tm_sql = sprintf("SELECT * FROM `members` m JOIN `team` t ON m.team_sid = t.sid WHERE t.sid =". $_GET['sid'] );

$tm_result = $mysqli->query($tm_sql);

$tm_row = $tm_result->num_rows;


$allm_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` =". $_GET['sid'] );

$allm_result = $mysqli->query($allm_sql);



$sql = sprintf("SELECT * FROM `team` WHERE `sid` =". $_GET['sid']);

$result = $mysqli->query($sql);

$row = $result->fetch_assoc();


//個別撈資料-----------------------------------
$m1_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` = ". $_GET['sid'] ." ORDER BY `created_at` DESC LIMIT 3,1");

$m1_result = $mysqli->query($m1_sql);

$m1_row = $m1_result->fetch_assoc();


$m2_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` = ". $_GET['sid'] ." ORDER BY `created_at` DESC LIMIT 1,1");

$m2_result = $mysqli->query($m2_sql);

$m2_row = $m2_result->fetch_assoc();


$m3_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` = ". $_GET['sid'] ." ORDER BY `created_at` DESC LIMIT 0,1");

$m3_result = $mysqli->query($m3_sql);

$m3_row = $m3_result->fetch_assoc();


$m4_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` = ". $_GET['sid'] ." ORDER BY `created_at` DESC LIMIT 2,1");

$m4_result = $mysqli->query($m4_sql);

$m4_row = $m4_result->fetch_assoc();


$m5_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` = ". $_GET['sid'] ." ORDER BY `created_at` DESC LIMIT 4,1");

$m5_result = $mysqli->query($m5_sql);

$m5_row = $m5_result->fetch_assoc();



$mvp_sql = sprintf("SELECT `name` FROM `members` WHERE `team_sid` = ". $_GET['sid'] ." ORDER BY `kda` DESC,`kill_num`,`missoni_complete`,`join_num` LIMIT 1");

$mvp_result = $mysqli->query($mvp_sql);

$mvp_row = $mvp_result->fetch_assoc();



?>




<?php include __DIR__.'/__html_head.php'?>
<link rel="stylesheet" href="css/team_info.css">
<style>


    /*橙黃色碼 #eaa315*/

    body {
        font-family: Microsoft JhengHei;
        background-color: #011F35;
        cursor: crosshair;
        background-image: none;
    }

    a {
        text-decoration: none;
        font-size: 14px;
        letter-spacing: 5px;
        color: #D5D5D5;
        cursor:url(target_cursor.ani),auto;
    }

    .teaminfo_warp {
        max-width: 1270px;
        margin: 0 auto;
        position: relative;

        /*border: 1px solid orangered;*/
        height: 1800px;


        background: <?= isset($row['color']) ? $row['color'] : '#022E49' ?> url("image/leak_papper_bk.png") repeat-y fixed center;
    }




</style>

<?php include __DIR__ . '/__navbar.php' ?>


<!--   //  GROUP 頁面內容  -->


        <div class="teaminfo_warp">

            <div class="teaminfo_teaminfo">


                    <h2>團隊資訊</h2>

                    <div class="teaminfo_teamlogo">
                        <img src="team_img/<?= $row['code'] ?>/<?= $row['bg_image'] ?>" alt="">
                    </div>


                    <div class="teaminfo_team_warp">

<!--                            <div class="teaminfo_team_m3">-->
<!--                                <div class="teaminfo_team_bk3 teaminfo_circle"> <p class="username usermame_m3">--><?//= $t_row['mname'] ?><!--</p><img src="image/group_member_photo1.png" alt=""> </div>-->
<!---->
<!--                                <div class="teaminfo_team_m3photo"></div>-->
<!--                            </div>-->




                        <div class="teaminfo_team_m1">
                            <div class="teaminfo_team_bk1 teaminfo_circle">
                                <p class="username usermame_m1"><?= $m1_row['name'] ?></p>
                                <div><img src="<?= empty($m1_row['image']) ? "user_img/non_member.jpg" : 'user_img/' . $m1_row['hash'] . '/' . $m1_row['image'] ?>" alt=""></div>
                            </div>

<!--                            <div class="teaminfo_team_m1photo"><img src="" alt=""></div>-->
                        </div>
                        <div class="teaminfo_team_m2">
                            <div class="teaminfo_team_bk2 teaminfo_circle">
                                <p class="username usermame_m2"><?= $m2_row['name'] ?></p>
                                <div><img src="<?= empty($m2_row['image']) ? "user_img/non_member.jpg" : 'user_img/' . $m2_row['hash'] . '/' . $m2_row['image'] ?>" alt=""></div>
                            </div>

<!--                            <div class="teaminfo_team_m2photo"></div>-->
                        </div>
                        <div class="teaminfo_team_m3">
                            <div class="teaminfo_team_bk3 teaminfo_circle">
                                <p class="username usermame_m3"><?= $m3_row['name'] ?></p>
                                <div><img src="<?= empty($m3_row['image']) ? "user_img/non_member.jpg" : 'user_img/' . $m3_row['hash'] . '/' . $m3_row['image'] ?>" alt=""></div>
                            </div>

<!--                            <div class="teaminfo_team_m3photo"></div>-->
                        </div>
                        <div class="teaminfo_team_m4">
                            <div class="teaminfo_team_bk4 teaminfo_circle">
                                <p class="username usermame_m4"><?= $m4_row['name'] ?></p>
                                <div><img src="<?= empty($m4_row['image']) ? "user_img/non_member.jpg" : 'user_img/' . $m4_row['hash'] . '/' . $m4_row['image'] ?>" alt=""></div>
                            </div>

<!--                            <div class="teaminfo_team_m4photo"></div>-->
                        </div>
                        <div class="teaminfo_team_m5">
                            <div class="teaminfo_team_bk5 teaminfo_circle">
                                <p class="username usermame_m5"><?= $m5_row['name'] ?></p>
<!--                                <div><img src="user_img/--><?//= $m5_row['hash'] ?><!--/--><?//= $m5_row['image'] ?><!--" alt=""></div>-->
                                <div><img src="<?= empty($m5_row['image']) ? "user_img/non_member.jpg" : 'user_img/' . $m5_row['hash'] . '/' . $m5_row['image'] ?>" alt=""></div>
                            </div>

<!--                            <div class="teaminfo_team_m5photo"></div>-->
                        </div>


                </div>



                <div class="group_team_label">
                        <div class="group_team_label_wrap">
                            <img class="group_team_label_logo" src="team_img/<?= $row['code'] ?>/<?= $row['image'] ?>" alt="">
                        </div>
                        <content>
                            <h3><?= $row['name'] ?></h3>
                            <p><?= $row['members_qty'] ?>成員</p>
                        </content>

                </div>  <!--  end of  group_team_label-->

                <p class="teaminfo_conclusion">
                    團隊勝負 <?= is_null($row['win']) ? "F" : $row['win'] ?>勝 <?= is_null($row['lose']) ? "F" : $row['lose'] ?>敗<br/><br/>
                    最佳MVP：<?= empty($mvp_row['name']) ? "還沒有人唷~快去對戰吧!" : $mvp_row['name'] ?><br/>
                </p>

                <!--0415修改增加div-->

                <div class="littlemap">

                    <div class="slogan_info">
                        <h3>團隊座右銘:</h3>
                        <!--座右銘設定只能20字-->
                        <h3><?= $row['motto'] ?></h3>
                    </div>

                    <div class="team_intro_info">

                        <!--團隊介紹設定只能78字 訂80好了-->
                        <p>
                            團隊介紹:<br/>
                            <?= $row['intorduction'] ?>
                        </p>
                    </div>
                </div>

                <!--0415-->

                <?php if( empty($_SESSION['user']['team_sid']) ): ?>
                <a class="group_page_bt group_addteam_bt" href="">加入團隊</a>
                <?php endif; ?>
                <?php if (isset($_SESSION['user']['sid'])): ?>
                    <?php if( $row['leader_sid'] == $_SESSION['user']['sid'] ): ?>
                    <a class="group_page_bt group_manageteam_bt" href="manage_team.php?sid=<?= $_GET['sid'] ?>">管理團隊</a>
                    <?php endif; ?>
                <?php endif; ?>


                </div>   <!-- end of teaminfo_teaminfo-->

            <div class="teaminfo_vsinfo">

                <div class="teaminfo_vsinfo_win">
                    <h3>勝場數</h3>
                    <h2><?= is_null($row['win']) ? "F" : $row['win'] ?></h2>
                    <h3>勝</h3>
                </div>

                <div class="teaminfo_vsinfo_team_all">
                    <img class="teaminfo_littlesoilder" src="image/team_info_smallsoldier.png" alt="">
                    <h3>團隊統計資料</h3>
                    <div style="height: 230px; width: 185px;"><img class="teaminfo_vsinfo_team_logo" src="team_img/<?= $row['code'] ?>/<?= $row['image'] ?>" alt=""></div>
                    <h3><?= $row['name'] ?></h3>
                </div>

                <div class="teaminfo_vsinfo_lose">
                    <h3>擊殺數</h3>
                    <h2><?= is_null($row['lose']) ? "F" : $row['lose'] ?></h2>
                    <h3>次</h3>
                </div>






           </div>    <!--end of teaminfo_vsinfo-->
<!--0422新增-->
            <div class="target_photo">
                <img src="image/team_info_target2.png" style="" alt="">
            </div>
<!-- ---------------------------------------------------------  -->

            <div class="teaminfo_members_teaminfo">

                <ul class="teaminfo_members_teaminfo_head">
                    <li></li>
                    <li>幫會成員</li>
                    <li>參賽過場次</li>
                    <li>擊殺數</li>
                    <li>團隊貢獻數</li>
                    <li>KDA</li>
                </ul>

                <?php while ($allm_row = $allm_result->fetch_assoc()): ?>
                <ul class="teaminfo_members_teaminfo_list">
                    <li class="teaminfo_members_teaminfo_mphoto"><img src="<?= empty($allm_row['image']) ? "user_img/non_member.jpg" : 'user_img/' . $allm_row['hash'] . '/' . $allm_row['image'] ?>" alt=""></li>
                    <li><?= $allm_row['name'] ?></li>
                    <li><?= empty($allm_row['join_num']) ? "F" : $allm_row['join_num'] ?></li>
                    <li><?= empty($allm_row['kill_num']) ? "F" : $allm_row['kill_num'] ?></li>
                    <li><?= empty($allm_row['missoni_complete']) ? "F" : $allm_row['missoni_complete'] ?></li>
                    <li><?= empty($allm_row['kda']) ? "F" : $allm_row['kda'] ?></li>
                </ul>
                <?php endwhile; ?>


<!--                <a class="group_page_bt teaminfo_members_morebt" href="">查看更多</a>-->

            </div>


        </div> <!--  end of  teaminfo_warp-->






<script>

</script>



<?php include __DIR__ . '/__html_foot.php' ?>