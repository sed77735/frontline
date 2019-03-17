<?php
require __DIR__ . '/__connect_db.php';

$pname ='none';


if (!empty($_SESSION['cart'])) {

    $sids = array_keys($_SESSION['cart']);

    $sql = sprintf("SELECT * FROM `products` WHERE `sid` IN (%s)", implode(',', $sids));

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
<link rel="stylesheet" href="css/checkout_test.css">
<style>
    body {
        /*background: #d5d5d1;*/
        font-family: Microsoft JhengHei;
    }

    li, p, h1, span, a {
        font-size: 14px;
        color: #D5D5D5;
        text-decoration: none;
    }

    .nav > li > a:hover, .nav > li > a:focus {
        background-color: transparent;
    }

    .check_pay_title {
        font-family: FontAwesome, Microsoft JhengHei;
    }
    .qty {
        border: solid 1px #000;
        appearance: none;
        -moz-appearance: none;
        -webkit-appearance: none;
        padding-right: 14px;
        background: url(http://ourjs.github.io/static/2015/arrow.png) no-repeat scroll right center transparent;
        padding-left: 5px;
        /* display: block; */
        width: 45px;
        height: 32px;
        border: 1px solid black;
        font-size: 14px;
        font-weight: bold;
        line-height: 32px;
    }

</style>
    <?php include __DIR__ . '/__navbar.php' ?>

<div class="wrap">
    <div class="Process">
        <div class="Process_css P_style Process_1">選擇付款方式</div>
        <div style="line-height: 60px;color: #bfbfbf" class="Process_css i_style fa fa-caret-right fa-2x"></div>
        <div class="Process_css P_nstyle Process_2">填寫詳細資料</div>
        <div style="line-height: 60px;color: #bfbfbf" class="Process_css i_style fa fa-caret-right fa-2x"></div>
        <div class="Process_css P_nstyle Process_3">購物完成</div>
    </div>
         <div class="table_side">

            <div id="tab1" class="tab_content" style="height: 550px;background: white">
<!--                <div style="height: 550px;width: 830px;background: white"></div>-->
                <?php if (!empty($_SESSION['cart'])): ?>

                    <table class="table table-bordered" style="background: white;" >
                        <thead>

                        <tr>
                            <th>商品</th>
                            <th>商品名稱</th>
                            <th>規格</th>
                            <th>數量</th>
                            <th>價格</th>
                            <th>總計</th>
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
                                <td class="price"  style="line-height: 100px;color: #e7418d;font-size: 16px;font-weight: bold;
                                    letter-spacing: 1px"><?= $row['price'] ?></td>
                                <td class="subtotal"  style="line-height: 100px;color: #e7418d;font-size: 16px;font-weight: bold;
                                    letter-spacing: 1px"><?= $row['price'] * $row['qty'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                         <div class="col-md-12">
                        <div class="pull-right" style="font-size: 16px;color:#e7418d;font-weight: bold">總計:
                            <strong class="total_price ">$<?= $total ?></strong></div>
                    </div>
                    <div class="check_pay">
                    <div class="fa fa-check  check_pay_title" aria-hidden="true">選擇付款方式</div><br>
                    <label class="radio-inline" style="margin: 5px 0">
                        <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                        <strong class="check_pay_p">信用卡</strong>
                        <span class="total_price ">$<?= $total ?></span>付款
                    </label><br>
                    <label class="radio-inline" style="margin: 5px 0">
                        <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                        <strong class="check_pay_p">ATM</strong>
                        <span class="total_price ">$<?= $total ?></span>付款
                    </label><br>
                    <label class="radio-inline" style="margin: 5px 0">
                        <input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3">
                        <strong class="check_pay_p">超商</strong>
                        <span class="total_price ">$<?= $total ?></span>付款，不取貨
                    </label><br>
                   </div>
                    <?php if(isset($_SESSION['user'])): ?>
                        <a href="checkout_form_test.php" class="pull-right checkout_button">確認</a>
                        <a href="product_list_test.php" class="pull-right checkout_button">繼續購物</a>
                    <?php else: ?>
                        <a href="product_list_test.php" class="pull-right checkout_button">登入會員</a>
                        <a href="product_list_test.php" class="pull-right checkout_button">繼續購物</a>
                    <?php endif; ?>

                <?php else: ?>


                <?php endif; ?>
            </div>
         </div>

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

            <?php if ($row['gun_sid'] == 21 or $row['gun_sid'] == 26 or $row['gun_sid'] ==16): ?>
            <img style="position: absolute;top:0;left: 0;" src="imgs/solider/doll_05_vest.png" alt="">
        <?php endif; ?>

            <?php if ($row['gun_sid'] == 20 or $row['gun_sid'] ==25): ?>
            <img style="position: absolute;top:0;left: 0;" src="imgs/solider/doll_06_clothes.png"
                 alt="">
        <?php endif; ?>

            <?php if ($row['gun_sid'] == 22 or $row['gun_sid'] ==27): ?>
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

            <?php if ($row['gun_sid'] == 23 or $row['gun_sid'] ==28): ?>
            <img style="position: absolute;top:0;left: 0;" src="imgs/solider/doll_07_kneepads.png"
                 alt="">

        <?php endif; ?>


        <?php endforeach; ?>
    </div>
</div>


<script>
    $(function () {


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
        }, 'json');

        $('.remove_item').click(function () {
            var tr = $(this).closest('tr');
            var sid = tr.attr("data-sid");


            $.get('add_to_cart.php', {sid: sid}, function (data) {
                tr.fadeOut();
                calc_items(data);
                calc_total_price()

            }, 'json');
        });

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

        function calc_total_price() {
            var t = 0;
            $('td.subtotal').each(function () {
                t += parseInt($(this).text());
            });
            $('.total_price').text(t)
        }
    });



</script>



</body>
</html>
