
<!--<link rel="stylesheet" href="style/reset.css">-->

<header id="nav_pc" class="navigation">
    <div class="nav_container">
        <div class="logo">
            <div><img src="image/logo_nav.png" alt=""></div>
        </div>

        <ul class="nav">
            <li class="nav_li <?= $pname=='none' ? 'active_bar' : '' ?>" data-x="-80px">
                <a href="index.html">首　　頁<span class="bottom_bar"></span></a>
            </li>

            <li class="nav_li <?= $pname=='ground' ? 'active_bar' : '' ?>" data-x="50px">
                <a href="ground.php">詳細介紹</a>
<!--                <ul class="sub_nav transition_nav">-->
<!--                    <li><a href="">叢　　林</a></li>-->
<!--                    <li><a href="">城　　鎮</a></li>-->
<!--                    <li><a href="">廣　　場</a></li>-->
<!--                    <li><a href="">室內作戰</a></li>-->
<!--                </ul>-->
            </li>

            <li class="nav_li <?= $pname=='activity' ? 'active_bar' : '' ?>" data-x="180px">
                <a class="" href="activity_list.php">參加活動</a>
                <ul class="transition_nav">
                    <li><a href="activity_list.php">活動列表</a></li>
                    <li><a href="create_activity.php">舉辦活動</a></li>
                    <li><a href="party_page.php">客製化派對</a></li>
                    <li><a href="activity_finished_list.php">幕後花絮</a></li>
                </ul>
            </li>

            <li class="nav_li <?= $pname=='team' ? 'active_bar' : '' ?>" data-x="310px">
                <a href="team_list.php">團隊資訊</a>
                <ul class="transition_nav">
                    <li><a href="team_list.php">團隊列表</a></li>
                    <li><a href="game_list.php">排 行 榜</a></li>
                    <li><a href="create_team.php">建立團隊</a></li>
                </ul>
            </li>

            <li class="nav_li <?= $pname=='product' ? 'active_bar' : '' ?> " data-x="440px">
                <a href="product_list_test.php">裝備列表</a>
            </li>
        </ul>

        <ul class="nav_right">

            <?php if (isset($_SESSION['user'])): ?>
           
            <a href="members.php"><span id="username" style="color: <?= $_SESSION['user']['gender'] == "女" ? "#E7418D" : "#61D6C8" ?>"><?= $_SESSION['user']['name'] ?></span></a>
            <?php endif; ?>
            <li class="user_head"><a href="members.php"><img src="image/non_member_small.png" alt=""></a></li>
            <li id="cart_nav"><a href="cart_list_test.php"><img src="image/cart.svg" alt=""></a></li>
            <li><a href="aboutus.php"><img src="image/about.svg" alt=""></a></li>
        </ul>


        <ul id="ccart_nav">

        </ul>


    </div>
</header>       <!--.navigation_pc-->

<div id="nav_phone" >
    <header class="navigation flexbox">

        <div class="menu transition_nav hum">
            <div class="allbar">
                <div class="bar bar1 transition_nav"></div>
                <div class="bar bar2 transition_nav"></div>
                <div class="bar bar3 transition_nav"></div>
            </div>
        </div><!-- menu -->

        <div class="logo">
            <div><img src="image/logo_nav.png" alt=""></div>
        </div>

        <ul class="nav_right">
            <li><a href="members.php"><img src="image/non_member_small.png" alt=""></a></li>
            <li><a href="cart_list_test.php"><img src="image/cart.svg" alt=""></a></li>
        </ul>
    </header><!--.navigation_phone-->

    <ul class="nav transition_nav">
        <li class="nav_li">
            <a href="index.html">首　　頁</a>
        </li>

        <li class="nav_li">
            <a href="ground.php" class="">詳細介紹</a><div><span class="transition_nav"> < </span></div>
<!--            <ul class="sub_nav transition_nav">-->
<!--                <li><a href="">叢　　林</a></li>-->
<!--                <li><a href="">城　　鎮</a></li>-->
<!--                <li><a href="">廣　　場</a></li>-->
<!--                <li><a href="">室內作戰</a></li>-->
<!--            </ul>-->
        </li>

        <li class="nav_li ">
            <p class="">參加活動</p><div><span class="transition_nav"> < </span></div>
            <ul class="sub_nav transition_nav">
                <li><a href="activity_list.php">活動列表</a></li>
                <li><a href="create_activity.php">舉辦活動</a></li>
                <li><a href="party_page.php">客製化派對</a></li>
                <li><a href="activity_finished_list.php">幕後花絮</a></li>
            </ul>
        </li>

        <li class="nav_li">
            <p class="">團隊資訊</p><div><span class="transition_nav"> < </span></div>
            <ul class="sub_nav transition_nav">
                <li><a href="team_list.php">團隊列表</a></li>
                <li><a href="game_list.php">排 行 榜</a></li>
                <li><a href="create_team.php">建立團隊</a></li>
            </ul>
        </li>

        <li class="nav_li">
            <a href="product_list_test.php">裝備列表</a>
        </li>
    </ul>
</div>





<script>


    // 導覽列------手機板----------------------------------------
    $(".menu").click(function(){
        $(this).toggleClass('active');
    });

    $(".menu").click(function(){
        $(".nav").toggleClass('active');
    });

    $(".nav_li").click(function(){
        $(this).find('.sub_nav').toggleClass('active').siblings().toggleClass('active');
    });

    $(".nav_li").click(function(){
        $(this).find('span').toggleClass('active');
    });


    // 導覽列------電腦板----------------------------------
    var x = $('.active_bar').data("x");
    $(".bottom_bar").css({marginLeft:x});

    $(".nav_li a").mouseover(function(){
        var x = $(this).parent(".nav_li").data("x");

        $(".bottom_bar").stop().animate({marginLeft:x}, 200);
    });

    $(".nav_li a").mouseout(function () {
//        $(".nav_li ul").css(display="block");

        var x = $('.active_bar').data("x");
        $(".bottom_bar").stop().animate({marginLeft: x}, 200);
    });

</script>