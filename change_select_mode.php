<?php
require __DIR__ . '/__connect_db.php';


$ground = isset($_POST['ground']) ? intval($_POST['ground']) : 0;



$sql = sprintf("SELECT * FROM `activity_selected` WHERE `mode_sel_sid` = ". $ground);
//echo $sql;
$result = $mysqli->query($sql);


?>


<?php while ($row = $result->fetch_assoc()): ?>
    <option value="<?= $row['mode_sel'] ?>"><?= $row['mode_sel'] ?></option>
<?php endwhile; ?>

