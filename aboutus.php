<?php

require __DIR__ . '/__connect_db.php';

$pname = 'none';

if (isset($_SESSION['server'])){
    unset($_SESSION['server']);
}

if (isset($_SESSION['team_members'])){
    unset($_SESSION['team_members']);
}

?>

<style>


    body {
        font-family: Microsoft JhengHei;
        background: #011f35;
        background: none;
    }

    .fa-2x{
        color: #d5d5d5;
    }




</style>

<?php include __DIR__.'/__html_head.php'?>
<link rel="stylesheet" href="css/aboutus.css">

<?php include __DIR__ . '/__navbar.php' ?>

	<div class="container">
		<div class="about">
			<div class="board">關於我們</div>
			<div class="ground">
				<h2>本店場地</h2>
				<div class="ground_left">
					<img src="images/earthmap.jpg" alt="">
				</div>
                <div class="ground_right">
                    <table>
                        <tbody> 
                            <tr>
                                <td><i class="fa fa-map-marker fa-2x fa-cog" aria-hidden="true"></i></td>
                                <td><p>地址：<br>238 新北市樹林區中正路212號</p></td>
                            </tr>
                            <tr style="height: 102px">
                                <td style="padding-bottom: 70px"><i class="fa fa-clock-o fa-2x fa-cog" aria-hidden="true"></i></td>
                                <td><p>營業時間：<br>星期三~星期日<br>上午 08:00~ 下午17:00</p></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-phone-square fa-2x fa-cog" aria-hidden="true"></i></td>
                                <td><p>連絡電話：<br>02-27208889</p></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-envelope fa-2x fa-cog" aria-hidden="true"></i></td>
                                <td><p>電子信箱：<br>services@mail.taipei.gov.tw</p></td>
                            </tr>
                        </tbody>
                    </table>
                </div>               
			</div><!-- ground -->
            <div class="service">
               <h2>服務說明</h2> 
               <div class="service_box">
                    <figure><img src="images/frontman.png" alt=""></figure>
                   <div class="s_leftup"><h3>入園費用</h3><p>半日票成人:350元<br>全天套票成人:500元<br>半日-12歲以下兒童:150元<br>全天套票-12歲以下兒童:200元</p></div>
                   <div class="s_rightup"><h3>基本裝備租借</h3><p>頭盔+護目鏡+護膝+各式長槍<br>(m4,m16,ak47,ak12,mp5,uzi,vector)<br>+1000發BB彈：總共600元。<br>另購5000發BB彈 X 1包 : 300元</p></div>
                   <div class="s_leftdown"><h3>飲食</h3><p>+瓶裝水(沒事多喝水): 25元<br>+罐裝汽水:30元<br>+多力多滋: 50元<br>現場提供免費充電插座</p></div>
                   <div class="s_rightdown"><h3 style="padding-top: 80px">客製化派對活動</h3><button>詳情說明</button></div>
               </div>
            </div><!-- service -->
            <div class="faq">
                <h2>常見問題</h2>
                <div class="faq_box">
                    <h3>Q1：我從未接觸過生存遊戲，不知道活動進行中是否有安全上的顧慮？</h3>
                    <p>A：生存遊戲是一項由來已久的活動，在活動的方式及裝備的安全性上，我們都經過<br>審慎的安排，現場亦有專業的活動人員帶領您完成準備，可以放心享受遊戲中所帶<br>來的體驗樂趣。</p>
                    <h3>Q1：我從未接觸過生存遊戲，不知道活動進行中是否有安全上的顧慮？</h3>
                    <p>A：生存遊戲是一項由來已久的活動，在活動的方式及裝備的安全性上，我們都經過<br>審慎的安排，現場亦有專業的活動人員帶領您完成準備，可以放心享受遊戲中所帶<br>來的體驗樂趣。</p>
                    <h3>Q1：我從未接觸過生存遊戲，不知道活動進行中是否有安全上的顧慮？</h3>
                    <p>A：生存遊戲是一項由來已久的活動，在活動的方式及裝備的安全性上，我們都經過<br>審慎的安排，現場亦有專業的活動人員帶領您完成準備，可以放心享受遊戲中所帶<br>來的體驗樂趣。</p>
                    <h3>Q1：我從未接觸過生存遊戲，不知道活動進行中是否有安全上的顧慮？</h3>
                    <p>A：生存遊戲是一項由來已久的活動，在活動的方式及裝備的安全性上，我們都經過<br>審慎的安排，現場亦有專業的活動人員帶領您完成準備，可以放心享受遊戲中所帶<br>來的體驗樂趣。</p>
                </div>
                <button class="button_faq">關於其他常見問題</button>
            </div>
            <div class="five">
                <h2>關於我們</h2>
                <div class="five_box"></div>   
            </div>
		</div><!-- about -->
	</div>
<!--    <footer></footer>-->

<?php include __DIR__ . '/__html_foot.php' ?>