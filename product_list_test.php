<?php
require __DIR__ . '/__connect_db.php';
$pname = "product";

$per_page = 15;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$cate = isset($_GET['cate']) ? intval($_GET['cate']) : 0;
$g_cate = isset($_GET['g_cate']) ? intval($_GET['g_cate']) : 0;
$search = isset($_GET['search']) ? $_GET['search'] : '';

//大分類與子分類1
$big_a_sql = "SELECT * FROM `categories` WHERE  `parent_sid`=0";
$big_a_rs = $mysqli->query($big_a_sql);

$sml_a_sql = "SELECT * FROM `categories_chid` WHERE  `prod_cate_sid`=0";
$sml_a_rs = $mysqli->query($sml_a_sql);

//大分類與子分類2
$big_b_sql = "SELECT * FROM `categories` WHERE  `parent_sid`=1";
$big_b_rs = $mysqli->query($big_b_sql);

$sml_b_sql = "SELECT * FROM `categories_chid` WHERE  `prod_cate_sid`=1";
$sml_b_rs = $mysqli->query($sml_b_sql);

//大分類與子分類3
$big_c_sql = "SELECT * FROM `categories` WHERE  `parent_sid`=2";
$big_c_rs = $mysqli->query($big_c_sql);

$sml_c_sql = "SELECT * FROM `categories_chid` WHERE  `prod_cate_sid`=2";
$sml_c_rs = $mysqli->query($sml_c_sql);

//大分類與子分類4
$big_d_sql = "SELECT * FROM `categories` WHERE  `parent_sid`=3";
$big_d_rs = $mysqli->query($big_d_sql);

$sml_d_sql = "SELECT * FROM `categories_chid` WHERE  `prod_cate_sid`=3";
$sml_d_rs = $mysqli->query($sml_d_sql);

//大分類與子分類5
$big_e_sql = "SELECT * FROM `categories` WHERE  `parent_sid`=4";
$big_e_rs = $mysqli->query($big_e_sql);

$sml_e_sql = "SELECT * FROM `categories_chid` WHERE  `prod_cate_sid`=4";
$sml_e_rs = $mysqli->query($sml_e_sql);

//大分類與子分類6
$big_f_sql = "SELECT * FROM `categories` WHERE  `parent_sid`=5";
$big_f_rs = $mysqli->query($big_f_sql);

$sml_f_sql = "SELECT * FROM `categories_chid` WHERE  `prod_cate_sid`=5";
$sml_f_rs = $mysqli->query($sml_f_sql);

$where = "WHERE type=1";
$where_gun = " ";

if ($cate) {
    $where .= " AND `category_sid`=$cate ";
}
if ($g_cate) {
    $where_gun = " AND `gun_sid`=$g_cate ";
}
if ($search) {
    $search2 = $mysqli->escape_string("%{$search}%");
    $where .= sprintf(" AND `name` LIKE '%s' ", $search2);
}


$total_sql = "SELECT COUNT(1) FROM `products`$where $where_gun ";
$total_rs = $mysqli->query($total_sql);
$total_num = $total_rs->fetch_row()[0];
$total_page = ceil($total_num / $per_page);


$p_sql = sprintf("SELECT * FROM `products` %s $where_gun  LIMIT %s,%s", $where, ($page - 1) * $per_page, $per_page);
$p_rs = $mysqli->query($p_sql);


?>





<?php include __DIR__.'/__html_head.php'?>
<link rel="stylesheet" href="css/product_list_test.css">
    <!-- Insert to your webpage before the </head> -->
    <script src="carouselengine_products/jquery.js"></script>
    <script src="carouselengine_products/amazingcarousel.js"></script>
    <link rel="stylesheet" type="text/css" href="carouselengine_products/initcarousel-1.css">
    <script src="carouselengine_products/initcarousel-1.js"></script>
    <!-- End of head section HTML codes -->
    <script src="js/jquery.fly.min.js"></script>
<style>

    ol, ul {
        list-style: none;
    }

    /*li a:visited {*/
        /*color: #FFF;*/
    /*}*/

    body {
        /*background: linear-gradient(-225deg, rgba(4, 68, 102, 1) 34%, rgba(1, 31, 53, 1));*/
        background: url("image/01sandboard-dark.jpg") fixed;
        font-family: Microsoft JhengHei;
    }

    li, p, h1, span, a {
        font-size: 14px;
        color: #D5D5D5;
        text-decoration: none;
    }
</style>
<?php include __DIR__ . '/__navbar.php' ?>


<div class="wrap">
<section>
    <div class="slide">

    <!--    -------------------------------422新增------------------------------------------->

    <div id="amazingcarousel-container-1">
        <div id="amazingcarousel-1" style="display:none;position:relative;width:100%;max-width:1030px;margin:0px auto 0px;">
            <div class="amazingcarousel-list-container">
                <ul class="amazingcarousel-list">
                    <a href="product_list_test.php?g_cate=25">
                    <li class="amazingcarousel-item">
                        <div class="amazingcarousel-item-container">
                            <div class="amazingcarousel-image"><img src="imgs/loadout01_banner-1030.jpg" /></div>                    </div>
                    </li></a>
                    <a href="product_list_test.php?g_cate=26">
                    <li class="amazingcarousel-item">
                        <div class="amazingcarousel-item-container">
                            <div class="amazingcarousel-image"><img src="imgs/loadout02_banner-1030.jpg" /></div>                    </div>
                    </li></a>
                    <a href="product_list_test.php?g_cate=27">
                    <li class="amazingcarousel-item">
                        <div class="amazingcarousel-item-container">
                            <div class="amazingcarousel-image"><img src="imgs/loadout03_banner-1030.jpg" /></div>                    </div>
                    </li></a>
                    <a href="product_list_test.php?g_cate=28">
                    <li class="amazingcarousel-item">
                        <div class="amazingcarousel-item-container">
                            <div class="amazingcarousel-image"><img src="imgs/loadout04_banner-1030.jpg" /></div>                    </div>
                    </li></a>
                </ul>
                <div class="amazingcarousel-prev"></div>
                <div class="amazingcarousel-next"></div>
            </div>
            <div class="amazingcarousel-nav"></div>
            <div class="amazingcarousel-engine"><a href="http://amazingcarousel.com">JavaScript Image Carousel</a></div>
        </div>
    </div>

    <?php if(isset($_GET['g_cate'])):


    if(intval($_GET['g_cate'])==25):?>
       <img src="imgs/banner/loadout01_banner-1030.jpg" alt="">
        <?php elseif (intval($_GET['g_cate'])==26): ?>
        <img src="imgs/banner/loadout02_banner-1030.jpg" alt="">
        <?php elseif (intval($_GET['g_cate'])==27): ?>
        <img src="imgs/banner/loadout03_banner-1030.jpg" alt="">
        <?php elseif (intval($_GET['g_cate'])==28):?>
        <img src="imgs/banner/loadout04_banner-1030.jpg" alt="">
        <?php else:?>


    <?php endif; ?>
    <?php endif; ?>



<!--    -------------------------------422新增------------------------------------------->

    <div class="new">
        <div class="board"><p>
        <?php

       if(isset($_GET['g_cate'])):
            $gcat=$_GET['g_cate'];

            $n_sql = "SELECT * FROM `categories_chid` WHERE sid=$gcat";
            $n_rs = $mysqli->query($n_sql);
            $n_row = $n_rs->fetch_assoc();
        ?>
                <?= $n_row['name']?>

                <?php  elseif(isset($_GET['cate'])):
                    $cat=$_GET['cate'];
                    $c_sql = "SELECT * FROM `categories` WHERE sid=$cat";
                    $c_rs = $mysqli->query($c_sql);
                    $c_row = $c_rs->fetch_assoc();
                   ?>

                <?= $c_row['name']?>

                <?php else: ?>
                新品上市
    <?php endif; ?>
            </p></div>
        <div class="new_cont1">

            <!--商品顯示-->
            <?php  while ($row = $p_rs->fetch_assoc()): ?>
                <div class="cart_list">
                    <a class="single_product" href="single-product_test.php?sid=<?= $row['sid'] ?>">
                    <img src="imgs/small/<?= $row['head_image'] ?>.jpeg" alt="">
                    </a>
                    <p><?= $row['name'] ?></p>

                    <div class="price" ><p  style="color: #e7418d">$<?= $row['price'] ?>
                        </p></div>
                    <div class="cart_qty">
                        <select name="qty" class="qty">
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
                        <i class="buy_btn fa fa-shopping-cart fa-2x cart_icon" data-sid="<?= $row['sid'] ?>"></i>
                        <?php
                        if(isset($_SESSION['user'])){
                        $like_p_sid = $row['sid'];
                        $member = $_SESSION['user']['sid'];

                        $search_sql="SELECT * FROM `like_products` WHERE products_sid=$like_p_sid AND member_sid=$member";
                        $search_rs = $mysqli->query($search_sql);

                        $search_like = $search_rs->fetch_assoc();

                            if($search_like['products_sid']==$row['sid']){
                                $class = 'likecolor';
                            ?>
                        <div class="cart_love like_btn <?=  $class ?>" aria-hidden="true" data-sid="<?= $row['sid'] ?>"></div>
                            <?php }else{ ?>
                                <div class="cart_love like_btn " aria-hidden="true" data-sid="<?= $row['sid'] ?>"></div>
                            <?php } ?>
                        <?php }else{ ?>
                            <a href="members.php"><div class="cart_love like_btn " aria-hidden="true" data-sid="<?= $row['sid'] ?>"></div></a>
                        <?php } ?>


                    </div>
                </div>
            <?php endwhile; ?>


        </div>
        <ul class="cart_page">

            <?php
            if ($cate) {
                $ar['cate'] = $cate;
            }
            if ($g_cate) {
                $ar['g_cate'] = $g_cate;
            }
            ?>

            <li class="cart_prev_page" href="?page=1"><a href="?page=1">&nbsp;&nbsp;</a></li>
            <?php for ($i = 1;
                       $i <= $total_page;
                       $i++):
                $ar = array('page' => $i);
                if ($cate) {
                    $ar['cate'] = $cate;
                }
                if ($g_cate) {
                    $ar['g_cate'] = $g_cate;
                }
                ?>
                <li><a  style="position: relative;top:10px" href="?<?= http_build_query($ar) ?>"><?= $i ?></a></li>
            <?php endfor ?>
            <li class="cart_next_page"><a href="?<?= http_build_query($ar) ?>">&nbsp;&nbsp;</a></li>
        </ul>
        <div class="banner">
            <a href="product_list_test.php?g_cate=25"><img src="imgs/banner/loadout01_banner-515.jpg" alt=""></a>
            <a href="product_list_test.php?g_cate=26"><img src="imgs/banner/loadout02_banner-515.jpg" alt=""></a>
            <a href="product_list_test.php?g_cate=27"><img src="imgs/banner/loadout03_banner-515.jpg" alt=""></a>
            <a href="product_list_test.php?g_cate=28"><img src="imgs/banner/loadout04_banner-515.jpg" alt=""></a>
        </div>


    </div>


</section>
<aside>
    <form class="">
        <input class="cart_search" name="search" placeholder="Search"
               value="<?= empty($search) ? '' : $search ?>">
        <button type="submit" class="cart_search_button fa fa-search"></button>
    </form>

    <ul>
        <?php while ($row = $big_a_rs->fetch_assoc()): ?>
            <li class="up"><a href="?cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php while ($row = $sml_a_rs->fetch_assoc()): ?>
                <li class="cate_g">
<!--                    0418新增 hover icon小標籤-->
                    <i class="fa fa-tag" aria-hidden="true"></i>
<!-- end of 0418 新增-->
                    <a href="?g_cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php endwhile; ?>
        <?php endwhile; ?>

        <?php while ($row = $big_b_rs->fetch_assoc()): ?>
            <li class="up"><a href="?cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php while ($row = $sml_b_rs->fetch_assoc()): ?>
                <li class="cate_g">
                    <!--                    0418新增 hover icon小標籤-->
                    <i class="fa fa-tag" aria-hidden="true"></i>
                    <!-- end of 0418 新增-->
                    <a href="?g_cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php endwhile; ?>
        <?php endwhile; ?>

        <?php while ($row = $big_c_rs->fetch_assoc()): ?>
            <li class="up"><a href="?cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php while ($row = $sml_c_rs->fetch_assoc()): ?>
                <li class="cate_g">
                    <!--                    0418新增 hover icon小標籤-->
                    <i class="fa fa-tag" aria-hidden="true"></i>
                    <!-- end of 0418 新增-->
                    <a href="?g_cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php endwhile; ?>
        <?php endwhile; ?>

        <?php while ($row = $big_d_rs->fetch_assoc()): ?>
            <li class="up"><a href="?cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php while ($row = $sml_d_rs->fetch_assoc()): ?>
                <li class="cate_g">
                    <!--                    0418新增 hover icon小標籤-->
                    <i class="fa fa-tag" aria-hidden="true"></i>
                    <!-- end of 0418 新增-->
                    <a href="?g_cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php endwhile; ?>
        <?php endwhile; ?>

        <?php while ($row = $big_e_rs->fetch_assoc()): ?>
            <li class="up"><a href="?cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php while ($row = $sml_e_rs->fetch_assoc()): ?>
                <li class="cate_g">
                    <!--                    0418新增 hover icon小標籤-->
                    <i class="fa fa-tag" aria-hidden="true"></i>
                    <!-- end of 0418 新增-->
                    <a href="?g_cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php endwhile; ?>
        <?php endwhile; ?>

        <?php while ($row = $big_f_rs->fetch_assoc()): ?>
            <li class="up"><a href="?cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php while ($row = $sml_f_rs->fetch_assoc()): ?>
                <li class="cate_g">
                    <!--                    0418新增 hover icon小標籤-->
                    <i class="fa fa-tag" aria-hidden="true"></i>
                    <!-- end of 0418 新增-->
                    <a href="?g_cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php endwhile; ?>
        <?php endwhile; ?>
    </ul>
</aside>
</div>
<!--422新增-->
<?php if(isset($_GET['g_cate'])){?>
    <script>$('.banner').css('display','none');</script>
<?php }elseif(isset($_GET['cate'])){ ?>
    <script>$('.banner').css('display','none');</script>
<?php } ?>

<?php if (isset($_GET['g_cate'])==25){?>
    <script> $('#amazingcarousel-container-1').css('display','none');</script>
<?php } elseif (isset($_GET['g_cate'])==26){?>
    <script>$('#amazingcarousel-container-1').css('display','none');</script>

<?php } elseif(isset($_GET['g_cate'])==27){ ?>
    <script>$('#amazingcarousel-container-1').css('display','none');</script>

<?php } elseif(isset($_GET['g_cate'])==28){?>
    <script>$('#amazingcarousel-container-1').css('display','none');</script>
<?php } else{?>

<?php } ?>

    <!--422新增-->
<script>



    $(function () {
//-------------------------------------------422------------------------------------------------

//-------------------------------------------422------------------------------------------------
//----------------------------420新增-----------------------------------------
        $('#cart_nav').mousemove(function () {

            var sid = $(this).attr('data-sid');
            var qty = $(this).closest('.cart_list').find('.qty').val();

            $.post('add_menu_cart.php', {sid: sid, qty: qty}, function (data) {

                $('#ccart_nav').css('max-height','900px');

                $('#ccart_nav').html(data);

            });
        });

        $('#cart_nav').mouseleave(function () {
            setTimeout(function () {
                $('#ccart_nav').css('max-height','0');
            },500);
        });
//----------------------------420新增-----------------------------------------


        var offset = $("#cart_nav").offset();


        $('.buy_btn').click(function () {

            var img = $(this).closest('.cart_list').find('img').attr('src'); //獲取當前點擊圖片鏈接
            var flyer = $('<img style="z-index: 200000;width: 40px;height: 40px;border-radius: 50%" src="' + img + '">'); //拋物體對象
            flyer.fly({
                start: {
                    left: event.pageX,//拋物體起點橫坐標
                    top: event.pageY //拋物體起點縱坐標
                },
                end: {
                    left: offset.left + 10,//拋物體終點橫坐標
                    top: offset.top + 10, //拋物體終點縱坐標
                },
                onEnd: function() {
                    $("#tip").show().animate({width: '200px'},300).fadeOut(500);////成功加入購物車動畫效果
                    this.destory(); //銷毀拋物體
                }
            });

            var sid = $(this).attr('data-sid');
            var qty = $(this).closest('.cart_list').find('.qty').val();

            $.post('add_menu_cart.php', {sid: sid, qty: qty}, function (data) {
                setTimeout(function () {
                $('#ccart_nav').css('max-height','900px');
                },1000);
                $('#ccart_nav').html(data);

                setTimeout(function () {
                    $('#ccart_nav').css('max-height','0');
                },4000);
            });

        });





        $('.like_btn').click(function () {

            $(this).toggleClass('likecolor');
            var sid = $(this).attr('data-sid');
             $.get('add_to_like_all.php', {sid: sid}, function (data) {

            }, 'json');
        });


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
</script>

<?php include __DIR__ . '/__html_foot.php' ?>