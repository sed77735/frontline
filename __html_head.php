<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style/reset.css">
    <link rel="stylesheet" media="screen and (max-width: 899px)" href="css/navbar_phone.css" />
    <link rel="stylesheet" media="screen and (min-width: 900px)" href="css/navbar_pc.css" />
    <link rel="stylesheet" href="css/footer.css">
    <link href='image/favicon.ico' rel='icon' type='image/x-icon'/>
    <script src="lib/jquery-3.1.1.js"></script>
    <link rel="stylesheet" href="lib/font-awesome-4.7.0/css/font-awesome.min.css"><!--font-awesome-->



    <link rel="stylesheet" href="css/coreSlider.css">
    <link rel="stylesheet" href="css/jquery.bxslider.css">
    <!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.2/masonry.pkgd.min.js"></script>-->
    <!--整頁面請搜尋0415新增  與 0415修改-->
    <!--0415新增輪播-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css'>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css'>
    <!-- end of 0415新增輪播-->

<!--    <link rel="stylesheet" type="text/css" href="datepic/jquery.datetimepicker.css"/>-->
<!--    <script src="datepic/jquery.js"></script>-->
<!--    <script src="datepic/jquery.datetimepicker.full.js"></script>-->


    <!--    0415新增 位置不能變喔瀑布流要在最下面-->
    <!-- Insert to your webpage before the </head> -->
<!--    <script src="carouselengine/jquery.js"></script>-->
<!--    <script src="carouselengine/amazingcarousel.js"></script>-->
<!--    <link rel="stylesheet" type="text/css" href="carouselengine/initcarousel-1.css">-->
<!--    <script src="carouselengine/initcarousel-1.js"></script>-->
    <!--  -------------------------------------------------------------------------------------------  -->


    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script><!--瀑布流-->
    <script src='http://imagesloaded.desandro.com/imagesloaded.pkgd.js'></script><!--imagesloaded-->


    <script src="js/jquery.bxslider.js"></script>
<!--    <script src="js/jquery.fly.min.js"></script>-->
    <title><?= isset($title) ? $title : '大前線' ?></title>
    <style>

        * { box-sizing: border-box; }

        body {
            font-family: Microsoft JhengHei;
            background-color: #011F35;
            background: url("image/02sandboard-blue.jpg") no-repeat fixed;
            /*overflow-x: hidden;*/
        }

        h2 {
            font-size: 20px;
            font-weight: normal;
            letter-spacing: 8px;
        }

        h4 {
            font-weight: bolder;
            font-size: 16px;
            border-left: 5px solid #011f35;
            display: inline-block;
            margin: 8px 0;
            padding-left: 4px;
        }

        a {
            text-decoration: none;
            font-size: 14px;
            letter-spacing: 5px;
            color: #D5D5D5;
            z-index: 10000;
        }

        .flexbox {
            display: flex;
        }



    </style>


</head>
<body>


