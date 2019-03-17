<?php
require __DIR__ . '/__connect_db.php';


//SELECT * FROM `products` WHERE `type` = 0 ORDER BY `products`.`date` ASC  舊到新 value=3
//SELECT * FROM `products` WHERE `type` = 0 ORDER BY `products`.`date` DESC  新到舊 value=2


$people = isset($_POST['people']) ? intval($_POST['people']) : 0;

$date = isset($_POST['date']) ? intval($_POST['date']) : 0;

$ground = isset($_POST['ground']) ? intval($_POST['ground']) : 0;

$mode = isset($_POST['mode']) ? intval($_POST['mode']) : 0;

$host = isset($_POST['host']) ? intval($_POST['host']) : 0;

$where = " WHERE `type` = 0 AND `activated` = 1";

if ($people) {
    $where .= " AND `people` = $people ";
}

if ($ground) {
    $where .= " AND `ground` = $ground ";
}

if ($mode) {
    $where .= " AND ( `mode` = $mode OR `mode2` = $mode )";
}

if ($host) {
    $where .= " AND `host` = $host ";
}


if ($date==0) {
    $where .= " ORDER BY rand() ";
} elseif ($date==1) {
    $where .= " ORDER BY `date` ASC Limit 20 ";
} elseif ($date==2) {
    $where .= " ORDER BY `created_at` DESC ";
} elseif ($date==3) {
    $where .= " ORDER BY `created_at` ASC ";
}

$sql = sprintf("SELECT * FROM `products`". $where);
//echo $sql;
$result = $mysqli->query($sql);
//echo $sql;
?>

<?php while ($row = $result->fetch_assoc()): ?>
    <div class="item_activity">
        <div class="activity_img">
            <a href="single_activity.php?type=<?= $row["type"] ?>&sid=<?= $row["sid"] ?>">
                <img src="activity_img/<?= $row['head_image'] ?>" alt="">
                <p> <?= $row["name"] ?></p>
                <span>進行中</span>
            </a>
        </div>
        <div class="info">
            <ul>
                <li><h4>遊戲日期：</h4><br/>&nbsp;&nbsp;&nbsp;&nbsp;<?= date("Y-m-d  H:i", strtotime($row["date"])) ?></li>
                <li><h4>地形：</h4><br/>&nbsp;&nbsp;&nbsp;&nbsp;<?= $row["ground"] ?></li>
                <?php if ($row['game_qty']==1): ?>
                    <li><h4>遊戲模式：</h4><br/>
                    &nbsp;&nbsp;&nbsp;&nbsp;第一場：<?= $row["mode"] ?>
                <?php else: ?>
                    <li><h4>遊戲模式：</h4><br/>
                        &nbsp;&nbsp;&nbsp;&nbsp;第一場：<?= $row["mode"] ?><br/>
                        &nbsp;&nbsp;&nbsp;&nbsp;第二場：<?= $row["mode2"] ?></li>
                <?php endif; ?>
                <li><h4>報名人數：</h4><br/>&nbsp;&nbsp;&nbsp;&nbsp;<?= $row["people"] ?></li>
                <li><h4>主辦單位：</h4><br/>&nbsp;&nbsp;&nbsp;&nbsp;<?= $row["host"] ?></li>
            </ul>
            <ul class="flexbox">
                <li><a href="activity_join.php?type=<?= $row["type"] ?>&sid=<?= $row["sid"] ?>">報名參加</a></li>
                <!--                                    <li><i class="fa fa-heart-o fa-2x like_btn" aria-hidden="true" data-sid="--><?//= $row['sid'] ?><!--"></i></li>-->
                <!--                                    <li><img class="join_img like_btn" src="image/wishlist.png" alt=""  data-sid="--><?//= $row['sid'] ?><!--"></li>-->
                <!--                                    <i class="buy_btn fa fa-shopping-cart fa-2x cart_icon" data-sid="--><?//= $row['sid'] ?><!--"></i>-->
                <?php
                if(isset($_SESSION['user'])){
                    $like_p_sid = $row['sid'];
                    $member = $_SESSION['user']['sid'];

                    $search_sql="SELECT * FROM `like_products` WHERE products_sid=$like_p_sid AND member_sid=$member";
                    $search_rs = $mysqli->query($search_sql);

                    $search_like = $search_rs->fetch_assoc();

                    if($search_like['products_sid']==$row['sid']){
                        $class = 'likecolor';
                        ?>
                        <li><div class="cart_love like_btn <?=  $class ?>" aria-hidden="true" data-sid="<?= $row['sid'] ?>"></div></li>
                    <?php }else{ ?>
                        <li><div class="cart_love like_btn " aria-hidden="true" data-sid="<?= $row['sid'] ?>"></div></li>
                    <?php } ?>
                <?php }else{ ?>
                    <li><a href="members.php"><div class="cart_love like_btn " aria-hidden="true" data-sid="<?= $row['sid'] ?>"></div></a></li>
                <?php } ?>



            </ul>
        </div>
    </div>
<?php endwhile; ?>

