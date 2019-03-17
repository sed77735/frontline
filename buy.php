<?php
require __DIR__ . '/__connect_db.php';

$pname = 'buy';

if (!empty($_SESSION['cart'])) {

    $sids = array_keys($_SESSION['cart']);

    $sql = sprintf("SELECT * FROM `products` WHERE `sid` IN (%s)", implode(',', $sids));

    $rs = $mysqli->query($sql);

    $cart_data = array();

    while ($row = $rs->fetch_assoc()) {
        $row['qty'] = $_SESSION['cart'][$row['sid']];

        $total += $row['qty']*$row['price'];

        $cart_data[$row['sid']] = $row;
    }
}

$o_sql = sprintf("INSERT INTO `orders`(
      `sid`, `type`, `member_sid`, `amount`, `order_date`
      ) VALUES (
      NULL,1 , %s, %s, NOW()
      )",intval($_SESSION['user']['sid'])
    , $total);
$mysqli->query($o_sql);
$order_sid = $mysqli->insert_id;

foreach ($_SESSION['cart'] as $sid=>$qty){

    $p_sql = sprintf("INSERT INTO `order_details`(
          `sid`, `order_sid`, `product_sid`, `price`, `quantity`
          ) VALUES (
          NULL, %s, %s, %s, %s
          )",
        $order_sid,
        $sid,
        $cart_data[$sid]['price'],
        $cart_data[$sid]['qty']
    );

    $mysqli->query($p_sql);

    unset($_SESSION['cart']);

    header('Location:product_list_test.php');
}
