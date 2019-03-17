<?php

require __DIR__ . '/__connect_db.php';

$pname = 'activity';

if (isset($_SESSION['server'])){
    unset($_SESSION['server']);
}

if (isset($_SESSION['activity_cart'])){
    unset($_SESSION['activity_cart']);
}

if (isset($_SESSION['activity_img'])){
    unset($_SESSION['activity_img']);
}

if (isset($_SESSION['team_members'])){
    unset($_SESSION['team_members']);
}


$people_sql = 'SELECT `people`, `people_value` FROM `activity_categories` WHERE sid != 6';

$people_rs = $mysqli->query($people_sql);


$date_sql = 'SELECT `date`, `date_value` FROM `activity_categories` WHERE sid != 5 AND sid != 6';

$date_rs = $mysqli->query($date_sql);


$ground_sql = 'SELECT `ground`, `ground_value` FROM `activity_categories` WHERE sid != 6';

$ground_rs = $mysqli->query($ground_sql);


$mode_sql = 'SELECT `mode`, `mode_value` FROM `activity_categories` WHERE 1';

$mode_rs = $mysqli->query($mode_sql);


$host_sql = 'SELECT `host`, `host_value` FROM `activity_categories` WHERE sid != 6';

$host_rs = $mysqli->query($host_sql);


$sql = "SELECT * FROM `products` WHERE `type` = 0 AND `activated` = 1 ORDER BY rand()";

$result = $mysqli->query($sql);

//
$t_sql = "SELECT `sid`, `name`, `code`, `image` FROM `team` WHERE 1 ORDER BY rand() ASC LIMIT 0,4";

$t_result = $mysqli->query($t_sql);


//排行榜---------------------------------------------------------------

$g_sql = sprintf("SELECT * FROM `game` ORDER BY rand() LIMIT 3");

$g_result = $mysqli->query($g_sql);
//
//$g_row = $g_result->fetch_assoc();

$g_round_ar = array();
$g_row_arr = array();
while($g_row=$g_result->fetch_assoc()){
    $g_round_ar[] = $g_row;
    $g_row_arr[$g_row['team1_sid']]=1;
    $g_row_arr[$g_row['team2_sid']]=1;
}
$keys = array_keys($g_row_arr);
$t1_sql = sprintf("SELECT * FROM `team` WHERE sid IN (%s)", implode(',',$keys ));
//echo $t1_sql;

$t1_result = $mysqli->query($t1_sql);

$member_data = array();

while ($t1_row = $t1_result->fetch_assoc()) {
//    $row['qty'] = $_SESSION['cart'][$row['sid']];

    $member_data[$t1_row['sid']] = $t1_row;
}



?>


<?php include __DIR__.'/__html_head.php'?>
    <link rel="stylesheet" href="css/activity_list.css">
    <style>

        body {
            font-family: Microsoft JhengHei;
        }

        select {
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

        <div class="activity_progress flexbox">
            <div class="activity_list">

                <select class="people" name="people" onchange="Change(this.value)">
                    <?php while ($people_row = $people_rs->fetch_assoc()): ?>
                    <option value="<?= $people_row['people_value'] ?>"><?= $people_row['people'] ?></option>
                    <?php endwhile; ?>
                </select>

                <select class="date" name="date" onchange="Change(this.value)">
                    <?php while ($date_row = $date_rs->fetch_assoc()): ?>
                    <option value="<?= $date_row['date_value'] ?>"><?= $date_row['date'] ?></option>
                    <?php endwhile; ?>
                </select>

                <select class="ground" name="ground" onchange="Change(this.value)">
                    <?php while ($ground_row = $ground_rs->fetch_assoc()): ?>
                        <option value="<?= $ground_row['ground_value'] ?>"><?= $ground_row['ground'] ?></option>
                    <?php endwhile; ?>
                </select>

                <select class="mode" name="mode" onchange="Change(this.value)">
                    <?php while ($mode_row = $mode_rs->fetch_assoc()): ?>
                        <option value="<?= $mode_row['mode_value'] ?>"><?= $mode_row['mode'] ?></option>
                    <?php endwhile; ?>
                </select>

                <select class="host" name="host" onchange="Change(this.value)">
                    <?php while ($host_row = $host_rs->fetch_assoc()): ?>
                        <option value="<?= $host_row['host_value'] ?>"><?= $host_row['host'] ?></option>
                    <?php endwhile; ?>
                </select>



                <div id="container">
                    <?php

                    //$rnd
                    $i=0;

                    while ($row = $result->fetch_assoc()): ?>

                        <div class="item_activity">
                            <div class="activity_img">
                                <a href="single_activity.php?type=<?= $row["type"] ?>&sid=<?= $row["sid"] ?>">
                                    <img src="activity_img/<?= $row['head_image'] ?>" alt="">
                                    <p> <?= $row["name"] ?></p>
                                    <span>進行中</span>
                                </a>
                            </div>
                            <div class="info">
                                <ul>
                                    <li><h4>遊戲日期：</h4><br/>&nbsp;&nbsp;&nbsp;&nbsp;<?= date("Y-m-d  H:i", strtotime($row["date"])) ?></li>
                                    <li><h4>地形：</h4><br/>&nbsp;&nbsp;&nbsp;&nbsp;<?= $row["ground"] ?></li>
                                    <?php if ($row['game_qty']==1): ?>
                                    <li><h4>遊戲模式：</h4><br/>
                                        &nbsp;&nbsp;&nbsp;&nbsp;第一場：<?= $row["mode"] ?>
                                    <?php else: ?>
                                    <li><h4>遊戲模式：</h4><br/>
                                        &nbsp;&nbsp;&nbsp;&nbsp;第一場：<?= $row["mode"] ?><br/>
                                        &nbsp;&nbsp;&nbsp;&nbsp;第二場：<?= $row["mode2"] ?></li>
                                    <?php endif; ?>
                                    <li><h4>報名人數：</h4><br/>&nbsp;&nbsp;&nbsp;&nbsp;<?= $row["people"] ?></li>
                                    <li><h4>主辦單位：</h4><br/>&nbsp;&nbsp;&nbsp;&nbsp;<?= $row["host"] ?></li>
                                </ul>
                                <ul class="flexbox">
                                    <li><a href="activity_join.php?type=<?= $row["type"] ?>&sid=<?= $row["sid"] ?>">報名參加</a></li>
<!--                                    <li><i class="fa fa-heart-o fa-2x like_btn" aria-hidden="true" data-sid="--><?//= $row['sid'] ?><!--"></i></li>-->
<!--                                    <li><img class="join_img like_btn" src="image/wishlist.png" alt=""  data-sid="--><?//= $row['sid'] ?><!--"></li>-->
<!--                                    <i class="buy_btn fa fa-shopping-cart fa-2x cart_icon" data-sid="--><?//= $row['sid'] ?><!--"></i>-->
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
                                            <li><div class="cart_love like_btn <?=  $class ?>" aria-hidden="true" data-sid="<?= $row['sid'] ?>"></div></li>
                                        <?php }else{ ?>
                                    <li><div class="cart_love like_btn " aria-hidden="true" data-sid="<?= $row['sid'] ?>"></div></li>
                                        <?php } ?>
                                    <?php }else{ ?>
                                    <li><a href="members.php"><div class="cart_love like_btn " aria-hidden="true" data-sid="<?= $row['sid'] ?>"></div></a></li>
                                    <?php } ?>



                                </ul>
                            </div>
                        </div>
                    <?php $i++; endwhile; ?>





                </div>

            </div>


            <div class="activity_aside">

                <div class="activity_click flexbox">
                    <a class="create" href="create_activity.php"><div><p>舉辦活動</p></div></a>
                    <a class="party" href="party_page.php"><div><p>客製化派隊</p></div></a>
                </div>

                <div class="activity_group_info">
                    <div> <h2>團隊介紹</h2> </div>
                    <table>
                        <?php while ($t_row = $t_result->fetch_assoc()): ?>
                        <tr>
                            <th><img src="team_img/<?= $t_row['code'] ?>/<?= $t_row['image'] ?>" alt=""></th>
                            <td><span><?= $t_row['code'] ?></span></td>
                            <td><p><a href="team_info.php?sid=<?= $t_row['sid'] ?>">...</a><?= $t_row['name'] ?></p></td>
                        </tr>
                        <?php endwhile; ?>
                    </table>
                    <div class="activity_more"><a href="team_list.php">查看更多</a></div>
                </div>

                <div class="activity_ranking">
                    <div> <h2>排行榜</h2> </div>
                    <div>
                        <?php  foreach($g_round_ar as $gr):
                        $team1 = $member_data[$gr['team1_sid']];
                        $team2 = $member_data[$gr['team2_sid']];
                        ?>
                        <div class="activity_score flexbox">
                            <div class="activity_left activity_group">
                                <div><img src="team_img/<?= $team1['code'] ?>/<?= $team1['image'] ?>" alt=""></div>
                                <p><?= $team1['name'] ?></p>
                                <span><?= $gr['team1_win'] ?></span>
                            </div>
                            <div class="activity_middle"><p>:</p></div>
                            <div class="activity_right activity_group">
                                <div><img src="team_img/<?= $team2['code'] ?>/<?= $team2['image'] ?>" alt=""></div>
                                <p><?= $team2['name'] ?></p>
                                <span><?= $gr['team2_win'] ?></span>
                            </div>
                        </div>
                        <?php  endforeach; ?>

                    </div>
                    <div class="activity_more"><a href="game_list.php">查看更多</a></div>
                </div>

            </div>

        </div>




    </div>

    <!--0415新增輪播-->
    <script src='js/jquery-mousewheel/jquery.mousewheel.js'></script>
    <script src='js/slick/slick.min.js'></script>

    <script src="js/index.js"></script>

    <!--0415新增輪播-->


<script type="text/javascript">


    //加入追蹤------------------------------------------------
    $('li').on('click','.like_btn',function () {
//        alert('活動已加入追蹤');
        $(this).toggleClass('likecolor');
        var sid = $(this).attr('data-sid');
        $.get('add_to_like_all.php', {sid: sid}, function (data) {

        }, 'json');
    });



    //篩選瀑布流-----------------------------------------------
    function Change() {
        var people = $('.people').val();
        var date = $('.date').val();
        var ground = $('.ground').val();
        var mode = $('.mode').val();
        var host = $('.host').val();

        console.log(people,date,ground,mode,host);

        $.post('change_list_select.php', {people:people,
            date:date,ground:ground,mode:mode,host:host}, function (data) {
            $('#container').html(data);
            $('#container').masonry( 'destroy' );
            $('#container').masonry({
                itemSelector : '.item_activity',
                isAnimated: false
//            columnWidth : 207
            });

            $('li').on('click','.like_btn',function () {
//                alert('活動已加入追蹤');
                $(this).toggleClass('likecolor');
                var sid = $(this).attr('data-sid');
                $.get('add_to_like_all.php', {sid: sid}, function (data) {

                }, 'json');
            });

        });



    }

    //篩選連動下拉式選單-----------------------------------------------
//    function Change_people() {
//        var ground = $('.ground').val();
//
//        console.log(ground);
//
//        $.post('change_select_people.php', { ground:ground }, function (data) {
//            $('.people').html(data);
//        });
//    }
//
//    function Change_mode() {
//        var ground = $('.ground').val();
//
//        console.log(ground);
//
//        $.post('change_select_mode.php', { ground:ground }, function (data) {
//            $('.mode').html(data);
//        });
//    }

    // 瀑布流----------------------------------------
    jQuery(window).on('load', function(){
//    $(function(){
        var $container = $('#container');
        $container.imagesLoaded(function(){
            $container.masonry({
                itemSelector : '.item_activity',
                isAnimated: true,
                resizeable: true

//                columnWidth : 240
            });
        });
    });





//    $(function(){
//        $('#container').masonry({
//            itemSelector : '.item_activity',
//            isAnimated: false
//            columnWidth : 207
//        });
//    });

</script>


<?php include __DIR__ . '/__html_foot.php' ?>