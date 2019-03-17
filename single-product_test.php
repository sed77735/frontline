<?php
require __DIR__ . '/__connect_db.php';

$pname = 'product';

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

$where = "WHERE 1";
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
<link rel="stylesheet" href="css/single-product_test.css">

<script src="js/coreSlider.js"></script>
<script src="js/jquery.bxslider.js"></script>
<style>

    body {
        font-family: Microsoft JhengHei;
    }

</style>

<?php include __DIR__ . '/__navbar.php' ?>
<div class="wrap">
    <section>
        <div class="slide">


        </div>
        <div class="new">
            <div class="board"><p>新品上市</p></div>
            <div class="new_cont1">
                <?php
                $sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;

                if (empty($sid)) {
                    header("Location: product_list_test.php");
                    exit;
                }


                $s_sql = "SELECT * FROM `products` WHERE `sid`= $sid";
                $result = $mysqli->query($s_sql);

                if (!$result->num_rows) {
                    echo "<script>alert('警告：將在確認之後跳頁'); 
                        location.href = 'product_list_test.php';</script>";
                    exit;
                }

                $s_row = $result->fetch_assoc();
                ?>

                <div class="thumbnail" style="position: relative">
                    <div class="single_show_box">
                        <div class="showbox"><img style="" id="show-image" src="imgs/small/<?= $s_row['head_image'] ?>.jpeg"/></div>
                        <div class="abgne-block-20120106">
                            <div class="slide_border"><a href="imgs/small/<?= $s_row['image_1'] ?>.jpeg"><img src="imgs/small/<?= $s_row['image_1'] ?>.jpeg" title=""/></a></div>
                            <div class="slide_border"><a href="imgs/small/<?= $s_row['image_2'] ?>.jpeg"><img src="imgs/small/<?= $s_row['image_2'] ?>.jpeg" title=""/></a></div>
                            <div class="slide_border"><a href="imgs/small/<?= $s_row['image_3'] ?>.jpeg"><img src="imgs/small/<?= $s_row['image_3'] ?>.jpeg" title=""/></a></div>
                            <div class="slide_border"><a href="imgs/small/<?= $s_row['head_image'] ?>.jpeg"><img src="imgs/small/<?= $s_row['head_image'] ?>.jpeg" title=""/></a></div>
                        </div>
                    </div>
                    <div class="caption">
                        <h5 style="line-height: 30px;font-weight: bolder;"><?= $s_row['name'] ?></h5>

                        <div>
                            <span class="glyphicon glyphicon-search"></span>

                            <div class="single_price"><strong>價格</strong>:<span
                                        style="color:  #e7418d;font-size: 20px;font-weight: bold">
                                        <?= $s_row['price'] ?></span><strong>元</strong></div>
                            <div class="fa fa-check-circle" style="margin-bottom: 20px;color: #4ad9c7">&nbsp;&nbsp;
<!--                                0418新增 span class-->
                                <span class="in_stock_info" style="color:black">現貨供應中</span></div>

<!--                            -->
                            <div style="font-size: 18px">數量&nbsp;:&nbsp;
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
                            </div>
                            <i class="buy_btn fa fa-shopping-cart fa-2x cart_icon  cart"
                               data-sid="<?= $s_row['sid'] ?>">
                                加入購物車 <span></span></i>




                            <!---------------------------------421更改地方-------------------------------------------->

                            <?php
                            if(isset($_SESSION['user'])){
                                $like_sid = $s_row['sid'];
                                $member = $_SESSION['user']['sid'];

                                $sp_sql="SELECT * FROM `like_products` WHERE products_sid=$like_sid AND member_sid=$member";
                                $sp_rs = $mysqli->query($sp_sql);

                                $sp_like = $sp_rs->fetch_assoc();

                                if($sp_like['products_sid']==$s_row['sid']){
                                    $addclass = 'lovehide';
                                    ?>
                                <div>
                                    <i class="fa cart_love cart_icon cart likebtn lbtn_1"
                                       data-sid="<?= $s_row['sid'] ?>">
                                        移除收藏清單</i>
                                    <i class="fa cart_love cart_icon cart lbtn_2 <?= $addclass ?>"
                                       data-sid="<?= $s_row['sid'] ?>">
                                        放入收藏清單</i>
                                </div>


                                <?php }else{ ?>

                                <i class="fa cart_love cart_icon cart likebtn lovehide lbtn_3"
                                       data-sid="<?= $s_row['sid'] ?>">

                                    <p>移除收藏清單</p></i>

                                <i class="fa cart_love cart_icon cart lbtn_4"
                                   data-sid="<?= $s_row['sid'] ?>">

                                    <p>放入收藏清單</p></i>


                                <?php } ?>
                            <?php }else{ ?>
                                <a style="letter-spacing: inherit" href="members.php"> <i class="fa cart_love cart_icon cart"
                                                          data-sid="<?= $s_row['sid'] ?>">
<!--                                      0424-->
                                       <p>請先登入會員</p></i></a>
<!--                                -->
                            <?php } ?>




                        </div>

                    </div>
                    <div class="intorduction" style="border-bottom: none;">
                        <p class="description" style="font-weight: bold;font-size: 18px">規格</p><br>
                        <p class="description"><?= $s_row['description_1'] ?></p>
                        <p class="description"><?= $s_row['description_2'] ?></p>
                        <p class="description"><?= $s_row['description_3'] ?></p>
                        <p class="description"><?= $s_row['description_4'] ?></p>
                        <p class="description"><?= $s_row['description_5'] ?></p></div>
                    <div class="intorduction">產品資訊<br><br><span
                                style="line-height:30px; color: black; font-size: 14px;"><?= $s_row['intorduction'] ?></span></div>
                    <!------------------------------------------------------------------------->

                    <div class="product">
                    <div class="prod_title">其他人也看了相關商品</div><br><br>
                        <div id="slider">
                    <?php
                    $gunid = $s_row['gun_sid'];
                    $gun_sql = "SELECT * FROM `products` WHERE gun_sid=$gunid NOT IN (sid=$sid)";
                    $gun_rs = $mysqli->query($gun_sql);
                    while ($gun_row = $gun_rs->fetch_assoc()):
                        ?>

<!--                        0418新增-->
                        <div class="cart_list">
                            <div class="onsale"><a href="single-product_test.php?sid=<?= $gun_row['sid'] ?>">SALE</a></div>
<!-- --------------------------------------   -->
                            <a class="single_product"
                               href="single-product_test.php?sid=<?= $gun_row['sid'] ?>">
                                <img class="recommend_product" src="imgs/small/<?= $gun_row['head_image'] ?>.jpeg" alt="">
                            </a>
                            <p><?= $gun_row['name'] ?></p>
                            <div class="price"><p style="color: #e7418d">$<?= $gun_row['price'] ?>
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
                                <i class="buy_btn_prod fa fa-shopping-cart fa-2x cart_icon_prod"
                                   data-gun="<?= $gun_row['sid'] ?>"></i>
<!--------------------------------------------------------------420修正----------------------------------->
                                <?php
                                if(isset($_SESSION['user'])){
                                $like_p_sid = $gun_row['sid'];
                                $member = $_SESSION['user']['sid'];

                                $search_sql="SELECT * FROM `like_products` WHERE products_sid=$like_p_sid AND member_sid=$member";
                                $search_rs = $mysqli->query($search_sql);

                                $search_like = $search_rs->fetch_assoc();

                                if($search_like['products_sid']==$gun_row['sid']){
                                $class = 'likecolor';
                                ?>

                                <i class="cart_love_prod like_btn likecolor <?=  $class ?>" data-gun="<?= $gun_row['sid'] ?>"
                                   aria-hidden="true"></i>
                                <?php }else{ ?>
                                <i class="cart_love_prod like_btn" data-gun="<?= $gun_row['sid'] ?>"
                                   aria-hidden="true"></i>
                                <?php } ?>
                                <?php }else{ ?>
                                <i class="cart_love_prod like_btn" data-gun="<?= $gun_row['sid'] ?>"
                                   aria-hidden="true"></i>
                                <?php } ?>
                                <!--------------------------------------------------------------420修正----------------------------------->
                            </div>

                        </div>
                    <?php endwhile; ?>
                        </div>
                        <div style="height: 0px"></div>
                </div>

            </div>

        </div>

        <!------------------------------------------------------------------------->
</div>

</section>
<aside>
    <form class="" action="product_list_test.php">
        <input class="cart_search " name="search" placeholder="Search"
               value="<?= empty($search) ? '' : $search ?>">
        <button type="submit" class="cart_search_button fa fa-search"></button>
    </form>
    <ul>
        <?php while ($row = $big_a_rs->fetch_assoc()): ?>
            <li class="up"><a href="product_list_test.php?cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php while ($row = $sml_a_rs->fetch_assoc()): ?>
                <li class="cate_g">
                    <!--                    0418新增 hover icon小標籤-->
                    <i class="fa fa-tag" aria-hidden="true"></i>
                    <!-- end of 0418 新增-->
                    <a href="product_list_test.php?g_cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a>
                </li>
            <?php endwhile; ?>
        <?php endwhile; ?>

        <?php while ($row = $big_b_rs->fetch_assoc()): ?>
            <li class="up"><a href="product_list_test.php?cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php while ($row = $sml_b_rs->fetch_assoc()): ?>
                <li class="cate_g">
                    <!--                    0418新增 hover icon小標籤-->
                    <i class="fa fa-tag" aria-hidden="true"></i>
                    <!-- end of 0418 新增-->
                    <a href="product_list_test.php?g_cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a>
                </li>
            <?php endwhile; ?>
        <?php endwhile; ?>

        <?php while ($row = $big_c_rs->fetch_assoc()): ?>
            <li class="up"><a href="product_list_test.php?cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php while ($row = $sml_c_rs->fetch_assoc()): ?>
                <li class="cate_g">
                    <!--                    0418新增 hover icon小標籤-->
                    <i class="fa fa-tag" aria-hidden="true"></i>
                    <!-- end of 0418 新增-->
                    <a href="product_list_test.php?g_cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a>
                </li>
            <?php endwhile; ?>
        <?php endwhile; ?>

        <?php while ($row = $big_d_rs->fetch_assoc()): ?>
            <li class="up"><a href="product_list_test.php?cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php while ($row = $sml_d_rs->fetch_assoc()): ?>
                <li class="cate_g">
                    <!--                    0418新增 hover icon小標籤-->
                    <i class="fa fa-tag" aria-hidden="true"></i>
                    <!-- end of 0418 新增-->
                    <a href="product_list_test.php?g_cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a>
                </li>
            <?php endwhile; ?>
        <?php endwhile; ?>

        <?php while ($row = $big_e_rs->fetch_assoc()): ?>
            <li class="up"><a href="product_list_test.php?cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php while ($row = $sml_e_rs->fetch_assoc()): ?>
                <li class="cate_g">
                    <!--                    0418新增 hover icon小標籤-->
                    <i class="fa fa-tag" aria-hidden="true"></i>
                    <!-- end of 0418 新增-->
                    <a href="product_list_test.php?g_cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a>
                </li>
            <?php endwhile; ?>
        <?php endwhile; ?>

        <?php while ($row = $big_f_rs->fetch_assoc()): ?>
            <li class="up"><a href="product_list_test.php?cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a></li>
            <?php while ($row = $sml_f_rs->fetch_assoc()): ?>
                <li class="cate_g">
                    <!--                    0418新增 hover icon小標籤-->
                    <i class="fa fa-tag" aria-hidden="true"></i>
                    <!-- end of 0418 新增-->
                    <a href="product_list_test.php?g_cate=<?= $row['sid'] ?>"><?= $row['name'] ?></a>
                </li>
            <?php endwhile; ?>
        <?php endwhile; ?>
    </ul>
</aside>
</div>

<script>
    $(function () {
        $('.lbtn_1').click(function () {
            $('.lbtn_1').addClass('lovehide');
            $('.lbtn_2').removeClass('lovehide');
        });
        $('.lbtn_2').click(function () {
            $('.lbtn_2').addClass('lovehide');
            $('.lbtn_1').removeClass('lovehide');
        });

        $('.lbtn_3').click(function () {
            $('.lbtn_3').addClass('lovehide');
            $('.lbtn_4').removeClass('lovehide');
        });
        $('.lbtn_4').click(function () {
            $('.lbtn_4').addClass('lovehide');
            $('.lbtn_3').removeClass('lovehide');
        });

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

        //        -------------------------------421更改地方------------------------------------------
        $('.cart_love').click(function () {
//            $(this).toggleClass('likebtn');
            var sid = $(this).attr('data-sid');
            $.get('add_to_like_all.php', {sid: sid}, function (data) {

            }, 'json');
        });

        $('.like_btn').click(function () {
            $(this).toggleClass('likecolor');
            var sid = $(this).attr('data-gun');
            $.get('add_to_like_all.php', {sid: sid}, function (data) {

            }, 'json');
        });
//        -------------------------------------------------------------------------------------


        $('#slider').bxSlider({
            slideWidth: 310,
        minSlides: 3,
        maxSlides: 3,
        moveSlides: 1,
        slideMargin: 10
    });
//        $('.slide_border').click(function () {
//            $('.slide_border').addClass('border_1');
//        });

        $('.buy_btn_prod').click(function () {
            var sid = $(this).attr('data-gun');
            var qty = $(this).closest('.cart_list').find('.qty').val();

            $.get('add_to_cart.php', {sid: sid, qty: qty}, function (data) {
//                alert("已加入追蹤清單123");

            }, 'json');
        });


        var $showImage = $('#show-image');

        // 當滑鼠移到 .abgne-block-20120106 中的某一個超連結時
        $('.abgne-block-20120106 a').mouseover(function () {
            // 把 #show-image 的 src 改成被移到的超連結的位置
            $showImage.attr('src', $(this).attr('href'));
        }).click(function () {
            // 如果超連結被點擊時, 取消連結動作
            return false;
        });

        $('.buy_btn').click(function () {
            var sid = $(this).attr('data-sid');
            var qty = $(this).closest('.caption').find('.qty').val();

            $.get('add_to_cart.php', {sid: sid, qty: qty}, function (data) {
                alert("已加入購物車");

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
