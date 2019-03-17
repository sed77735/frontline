<?php
require __DIR__ . '/__connect_db.php';

$pname ='none';


//SELECT * FROM `check_form` WHERE `members_id`=5 ORDER BY `check_form`.`sid` DESC LIMIT 1
//$who = $_SESSION['user']['sid'];
//$sql = "SELECT * FROM `check_form` WHERE `members_id`= $who ORDER BY `check_form`.`sid` DESC LIMIT 1";
//$rs = $mysqli->query($sql);
//$row = $rs->fetch_assoc();

$name = $_SESSION['tmp']['name'];
$userid = $_SESSION['tmp']['userid'];
$email = $_SESSION['tmp']['email'];
$phone = $_SESSION['tmp']['phone'];
$address = $_SESSION['tmp']['address'];
$toname = $_SESSION['tmp']['toname'];
$tophone = $_SESSION['tmp']['tophone'];
$toaddress = $_SESSION['tmp']['toaddress'];

if (isset($_POST['userid'])) {
    $sql = sprintf("INSERT INTO `check_form`(`sid`, `name`, `userid`,
 `email`, `phone`, `address`,
  `toname`, `tophone`, `toaddress`,
   `members_id`)
VALUES (NULL, '%s', '%s',
        '%s','%s','%s',
        '%s','%s','%s',
        '%s')",
        $mysqli->escape_string($name),
        $mysqli->escape_string($userid),
        $mysqli->escape_string($email),
        $mysqli->escape_string($phone),
        $mysqli->escape_string($address),
        $mysqli->escape_string($toname),
        $mysqli->escape_string($tophone),
        $mysqli->escape_string($toaddress),
        intval($_SESSION['user']['sid'])
    );
    $mysqli->query($sql);
    header('Location:buy.php');
}


?>


<?php include __DIR__.'/__html_head.php'?>
<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="css/checkout_final_test.css">
<style>
    body {
        /*background: #d5d5d1;*/
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

    h4 {
        border: none;
    }

    .check_form_title {
        font-family: FontAwesome, Microsoft JhengHei;
    }

</style>
<?php include __DIR__ . '/__navbar.php' ?>

<div  class="wrap clearfix">
    <div class="Process">
        <div class="Process_css P_nstyle Process_1">選擇付款方式</div>
        <div style="line-height: 40px;color: #bfbfbf" class="Process_css i_style fa fa-caret-right fa-2x"></div>
        <div class="Process_css P_nstyle Process_2">填寫詳細資料</div>
        <div style="line-height: 40px;color: #bfbfbf" class="Process_css i_style fa fa-caret-right fa-2x"></div>
        <div class="Process_css P_style Process_3">購物完成</div>
    </div>
<div class="check_form_wrap"style="clear: both">
    <div class="font_check">
    <h3>購物完成!</h3>
    <h4>請記住您的資料,避免後續問題</h4>
    </div>
    <form name="form1" method="post" onsubmit="return checkForm();">

        <p class="fa fa-check check_form_title">付款人</p>
        <div class="form-group">
            <label for="name">姓名<span class="info"></span></label>
            <input  type="text" class="form-control col-sm-10" id="name" name="name" readonly="readonly" value="<?= $name ?>"
                   placeholder="請填入真實姓名">
        </div>

        <div class="form-group">
            <label for="userid">身分證字號<span class="info"></span></label>
            <input type="text" class="form-control" id="userid" name="userid" readonly="readonly" value="<?= $userid ?>">
        </div>

        <div class="form-group">
            <label for="email">E-mail<span class="info"></span></label>
            <input type="text" class="form-control" id="email" name="email" readonly="readonly" value="<?= $email ?>">
        </div>

        <div class="form-group">
            <label for="phone">手機<span class="info"></span></label>
            <input type="text" class="form-control" id="phone" name="phone" readonly="readonly" value="<?= $phone ?>">
        </div>

        <div class="form-group">
            <label for="address">地址<span class="info"></span></label>
            <input type="text" class="form-control" id="address" readonly="readonly" name="address"
                   value="<?= $address ?>">
        </div>

        <p class="fa fa-check check_form_title">收件人</p>
        <div class="form-group">
            <label for="toname">姓名<span class="info"></span></label>
            <input type="text" class="form-control btn_val" id="toname" name="toname" readonly="readonly"
                   data-val="" value="<?= $toname ?>"
                   placeholder="請填入真實姓名">
        </div>
        <div class="form-group">
            <label for="tophone">手機<span class="info"></span></label>
            <input type="text" class="form-control btn_val1" id="tophone" name="tophone" readonly="readonly"
                   data-val1="<?= $phone ?>" value="<?= $tophone ?>">
        </div>

        <div class="form-group">
            <label for="toaddress">地址<span class="info"></span></label>
            <input type="text" class="form-control btn_val2" id="toaddress" name="toaddress" readonly="readonly"
                   data-val2="<?= $address ?>" value="<?= $toaddress ?>">
        </div>
        <a href="checkout_form_test.php"><div class="pull-left btn btn-default btn-checkout">回上一頁</div></a>
        <a href="buy.php"><button type="submit" class="pull-right btn btn-default btn-checkout">確認</button></a>
     </form>

</div>

</div>

<script>
    $(function () {

//------------------------------NAV------------------------------------------
        var x = $('.active').data("x");
        $(".test").css({marginLeft: x});


        $(".nav_li a").mouseover(function () {
            var x = $(this).parent(".nav_li").data("x");


            $(".test").stop().animate({marginLeft: x}, 500);
//        $(this).find('a').addClass("active");
//        $(".nav_li").not(this).find('a').removeClass("active");

        });

        $(".nav_li a").mouseout(function () {
            $(".nav_li ul").css(display = "block");
            var x = $('.active').data("x");
            $(".test").stop().animate({marginLeft: x}, 500);
        });

    });
    //----------------------------------------確認資料-----------------------------------------



</script>

</body>
</html>
