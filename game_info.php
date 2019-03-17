<?php
require __DIR__ . '/__connect_db.php';

$dir = __DIR__. '/user_img/';

$pname = 'team';

if (isset($_SESSION['server'])){
    unset($_SESSION['server']);
}

if (isset($_SESSION['team_members'])){
    unset($_SESSION['team_members']);
}



//活動資訊------------------------
$p_sql = sprintf("SELECT * FROM `game` g JOIN `products` p ON g.`products_sid` = p.`sid` 
WHERE g.`sid` =". $_GET['sid']);

$p_result = $mysqli->query($p_sql);

$p_row = $p_result->fetch_assoc();



//團隊vs 下方隊員-----------------------

$sql = sprintf("SELECT * FROM `game` WHERE `sid` =". $_GET['sid']);

$result = $mysqli->query($sql);

$row = $result->fetch_assoc();

$ans = ( ($row['team1_win']>$row['team2_win'])||($row['team1_kill']>$row['team2_kill']) ? $row['team1_sid'] : $row['team2_sid'] ) ;

$ans2 = ( ($row['team1_win']<$row['team2_win'])||($row['team1_kill']<$row['team2_kill']) ? $row['team1_sid'] : $row['team2_sid'] )


?>

<?php include __DIR__.'/__html_head.php'?>
<link rel="stylesheet" href="css/game_info.css">
    <style>

        body {
            font-family: Microsoft JhengHei;
        }

    </style>

<?php include __DIR__ . '/__navbar.php' ?>

<!--   //  GROUP 頁面內容  -->


    <div class="gameinfo_warp">

        <div class="gameinfo_team_warp">

            <div class="gameinfo_winteam_info">
                <h1>賽後資訊</h1>
                <div class="gameinfo_vsinfo_win">
                    <h3>勝場數</h3>
                    <div class="svg_bk_draw">
                        <svg class="hello" x="0px" y="0px"
                             width="200" height="125px" viewBox="0 0 230.3 155.9">
                            <path d="M569,354.9c18.87.41,38.62,5.78,51.55,19.52s16.45,37.2,4.13,51.5c-6.86,8-17.28,12-27.61,13.84-13.6,2.45-30.13.3-37.1-11.64-5.62-9.64-2.56-22.52,4.62-31s17.66-13.53,28.07-17.54A236.91,236.91,0,0,1,689,364.08" transform="translate(-556.61 -354.4)"/>
                        </svg>
                    </div>
                    <h2><?= $row['team1_win']>$row['team2_win'] ? $row['team1_win'] : $row['team2_win'] ?></h2>
                    <h4>勝</h4>
                    <h3>擊殺數</h3>
                    <div class="svg_bk_draw">
                        <svg class="hello2" x="0px" y="0px"
                             width="200" height="125px" viewBox="0 0 230.3 155.9">
                            <path d="M569,354.9c18.87.41,38.62,5.78,51.55,19.52s16.45,37.2,4.13,51.5c-6.86,8-17.28,12-27.61,13.84-13.6,2.45-30.13.3-37.1-11.64-5.62-9.64-2.56-22.52,4.62-31s17.66-13.53,28.07-17.54A236.91,236.91,0,0,1,689,364.08" transform="translate(-556.61 -354.4)"/>
                        </svg>
                    </div>
                    <h2><?= $row['team1_kill']>$row['team2_kill'] ? $row['team1_kill'] : $row['team2_kill'] ?></h2>
                    <h4>次</h4>
                </div>

                <?php $twin_sql = sprintf("SELECT * FROM `team` WHERE `sid` =". $ans);

                $twin_result = $mysqli->query($twin_sql);

                $twin_row = $twin_result->fetch_assoc(); ?>

                <div class="gameinfo_game_info_win" >
                    <h2 class="result_type_win">WIN</h2>
                    <div class="group_team_label">
                        <div>
                            <img class="group_team_label_logo" src="team_img/<?= $twin_row['code'] ?>/<?= $twin_row['image'] ?>" alt="">
                        </div>
                        <content>
                            <h3><?= $twin_row['name'] ?></h3>
                            <p><?= $twin_row['members_qty'] ?>成員</p>
                            <?php if (empty($_SESSION['user']['team_sid'])): ?>
                                <a class="group_page_bt group_team_moreinfo_bt" href="">加入團隊</a>
                            <?php endif; ?>
                        </content>
                    </div>  <!--  end of  group_team_label-->

                    <div class="gameinfo_game_info_teamlogo_div" >
                        <img class="gameinfo_game_info_teamlogo" src="team_img/<?= $twin_row['code'] ?>/<?= $twin_row['bg_image'] ?>" alt="">
                    </div>

                    <div class="gameinfo_game_map">
                        <img src="image/<?= $p_row['ground'] ?>_map.jpg" alt="">
                    </div>

                </div>

            </div>  <!--end of gameinfo_winteam_info-->

            <div class="gameinfo_loseteam_info">

                <?php $tlose_sql = sprintf("SELECT * FROM `team` WHERE `sid` =". $ans2);

                $tlose_result = $mysqli->query($tlose_sql);

                $tlose_row = $tlose_result->fetch_assoc(); ?>

                <div class="gameinfo_game_info_lose" >
                    <h2 class="result_type_lose"> LOSE </h2>
                    <div class="group_team_label">
                        <div>
                            <img class="group_team_label_logo" src="team_img/<?= $tlose_row['code'] ?>/<?= $tlose_row['image'] ?>" alt="">
                        </div>
                        <content>
                            <h3><?= $tlose_row['name'] ?></h3>
                            <p><?= $tlose_row['members_qty'] ?>成員</p>
                            <?php if (empty($_SESSION['user']['team_sid'])): ?>
                            <a class="group_page_bt group_team_moreinfo_bt" href="">加入團隊</a>
                            <?php endif; ?>

                        </content>
                    </div>  <!--  end of  group_team_label-->

                    <div class="gameinfo_game_info_teamlogo_div">
                        <img class="gameinfo_game_info_teamlogo" src="team_img/<?= $tlose_row['code'] ?>/<?= $tlose_row['bg_image'] ?>" alt="">
                    </div>

                    <div class="gameinfo_game_detail">
                        <h3>遊戲時間：<?= date("Y-m-d", strtotime($p_row["date"])) ?><br/>
                            遊戲類型：<?= $p_row['ground'] ?><br/>
                            遊戲人數：<?= $p_row['people'] ?><br/>
                        </h3>
                    </div>

                </div>

                <div class="gameinfo_vsinfo_lose">
                    <h3>勝場數</h3>
                    <div class="svg_bk_draw">
                        <svg class="hello" x="0px" y="0px"
                             width="200" height="125px" viewBox="0 0 230.3 155.9">
                            <path d="M569,354.9c18.87.41,38.62,5.78,51.55,19.52s16.45,37.2,4.13,51.5c-6.86,8-17.28,12-27.61,13.84-13.6,2.45-30.13.3-37.1-11.64-5.62-9.64-2.56-22.52,4.62-31s17.66-13.53,28.07-17.54A236.91,236.91,0,0,1,689,364.08" transform="translate(-556.61 -354.4)"/>
                        </svg>
                    </div>
                    <h2><?= $row['team1_win']>$row['team2_win'] ? $row['team2_win'] : $row['team1_win'] ?></h2>
                    <h4>勝</h4>
                    <h3>擊殺數</h3>
                    <div class="svg_bk_draw">
                        <svg class="hello2" x="0px" y="0px"
                             width="200" height="125px" viewBox="0 0 230.3 155.9">
                            <path d="M569,354.9c18.87.41,38.62,5.78,51.55,19.52s16.45,37.2,4.13,51.5c-6.86,8-17.28,12-27.61,13.84-13.6,2.45-30.13.3-37.1-11.64-5.62-9.64-2.56-22.52,4.62-31s17.66-13.53,28.07-17.54A236.91,236.91,0,0,1,689,364.08" transform="translate(-556.61 -354.4)"/>
                        </svg>
                    </div>
                    <h2><?= $row['team1_kill']>$row['team2_kill'] ? $row['team2_kill'] : $row['team1_kill'] ?></h2>
                    <h4>次</h4>
                </div>

            </div>  <!--end of gameinfo_winteam_info-->

        </div>  <!-- end of gameinfo_team_warp-->\

        <div class="gameinfo_twoteam_wrap">
            <div class="gameinfo_twoteam_member_mvpdetail">

                <?php $mvpwin_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` =". $ans ." ORDER BY `kda` DESC,`kill_num`,`missoni_complete`,`join_num` LIMIT 1");

                $mvpwin_result = $mysqli->query($mvpwin_sql);

                $mvpwin_row = $mvpwin_result->fetch_assoc(); ?>

                <div class="gameinfo_winteam_mvp">
                    <h3><?= $mvpwin_row['name'] ?></h3>
<!--0418修改 外面包div-->
                    <div class="gameinfo_winteam_mvp_photo_wrap">
                    <img class="gameinfo_winteam_mvp_photo" src="user_img/<?= $mvpwin_row['hash']?>/<?= $mvpwin_row['image'] ?>" alt="">
                    </div>

<!-- ----------------------------------------------------  -->

                    <h3>MVP</h3>
                </div>

                <?php $mvplose_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` =". $ans2 ." ORDER BY `kda` DESC,`kill_num`,`missoni_complete`,`join_num` LIMIT 1");

                $mvplose_result = $mysqli->query($mvplose_sql);

                $mvplose_row = $mvplose_result->fetch_assoc(); ?>

                <div class="gameinfo_loseteam_mvp">
                    <h3><?= $mvplose_row['name'] ?></h3>

<!--0418修改 外面包div-->

                    <div class="gameinfo_loseteam_mvp_photo_wrap">
                        <img class="gameinfo_loseteam_mvp_photo" src="user_img/<?= $mvplose_row['hash']?>/<?= $mvplose_row['image'] ?>" alt="">
                    </div>
<!-- ----------------------------------------------------  -->
                    <h3>MVP</h3>

                </div>

            </div>  <!--end of gameinfo_twoteam_member_mvpdetail-->

            <div class="gameinfo_twoteam_member_detail">

                <div class="gameinfo_winteam_members winteam_members_left">

                    <?php $jwin_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` =". $ans ." ORDER BY `join_num` DESC,`kda`,`missoni_complete`,`kill_num` LIMIT 1");

                    $jwin_result = $mysqli->query($jwin_sql);

                    $jwin_row = $jwin_result->fetch_assoc(); ?>

                    <div class="gameinfo_winteam_helper">
                        <h3><?= $jwin_row['name'] ?></h3>
                        <!--0418修改 外面包div-->
                        <div class="gameinfo_winteam_helper_photo_wrap">
                                 <img class="gameinfo_winteam_helper_photo" src="user_img/<?= $jwin_row['hash'] ?>/<?= $jwin_row['image'] ?>" alt="">

                        </div>
                        <h3>助攻王</h3>
                        <!-- ---------------------------------- -->
                        <div class="gameinfo_markline"></div>
                    </div>

                    <div class="gameinfo_winteam_top4">

                        <?php $jwin_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` =". $ans ." ORDER BY `kill_num` DESC,`kda`,`missoni_complete`,`join_num` LIMIT 2");

                        $jwin_result = $mysqli->query($jwin_sql);

                        while ($jwin_row = $jwin_result->fetch_assoc()):  ?>

                        <div class="gameinfo_winteam_best">
                            <h3><?= $jwin_row['name'] ?></h3>
                            <!--0418修改 外面包div-->
                            <div class="gameinfo_winteam_best_photo_wrap">
                                 <img class="gameinfo_winteam_best_photo" src="user_img/<?= $jwin_row['hash'] ?>/<?= $jwin_row['image'] ?>" alt="">
                            </div>
                            <!-- ---------------------------------- -->
                            <h3>助攻手</h3>
                        </div>

                        <?php endwhile; ?>


                    </div>



                    <div class="gameinfo_winteam_top4">
                        <?php $mcwin_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` =". $ans ." ORDER BY `missoni_complete` DESC,`kda`,`kill_num`,`join_num` LIMIT 2");

                        $mcwin_result = $mysqli->query($mcwin_sql);

                        while ($mcwin_row = $mcwin_result->fetch_assoc()):  ?>
                        <div class="gameinfo_winteam_best70">
                            <h3><?= $mcwin_row['name'] ?></h3>
                            <!--0418修改 外面包div-->
                            <div class="gameinfo_winteam_best70_photo_wrap">
                                <img class="gameinfo_winteam_best70_photo" src="user_img/<?= $mcwin_row['hash'] ?>/<?= $mcwin_row['image'] ?>" alt="">
                            </div>
                            <!-- ---------------------------------- -->
                            <h3>任務達成率70%</h3>
                        </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="gameinfo_markline"></div>

                </div>



                <div class="gameinfo_winteam_members loseteam_members_right">

                    <?php $jlose_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` =". $ans2 ." ORDER BY `join_num` DESC,`kda`,`missoni_complete`,`kill_num` LIMIT 1");

                    $jlose_result = $mysqli->query($jlose_sql);

                    $jlose_row = $jlose_result->fetch_assoc(); ?>

                    <div class="gameinfo_winteam_helper">
                        <h3><?= $jlose_row['name'] ?></h3>
                        <!--0418修改 外面包div-->
                        <div class="gameinfo_winteam_helper_photo_wrap">
                            <img class="gameinfo_winteam_helper_photo" src="user_img/<?= $jlose_row['hash'] ?>/<?= $jlose_row['image'] ?>" alt="">

                        </div>
                        <h3>助攻王</h3>
                        <!-- ---------------------------------- -->
                        <div class="gameinfo_markline"></div>
                    </div>

                    <div class="gameinfo_winteam_top4">

                        <?php $jlose_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` =". $ans2 ." ORDER BY `kill_num` DESC,`kda`,`missoni_complete`,`join_num` LIMIT 2");

                        $jlose_result = $mysqli->query($jlose_sql);

                        while ($jlose_row = $jlose_result->fetch_assoc()):  ?>

                            <div class="gameinfo_winteam_best">
                                <h3><?= $jlose_row['name'] ?></h3>
                                <!--0418修改 外面包div-->
                                <div class="gameinfo_winteam_best_photo_wrap">
                                    <img class="gameinfo_winteam_best_photo" src="user_img/<?= $jlose_row['hash'] ?>/<?= $jlose_row['image'] ?>" alt="">
                                </div>
                                <!-- ---------------------------------- -->
                                <h3>助攻手</h3>
                            </div>

                        <?php endwhile; ?>


                    </div>



                    <div class="gameinfo_winteam_top4">
                        <?php $mclose_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` =". $ans2 ." ORDER BY `missoni_complete` DESC,`kda`,`kill_num`,`join_num` LIMIT 2");

                        $mclose_result = $mysqli->query($mclose_sql);

                        while ($mclose_row = $mclose_result->fetch_assoc()):  ?>
                            <div class="gameinfo_winteam_best70">
                                <h3><?= $mclose_row['name'] ?></h3>
                                <!--0418修改 外面包div-->
                                <div class="gameinfo_winteam_best70_photo_wrap">
                                    <img class="gameinfo_winteam_best70_photo" src="user_img/<?= $mclose_row['hash'] ?>/<?= $mclose_row['image'] ?>" alt="">
                                </div>
                                <!-- ---------------------------------- -->
                                <h3>任務達成率70%</h3>
                            </div>
                        <?php endwhile; ?>
                    </div>





                    <div class="gameinfo_markline"></div>

                </div>

                <!--<div class="gameinfo_loseteam_members">-->


                <!--</div>-->


            </div>




        </div> <!--end of gameinfo_twoteam_wrap-->
        </div> <!-- end of gameinfo_warp-->







    <div class="game_info_gallery">

        <!-- Insert to your webpage where you want to display the carousel -->
        <div id="amazingcarousel-container-1">
            <div id="amazingcarousel-1" style="display:none;position:relative;width:100%;max-width:1270px;margin:0px auto 0px;">
                <div class="amazingcarousel-list-container">
                    <ul class="amazingcarousel-list">
                        <li class="amazingcarousel-item">
                            <div class="amazingcarousel-item-container">
                                <div class="amazingcarousel-image"><img src="image/game_info_galleryphoto1.jpg"  alt="game_info_galleryphoto1" /></div>                    </div>
                        </li>
                        <li class="amazingcarousel-item">
                            <div class="amazingcarousel-item-container">
                                <div class="amazingcarousel-image"><img src="image/game_info_galleryphoto2.jpg"  alt="game_info_galleryphoto2" /></div>                    </div>
                        </li>
                        <li class="amazingcarousel-item">
                            <div class="amazingcarousel-item-container">
                                <div class="amazingcarousel-image"><img src="image/game_info_galleryphoto3.jpg"  alt="game_info_galleryphoto3" /></div>                    </div>
                        </li>
                    </ul>
                    <div class="amazingcarousel-prev"></div>
                    <div class="amazingcarousel-next"></div>
                </div>
                <div class="amazingcarousel-nav"></div>
                <div class="amazingcarousel-engine"><a href="http://amazingcarousel.com">JavaScript Scroller</a></div>
            </div>
        </div>
        <!-- End of body section HTML codes -->


    </div>












<script>

    //    0418 比數苗線動畫

    var draw = document.querySelector('.hello path');

    var tam = draw.getTotalLength();

    console.log(tam);


</script>

<?php include __DIR__ . '/__html_foot.php' ?>