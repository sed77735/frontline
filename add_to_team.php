<?php
require __DIR__ . '/__connect_db.php';



if(! isset($_SESSION['team_members'])) {
    $_SESSION['team_members'] = array();
}

if(isset($_GET['sid'])){
    $sid = intval($_GET['sid']);
    $name = isset($_GET['name']) ? $_GET['name'] : "";
//    echo $name;

    if(empty($name)){
        unset($_SESSION['team_members'][$sid]); // 刪除項目
    } else {
        $_SESSION['team_members'][$sid] = $name; // 設定
    }



//echo json_encode($_SESSION['team_members']); // 查詢



// 三個功能: 查詢, 設定, 刪除項目


//if(! empty($_SESSION['team_members'])) {

    $sids = array_keys($_SESSION['team_members']);

    $sql = sprintf("SELECT * FROM `members` WHERE `sid` IN (%s)", implode(',', $sids));

//echo $sids;
//echo $sql;

    $rs = $mysqli->query($sql);

    $member_data = array();

    while ($row = $rs->fetch_assoc()) {
        $row['name'] = $_SESSION['team_members'][$row['sid']];

        $member_data[$row['sid']] = $row;
    }

//}

?>

<!--<pre>-->
<!--print_r($member_data)-->
<!--</pre>-->

<?php if($_SESSION['team_members'][$sid]==$_SESSION['user']['name']):
    unset($_SESSION['team_members'][$sid]);?>
<!--    <tr id="find">-->
<!--        <td id="member_name" class="memberlist_username_id_add">--><?//=$row['name']?><!--</td>-->
<!--    </tr>-->
<?php else: ?>
    <?php foreach ($sids as $sid):
        $row = $member_data[$sid];
        ?>
        <tr>
            <td class="memberlist_username_id"><?=$row['name']?></td>
            <td class="memberlist_delete remove_btn" data-sid="<?= $row['sid'] ?>">剔除</td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>

<?php
}