<?php
require __DIR__ . '/__connect_db.php';

$pname ='none';

if (!isset($_SESSION['user'])) {
    header('Location: ./');
    exit;
}

$sql = "SELECT * FROM `members` WHERE `sid`=" . intval($_SESSION['user']['sid']);
$rs = $mysqli->query($sql);
$row = $rs->fetch_assoc();

$email = $row['email'];
$name = $row['name'];
$phone = $row['phone'];
$address = $row['address'];

if (isset($_POST['userid'])) {

    $_SESSION['tmp']=$_POST;

    header('Location:checkout_final_test.php');
}


?>


<?php include __DIR__.'/__html_head.php'?>
<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
<link rel="stylesheet" href="css/checkout_form_test.css">
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

    .check_form_title {
        font-family: FontAwesome, Microsoft JhengHei;
    }


</style>
<?php include __DIR__ . '/__navbar.php' ?>

<div  class="wrap clearfix">
    <div class="Process">
        <div class="Process_css P_nstyle Process_1">選擇付款方式</div>
        <div style="line-height: 40px;color: #bfbfbf" class="Process_css i_style fa fa-caret-right fa-2x"></div>
        <div class="Process_css P_style Process_2">填寫詳細資料</div>
        <div style="line-height: 40px;color: #bfbfbf" class="Process_css i_style fa fa-caret-right fa-2x"></div>
        <div class="Process_css P_nstyle Process_3">購物完成</div>
    </div>
<div class="check_form_wrap"style="clear: both">
    <form name="form1" method="post" onsubmit="return checkForm();">
        <p class="fa fa-user check_form_title" style="letter-spacing: 5px">付款人</p>
        <div class="form-group">
            <label for="name">姓名<span class="info"></span></label>
            <input  type="text" class="form-control col-sm-10" id="name" name="name" value="<?= $name ?>"
                   placeholder="請填入付款人真實姓名">
        </div>

        <div class="form-group">
            <label for="userid">身分證字號<span class="info"></span></label>
            <input type="text" class="form-control" id="userid" name="userid"placeholder="請填入付款人身分證字號">
        </div>

        <div class="form-group">
            <label for="email">E-mail<span class="info"></span></label>
            <input type="text" class="form-control" id="email" name="email" value="<?= $email ?>"placeholder="請填入付款人信箱">
        </div>

        <div class="form-group">
            <label for="phone">手機<span class="info"></span></label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?= $phone ?>"placeholder="請填入付款人手機">
        </div>

        <div class="form-group">
            <label for="address">地址<span class="info"></span></label>
            <input type="text" class="form-control" id="address" name="address"placeholder="請填入付款人地址"
                   value="<?= $address ?>">
        </div>

        <p class="fa fa-user check_form_title" style="letter-spacing: 5px">收件人</p>
        <div class="btn_check btn-default btn">同會員資料</div>
        <div class="form-group">
            <label for="toname">姓名<span class="info"></span></label>
            <input type="text" class="form-control btn_val" id="toname" name="toname"
                   data-val="<?= $name ?>" value=""
                   placeholder="請填入收件人真實姓名">
        </div>
        <div class="form-group">
            <label for="tophone">手機<span class="info"></span></label>
            <input type="text" class="form-control btn_val1" id="tophone" name="tophone"
                   data-val1="<?= $phone ?>" value="" placeholder="請填入收件人電話">
        </div>

        <div class="form-group">
            <label for="toaddress">地址<span class="info"></span></label>
            <input type="text" class="form-control btn_val2" id="toaddress" name="toaddress"placeholder="請填入收件人收貨地址"
                   data-val2="<?= $address ?>" value="">
        </div>
        <a href="checkout_test.php"><div class="pull-left btn btn-default btn-checkout">回上一頁</div></a>
        <button  type="submit" class="btn btn-default btn-checkout pull-right">送出訂單</button>
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

    $('.btn_check').click(function () {
        var t;
        var t1;
        var t2;
        t = $('.btn_val').attr('data-val');
        $('.btn_val').val(t);
        t1 = $('.btn_val1').attr('data-val1');
        $('.btn_val1').val(t1);
        t2 = $('.btn_val2').attr('data-val2');
        $('.btn_val2').val(t2);
    });

//    $('.btn-checkout').click(function () {
//        var ckech = confirm('確認資料無誤');
//
//        if(!ckech){
//            return false;
//        }
//        checkForm()
//
//    });

    function checkForm() {
        var $name = $('#name');
        var $userid = $('#userid');
        var $email = $('#email');
        var $phone = $('#phone');
        var $address = $('#address');
        var $toname = $('#toname');
        var $tophone = $('#tophone');
        var $toaddress = $('#toaddress');


        var items = [$name, $userid, $email, $phone, $address, $toname, $tophone, $toaddress];

        var name = $name.val();
        var userid = $userid.val();
        var email = $email.val();
        var phone = $phone.val();
        var address = $address.val();
        var toname = $toname.val();
        var tophone = $tophone.val();
        var toaddress = $toaddress.val();


        var i;
        var pattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        var isPass = true;


        for (i = 0; i < items.length; i++) {
            items[i].closest('.form-group').find('.info').text('');
            items[i].css('border-color', '#ccc');
        }

        if (name.length < 2) {
            $name.closest('.form-group').find('.info').text(' 請填姓名!');
            $name.css('border-color', 'red');
            isPass = false;
        }

        if (!userid) {
            $userid.closest('.form-group').find('.info').text(' 請填寫身分證字號 !');
            $userid.css('border-color', 'red');
            isPass = false;
        }

        if (!pattern.test(email)) {
            $email.closest('.form-group').find('.info').text(' E-mail格式不正確 !');
            $email.css('border-color', 'red');
            isPass = false;
        }

        if (!email) {
            $email.closest('.form-group').find('.info').text(' 請填寫E-mail !');
            $email.css('border-color', 'red');
            isPass = false;
        }

        if (!phone) {
            $phone.closest('.form-group').find('.info').text(' 請填寫電話 !');
            $phone.css('border-color', 'red');
            isPass = false;
        }

        if (!address) {
            $address.closest('.form-group').find('.info').text(' 請填寫地址 !');
            $address.css('border-color', 'red');
            isPass = false;
        }

        if (!toname) {
            $toname.closest('.form-group').find('.info').text(' 請填姓名!');
            $toname.css('border-color', 'red');
            isPass = false;
        }

        if (!tophone) {
            $tophone.closest('.form-group').find('.info').text(' 請填寫電話 !');
            $tophone.css('border-color', 'red');
            isPass = false;
        }

        if (!toaddress) {
            $toaddress.closest('.form-group').find('.info').text(' 請填寫地址 !');
            $toaddress.css('border-color', 'red');
            isPass = false;
        }



        if (isPass) {
            document.form1.submit(function () {

            });

        }

        return false;

    }





</script>

</body>
</html>
