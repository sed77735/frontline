<?php
require __DIR__ . '/__connect_db.php';



if(! isset($_SESSION['sel_members'])) {
    $_SESSION['sel_members'] = array();
}

if(isset($_GET['sid'])) {
    $sid = intval($_GET['sid']);
    $name = isset($_GET['name']) ? $_GET['name'] : "";
//    echo $name;

    if (empty($name)) {
        unset($_SESSION['sel_members'][$sid]); // 刪除項目
    } else {
        $_SESSION['sel_members'][$sid] = $name; // 設定
    }


}
//echo json_encode($_SESSION['team_members']); // 查詢



// 三個功能: 查詢, 設定, 刪除項目


//if(! empty($_SESSION['team_members'])) {

    $sids = array_keys($_SESSION['sel_members']);

    $sql = sprintf("SELECT * FROM `members` WHERE `sid` IN (0%s)", implode(',', $sids));

//echo $sids;
//echo $sql;

    $rs = $mysqli->query($sql);

    $member_data = array();

    while ($row = $rs->fetch_assoc()) {
        $row['name'] = $_SESSION['sel_members'][$row['sid']];

        $member_data[$row['sid']] = $row;
    }

//}

?>



    <?php foreach ($sids as $sid):
        $row = $member_data[$sid];
        ?>

        <div class="add_group_member_show" data-sid="<?= $row['sid'] ?>">
            <div class="add_group_member"><img src="<?= empty($row['image']) ? "user_img/non_member.jpg" : 'user_img/' . $row['hash'] . '/' . $row['image'] ?>" alt="">
            </div>
            <p class="add_group_member_username"><?= $row['name'] ?></p>
        </div>

    <?php endforeach; ?>

