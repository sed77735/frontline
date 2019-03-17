<?php

require __DIR__ . '/__connect_db.php';

$pname = 'activity';

if (isset($_SESSION['server'])){
    unset($_SESSION['server']);
}

if (isset($_SESSION['team_members'])){
    unset($_SESSION['team_members']);
}


$sql = sprintf("SELECT * FROM `products` WHERE `type` = 0 AND `activated` = 0 order by rand()");

$result = $mysqli->query($sql);


?>


<?php include __DIR__.'/__html_head.php'?>
<link rel="stylesheet" href="css/activity_finished_list.css">
    <style>

        body {
            font-family: Microsoft JhengHei;
        }

    </style>

<?php include __DIR__ . '/__navbar.php' ?>

    <!--    0415新增輪播html   刪掉了原本的activity finished-->
    <div class="slide_container">
        <div class="slidewrap">
            <a href="activity_finished_list.php">
                <div id="mouse_scroll_icon"><img src="image/moscroll_icon.png" alt=""></div>

                <h2>幕後花絮</h2>
                <div class="split-slideshow">
                    <div class="slideshow">
                        <div class="slider">
                            <div class="item">
                                <img src="image/1.jpg">
                            </div>
                            <div class="item">
                                <img src="image/2.jpg">
                            </div>
                            <div class="item">
                                <img src="image/3.jpg">
                            </div>
                        </div>
                    </div>
                    <div class="slideshow-text">

                        <div class="item">
                            <span>SCROLL</span>

                            <!--<div class="mouse_scroll_icon">-->
                            <!--<img  src="image/mosue_scroll_icon.png" alt="">-->
                            <!--</div>-->
                            <!--<span class="scroll-btn">-->
                            <!--<a href="#">-->
                            <!--<span class="mouse">-->
                            <!--<span>-->
                            <!--</span>-->
                            <!--</span>-->
                            <!--</a>-->
                            <!--<p>scroll me</p>-->

                            <!--</span>-->
                        </div>
                        <div class="item">Desert</div>
                        <div class="item">WILD</div>
                        <div class="item">PLAY</div>
                    </div>
                </div>
            </a>
        </div>  <!--end of slidewrap-->
    </div>
    <!--   end of 0415新增輪播html-->

    <div class="activity_wrap">



        <div id="container" class="flexbox">

            <?php while ($row = $result->fetch_assoc()): ?>
             <div class="activity_title flexbox item transition">

                 <a href="single_activity_finished.php?type=0&sid=<?= $row['sid']?>&activated=0">
                 <div class="activity_title_img flexbox">
                    <img src="activity_img/<?= $row['head_image'] ?>" alt="">
                    <div class="flexbox">
                        <h2><?= $row['name'] ?></h2>
                        <p><?= $row['host'] ?></p>
                    </div>
                    <span>已結束</span>
                </div>
                 </a>
                <div class="activity_title_info">
                    <ul class="flexbox">
                        <li><p>地形</p><span><?= $row['ground'] ?></span></li>
                        <?php if ($row['game_qty']==2): ?>
                        <li class="flexbox">
                            <p>遊戲模式</p>
                            <div><img src="image/<?= $row['mode'] ?>.png" alt=""></div>
                            <div><img src="image/<?= $row['mode2'] ?>.png" alt=""></div></li>
                        <?php else: ?>
                        <li class="flexbox">
                            <p>遊戲模式</p>
                            <div><img src="image/<?= $row['mode'] ?>.png" alt=""></div>
                            <?php endif; ?>
                        <li><p>時間</p><span><?= date("Y-m-d", strtotime($row["date"])) ?></span></li>
                        <li><p>人數</p><span><?= $row['people'] ?> 人</span></li>
                        <li><p>參加費用</p><span><?= $row['price'] ?></span></li>
                    </ul>
                </div>

            </div>
            <?php endwhile; ?>



        </div>
    </div>



    <!--0415新增輪播-->
    <script src='js/jquery-mousewheel/jquery.mousewheel.js'></script>
    <script src='js/slick/slick.min.js'></script>

    <script src="js/index.js"></script>

    <!--0415新增輪播-->


<script>



    // 瀑布流----------------------------------------
//    $(function(){
//        var $container = $('#container');
//        $container.imagesLoaded(function(){
//            $container.masonry({
//                itemSelector : '.item',
//                isAnimated: true,
//                columnWidth : 240
//            });
//        });
//    });

        $(function(){
            $('#container').masonry({
                itemSelector : '.item',
                isAnimated: false
    //            columnWidth : 207
            });
        });



</script>

<?php include __DIR__ . '/__html_foot.php' ?>