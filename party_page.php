<?php

require __DIR__ . '/__connect_db.php';

$pname = 'activity';

if (isset($_SESSION['server'])){
    unset($_SESSION['server']);
}

if (isset($_SESSION['team_members'])){
    unset($_SESSION['team_members']);
}



$mode_sql = 'SELECT `mode`, `mode_value` FROM `activity_categories` WHERE `sid` != 1';

$mode_rs = $mysqli->query($mode_sql);



?>



<?php include __DIR__.'/__html_head.php'?>
    <link rel="stylesheet" type="text/css" href="datepic/jquery.datetimepicker.css"/>
    <script src="lib/jquery-3.1.1.js"></script>
    <script src="datepic/jquery.js"></script>
    <script src="datepic/jquery.datetimepicker.full.js"></script>
    <link rel="stylesheet" href="css/party_page.css">
    <style>

        body {
            font-family: Microsoft JhengHei;
        }

    </style>

<?php include __DIR__ . '/__navbar.php' ?>

    <div class="party_page_wrap">


            <div class="party_page_title flexbox">
                <div class="create_activity_title_text ">
                    <h2>發起活動</h2>
                </div>
                <div class="create_activity_title_right flexbox-column">
                    <img class="party_title_bk" src="image/party_title_bk.jpg" alt="">
                    <img class="party_title_lightlogo" src="image/party_title_lightlogo.png" alt="">
                </div>
            </div>

            <div class="party_page_content">

                <div class="party_page_intro flexbox">
                        <div class="party_page_intro_left">
                            <img src="image/party_intro_target.png" alt="">
                        </div>

                        <div class="party_page_intro_right">
                            <h2>想像一種（生存遊戲）不再是只有迷彩、叢林感的生存遊戲，<br/>
                                而是五彩繽紛、夜店螢光感的專屬客製化生存遊戲。<br/></h2>

                            <h2>不管是生日派對、單身派對、婚宴派對、春酒尾牙、公司年度餐會<br/>
                                、聖誕派對、跨年晚會、家族日活動還是 校外教學，我們提供<br/>
                                專屬於您的客製化生存遊戲派對，是派對也是生存遊戲，<br/></h2>

                            <div class="party_page_intro_rightbottom flexbox">
                                <h3>我們所提供的遊戲類型：<br/>
                                    <i class="fa fa-check" aria-hidden="true"></i>水槍大戰派對<br/>
                                    <i class="fa fa-check" aria-hidden="true"></i>玩具槍大戰派對<br/>
                                    <i class="fa fa-check" aria-hidden="true"></i>水球大戰派對<br/>

                                </h3>
                                <h3>
                                    組合式加值服務項目包含：<br/>
                                    <i class="fa fa-check" aria-hidden="true"></i>特殊場地佈置造型<br/>
                                    <i class="fa fa-check" aria-hidden="true"></i>提供生存遊戲裝扮<br/>
                                    <i class="fa fa-check" aria-hidden="true"></i>客製化照片佈置需求<br/>

                                </h3>
                            </div>
                        </div>

                </div>

<!--0420新增底圖框框動畫-->

                <div class="draw_square flexbox">


                    <svg class="hello" viewBox="0 0 359.49 348.49">

                        <polygon class="cls-1" points="321.67 78.47 359.05 268.27 262.1 265.41 172.66 208.69 115 181.7 86.09 86.85 152.56 40.83 246.22 0.43 321.67 78.47"/>
                        <polygon class="cls-1" points="313.88 85.73 351.26 275.53 254.31 272.67 164.88 215.95 107.21 188.96 78.3 94.11 144.77 48.09 238.43 7.68 313.88 85.73"/>
                        <polygon class="cls-1" points="306.09 92.98 343.48 282.79 246.52 279.93 157.09 223.21 99.42 196.21 70.51 101.36 136.98 55.35 230.64 14.94 306.09 92.98"/>
                        <polygon class="cls-1" points="298.3 100.24 335.69 290.05 238.73 287.19 149.3 230.47 91.63 203.47 62.72 108.62 129.19 62.6 222.85 22.2 298.3 100.24"/>
                        <polygon class="cls-1" points="290.51 107.5 327.9 297.31 230.94 294.44 141.51 237.73 83.84 210.73 54.94 115.88 121.4 69.86 215.06 29.46 290.51 107.5"/>
                        <polygon class="cls-1" points="282.73 114.76 320.11 304.57 223.16 301.7 133.72 244.99 76.06 217.99 47.15 123.14 113.62 77.12 207.28 36.72 282.73 114.76"/>
                        <polygon class="cls-1" points="274.94 122.02 312.32 311.83 215.37 308.96 125.94 252.25 68.27 225.25 39.36 130.4 105.83 84.38 199.49 43.98 274.94 122.02"/>
                        <polygon class="cls-1" points="267.15 129.28 304.53 319.08 207.58 316.22 118.15 259.5 60.48 232.51 31.57 137.66 98.04 91.64 191.7 51.24 267.15 129.28"/>
                        <polygon class="cls-1" points="259.36 136.54 296.75 326.34 199.79 323.48 110.36 266.76 52.69 239.77 23.78 144.92 90.25 98.9 183.91 58.5 259.36 136.54"/>
                        <polygon class="cls-1" points="251.57 143.8 288.96 333.6 192 330.74 102.57 274.02 44.9 247.03 15.99 152.18 82.46 106.16 176.12 65.76 251.57 143.8"/>
                        <polygon class="cls-1" points="243.78 151.06 281.17 340.86 184.22 338 94.78 281.28 37.12 254.28 8.21 159.43 74.67 113.42 168.34 73.02 243.78 151.06"/>
                        <polygon class="cls-1" points="236 158.31 273.38 348.12 176.43 345.26 87 288.54 29.33 261.54 0.42 166.69 66.89 120.67 160.55 80.27 236 158.31"/>
                    </svg>



                </div>


                <div class="draw_square2 flexbox">

                    <svg class="hello2" viewBox="0 0 204.72 217.76">
                        <polygon class="cls-1" points="31.46 52.44 131.42 0.31 145.77 54.98 128.78 114.3 123.18 150.98 74.91 182.75 38.25 153.17 0.25 107.46 31.46 52.44"/>
                        <polygon class="cls-1" points="36.8 55.6 136.76 3.46 151.11 58.13 134.12 117.46 128.52 154.14 80.25 185.91 43.59 156.33 5.59 110.62 36.8 55.6"/>
                        <polygon class="cls-1" points="42.14 58.76 142.1 6.62 156.45 61.3 139.46 120.62 133.86 157.3 85.59 189.07 48.93 159.49 10.93 113.78 42.14 58.76"/>
                        <polygon class="cls-1" points="47.48 61.92 147.44 9.78 161.79 64.45 144.8 123.78 139.2 160.46 90.93 192.23 54.27 162.65 16.27 116.94 47.48 61.92"/>
                        <polygon class="cls-1" points="52.82 65.08 152.77 12.94 167.13 67.61 150.14 126.94 144.54 163.62 96.27 195.39 59.61 165.81 21.61 120.09 52.82 65.08"/>
                        <polygon class="cls-1" points="58.16 68.23 158.11 16.1 172.47 70.77 155.48 130.1 149.88 166.78 101.61 198.55 64.95 168.96 26.95 123.25 58.16 68.23"/>
                        <polygon class="cls-1" points="63.5 71.39 163.45 19.26 177.81 73.93 160.82 133.26 155.22 169.94 106.95 201.71 70.29 172.12 32.29 126.41 63.5 71.39"/>
                        <polygon class="cls-1" points="68.84 74.55 168.79 22.42 183.15 77.09 166.16 136.42 160.55 173.1 112.29 204.87 75.63 175.28 37.63 129.57 68.84 74.55"/>
                        <polygon class="cls-1" points="74.18 77.71 174.13 25.58 188.49 80.25 171.5 139.58 165.89 176.26 117.63 208.03 80.97 178.44 42.97 132.73 74.18 77.71"/>
                        <polygon class="cls-1" points="79.52 80.87 179.47 28.74 193.82 83.41 176.84 142.74 171.23 179.42 122.97 211.19 86.31 181.6 48.31 135.89 79.52 80.87"/>
                        <polygon class="cls-1" points="84.86 84.03 184.81 31.9 199.16 86.57 182.18 145.9 176.57 182.58 128.31 214.35 91.64 184.76 53.65 139.05 84.86 84.03"/>
                        <polygon class="cls-1" points="90.2 87.19 190.15 35.06 204.5 89.73 187.51 149.06 181.91 185.74 133.65 217.5 96.98 187.92 58.99 142.21 90.2 87.19"/>
                    </svg>

                </div>

<!-- ---------------------------------  -->
                <div class="party_page_content_inner_wrap flexbox-column">

                    <div class="party_activity_photos flexbox">

                        <div class="party_activity_photo"> <img src="image/party_activity1.png" alt="">  </div>
                        <div class="party_activity_photo"> <img src="image/party_activity2.png" alt="">  </div>
                        <div class="party_activity_photo"> <img src="image/party_activity3.png" alt="">  </div>
                        <div class="party_activity_photo"> <img src="image/party_activity4.png" alt="">  </div>

                    </div>


                    <div class="party_page_content_inner flexbox">
                    <form class="flexbox" name="form1" method="post" onsubmit="return checkForm();">
                        <div class="top_info flexbox">
                            <div class="img_upload_group flexbox">

                            <div class="form-group img_upload_groupright">

                                <div class="form-group">


                                    <div class="name_text_info flexbox">
                                        <label for="name">姓名/公司名稱</label>
                                        <input type="text" class="form-control" id="name" name="name" value="">
                                        <i class="error fa fa-info-circle fa-2x"></i>
                                        <span class="info"></span>

                                    </div>


                                </div>

                                <div class="form-group">


                                    <div class="teamcode_text_info flexbox">
                                        <label for="EMAIL">電子信箱EMAIL</label>
                                        <input type="text" class="form-control" id="EMAIL" name="EMAIL" value="">
                                        <i class="error fa fa-info-circle fa-2x"></i>
                                        <span class="info"></span>

                                    </div>

                                </div>

                                <div class="form-group">


                                    <div class="teamcode_text_info flexbox">
                                        <label for="phonenumber">聯絡電話</label>
                                        <input type="text" class="form-control" id="phonenumber" name="phonenumber" value="">
                                        <i class="error fa fa-info-circle fa-2x"></i>
                                        <span class="info"></span>

                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="datetimepicker_dark">活動日期</label>
                                    <input class="input date" type="text" name="date" id="datetimepicker_dark"/>
                                    <i class="error fa fa-info-circle fa-2x"></i>
                                    <span class="info"></span>
                                </div>

                                <div class="form-group">
                                    <label for="people">活動人數</label>
                                    <select class="people" name="people" id="people" onchange="Change(this.value)">
                                        <?php for($i=1; $i<=50; $i++): ?>
                                            <option value="<?=$i?>"><?=$i?></option>
                                        <?php endfor ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="mode">遊戲模式</label>
                                    <select class="mode" name="mode" id="mode" onchange="Change(this.value)">
                                        <?php while ($mode_row = $mode_rs->fetch_assoc()): ?>
                                            <option value="<?= $mode_row['mode'] ?>"><?= $mode_row['mode'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                    <!--                            <i class="plus fa fa-plus fa-lg fa-fw" aria-hidden="true"></i>-->
                                </div>


                                <div class="form-group">

                                    <section class="team_open_section">
                                        <p class="specialoffer">組合式加值服務需求</p>

                                        <div class="team_open_select">
                                            <input type="checkbox" class="check_item" name="select_1" id="checkbox-1">
                                            <label for="checkbox-1"><span class="checkbox">特殊場地佈置造型</span></label>
                                            <input type="checkbox" class="check_item" name="select_1" id="checkbox-2">
                                            <label for="checkbox-2"><span class="checkbox">提供生存遊戲裝扮</span></label>
                                            <input type="checkbox" class="check_item" name="select_1" id="checkbox-3">
                                            <label for="checkbox-3"><span class="checkbox">客製化照片佈置需求</span></label>
                                        </div>
                                    </section>

                                </div>


                            </div>

                            </div> <!--end of img_upload_group flexbox-->



                            <div class="team_intorduction flexbox">
                                <label for="team_intorduction">活動概述/需求</label>
                                <textarea id="team_intorduction" name="team_intorduction" cols="30" rows="10"></textarea>
                                <div class="team_intorduction_info flexbox">
                                    <i class="fa fa-info-circle fa-2x"></i>
                                    <span class="info">最多限200字</span>
                                </div>
                            </div>


                            <div class="team_slogan flexbox">
                                <label for="team_slogan">其他備註</label>
                                <textarea id="team_slogan" name="team_slogan" cols="30" rows="10"></textarea>
                                <div class="team_slogan_info flexbox">
                                    <i class="fa fa-info-circle fa-2x"></i>
                                    <span class="info">最多限200字</span>
                                </div>
                            </div>



                                <div class="btn flexbox">
                                    <!--<a class="btn1" href="single_activity.php"></a>-->
                                    <button type="submit" class="btn2">送出新增</button>

                                </div>
                        </div><!--end of top_info-->


                        <!--<div class="line"></div>-->

                    </form>

</div><!--end of party_page_content_inner-->



            </div> <!--end of party_page_content-->

    </div> <!--end of party_page_wrap-->

    </div>




<script>



    //檢查表單-----------------------------------
    function checkForm(){
        var $name = $('#name');
        var $date = $('#datetimepicker_dark');
        var $email = $('#EMAIL');
        var $phonenumber = $('#phonenumber');

        var items = [$name, $date, $email, $phonenumber];

        var name = $name.val();
        var date = $date.val();
        var email = $email.val();
        var phonenumber = $phonenumber.val();

        var i;
        var email_pattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
        var isPass = true;

        for(i=0; i<items.length; i++){
            items[i].closest('.form-group').find('i').addClass('error');
            items[i].closest('.form-group').find('span').text('');
            $('.act_img_form').find('.info').text('');
        }

//        alert("1111");
        if(! name){
            $name.closest('.form-group').find('i').removeClass('error');
            $name.closest('.form-group').find('span').text('請填寫姓名或公司名稱');
            isPass = false;
        }


//        if(date.length < 1){
//            $date.closest('.form-group').find('i').removeClass('error');
//            $date.closest('.form-group').find('span').text('請選擇日期');
//            isPass = false;
//        }

        if(! email_pattern.test(email)){
            $email.closest('.form-group').find('i').removeClass('error');
            $email.closest('.form-group').find('span').text('電子信箱格試錯誤');
            isPass = false;
        }

        if(! email){
            $email.closest('.form-group').find('i').removeClass('error');
            $email.closest('.form-group').find('span').text('請填寫電子信箱');
            isPass = false;
        }



        if(! phonenumber){
            $phonenumber.closest('.form-group').find('i').removeClass('error');
            $phonenumber.closest('.form-group').find('span').text('請填寫連絡電話');
            isPass = false;
        }

//        alert('123');
        return isPass;

    }

    //datepicker--------------------------------
    $('#datetimepicker_dark').datetimepicker({theme:'dark'});

    $('#datetimepicker_dark').datetimepicker({

        allowTimes:[
            '9:00','10:00','11:00','12:00', '13:00','14:00', '15:00',
            '16:00','17:00', '18:00', '19:00', '20:00', '21:00'
        ]
    });


    //表單 select變成單選----------------------------------------

    $('.check_item').on('change', function () {
        $('.check_item').not(this).prop('checked', false);
    });

    //----------------------------------------




//    var qty_sels = $('select.people_qty');
//
//    qty_sels.each(function(){
//        var qty = $(this).attr('data-qty');
//        $(this).val(qty);
//    });


</script>


<?php include __DIR__ . '/__html_foot.php' ?>