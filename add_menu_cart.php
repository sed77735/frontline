<?php
require __DIR__ . '/__connect_db.php';

if(! isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if(isset($_POST['sid'])){
    $sid = intval($_POST['sid']);
    $qty = isset($_POST['qty']) ? intval($_POST['qty']) : 0;

    if ($qty==0){
        unset($_SESSION['cart'][$sid]);
    } else {
        $_SESSION['cart'][$sid] = $qty;
    }

}

//echo json_encode($_SESSION['cart']);


if (!empty($_SESSION['cart'])) {

    $sids = array_keys($_SESSION['cart']);

    $sql = sprintf("SELECT * FROM `products` WHERE type=1 AND `sid` IN (%s)", implode(',', $sids));

    $rs = $mysqli->query($sql);

    $cart_data = array();

    while ($row = $rs->fetch_assoc()) {
        $row['qty'] = $_SESSION['cart'][$row['sid']];
        $cart_data[$row['sid']] = $row;
    }
}

$total = 0;
foreach ($_SESSION['cart'] as $sid => $qty):
    $row = $cart_data[$sid];
//    $total += $row['price'] * $row['qty'];

?>

<!--    0418修改 與新增改CSS-->
            <li>
                <div class="cart_menu_div">
                    <div class="cart_menu_product_photo">
                        <img style="width: 100%;height: 100%;" src="imgs/small/<?= $row['head_image'] ?>.jpeg" alt="">
                    </div>
                    <p class="cart_menu_price">價格:<?= $row['price'] ?></p>
                    <p class="cart_menu_qty">數量:<?= $row['qty'] ?></p>

                </div>
                <div class="cart_menu_div"><p class="cart_menu_product_name"><?= $row['name'] ?></p></div></li>


<!--    ------------------------------------------------  -->

        <?php  endforeach; ?>