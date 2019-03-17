<?php

require __DIR__ . '/__connect_db.php';

$pname = 'activity';

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


$m_sql = "SELECT p.`mode`, a.`mode_value`, a.`mode_intorduction` 
FROM `products` p INNER JOIN `activity_categories` a 
ON p.`mode` = a.`mode` WHERE p.sid = $sid";
$m_result = $mysqli->query($m_sql);
$m_row = $m_result->fetch_assoc();



$sql = "SELECT * FROM `products` WHERE `type` = $type AND `sid`= $sid";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();

if(!empty($_SESSION['activity_cart']) and !empty($_SESSION['user'])) {
    if (isset($_POST['name'])) {
        $a_sql = sprintf("INSERT INTO `check_form`(`sid`,`type`, `name`, `email`, `phone`, `members_id`) 
VALUES (NULL, 0,'%s','%s','%s','%s')",
            $_SESSION['activity_cart']['name'],
            $_SESSION['activity_cart']['email'],
            $_SESSION['activity_cart']['phone'],
            $_SESSION['user']['sid']
        );

        $a_success = $mysqli->query($a_sql);

// 寫入訂單
        $o_sql = sprintf("INSERT INTO `orders`(
      `sid`,`type`,`member_sid`, `amount`, `order_date`
      ) VALUES (
      NULL, %s, %s, %s, NOW()
      )",
            0,
            intval($_SESSION['user']['sid']),
            $_SESSION['activity_cart']['people_qty'] * $row['price']
        );
        $o_success = $mysqli->query($o_sql);

        $order_sid = $mysqli->insert_id;

// 寫入訂單明細


        $od_sql = sprintf("INSERT INTO `order_details`(
      `sid`, `order_sid`, `product_sid`, `price`, `quantity`
      ) VALUES (
      NULL, %s, %s, %s, %s
      )",
            $order_sid,
            $row['sid'],
            $row['price'],
            $_SESSION['activity_cart']['people_qty']
        );

        $od_success = $mysqli->query($od_sql);

        //計算目前人數
        $s_sql = sprintf("SELECT `now_people_qty` FROM `products` WHERE `sid` = %s",$_GET['sid']);

        $s_success = $mysqli->query($s_sql);

        $s_row = $s_success->fetch_array();

//        echo $s_row[0];
//        exit();

        $p_sql = sprintf("UPDATE `products` SET `now_people_qty` = %s WHERE `sid` = %s",
            ($s_row[0]+$_SESSION['activity_cart']['people_qty']), $_GET['sid'] );
//        echo $p_sql;
//        exit();
        $p_success = $mysqli->query($p_sql);

        if ($a_success && $o_success && $od_success) {
        header('Location: activity_list.php');
        }



    }
}

?>


<?php include __DIR__.'/__html_head.php'?>
    <link rel="stylesheet" href="css/activity_join_check.css">
    <style>

        body {
            font-family: Microsoft JhengHei;
        }

    </style>


<?php include __DIR__ . '/__navbar.php' ?>


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


        </div>

        <div class="join_content">

            <div class="join_content_inner flexbox">
                <h2>報名資料確認</h2>


                <form name="form1" method="post">
                    <p>您的報名資訊 <span>請再次確認你所填寫的資訊</span></p>
                    <div class="ttt">
                        <div class="form-group">
                            <label for="name">姓名</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $_SESSION['activity_cart']['name'] ?>" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label for="phone">聯絡電話</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= $_SESSION['activity_cart']['phone'] ?>" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label for="email">電子信箱</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?= $_SESSION['activity_cart']['email'] ?>" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label for="people_qty">參加人數</label>
                            <input type="text" class="form-control" id="people_qty" name="people_qty" value="<?= $_SESSION['activity_cart']['people_qty'] ?>" readonly="readonly">
                        </div>
                    </div>
                        <p>**請於填寫報名後3日內至本店場地現場付費 或 於活動當日前至現場付費</p>


                    <div class="btn flexbox">
                        <a class="btn1" href="activity_join.php?type=<?= $row["type"] ?>&sid=<?= $row["sid"] ?>">返回上頁修改</a>
<!--                        <a href="activity_list.php"><button type="submit" class="btn2">送出報名</button></a>-->
                        <button type="submit" class="btn2">送出報名</button>
                    </div>
                </form>

            </div>

        </div>




    </div>


<script>

    $('.btn2').click(function () {
        alert('資料送出成功！');
    });



    // 導覽列----------------------------------------
    var x = $('.active').data("x");
    $(".bottom_bar").css({marginLeft:x});

    $(".nav_li a").mouseover(function(){
        var x = $(this).parent(".nav_li").data("x");

        $(".bottom_bar").stop().animate({marginLeft:x}, 300);
    });

    $(".nav_li a").mouseout(function () {
        $(".nav_li ul").css(display="block");
            var x = $('.active').data("x");
            $(".bottom_bar").stop().animate({marginLeft: x}, 300);
    });

</script>

<?php include __DIR__ . '/__html_foot.php' ?>