<?php

require __DIR__ . '/__connect_db.php';

$pname = 'activity';

if (isset($_SESSION['activity_cart'])){
    unset($_SESSION['activity_cart']);
}


if (isset($_SESSION['server'])){
    unset($_SESSION['server']);
}

if (isset($_SESSION['team_members'])){
    unset($_SESSION['team_members']);
}




$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
$type = isset($_GET['type']) ? intval($_GET['type']) : 1;

$s_sql = "SELECT * FROM `products` WHERE `sid` = $sid";
$s_result = $mysqli->query($s_sql);

if (!$s_result->num_rows||!$type==0){
    header("Location: activity_list.php");
    exit;
}



$p_sql = "SELECT p.`people`, a.`people_value`, a.`total_people`
FROM `products` p INNER JOIN `activity_categories` a
ON p.`people` = a.`people` WHERE p.sid = $sid";
$p_result = $mysqli->query($p_sql);
$p_row = $p_result->fetch_assoc();


$g_sql = "SELECT p.`ground`, a.`ground_value`, a.`ground_intorduction` 
FROM `products` p INNER JOIN `activity_categories` a 
ON p.`ground` = a.`ground` WHERE p.sid = $sid";
$g_result = $mysqli->query($g_sql);
$g_row = $g_result->fetch_assoc();


$m_sql = "SELECT p.`mode`, a.`mode_value`, a.`mode_intorduction` , a.`mode_win_condition`
FROM `products` p INNER JOIN `activity_categories` a 
ON p.`mode` = a.`mode` WHERE p.sid = $sid";
$m_result = $mysqli->query($m_sql);
$m_row = $m_result->fetch_assoc();

$m2_sql = "SELECT p.`mode2`, a.`mode_value`, a.`mode_intorduction` , a.`mode_win_condition`
FROM `products` p INNER JOIN `activity_categories` a 
ON p.`mode2` = a.`mode` WHERE p.sid = $sid";
$m2_result = $mysqli->query($m2_sql);
$m2_row = $m2_result->fetch_assoc();



$sql = "SELECT * FROM `products` WHERE `type` = $type AND `sid`= $sid";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();


$mhost_sql = "SELECT m.name as mname, m.image as mimage, m.email as memail, m.hash as mhash
                FROM `products` p JOIN `members` m
                ON p.members_sid = m.sid WHERE p.sid =".$_GET['sid'];

$mhost_result = $mysqli->query($mhost_sql);
$mhost_row = $mhost_result->fetch_assoc();

$thost_sql = "SELECT m.name as mname, m.image as mimage, m.email as memail, m.hash as mhash, 
                t.sid as tsid, t.name as tname, t.image as timage, t.code as tcode FROM `products` p JOIN `members` m 
                ON p.members_sid = m.sid JOIN `team` t 
                ON p.team_sid = t.sid WHERE p.sid =".$_GET['sid'];

$thost_result = $mysqli->query($thost_sql);
$thost_row = $thost_result->fetch_assoc();


?>

<?php include __DIR__.'/__html_head.php'?>
    <link rel="stylesheet" href="css/single_activity.css">
    <style>

        body {
            font-family: Microsoft JhengHei;
        }

    </style>

    <?php include __DIR__ . '/__navbar.php' ?>


</head>
<body>
    <div class="activity_wrap">

        <div class="activity_title flexbox">

            <div class="activity_title_left">
                <div class="activity_title_img flexbox">
                    <img src="activity_img/<?= $row['head_image'] ?>" alt="">
                </div>
                <div class="flexbox">
                    <h2><?= $row['name'] ?></h2>
                    <p><?= $row['host'] ?></p>
                </div>
                <span>進行中</span>
            </div>
            <div class="activity_title_info">
                <ul class="flexbox">
                    <li><p>地形</p><span><?= $row['ground'] ?></span></li>
                    <?php if ($row['game_qty']==2): ?>
                    <li class="flexbox"><p>遊戲模式</p><div><img src="image/<?= $row['mode'] ?>.png" alt=""></div><span><?= $row['mode'] ?></span>
                        <div><img src="image/<?= $row['mode2'] ?>.png" alt=""></div><span><?= $row['mode2'] ?></span></li>
                    <?php else: ?>
                        <li class="flexbox"><p>遊戲模式</p><div><img src="image/<?= $row['mode'] ?>.png" alt=""></div><span><?= $row['mode'] ?></span></li>
                    <?php endif; ?>
                    <li><p>時間</p><span><?= date("Y-m-d H:i", strtotime($row["date"])) ?></span></li>
                    <li><p>目前人數</p><span><?= $row['now_people_qty'] ?> / <?= $p_row['total_people'] ?>人</span></li>
                    <li><p>參加費用</p><span><?= $row['price'] ?>元 / 每人</span></li>
                </ul>

            </div>

            <div class="join activity_title_join">
<!--                0415新增 span-->
                <a style="z-index: 100000;" href="activity_join.php?type=<?= $row["type"] ?>&sid=<?= $row["sid"] ?>"> <h2><span>報名參加</span></h2> </a>
<!--                -->
            </div>

        </div>

        <div class="activity_content">

            <div class="activity_content_inner flexbox">
                <div class="activity_content_left">
                    <h3>活動內容</h3><br/>
                            <p><?= $row['intorduction'] ?></p>
                        <br/>
                    <h3>場地介紹</h3><br/>
                            <h4>地形0<?= $g_row['ground_value'] ?>-<?= $row['ground'] ?></h4>
                        <br/>
                            <p><?= $g_row['ground_intorduction'] ?></p>
                        <br/>

                    <h3>遊戲方式</h3><br/>

                        <?php if ($row['game_qty']==2): ?>

                                <h4>場數1：<?= $m_row['mode'] ?></h4>
                                <p><?= $m_row['mode_intorduction'] ?></p>
                                <h4>獲勝條件</h4>
                                <p><?= $m_row['mode_win_condition'] ?></p>
                                <br/>
                                <h4>場數2：<?= $m2_row['mode2'] ?></h4>
                                <p><?= $m2_row['mode_intorduction'] ?></p>
                                <h4>獲勝條件</h4>
                                <p><?= $m_row['mode_win_condition'] ?></p>
                                <h4>人數：</h4><span id="people"><?= $row['people'] ?></span>
                            <br/>
                            <br/>
                        <?php else: ?>

                                <h4>場數1：<?= $m_row['mode'] ?></h4>
                                <p><?= $m_row['mode_intorduction'] ?></p>
                                <h4>獲勝條件</h4>
                                <p><?= $m_row['mode_win_condition'] ?></p>
                                <br/>
                                <h4>人數：</h4><span id="people"><?= $row['people'] ?></span>
                            <br/>
                            <br/>
                        <?php endif; ?>

                    <h3>裝備限制</h3><br/>
                            <p><?= $row['equip_limit'] ?></p>
                        <br/>
                    <h3>備註</h3><br/>
                            <p><?= $row['active_note'] ?></p>
                            <p>40人以上，每隊擁有2名醫護兵 <br/>
                                32人以下，每隊擁有1名醫護兵。<br/>
                                醫護兵：醫護兵擁有將隊友復活的能力，在隊友陣亡60秒內抵達，站在陣亡隊友旁計時30秒後復活隊友。醫護兵無法復活自己。
                            </p>
                        <br/>
                </div>

                <div class="activity_content_right">
                    <h3>主辦方</h3>
                    <div class="activity_host flexbox">
                        <br/>

                        <?php if($row['host']=="店家主辦"): ?>
                            <div id="self">
                                <img src="image/frontline_squad.jpg" alt="">
                            </div>
                        <?php else: ?>

                            <?php if($row['host']=="槍隊比賽"): ?>
                            <a class="flexbox" href="team_info.php?sid=<?= $thost_row['tsid'] ?>">
                                <img src="team_img/<?= $thost_row['tcode'] ?>/<?= $thost_row['timage'] ?>" alt="">
                                <p><?= $thost_row['tname'] ?></p>
                            </a>
                            <?php endif; ?>

                            <div class="flexbox members_head">
<!--                                <img src="user_img/--><?//= $mhost_row['mhash']?><!--/--><?//= $mhost_row['mimage'] ?><!--" alt="">-->
                                <img src="<?= empty($mhost_row['mimage']) ? "user_img/non_member.jpg" : 'user_img/' . $mhost_row['mhash'] . '/' . $mhost_row['mimage'] ?>" alt="">
                                <p><?= $mhost_row['mname'] ?></p>
                            </div>
                            <p class="flexbox members_info">聯絡方式：<?= $mhost_row['memail'] ?></p>
                        <?php endif; ?>

                    </div>
                    <div class="activity_map">
                        <img src="image/<?= $row['ground'] ?>.jpg" alt="">
                        <div> <a href="ground.php"> 查看場地 </a> </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="join flexbox"> <a href="activity_join.php?type=<?= $row["type"] ?>&sid=<?= $row["sid"] ?>"> <h2>報名參加</h2> </a> </div>





    </div>


<?php include __DIR__ . '/__html_foot.php' ?>