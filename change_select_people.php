<?php
require __DIR__ . '/__connect_db.php';


$ground = isset($_POST['ground']) ? intval($_POST['ground']) : 0;



$sql = sprintf("SELECT * FROM `activity_selected` WHERE `people_sel_sid` = ". $ground);
//echo $sql;
$result = $mysqli->query($sql);


?>


<?php while ($row = $result->fetch_assoc()): ?>
    <option value="<?= $row['people_sel'] ?>"><?= $row['people_sel'] ?></option>
<?php endwhile; ?>

