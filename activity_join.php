<?php

require __DIR__ . '/__connect_db.php';

$pname = 'activity';

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

if (! isset($_SESSION['activity_cart'])){
    $_SESSION['activity_cart']=array();
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



$sql = "SELECT * FROM `products` WHERE `type` = $type AND `sid`= $sid";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();



if(isset($_POST['name'])){
    $_SESSION['activity_cart'] = $_POST;
    header('Location: activity_join_check.php?type=' . $row["type"] . '&sid=' . $row["sid"]);
}


?>


<?php include __DIR__.'/__html_head.php'?>
<link rel="stylesheet" href="css/activity_join.css">
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
                <h2>報名資料填寫</h2>
                <form name="form1" method="post" onsubmit="return checkForm();">
                    <?php if(empty($_SESSION['activity_cart'])): ?>
                    <div class="form-group">
                        <label for="name">姓名</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $_SESSION['user']['name'] ?>">
                        <span class="info"></span>
                    </div>
                    <div class="form-group">
                        <label for="phone">聯絡電話</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $_SESSION['user']['phone'] ?>">
                        <span class="info"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">電子信箱</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?= $_SESSION['user']['email'] ?>">
                        <span class="info"></span>
                    </div>
                    <div class="form-group">
                        <label for="people">參加人數</label>
                        <select name="people_qty" class="people_qty1">
                            <option selected="true" value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div>
                    <?php else: ?>
                    <div class="form-group">
                        <label for="name">姓名</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $_SESSION['activity_cart']['name'] ?>">
                        <span class="info"></span>
                    </div>
                    <div class="form-group">
                        <label for="phone">聯絡電話</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $_SESSION['activity_cart']['phone'] ?>">
                        <span class="info"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">電子信箱</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?= $_SESSION['activity_cart']['email'] ?>">
                        <span class="info"></span>
                    </div>
                    <div class="form-group">
                        <label for="people_qty">參加人數</label>
                        <select name="people_qty" class="people_qty" data-qty="<?= $_SESSION['activity_cart']['people_qty'] ?>">
                            <?php for($i=1; $i<=6; $i++): ?>
                                <option value="<?=$i?>"><?=$i?></option>
                            <?php endfor ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <div class="rule">
                        <label for="address">報名須知</label><span>**請詳細閱讀下列報名/遊戲說明</span>
                        <textarea name="" id="" cols="30" rows="10" disabled="disabled">
一、報名規範
1.付款
大前線的活動報名繳費方式一律以現場繳費方式
2.查詢活動
在您報名完成或者將活動加入追蹤後，可以在您的會員中心查看訂單與追蹤清單，了解活動的最新動向。
3.活動人數
若報名人數不足將順延活動舉辦日期。
4.候補位服務
若活動舉行當天，有報名者臨時無法參加缺席，大前線提供現場候補位的服務。

二、場內禮儀
1.請玩家遵守遊戲的陣亡規則，遵守舉辦人所提出的活動規範，讓所有玩家能夠擁有良好的遊戲體驗。
3.若有爭執，大前線工作人員會介入了解情況，若發生肢體衝突並且屢勸不聽，
大前線保留將玩家逐出場館並報警的權利，避免影響其他玩家的權利。

三、聯絡
任何問題請聯絡活動主辦人，也歡迎使用大前線的客服信箱，或撥打客服專線，將有專人為您服務。

                            </textarea>
                        <p>**請於活動當日前至現場付費</p>
                    </div>


                    <div class="btn flexbox">
                        <a class="btn1" href="single_activity.php?type=<?= $row["type"] ?>&sid=<?= $row["sid"] ?>">返回活動列表</a>
<!--                        <a class="btn2" href="activity_join.php?type=--><?//= $row["type"] ?><!--&sid=--><?//= $row["sid"] ?><!--">送出報名</a>-->
                        <button type="submit" class="btn2">確認</button>
                    </div>
                </form>

            </div>

        </div>




    </div>


<script>

    var qty_sels = $('select.people_qty');

    qty_sels.each(function(){
        var qty = $(this).attr('data-qty');
        $(this).val(qty);
    });

    function checkForm(){
        var $email = $('#email');
        var $name = $('#name');
        var $phone = $('#phone');

        var items = [$email, $name, $phone];

        var email = $email.val();
        var name = $name.val();
        var phone = $phone.val();

        var i;
        var pattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        var isPass = true;



        for(i=0; i<items.length; i++){
            items[i].closest('.form-group').find('.info').text('');
        }

        if(! pattern.test(email)){
            $email.closest('.form-group').find('.info').text(' E-mail格式不正確 !');
            isPass = false;
        }

        if(! email){
            $email.closest('.form-group').find('.info').text(' 請填寫E-mail !');
            isPass = false;
        }


        if(name.length < 2){
            $name.closest('.form-group').find('.info').text(' 請填寫真實姓名!');
            isPass = false;
        }


        if(! phone){
            $phone.closest('.form-group').find('.info').text(' 請填寫電話 !');
            isPass = false;
        }


        return isPass;



    }

</script>

<?php include __DIR__ . '/__html_foot.php' ?>