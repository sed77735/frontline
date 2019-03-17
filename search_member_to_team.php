<?php
require __DIR__ . '/__connect_db.php';

//unset($_SESSION['user']);

//搜尋-------------------
$where = " WHERE 1 AND `name` NOT IN ('" . $_SESSION['user']['name'] . "')";

$search = isset($_POST['search']) ? $_POST['search'] : '';
if($search) {
    $search2 = $mysqli->escape_string( "%{$search}%" );
    $where .= sprintf(" AND `name` LIKE '%s'  ", $search2 );
//    $where .= sprintf(" AND (`email` LIKE '%s' OR `name` LIKE '%s' ) ", $search2, $search2);
}

$s_sql = sprintf("SELECT * FROM `members` %s", $where);

//echo $s_sql;
//exit;
$s_rs = $mysqli->query($s_sql);

?>


<?php while ($row = $s_rs->fetch_assoc()): ?>

    <tr id="find">
        <td id="" class="member_name memberlist_username_id_add"><?=$row['name']?></td>
        <td id="" class="add_btn memberlist_add" data-sid="<?= $row['sid'] ?>">新增</td>
    </tr>
<?php endwhile; ?>