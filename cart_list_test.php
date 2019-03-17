<?php
require __DIR__ . '/__connect_db.php';

$pname = 'none';

if (isset($_SESSION['server'])){
    unset($_SESSION['server']);
}

if (isset($_SESSION['team_members'])){
    unset($_SESSION['team_members']);
}


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

?>



<?php include __DIR__.'/__html_head.php'?>

<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
<script src="js/jquery.bxslider.js"></script>
<link rel="stylesheet" href="css/cart_list_test.css">
<style>

    /*nav*/
    * {
        box-sizing: border-box;
    }
    body {
        font-family: Microsoft JhengHei;
    }

    li, p, h1, span, a {
        font-family: Microsoft JhengHei;
        font-size: 14px;
        color: #D5D5D5;
        text-decoration: none;
    }

    .nav > li > a:hover, .nav > li > a:focus {
        background-color: transparent;
    }

</style>

    <?php include __DIR__ . '/__navbar.php' ?>


<div class="wrap">
    <div class="abgne_tab">
        <ul class="tabs">
            <li class="active"><a href="#tab1">購物車</a></li>
            <li><a href="#tab2">檢視清單</a></li>
            <li><a href="#tab3">追蹤訂單</a></li>
        </ul>

        <div class="table_side" style="margin-bottom: 30px">

            <div id="tab1" class="tab_content" style="height: 550px;background: white;">
                <!--                <div style="height: 550px;width: 830px;background: white"></div>-->
                <?php if (!empty($_SESSION['cart'])): ?>

                    <table class="table table-bordered" style="background: white;">
                        <thead>
                        <tr>
                            <th>商品</th>
                            <th>商品名稱</th>
                            <th>規格</th>
                            <th>數量</th>
                            <th>價格</th>
                            <th>總計</th>
                            <th>變更</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = 0;
                        foreach ($_SESSION['cart'] as $sid => $qty):
                            $row = $cart_data[$sid];
                            $total += $row['price'] * $row['qty'];
                            ?>
                            <tr data-sid="<?= $row['sid'] ?>">
                                <td style="width: 140px;height: 120px"><img style="width: 100%;height: 100px"
                                                                            src="imgs/small/<?= $row['head_image'] ?>.jpeg"
                                                                            alt="">
                                </td>
                                <td style="width: 140px;"><?= $row['name'] ?></td>
                                <td style="width: 140px;"><?= $row['description_5'] ?><br>

                                </td>
                                <td style="width: 70px;height: 100px;line-height: 100px">
                                    <select name="qty" class="qty" data-qty="<?= $row['qty'] ?>">
                                        <?php for ($i = 1; $i < 10; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </td>
                                <td class="price" style="line-height: 100px;color: #e7418d;font-size: 16px;font-weight: bold;
                                    letter-spacing: 1px"><?= $row['price'] ?></td>
                                <td class="subtotal" style="line-height: 100px;color: #e7418d;font-size: 16px;font-weight: bold;
                                    letter-spacing: 1px"><?= $row['price'] * $row['qty'] ?></td>
                                <td class="change" style="padding: 0;">
                                    <span class="fa fa-times fa-2x cart_icon remove_item" aria-hidden="true"><p>移除項目</p></span>
<!---------------------------------------------------421更改------------------------------------>
                                    <?php
                                    if(isset($_SESSION['user'])){
                                        $like_p_sid = $row['sid'];
                                        $member = $_SESSION['user']['sid'];

                                        $search_sql="SELECT * FROM `like_products` WHERE products_sid=$like_p_sid AND member_sid=$member";
                                        $search_rs = $mysqli->query($search_sql);

                                        $search_like = $search_rs->fetch_assoc();

                                        if($search_like['products_sid']==$row['sid']){
                                            $class = 'likebtn';
                                            ?>

                                            <div class="fa cart_icon like_item <?=  $class ?>" aria-hidden="true"
                                                 data-like="<?= $like_row['products_sid'] ?>"><br><p>追蹤</p></div>
                                        <?php }else{ ?>
                                            <div class="fa cart_icon like_item" aria-hidden="true"
                                                 data-like="<?= $like_row['products_sid'] ?>"><br><p>加入追蹤</p></div>
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <div class="fa cart_icon like_item" aria-hidden="true"
                           移除                  data-like="<?= $like_row['products_sid'] ?>"><br><p>登入會員</p></div>
                                    <?php } ?>
                                    <!---------------------------------------------------421更改------------------------------------>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="people_side">
                        <?php
                        foreach ($_SESSION['cart'] as $sid => $qty):
                            $row = $cart_data[$sid];
                            if ($row['gun_sid'] == 1 or $row['gun_sid'] == 2):
                                ?>

                                <img style="position: absolute;top:0;left: 0;"
                                     src="imgs/solider/doll_03_main_weapon.png" alt="">
                            <?php endif; ?>


                            <?php if ($row['gun_sid'] == 14): ?>
                            <img style="position: absolute;top:0;left: 0;" src="imgs/solider/doll_01_head.png" alt="">

                        <?php endif; ?>

                            <?php if ($row['gun_sid'] == 15): ?>
                            <img style="position: absolute;top:0;left: 0;" src="imgs/solider/doll_02_gloves.png" alt="">
                        <?php endif; ?>

                            <?php if ($row['gun_sid'] == 3): ?>
                            <img style="position: absolute;top:0;left: 0;" src="imgs/solider/doll_04_pistol.png" alt="">
                        <?php endif; ?>

                            <?php if ($row['gun_sid'] == 21 or $row['gun_sid'] ==16): ?>
                            <img style="position: absolute;top:0;left: 0;" src="imgs/solider/doll_05_vest.png" alt="">
                        <?php endif; ?>

                            <?php if ($row['gun_sid'] == 20): ?>
                            <img style="position: absolute;top:0;left: 0;" src="imgs/solider/doll_06_clothes.png"
                                 alt="">
                        <?php endif; ?>

                            <?php if ($row['gun_sid'] == 22 ): ?>
                            <img style="position: absolute;top:0;left: 0;" src="imgs/solider/doll_08_pants.png" alt="">
                        <?php endif; ?>

                            <?php if ($row['gun_sid'] == 24 or $row['gun_sid'] ==29): ?>
                            <img style="position: absolute;top:0;left: 0;" src="imgs/solider/doll_09_boots.png" alt="">
                        <?php endif; ?>

                            <?php if ($row['gun_sid'] == 4 or $row['gun_sid'] ==5 or $row['gun_sid'] ==6 or $row['gun_sid'] ==7 or
                            $row['gun_sid'] ==8 or $row['gun_sid'] ==9 or $row['gun_sid'] ==10 or $row['gun_sid'] ==11 or
                            $row['gun_sid'] ==12 or $row['gun_sid'] ==13 or $row['gun_sid'] ==17 or $row['gun_sid'] ==18 or $row['gun_sid'] ==19): ?>
                            <img style="position: absolute;top:0;left: 0;" src="imgs/solider/doll_10_crate.png" alt="">
                        <?php endif; ?>

                            <?php if ($row['gun_sid'] == 23): ?>
                            <img style="position: absolute;top:0;left: 0;" src="imgs/solider/doll_07_kneepads.png"
                                 alt="">

                        <?php endif; ?>


                        <?php endforeach; ?>
                    </div>
                    <div class="col-md-12">
                        <div class="pull-right" style="font-size: 16px;color:#e7418d;font-weight: bold">總計:
                            <strong class="total_price "><?= $total ?></strong></div>
                    </div>
                    <a href="checkout_test.php" class="pull-right checkout_button">確定結帳</a>
                    <a href="product_list_test.php" class="pull-left checkout_button">繼續購物</a>

                <?php else: ?>
                    <div style="width: 1280px;margin: 0 auto">
                        <h5 style="font-size: 70px;text-align: center;height: 530px;line-height: 550px">您尚未購物</h5>
                    </div>
                <?php endif; ?>

            </div>
            <!----------------------------TAB2----------------------------------------->
            <div id="tab2" class="tab_content">
                <?php if (isset($_SESSION['user']['sid'])): ?>

                    <table class="table table-bordered" style="width: 1280px">
                        <thead>
                        <tr>
                            <th>戰地活動</th>
                            <th>名稱</th>
                            <th>活動日期</th>
                            <th>概述</th>
                            <th>數量</th>
                            <th>價格</th>
                            <th>狀態</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $user_sid = $_SESSION['user']['sid'];
                        $order_sql = sprintf("SELECT * FROM `order_details` d JOIN `orders` o ON d.order_sid = o.sid JOIN `products` p ON d.product_sid = p.sid 
                                        WHERE p.type=0 AND o.member_sid=$user_sid ORDER BY `o`.`order_date` DESC LIMIT 0,4");
                        $order_rs = $mysqli->query($order_sql);

                        while ($order_row = $order_rs->fetch_assoc()):;
                            ?>
                            <tr data-sid-1="">
                                <td style="width: 140px;height: 120px"><img style="width: 100%;height: 100px"
                                                                            src="activity_img/<?= $order_row['head_image'] ?>"
                                                                            alt="">
                                </td>
                                <td style="width: 140px;"><?= $order_row['name'] ?></td>
                                <td style="width: 140px;"><?= $order_row['order_date'] ?><br>

                                </td>
                                <td style="width: 140px;height: 100px;">
                                    <?= $order_row['host'] ?><br>
                                    <?= $order_row['ground'] ?><br>
                                    <?= $order_row['mode'] ?><br>
                                    <?= $order_row['people'] ?><br>
                                </td>
                                <td class="price_1" style="width: 140px;line-height: 100px;color: #e7418d;font-size: 16px;font-weight: bold;
                                    letter-spacing: 1px"><?= $order_row['quantity'] ?></td>
                                <td class="subtotal_1" style="width: 140px;line-height: 100px;color: #e7418d;font-size: 16px;font-weight: bold;
                                    letter-spacing: 1px"><?= $order_row['price']*$order_row['quantity'] ?></td>
                                <td class="tab_change" style="padding: 0;">
                                    <span class="tab_active" style="background: #4ad9c7">現場付款</span>
                                    <span class="tab_active" style="background: #ddd">等待中</span>
                                    <a href="single_activity.php?type=0&sid=<?= $order_row['product_sid'] ?>" style="text-decoration: none;"><span class="tab_active">活動細節</span></a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>


                    <table class="table table-bordered" style="width: 1280px">
                        <thead>
                        <tr>
                            <th>商品</th>
                            <th>商品名稱</th>
                            <th>購買日期</th>
                            <th>規格</th>
                            <th>數量</th>
                            <th>價格</th>
                            <th>狀態</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $user_sid = $_SESSION['user']['sid'];
                        $order_sql = sprintf("SELECT * FROM `order_details` d JOIN `orders` o ON d.order_sid = o.sid JOIN `products` p ON d.product_sid = p.sid 
                                        WHERE p.type=1 AND o.member_sid=$user_sid ORDER BY `o`.`order_date` DESC LIMIT 0,4");
                        $order_rs = $mysqli->query($order_sql);

                        while ($order_row = $order_rs->fetch_assoc()):;
                            ?>
                            <tr data-sid-1="">
                                <td style="width: 140px;height: 120px"><img style="width: 100%;height: 100px"
                                                                            src="imgs/small/<?= $order_row['head_image'] ?>.jpeg"
                                                                            alt="">
                                </td>
                                <td style="width: 140px;"><?= $order_row['name'] ?></td>
                                <td style="width: 140px;"><?= $order_row['order_date'] ?><br>

                                </td>
                                <td style="width: 140px;height: 100px;">
                                    <?= $order_row['description_5'] ?>
                                </td>
                                <td class="price_1" style="width: 140px;line-height: 100px;color: #e7418d;font-size: 16px;font-weight: bold;
                                    letter-spacing: 1px"><?= $order_row['quantity'] ?></td>
                                <td class="subtotal_1" style="width: 140px;line-height: 100px;color: #e7418d;font-size: 16px;font-weight: bold;
                                    letter-spacing: 1px"><?= $order_row['price']*$order_row['quantity'] ?></td>
                                <td class="tab_change" style="padding: 0;">
                                    <span class="tab_active" style="background: #4ad9c7">付款完成</span>
                                    <span class="tab_active" style="background: #ddd">未送達</span>
                                    <span class="tab_active">我要退貨</span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div style="width: 1280px;margin: 0 auto">
                        <h5 style="font-size: 70px;text-align: center;height: 530px;line-height: 550px">您尚未登入會員</h5>
                    </div>
                <?php endif; ?>
            </div>
            <!--------------------------TAB3------------------------------------------>

            <div id="tab3" class="tab_content">
                <?php if (isset($_SESSION['user']['sid'])): ?>
                    <table class="table table-bordered" style="width: 1280px">
                        <thead>
                        <tr>
                            <th>戰地活動</th>
                            <th>名稱</th>
                            <th>活動日期</th>
                            <th>概述</th>
                            <th>價格</th>
                            <th>狀態</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $like_sql = sprintf("SELECT p.name as pname,p.sid as psid, p.*,m.*,l.* FROM `like_products` l JOIN `products` p ON l.products_sid = p.sid JOIN `members` m ON l.member_sid = m.sid WHERE p.type=0 ORDER BY p.name
");
                        $like_rs = $mysqli->query($like_sql);

                        while ($like_row = $like_rs->fetch_assoc()):;
                            ?>
                            <tr data-like="<?= $like_row['products_sid'] ?>">
                                <td style="width: 140px;height: 120px"><img style="width: 100%;height: 100px" src="activity_img/<?= $like_row['head_image'] ?>"
                                                                            alt="">
                                </td>
                                <td style="width: 140px;"><?= $like_row['pname'] ?></td>
                                <td style="width: 140px;"><?= $like_row['date'] ?><br>

                                </td>
                                <td style="width: 140px;height: 100px;">
                                    <?= $like_row['host'] ?><br>
                                    <?= $like_row['ground'] ?><br>
                                    <?= $like_row['mode'] ?><br>
                                    <?= $like_row['people'] ?><br>
                                </td>
                                <td class="subtotal_1" style="width: 140px;line-height: 100px;color: #e7418d;font-size: 16px;font-weight: bold;
                                    letter-spacing: 1px"><?= $like_row['price'] ?></td>
                                <td class="tab2_change" style="padding: 0;">
                                    <span class="fa fa-times fa-2x cart_icon like_remove_item"
                                          data-like="<?= $like_row['sid'] ?>" aria-hidden="true"><p>移除項目</p></span>
                                    <a href="activity_join.php?type=0&sid=<?= $like_row['psid'] ?>">
                                            <span class="cart_icon activity_join_btn">
                                                <img class="join_img" src="images/join.png" alt="">
                                                <p>我要報名</p>
                                            </span>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                        </tbody>
                    </table>
                    <table class="table table-bordered" style="width: 1280px">
                        <thead>
                        <tr>
                            <th>商品</th>
                            <th>商品名稱</th>
                            <th>購買日期</th>
                            <th>規格</th>
                            <th>價格</th>
                            <th>狀態</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        $like_sql = sprintf("SELECT  p.name as pname,p.*,m.*,l.* FROM `like_products` l JOIN `products` p ON
                                            l.products_sid = p.sid JOIN `members` m ON l.member_sid = m.sid 
                                            WHERE p.type=1 ORDER BY p.name");
                        $like_rs = $mysqli->query($like_sql);

                        while ($like_row = $like_rs->fetch_assoc()):;
                            ?>
                            <tr data-like="<?= $like_row['products_sid'] ?>">
                                <td style="width: 140px;height: 120px"><img style="width: 100%;height: 100px" src="imgs/small/<?= $like_row['head_image'] ?>.jpeg"
                                                                            alt="">
                                </td>
                                <td style="width: 140px;"><?= $like_row['pname'] ?></td>
                                <td style="width: 140px;"><?= $like_row['like_time'] ?><br>

                                </td>
                                <td style="width: 140px;height: 100px;">
                                    <?= $like_row['description_5'] ?>
                                </td>
                                <td class="subtotal_1" style="width: 140px;line-height: 100px;color: #e7418d;font-size: 16px;font-weight: bold;
                                    letter-spacing: 1px"><?= $like_row['price'] ?></td>
                                <td class="tab2_change" style="padding: 0;">
                                    <span class="fa fa-times fa-2x cart_icon like_remove_item"
                                          data-like="<?= $like_row['sid'] ?>" aria-hidden="true"><p>移除項目</p></span>
                                    <span class="fa fa-shopping-cart fa-2x cart_icon like_like_item"
                                          data-like="<?= $like_row['products_sid'] ?>" aria-hidden="true"><p>加入購物車</p></span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div style="width: 1280px;margin: 0 auto">
                        <h5 style="font-size: 70px;text-align: center;height: 530px;line-height: 550px;">您尚未登入會員</h5>
                    </div>
                <?php endif; ?>
            </div>

        </div>

    </div>


    <div class="product">
        <div class="prod_title" style="margin-bottom: 30px;margin-top: 30px">其他人也看了相關商品</div>
        <div id="slider">
        <?php
        $prod_sql = "SELECT * FROM `products` WHERE type=1 ORDER BY RAND() LIMIT 5";
        $prod_rs = $mysqli->query($prod_sql);

        while ($prod_row = $prod_rs->fetch_assoc()):
            ?>

            <div class="cart_list">
                <a class="single_product"
                   href="single-product_test.php?sid=<?= $prod_row['sid'] ?>">
                    <img style="height: 192px" src="imgs/small/<?= $prod_row['head_image'] ?>.jpeg" alt="">
                </a>
                <p><?= $prod_row['name'] ?></p>
                <div class="prod_price"><p style="color: #e7418d;font-size: 20px;text-align: right;
                                                font-weight: bold">$<?= $prod_row['price'] ?>
                    </p></div>
                <div class="cart_qty">
                    <select name="prod_qty" class="prod_qty">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select>
                    <i class="buy_btn_prod fa fa-shopping-cart fa-2x cart_icon_prod"
                       data-gun="<?= $prod_row['sid'] ?>"></i>

                    <?php
                if(isset($_SESSION['user'])){
                    $like_p_sid = $prod_row['sid'];
                    $member = $_SESSION['user']['sid'];

                    $search_sql="SELECT * FROM `like_products` WHERE products_sid=$like_p_sid AND member_sid=$member";
                    $search_rs = $mysqli->query($search_sql);

                    $search_like = $search_rs->fetch_assoc();
                    if($search_like['products_sid']==$prod_row['sid']){
                    $class = 'likecolor';
                    ?>

                    <span class="cart_love_prod like_btn <?= $class ?>"
                       data-gun="<?= $prod_row['sid'] ?>  aria-hidden=" true"></i>
                    <?php }else{ ?>
                        <span class="cart_love_prod like_btn"
                           data-gun="<?= $prod_row['sid'] ?>  aria-hidden=" true"></i>
                    <?php } ?>
                <?php }else{ ?>
                    <span class="cart_love_prod like_btn"
                          data-gun="<?= $prod_row['sid'] ?>  aria-hidden=" true"></i>
                <?php } ?>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    </div><br><br>
</div>


<script>


    $(function () {

        $('.activity_join_btn').mouseover(function () {
            $(this).find(".join_img").attr("src","images/join_hover.png")
        });

        $('.activity_join_btn').mouseleave(function () {
            $(this).find(".join_img").attr("src","images/join.png")
        });

        $('#slider').bxSlider({
            slideWidth: 420,
            minSlides: 5,
            maxSlides: 5,
            moveSlides: 1,
            slideMargin: 10
        });


        $('.remove_item').click(function () {
            var tr = $(this).closest('tr');
            var sid = tr.attr("data-sid");
            $.get('add_to_cart.php', {sid: sid}, function (data) {
                tr.fadeOut(function () {
                    tr.remove();
                    calc_total_price();
                    location.reload();
                });
                calc_items(data);
            }, 'json');
        });
//-----------------------------------------420修改---------------------
        $('.like_item').click(function () {
            var tr = $(this).closest('tr');
            var sid = tr.attr("data-sid");
            $.get('add_to_like_all.php', {sid: sid}, function (data) {
                location.reload();
            }, 'json');

        });
//-----------------------------------------420修改---------------------
        $('.like_btn').click(function () {
            $(this).toggleClass('likecolor');
            var sid = $(this).attr('data-gun');

            location.reload();
            $.get('add_to_like_all.php', {sid: sid}, function (data) {

            }, 'json');
        });

        $('.like_remove_item').click(function () {
            var sid = $(this).attr('data-like');
            var tr = $(this).closest('tr');
            $.get('add_to_like_remove.php', {sid: sid}, function (data) {
                tr.fadeOut();
            }, 'json');
        });
//-----------------------------------------420修改---------------------
        $('.like_like_item').click(function () {
            var tr = $(this).closest('tr');
            var sid = $(this).attr('data-like');
            var qty = 1;
            $.get('add_to_cart.php', {sid: sid, qty: qty}, function (data) {
                location.reload();
            }, 'json');

        });
//-----------------------------------------420修改---------------------
        $('.buy_btn_prod').click(function () {
            var sid = $(this).attr('data-gun');
            var qty = $(this).closest('.cart_list').find('.prod_qty').val();
            location.reload();
            $.get('add_to_cart.php', {sid: sid, qty: qty}, function (data) {

            }, 'json');

        });


        $('ul.tabs').find('a').click(function () {
            $('ul.tabs').find('a').css({color: '#999999', borderRight: 'none'});
            $(this).css({color: '#EAA355', borderRight: '#999999 1px solid '});
        });

//--------------------------------------------------------------------

        var cart_count = $('.cart_count');

        function calc_items(obj) {
            var total = 0;
            for (var s in obj) {
                total += obj[s];
            }
            cart_count.text(total)
        }

        $.get('add_to_cart.php', function (data) {
            calc_items(data);
            calc_total_price();
        }, 'json');

        function calc_total_price() {
            var t = 0
            $('td.subtotal').each(function () {
                t += parseInt($(this).text());
            });
            $('.total_price').text(t)
        }


        var qty_sels = $('select.qty');

        qty_sels.each(function () {
            var qty = $(this).attr('data-qty');
            $(this).val(qty);
        });

        qty_sels.change(function () {
            var $tr = $(this).closest('tr');
            var sid = $tr.attr("data-sid");
            var qty = $(this).val();
            var price = $tr.find('.price').text();
            var $subtotal = $tr.find('.subtotal');

            $.get('add_to_cart.php', {sid: sid, qty: qty}, function (data) {
                $subtotal.text(qty * price);
                calc_items(data);
                calc_total_price()
            }, 'json')
        });


//------------------------頁籤------------------------------------------
        // 預設顯示第一個 Tab
        var _showTab = 0;
        var $defaultLi = $('ul.tabs li').eq(_showTab).addClass('active');
        $($defaultLi.find('a').attr('href')).siblings().hide();

        // 當 li 頁籤被點擊時...
        // 若要改成滑鼠移到 li 頁籤就切換時, 把 click 改成 mouseover
        $('ul.tabs li').click(function () {
            // 找出 li 中的超連結 href(#id)
            var $this = $(this),
                _clickTab = $this.find('a').attr('href');
            // 把目前點擊到的 li 頁籤加上 .active
            // 並把兄弟元素中有 .active 的都移除 class
            $this.addClass('active').siblings('.active').removeClass('active');
            // 淡入相對應的內容並隱藏兄弟元素
            $(_clickTab).stop(false, true).fadeIn().siblings().hide();

            return false;
        }).find('a').focus(function () {
            this.blur();
        });

        var _showTab = 0;
        $('.abgne_tab').each(function () {
            // 目前的頁籤區塊
            var $tab = $(this);

            var $defaultLi = $('ul.tabs li', $tab).eq(_showTab).addClass('active');
            $($defaultLi.find('a').attr('href')).siblings().hide();

            // 當 li 頁籤被點擊時...
            // 若要改成滑鼠移到 li 頁籤就切換時, 把 click 改成 mouseover
            $('ul.tabs li', $tab).click(function () {
                // 找出 li 中的超連結 href(#id)
                var $this = $(this),
                    _clickTab = $this.find('a').attr('href');
                // 把目前點擊到的 li 頁籤加上 .active
                // 並把兄弟元素中有 .active 的都移除 class
                $this.addClass('active').siblings('.active').removeClass('active');
                // 淡入相對應的內容並隱藏兄弟元素
                $(_clickTab).stop(false, true).fadeIn().siblings().hide();

                return false;
            }).find('a').focus(function () {
                this.blur();
            });
        });

    });
</script>

<?php include __DIR__ . '/__html_foot.php' ?>
