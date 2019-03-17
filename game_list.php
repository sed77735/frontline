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



if( isset($_SESSION['user']) && ! empty($_SESSION['user']['team_sid']) ) {


    //個別撈資料-----------------------------------
    $m1_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` = ". $_SESSION['user']['team_sid'] ." ORDER BY `join_num` DESC LIMIT 3,1");

    $m1_result = $mysqli->query($m1_sql);

    $m1_row = $m1_result->fetch_assoc();


    $m2_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` = ". $_SESSION['user']['team_sid'] ." ORDER BY `join_num` DESC LIMIT 1,1");

    $m2_result = $mysqli->query($m2_sql);

    $m2_row = $m2_result->fetch_assoc();


    $m3_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` = ". $_SESSION['user']['team_sid'] ." ORDER BY `join_num` DESC LIMIT 0,1");

    $m3_result = $mysqli->query($m3_sql);

    $m3_row = $m3_result->fetch_assoc();


    $m4_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` = ". $_SESSION['user']['team_sid'] ." ORDER BY `join_num` DESC LIMIT 2,1");

    $m4_result = $mysqli->query($m4_sql);

    $m4_row = $m4_result->fetch_assoc();


    $m5_sql = sprintf("SELECT * FROM `members` WHERE `team_sid` = ". $_SESSION['user']['team_sid'] ." ORDER BY `join_num` DESC LIMIT 4,1");

    $m5_result = $mysqli->query($m5_sql);

    $m5_row = $m5_result->fetch_assoc();


    //團隊資訊--------------
    $t_sql = sprintf("SELECT m.name as mname FROM `team` t JOIN `members` m ON 
                        m.team_sid = t.sid WHERE t.sid =" . $_SESSION['user']['team_sid']);

    $t_result = $mysqli->query($t_sql);


    $n_sql = sprintf("SELECT * FROM `team` WHERE `sid` = " . $_SESSION['user']['team_sid']);

    $n_result = $mysqli->query($n_sql);

    $n_row = $n_result->fetch_assoc();


    $tm_sql = sprintf("SELECT * FROM `members` m JOIN `team` t ON m.team_sid = t.sid WHERE t.sid =" . $_SESSION['user']['team_sid']);

    $tm_result = $mysqli->query($tm_sql);

    $tm_row = $tm_result->num_rows;
}

    //團隊列表---------------
//    $sql = sprintf("SELECT * FROM `team` WHERE `public` = 'public'");
//
//    $result = $mysqli->query($sql);

    //團隊vs------------------------

    $g1_sql = sprintf("SELECT * FROM `game` g JOIN `team` t ON g.team1_sid = t.sid");

    $g1_result = $mysqli->query($g1_sql);

//    $g1_row = $g1_result->fetch_assoc();

    $g2_sql = sprintf("SELECT * FROM `game` g JOIN `team` t ON g.team2_sid = t.sid");

    $g2_result = $mysqli->query($g2_sql);

//    $g2_row = $g2_result->fetch_assoc();


//SELECT * FROM `team` t JOIN `members` m ON t.sid = m.team_sid WHERE t.sid = 2
    $sql = sprintf("SELECT * FROM `game`");

    $result = $mysqli->query($sql);

    $row = $result->num_rows;
//    echo $row;

//for ($i=1;$i<=$row;$i++):
//            endfor;




//排行榜---------------------------------------------------------------

$g_sql = sprintf("SELECT * FROM `game`");

$g_result = $mysqli->query($g_sql);
//
//$g_row = $g_result->fetch_assoc();

$g_round_ar = array();
$g_row_arr = array();
while($g_row=$g_result->fetch_assoc()){
    $g_round_ar[] = $g_row;
    $g_row_arr[$g_row['team1_sid']]=1;
    $g_row_arr[$g_row['team2_sid']]=1;
}
$keys = array_keys($g_row_arr);
$t1_sql = sprintf("SELECT * FROM `team` WHERE sid IN (%s)", implode(',',$keys ));
//echo $t1_sql;

$t1_result = $mysqli->query($t1_sql);

$member_data = array();

while ($t1_row = $t1_result->fetch_assoc()) {
//    $row['qty'] = $_SESSION['cart'][$row['sid']];

    $member_data[$t1_row['sid']] = $t1_row;
}


?>

<!--<pre>-->
<?php //print_r($g_round_ar); ?>
<?php //print_r($g_row_arr); ?>
<?php //print_r($member_data); ?>
<!--</pre>-->


<?php include __DIR__.'/__html_head.php'?>
    <link href='image/favicon.ico' rel='icon' type='image/x-icon'/>
<link rel="stylesheet" href="css/game_list.css">
    <style>

        body {
            font-family: Microsoft JhengHei;
        }

    </style>

<?php include __DIR__ . '/__navbar.php' ?>


<!--   //  GROUP 頁面內容  -->


        <div class="group_wrap">

    <?php if ( empty($_SESSION['user']['team_sid'])): ?>

    <div class="group_noteam">

        <div>
            <img src="image/photo_01.jpg" alt="">
        </div>
        <h2>排行榜</h2>
        <div class="group_noteam_leftinfo">
            <p>您想提高自己的聲望嗎？不想再獨自一人在戰場上<br/>
                孤軍奮戰或別想再跟豬隊友被高手壓制了嗎?<br/>
                現在就建立一個屬於自己的強悍團隊<br/>
                邀請親朋好友一同組織戰力堅強的陣容
            </p>
        </div>

        <div class="group_noteam_rightinfo">
            <p>建立團隊立刻享有:<br/>
                在排行榜上積分排名<br/>
                上傳自製徽章<br/>
                最多50人的龐大團隊<br/>
                與其他團隊專屬的約戰活動<br/>
                隊員的積分與技巧分析
            </p>
        </div>
        <!--<a class="group_addteam_bt" href="">加入團隊</a>-->

    </div>  <!--end of group_wrap-->
    <?php else: ?>

    <div class="group_hasteam">

        <h2>排行榜</h2>

<!--        <a class="group_addteam_bt" href="create_team.html">建立團隊</a>-->
        <div class="group_member_info_wrap">
            <div class="group_member_info">
                <div class="m1 m mss"> <p><?= $m1_row['name'] ?></p> <img src="<?= empty($m1_row['image']) ? "user_img/non_member.jpg" : 'user_img/' . $m1_row['hash'] . '/' . $m1_row['image'] ?>" alt=""> </div>
                <div class="m2 m ms"> <p><?= $m2_row['name'] ?></p> <img src="<?= empty($m2_row['image']) ? "user_img/non_member.jpg" : 'user_img/' . $m2_row['hash'] . '/' . $m2_row['image'] ?>" alt=""> </div>
                <div class="m3 m"> <p><?= $m3_row['name'] ?></p> <img src="<?= empty($m3_row['image']) ? "user_img/non_member.jpg" : 'user_img/' . $m3_row['hash'] . '/' . $m3_row['image'] ?>" alt=""> </div>
                <div class="m4 m ms"> <p><?= $m4_row['name'] ?></p> <img src="<?= empty($m4_row['image']) ? "user_img/non_member.jpg" : 'user_img/' . $m4_row['hash'] . '/' . $m4_row['image'] ?>" alt=""> </div>
                <div class="m5 m mss"> <p><?= $m5_row['name'] ?></p> <img src="<?= empty($m5_row['image']) ? "user_img/non_member.jpg" : 'user_img/' . $m5_row['hash'] . '/' . $m5_row['image'] ?>" alt=""> </div>
            </div>
        </div>
        <div class="group_hasteam_label js-tilt" data-tilt="" data-tilt-max="20" data-tilt-axis="x" data-tilt-perspective="250">
            <div class="group_team_label_logo js-tilt" data-tilt="" data-tilt-speed="250" data-tilt-max="20" data-tilt-axis="x" data-tilt-perspective="250">
                <img src="team_img/<?= $n_row['code'] ?>/<?= $n_row['image'] ?>" alt="">
            </div>

            <content>
                <h3><?= $n_row['name'] ?></h3>
                <p><?= $tm_row ?>成員</p>

                <a href="team_info.php?sid=<?= $_SESSION['user']['team_sid'] ?>">我的團隊</a>
            </content>
<!--            <a>我的團隊</a>-->
        </div>  <!--  end of  group_team_label -->

            </div>  <!--end of group_noteam-->

    <?php endif; ?>


            </div>  <!--end of group_wrap-->

        <div class="ratinglists_wrap">

            <?php  foreach($g_round_ar as $gr):
                $team1 = $member_data[$gr['team1_sid']];
                $team2 = $member_data[$gr['team2_sid']];

                ?>
            <div class="rating_gameHistory">

                <div class="rating_win_team">
                    <div class="win">
                        <img class="group_team_label_logo" src="team_img/<?= $team1['code'] ?>/<?= $team1['image'] ?>" alt="">
                    </div>
                    <content>
                        <h3><?= $team1['name'] ?></h3>
                        <p><?= $team1['members_qty'] ?>成員</p>
                        <a href="team_info.php?sid=<?= $team1['sid'] ?>">團隊資訊</a>
                    </content>
                </div>  <!--  end of  group_team_label-->


                <div class="rating_game_info">
                    <div class="rating_game_info_teams">
                        <img src="team_img/<?= $team1['code'] ?>/<?= $team1['bg_image'] ?>" alt="">
                        <img src="team_img/<?= $team2['code'] ?>/<?= $team2['bg_image'] ?>" alt="">
                    </div>

                    <a href="game_info.php?sid=<?= $gr['sid'] ?>"> 賽後資訊</a>

                    <h3>比賽比數</h3>
                    <p><?= $gr['team1_win'] ?> vs <?= $gr['team2_win'] ?></p>
                </div>


                <div class="rating_lose_team">
                    <div class="lose">
                        <img class="group_team_label_logo" src="team_img/<?= $team2['code'] ?>/<?= $team2['image'] ?>" alt="">
                    </div>
                    <content>
                        <h3><?= $team2['name'] ?></h3>
                        <p><?= $team2['members_qty'] ?>成員</p>
                        <a href="team_info.php?sid=<?= $team2['sid'] ?>">團隊資訊</a>
                    </content>
                </div>

            </div>  <!--   enf of rating_gameHistory  -->
            <?php  endforeach; ?>

        </div> <!--  end of  ratinglists_wrap  -->




    <!--0418新增 扭扭扭js-->
    <script src="lib/tilt.jquery.js"></script> <!-- Load Tilt.js library -->
    <!-- ------------------------------- -->

    <script >
        $('.js-tilt').tilt({
            axis: "x"
        })
    </script>

<?php include __DIR__ . '/__html_foot.php' ?>