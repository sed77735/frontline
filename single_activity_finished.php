<?php

require __DIR__ . '/__connect_db.php';

$pname = 'activity';

if (isset($_SESSION['activity_cart'])){
    unset($_SESSION['activity_cart']);
}

if (isset($_SESSION['server'])){
    unset($_SESSION['server']);
}

if (isset($_SESSION['team_members'])){
    unset($_SESSION['team_members']);
}


$sid = isset($_GET['sid']) ? intval($_GET['sid']) : 0;
$type = isset($_GET['type']) ? intval($_GET['type']) : 1;
$activated = isset($_GET['activated']) ? intval($_GET['activated']) : 1;

$s_sql = "SELECT * FROM `products` WHERE `sid` = $sid AND `activated` = 0";
$s_result = $mysqli->query($s_sql);

if ( !$s_result->num_rows || !$type==0 || !$activated==0 ){
    header("Location: activity_list.php");
    exit;
}



$p_sql = "SELECT p.`people`, a.`people_value`, a.`total_people`
FROM `products` p INNER JOIN `activity_categories` a
ON p.`people` = a.`people` WHERE p.sid = $sid";
$p_result = $mysqli->query($p_sql);
$p_row = $p_result->fetch_assoc();


$g_sql = "SELECT p.`ground`, a.`ground_value`, a.`ground_intorduction` 
FROM `products` p INNER JOIN `activity_categories` a 
ON p.`ground` = a.`ground` WHERE p.sid = $sid";
$g_result = $mysqli->query($g_sql);
$g_row = $g_result->fetch_assoc();


$m_sql = "SELECT p.`mode`, a.`mode_value`, a.`mode_intorduction` , a.`mode_win_condition`
FROM `products` p INNER JOIN `activity_categories` a 
ON p.`mode` = a.`mode` WHERE p.sid = $sid";
$m_result = $mysqli->query($m_sql);
$m_row = $m_result->fetch_assoc();

$m2_sql = "SELECT p.`mode2`, a.`mode_value`, a.`mode_intorduction` , a.`mode_win_condition`
FROM `products` p INNER JOIN `activity_categories` a 
ON p.`mode2` = a.`mode` WHERE p.sid = $sid";
$m2_result = $mysqli->query($m2_sql);
$m2_row = $m2_result->fetch_assoc();



$sql = "SELECT * FROM `products` WHERE `type` = 0 AND `sid`= $sid AND `activated` = 0 ";
$result = $mysqli->query($sql);
$row = $result->fetch_assoc();


$mhost_sql = "SELECT m.name as mname, m.image as mimage, m.email as memail, m.hash as mhash
                FROM `products` p JOIN `members` m
                ON p.members_sid = m.sid WHERE p.sid =".$_GET['sid'];

$mhost_result = $mysqli->query($mhost_sql);
$mhost_row = $mhost_result->fetch_assoc();

$thost_sql = "SELECT m.name as mname, m.image as mimage, m.email as memail, m.hash as mhash, 
                t.sid as tsid, t.name as tname, t.image as timage, t.code as tcode FROM `products` p JOIN `members` m 
                ON p.members_sid = m.sid JOIN `team` t 
                ON p.team_sid = t.sid WHERE p.sid =".$_GET['sid'];

$thost_result = $mysqli->query($thost_sql);
$thost_row = $thost_result->fetch_assoc();



?>


<?php include __DIR__.'/__html_head.php'?>
<link rel="stylesheet" href="css/single_activity_finished_list.css">
    <!--    0415新增 位置不能變喔瀑布流要在最下面-->
    <!-- Insert to your webpage before the </head> -->
    <script src="carouselengine/jquery.js"></script>
    <script src="carouselengine/amazingcarousel.js"></script>
    <link rel="stylesheet" type="text/css" href="carouselengine/initcarousel-1.css">
    <script src="carouselengine/initcarousel-1.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script><!--瀑布流-->
    <script src='http://imagesloaded.desandro.com/imagesloaded.pkgd.js'></script><!--imagesloaded-->
    <style>

        body {
            font-family: Microsoft JhengHei;
        }

    </style>

<?php include __DIR__ . '/__navbar.php' ?>

    <div class="activity_wrap">

        <div class="activity_inner_wrap">
            <div style="height: 50px"></div>

            <div class="activity_finished_title flexbox">
                <h2>活動花絮照片</h2>
                <p><?= date("Y-m-d", strtotime($row["date"])) ?></p>
            </div>

            <!-- Insert to your webpage where you want to display the carousel -->
            <div id="amazingcarousel-container-1">
                <div id="amazingcarousel-1" style="display:none;position:relative;width:100%;max-width:1050px;margin:0px auto 0px;">
                    <div class="amazingcarousel-list-container">
                        <ul class="amazingcarousel-list">
                            <li class="amazingcarousel-item">
                                <div class="amazingcarousel-item-container">
                                    <div class="amazingcarousel-image"><a href="images/36226_1322127129545_4407646_n-lightbox.jpg" class="html5lightbox"><img src="images/36226_1322127129545_4407646_n.jpg" /></a></div>                    </div>
                            </li>
                            <li class="amazingcarousel-item">
                                <div class="amazingcarousel-item-container">
                                    <div class="amazingcarousel-image"><a href="images/36226_1322127209547_402960_n-lightbox.jpg" class="html5lightbox"><img src="images/36226_1322127209547_402960_n.jpg" /></a></div>                    </div>
                            </li>
                            <li class="amazingcarousel-item">
                                <div class="amazingcarousel-item-container">
                                    <div class="amazingcarousel-image"><a href="images/36226_1322127249548_2812130_n-lightbox.jpg" class="html5lightbox"><img src="images/36226_1322127249548_2812130_n.jpg" /></a></div>                    </div>
                            </li>
                            <li class="amazingcarousel-item">
                                <div class="amazingcarousel-item-container">
                                    <div class="amazingcarousel-image"><a href="images/36722_1327100293871_6960736_n-lightbox.jpg" class="html5lightbox"><img src="images/36722_1327100293871_6960736_n.jpg" /></a></div>                    </div>
                            </li>
                            <li class="amazingcarousel-item">
                                <div class="amazingcarousel-item-container">
                                    <div class="amazingcarousel-image"><a href="images/36722_1327100333872_3982299_n-lightbox.jpg" class="html5lightbox"><img src="images/36722_1327100333872_3982299_n.jpg" /></a></div>                    </div>
                            </li>
                            <li class="amazingcarousel-item">
                                <div class="amazingcarousel-item-container">
                                    <div class="amazingcarousel-image"><a href="images/38263_1341299968854_2129166_n-lightbox.jpg" class="html5lightbox"><img src="images/38263_1341299968854_2129166_n.jpg" /></a></div>                    </div>
                            </li>
                            <li class="amazingcarousel-item">
                                <div class="amazingcarousel-item-container">
                                    <div class="amazingcarousel-image"><a href="images/41137_1380999481317_1739227_n-lightbox.jpg" class="html5lightbox"><img src="images/41137_1380999481317_1739227_n.jpg" /></a></div>                    </div>
                            </li>
                            <li class="amazingcarousel-item">
                                <div class="amazingcarousel-item-container">
                                    <div class="amazingcarousel-image"><a href="images/41337_1381011761624_7845782_n-lightbox.jpg" class="html5lightbox"><img src="images/41337_1381011761624_7845782_n.jpg" /></a></div>                    </div>
                            </li>
                            <li class="amazingcarousel-item">
                                <div class="amazingcarousel-item-container">
                                    <div class="amazingcarousel-image"><a href="images/45663_1380999361314_6123762_n-lightbox.jpg" class="html5lightbox"><img src="images/45663_1380999361314_6123762_n.jpg" /></a></div>                    </div>
                            </li>
                        </ul>
                        <div class="amazingcarousel-prev"></div>
                        <div class="amazingcarousel-next"></div>
                    </div>
                    <div class="amazingcarousel-nav"></div>
                    <div class="amazingcarousel-engine"><a href="http://amazingcarousel.com">jQuery Image Scroller</a></div>
                </div>
            </div>
            <!-- End of body section HTML codes -->


<!--            </div>-->

            <div class="activity_finished_record_all">
                <h2>當日比賽流程記錄</h2>

                <div class="activity_finished_record flexbox">

                    <div class="activity_finished_record_left flexbox">
                        <h2>第一場:</h2>
                        <p>地形0<?= $g_row['ground_value'] ?>-<?= $row['ground'] ?> <br/><br/>

                        A隊於3:05時擊敗B隊<br/>
                        得分數98分<br/>
                        擊中率72%<br/>
                        </p>
                    </div>

                    <div class="activity_finished_record_right flexbox">
                        <div class="hhh"><a href=""><img src="image/<?= $row['ground'] ?>_map.jpg" alt=""></a></div>
                        <div>
                            <p>
                                遊戲時間: <br/><?= date("Y-m-d H:i", strtotime($row["date"])) ?><br/>
                                遊戲類型:<?= $row['mode'] ?><br/>
                                遊戲人數:<?= $row['people'] ?><br/>
                            </p>
                            <div class="mode_img"><img src="image/<?= $row['mode'] ?>.png" alt=""></div>
                        </div>

                    </div>
                </div>

                <?php if ($row['game_qty']==2): ?>

                <div class="activity_finished_record flexbox">

                    <div class="activity_finished_record_left flexbox">
                        <h2>第二場:</h2>
                        <p>地形0<?= $g_row['ground_value'] ?>-<?= $row['ground'] ?> <br/><br/>

                            A隊於3:05時擊敗B隊<br/>
                            得分數98分<br/>
                            擊中率72%<br/>
                        </p>
                    </div>

                    <div class="activity_finished_record_right flexbox">
                        <div class="hhh"><a href=""><img src="image/<?= $row['ground'] ?>_map.jpg" alt=""></a></div>
                        <div>
                            <p>
                                遊戲時間: <br/><?= date("Y-m-d H:i", strtotime($row["date"])) ?><br/>
                                遊戲類型:<?= $row['mode2'] ?><br/>
                                遊戲人數:<?= $row['people'] ?><br/>
                            </p>
                            <div class="mode_img"><img src="image/<?= $row['mode2'] ?>.png" alt=""></div>
                        </div>

                    </div>
                </div>
                <?php endif; ?>

            </div>



            <div id="container">
                <h2>活動參加評價</h2>
                <div class="activity_finished_evaluation flexbox item">
                    <div class="activity_finished_evaluation_user">
                        <img src="image/BryanMills.jpg" alt="">
                        <p>最強老爸</p>
                    </div>
                    <div class="activity_finished_evaluation_text flexbox">
                        <div class="star">
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                        </div>
                        <div class="flexbox">
                            <i class="fa fa-quote-left" aria-hidden="true"></i>
                            <p>阿怪超龜的啦，新的場地也太好躲了吧，
                                街道的部分安排得不錯，但有些地方暗
                                了點，建議店家可以增加照明設備。
                            </p>
                            <i class="fa fa-quote-right" aria-hidden="true"></i>
                        </div>

                    </div>

                </div>
                <div class="activity_finished_evaluation flexbox item">
                    <div class="activity_finished_evaluation_user">
                        <img src="image/mumu.jpg" alt="">
                        <p>高慕涵</p>
                    </div>
                    <div class="activity_finished_evaluation_text flexbox">
                        <div class="star">
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                        </div>
                        <div class="flexbox">
                            <i class="fa fa-quote-left" aria-hidden="true"></i>
                            <p>明年就約在廣場！──被水槍噴進護目鏡的Mumu</p>
                            <i class="fa fa-quote-right" aria-hidden="true"></i>
                        </div>

                    </div>

                </div>

                <div class="activity_finished_evaluation flexbox item">
                    <div class="activity_finished_evaluation_user">
                        <img src="image/TopGun.jpg" alt="">
                        <p>阿湯</p>
                    </div>
                    <div class="activity_finished_evaluation_text flexbox">
                        <div class="star">
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                        </div>
                        <div class="flexbox">
                            <i class="fa fa-quote-left" aria-hidden="true"></i>
                            <p>也許店家可以考慮辦個水槍派對活動。</p>
                            <i class="fa fa-quote-right" aria-hidden="true"></i>
                        </div>

                    </div>

                </div>

                <div class="activity_finished_evaluation flexbox item">
                    <div class="activity_finished_evaluation_user">
                        <img src="image/jake.jpg" alt="">
                        <p>老皮</p>
                    </div>
                    <div class="activity_finished_evaluation_text flexbox">
                        <div class="star">
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                        </div>
                        <div class="flexbox">
                            <i class="fa fa-quote-left" aria-hidden="true"></i>
                            <p>作得超酷的，場地推一個。</p>
                            <i class="fa fa-quote-right" aria-hidden="true"></i>
                        </div>

                    </div>

                </div>

                <div class="activity_finished_evaluation flexbox item">
                    <div class="activity_finished_evaluation_user">
                        <img src="image/holmes1.jpg" alt="">
                        <p>福爾摩斯</p>
                    </div>
                    <div class="activity_finished_evaluation_text flexbox">
                        <div class="star">
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                            <i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i>
                        </div>
                        <div class="flexbox">
                            <i class="fa fa-quote-left" aria-hidden="true"></i>
                            <p>我居然看到了空軍基地的加油桶，到底是從哪弄來的......</p>
                            <i class="fa fa-quote-right" aria-hidden="true"></i>
                        </div>

                    </div>

                </div>




            </div>

        </div>




        <div class="activity_title flexbox">
            <div class="activity_title_left">
                <div class="activity_title_img flexbox">
                    <img src="activity_img/<?= $row['head_image'] ?>" alt="">

                </div>
                <div class="flexbox">
                    <h2><?= $row['name'] ?></h2>
                    <p><?= $row['host'] ?></p>
                </div>
                <span>已結束</span>
            </div>
            <div class="activity_title_info">
                <ul class="flexbox">
                    <li><p>地形</p><span><?= $row['ground'] ?></span></li>
                    <?php if ($row['game_qty']==2): ?>
                        <li class="flexbox"><p>遊戲模式</p><div><img src="image/<?= $row['mode'] ?>.png" alt=""></div><span><?= $row['mode'] ?></span>
                            <div><img src="image/<?= $row['mode2'] ?>.png" alt=""></div><span><?= $row['mode2'] ?></span></li>
                    <?php else: ?>
                        <li class="flexbox"><p>遊戲模式</p><div><img src="image/<?= $row['mode'] ?>.png" alt=""></div><span><?= $row['mode'] ?></span></li>
                    <?php endif; ?>
                    <li><p>時間</p><span><?= date("Y-m-d H:i", strtotime($row["date"])) ?></span></li>
                    <li><p>人數</p><span><?= $p_row['people'] ?></span></li>
                    <li><p>參加費用</p><span><?= $row['price'] ?>元 / 每人</span></li>
                </ul>

            </div>

            <div class="activity_title_join">
                <h2>活動已結束</h2>
            </div>

        </div>

        <div class="activity_content">

            <div class="activity_content_inner flexbox">
                <div class="activity_content_left">
                    <h3>活動內容</h3><br/>
                    <p><?= $row['intorduction'] ?></p>
                    <br/>
                    <h3>場地介紹</h3><br/>
                    <h4>地形0<?= $g_row['ground_value'] ?>-<?= $row['ground'] ?></h4>
                    <br/>
                    <p><?= $g_row['ground_intorduction'] ?></p>
                    <br/>

                    <h3>遊戲方式</h3><br/>

                    <?php if ($row['game_qty']==2): ?>

                        <h4>場數1：<?= $m_row['mode'] ?></h4>
                        <p><?= $m_row['mode_intorduction'] ?></p>
                        <h4>獲勝條件</h4>
                        <p><?= $m_row['mode_win_condition'] ?></p>
                        <br/>
                        <h4>場數2：<?= $m2_row['mode2'] ?></h4>
                        <p><?= $m2_row['mode_intorduction'] ?></p>
                        <h4>獲勝條件</h4>
                        <p><?= $m_row['mode_win_condition'] ?></p>
                        <h4>人數：</h4><span id="people"><?= $row['people'] ?></span>
                        <br/>
                        <br/>
                    <?php else: ?>

                        <h4>場數1：<?= $m_row['mode'] ?></h4>
                        <p><?= $m_row['mode_intorduction'] ?></p>
                        <h4>獲勝條件</h4>
                        <p><?= $m_row['mode_win_condition'] ?></p>
                        <br/>
                        <h4>人數：</h4><span id="people"><?= $row['people'] ?></span>
                        <br/>
                        <br/>
                    <?php endif; ?>

                    <h3>裝備限制</h3><br/>
                    <p><?= $row['equip_limit'] ?></p>
                    <br/>
                    <h3>備註</h3><br/>
                    <p><?= $row['active_note'] ?></p>
                    <p>40人以上，每隊擁有2名醫護兵 <br/>
                        32人以下，每隊擁有1名醫護兵。<br/>
                        醫護兵：醫護兵擁有將隊友復活的能力，在隊友陣亡60秒內抵達，站在陣亡隊友旁計時30秒後復活隊友。醫護兵無法復活自己。
                    </p>
                    <br/>
                </div>

                <div class="activity_content_right">
                    <h3>主辦方</h3>
                    <div class="activity_host flexbox">
                        <br/>

                        <?php if($row['host']=="店家主辦"): ?>
                            <div id="self">
                                <img src="image/frontline_squad.jpg" alt="">
                            </div>
                        <?php else: ?>

                            <?php if($row['host']=="槍隊比賽"): ?>
                                <a class="flexbox" href="team_info.php?sid=<?= $thost_row['tsid'] ?>">
                                    <img src="team_img/<?= $thost_row['tcode'] ?>/<?= $thost_row['timage'] ?>" alt="">
                                    <p><?= $thost_row['tname'] ?></p>
                                </a>
                            <?php endif; ?>

                            <div class="flexbox members_head">
                                <img src="user_img/<?= $mhost_row['mhash']?>/<?= $mhost_row['mimage'] ?>" alt="">
                                <p><?= $mhost_row['mname'] ?></p>
                            </div>
                            <p class="flexbox members_info">聯絡方式：<?= $mhost_row['memail'] ?></p>
                        <?php endif; ?>

                    </div>
                    <div class="activity_map">
                        <img src="image/<?= $row['ground'] ?>.jpg" alt="">
                        <div> <a href="ground.php"> 查看場地 </a> </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="join flexbox"><a href="activity_finished_list.php"> <h2 class="finish_h2">回上頁</h2></a> </div>





    </div>


<script>



    // 瀑布流----------------------------------------
//    $(function(){
//        var $container = $('#container');
//        $container.imagesLoaded(function(){
//            $container.masonry({
//                itemSelector : '.item',
//                isAnimated: true
////                columnWidth : 240
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