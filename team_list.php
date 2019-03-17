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


//if (! isset($_SESSION['user'])){
//    header("Location: members.php");
//}

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
    $sql = sprintf("SELECT * FROM `team` WHERE `public` = 'public' ORDER BY rand()");

    $result = $mysqli->query($sql);



?>


<?php include __DIR__.'/__html_head.php'?>
<link rel="stylesheet" href="css/team_list.css">
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
        <h2>團隊列表</h2>
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

        <h2>團隊列表</h2>

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
        <!--0421增加 扭扭扭data標籤-->
        <div class="group_hasteam_label js-tilt" data-tilt="" data-tilt-max="20" data-tilt-axis="x" data-tilt-perspective="250">
            <div class="group_team_label_logo js-tilt" data-tilt="" data-tilt-speed="250" data-tilt-max="20" data-tilt-axis="x" data-tilt-perspective="250">
                <!-- ---------------------------------  -->
                <img src="team_img/<?= $n_row['code'] ?>/<?= $n_row['image'] ?>" alt="">
            </div>

            <content>
                <h3><?= $n_row['name'] ?></h3>
                <p><?= $tm_row ?>成員</p>

                <a href="team_info.php?sid=<?= $_SESSION['user']['team_sid'] ?>">我的團隊</a>
            </content>
<!--            <a>我的團隊</a>-->
        </div>  <!--  end of  group_team_label -->

    </div> <!--end of group_hasteam-->

    <?php endif; ?>


</div>  <!--end of group_wrap-->


<div class="group_teamlists_wrap">


    <?php while ($row = $result->fetch_assoc()): ?>
<!--        --><?php //$m_sql = sprintf("SELECT * FROM `members` m JOIN `team` t ON m.team_sid = t.sid WHERE t.sid =". $row['sid'] );

//        $m_result = $mysqli->query($m_sql);

//        $m_row = $m_result->num_rows; ?>

        <!--0421增加 扭扭扭data標籤-->
        <div class="group_team js-tilt" data-tilt="" data-tilt-speed="250" data-tilt-max="20" data-tilt-axis="x" data-tilt-perspective="250">
            <div class="group_team_bk">
                <img src="team_img/<?= $row['code'] ?>/<?= $row['bg_image'] ?>" alt="">
            </div>

            <div class="group_team_label js-tilt" data-tilt="" data-tilt-speed="250" data-tilt-max="20" data-tilt-axis="x" data-tilt-perspective="250">
                <!-- ---------------------------- -->
            <div class="group_team_label_logo">
                <img src="team_img/<?= $row['code'] ?>/<?= $row['image'] ?>" alt="">
            </div>
            <content>
                <h3><?= $row['name'] ?></h3>
                <p><?= $row['members_qty'] ?>成員</p>
            </content>
        </div>  <!--  end of  group_team_label-->

        <div class="group_team_info">
            <p><?= $row['intorduction'] ?><br/>

            </p>
            <a href="team_info.php?sid=<?= $row['sid'] ?>">關於更多</a>
            <content>
                <h3>團隊勝負<br/></h3>
                <div>
                    <h4><?= is_null($row['win']) ? "F" : $row['win'] ?></h4><p>勝</p><h4><?= is_null($row['lose']) ? "F" : $row['lose'] ?></h4><p>敗</p>
                </div>
            </content>
        </div>

    </div>
    <?php endwhile;?>



</div> <!--  end of  group_teamlists_wrap-->


    <!--0418新增 扭扭扭js-->
    <script src="lib/tilt.jquery.js"></script> <!-- Load Tilt.js library -->
    <!-- ------------------------------- -->

    <script >
        $('.js-tilt').tilt({
            axis: "x"
        })
    </script>


<?php include __DIR__ . '/__html_foot.php' ?>