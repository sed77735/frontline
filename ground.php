<?php
require __DIR__ . '/__connect_db.php';

$pname = 'ground';

if (isset($_SESSION['server'])){
    unset($_SESSION['server']);
}

if (isset($_SESSION['team_members'])){
    unset($_SESSION['team_members']);
}


?>



<?php include __DIR__.'/__html_head.php'?>
<link rel="stylesheet" href="css/ground.css">
    <style>

        body {
            font-family: Microsoft JhengHei;
        }

    </style>

<?php include __DIR__ . '/__navbar.php' ?>

	<div class="container">
		<div class="map transition hide"></div>
		<div class="flare transition">
			<img src="images/title_lense_flare_530.png" alt="">
		</div>
		<div class="title">
			<h1>本館場地總覽</h1>
			<h3>23867新北市樹林區中正路188-6號</h3>
		</div>
        <div class="info_title transition" id="title_01">
            <img src="images/info_title01_number.png" alt="">
        </div>
        <div class="info_title transition" id="title_02">
            <img src="images/info_title02_number.png" alt="">
        </div>
        <div class="info_title transition" id="title_03">
            <img src="images/info_title03_number.png" alt="">
        </div>
        <div class="info_title transition" id="title_04">
            <img src="images/info_title04_number.png" alt="">
        </div>
		<div class="tag zone1 transition_fast show">
			<h2>野地叢林</h2><h3>地形01-開闊雨林地</h3>
			<div class="mode transition hide">
				<h3 style="color: #eaa315">建議人數 32-50 玩家</h3>
				<img src="images/gametype_switch01_tdm.png" alt="" style="padding-left: 50px">
				<img src="images/gametype_switch03_ctf.png" alt="">
				<img src="images/gametype_switch02_conquest.png" alt="">
			</div>
		</div>
		<figure class="pic_zone1 transition hide">
            <img src="images/zone1_forest.png" alt="">
            <div class="tdm_zone1 typepic"><img src="images/zone1_forest.png" alt=""></div>
            <div class="ctf_zone1 typepic"><img src="images/zone1_forest_ctf.png" alt=""></div>
            <div class="conquest_zone1 typepic"><img src="images/zone1_forest_conquest.png" alt=""></div>
        </figure>
 
        <div class="info" id="info1">
            <div class="tag_inner"><h2>野地叢林</h2><h3>地形01-開闊雨林地</h3></div>
            <div class="mode" style="width: 190px">
                <h3 style="color: #eaa315">建議人數 32-50 玩家</h3>
                <img src="images/gametype_switch01_tdm.png" alt="" style="padding-left: 50px">
                <img src="images/gametype_switch03_ctf.png" alt="">
                <img src="images/gametype_switch02_conquest.png" alt="">
            </div>
            <div class="infotext">
                <p>典型的叢林大規模會戰戰場地形。<br>狙擊手隱匿在樹林中搜尋落單的目標，步兵在多變的樹林地捉對廝殺，繞過散落在各處的軍事殘骸，協助隊伍在地形掩護中前進。<br>保持警戒! 墜毀的直升機裡、矮樹叢裡、岩石的背面，山丘的制高點甚至陽光乍現的草原都暗藏著等待您露出破綻的威脅。</p>
            </div>
            <div class="bigpic"><div class="pictitle"></div><img src="images/01-1-default_380.jpg" alt=""></div>
            <div class="smallpic"><img src="images/01-2-lonesurvivor_380.jpg" alt=""></div>
            <div class="smallpic"><img src="images/01-3-wreckage_380.jpg" alt=""></div>
            <div class="smallpic"><img src="images/01-4-creek_380.jpg" alt=""></div>
        </div>
        <div class="custom" id="custom1">
            <div class="game">
                <div class="pictitle" style="background: url(images/info_gametypes_title.png);"></div>
                <a href="activity_list.php">我要參加</a>
                <div class="game_typebox tdm_box actived">
                    <div class="game_typelogo"><img src="images/gametype_big_01tdm.png" alt=""></div>
                    <div class="game_typelist"><ul>
                        <li class="tdm" style="background: url(images/gametype_switch01_tdm_y.png);opacity: 1"></li>
                        <li class="ctf"></li>
                        <li class="conquest"></li>
                    </ul></div>
                    <h2 style="text-align: left">團隊死鬥</h2>
                    <h3 style="text-align: left">TEAM DEATHMATCH</h3>
                    <div class="game_typeinfo">
                        <p>將場地上的敵方團隊全部消滅。<br>保護好我方的醫護兵，維持人數優勢，提防敵隊的醫護兵救治敵人，壓制敵人並且殲滅敵方。殲滅敵方團隊所有成員即獲勝，遊戲結束。</p>
                    </div>
                </div><!-- tdm_box -->
               <div class="game_typebox ctf_box">
                    <div class="game_typelogo"><img src="images/gametype_big_03ctf.png" alt=""></div>
                    <div class="game_typelist"><ul>
                        <li class="tdm"></li>
                        <li class="ctf" style="background: url(images/gametype_switch03_ctf_y.png);opacity: 1"></li>
                        <li class="conquest"></li>
                    </ul></div>
                    <h2 style="text-align: left">搶奪旗幟</h2>
                    <h3 style="text-align: left">CAPTURE TH FLAG</h3>
                    <div class="game_typeinfo">
                        <p>奪取敵方軍旗。<br>在場地中找到敵方旗幟位置，將敵方旗幟並帶回我方旗幟基地得分。搶奪旗幟者若陣亡，則旗幟掉落，須由其他隊員繼續攜帶，若掉落90秒內無人撿拾，旗幟自動由裁判歸還。取得三分之團隊獲勝。</p>
                    </div>
                </div><!-- ctf_box -->
                <div class="game_typebox conquest_box">
                    <div class="game_typelogo"><img src="images/gametype_big_02conquest.png" alt=""></div>
                    <div class="game_typelist"><ul>
                        <li class="tdm"></li>
                        <li class="ctf"></li>
                        <li class="conquest" style="background: url(images/gametype_switch02_conquest_y.png);opacity: 1"></li>
                    </ul></div>
                    <h2 style="text-align: left">全面征服</h2>
                    <h3 style="text-align: left">CONQUEST</h3>
                    <div class="game_typeinfo">
                        <p>搶攻各個占領點，有些占領點擁有戰略優勢，將其列為優先進功的目標。人員進入佔領區域時間達60秒後成功占領，區域內若有敵隊人員，不予計時，將敵隊掃除後開始占領，同時佔領全部區域之團隊獲勝。<br>拿下所有佔領區域贏得第一回合，採取五回合制，贏得三回合團隊獲勝。</p>
                    </div>
                </div><!-- conquest_box -->
            </div><!-- game -->
            <div class="equip lion">
                <div class="pictitle" style="background: url(images/info_loadouts_title.png);" ></div>
                <div class="equiptext">
                <h2>俄羅斯山地獅</h2>
                <p>北方戰鬥民族的強悍戰士<br>主武器 : AK12步槍<br>副武器 : (PMM)Makarov手槍<br>頭部裝備 : 6B47頭盔/ZSH1-2頭盔<br>制服裝備 : GORKA服裝 SSO smersh背心<br>鞋類 : Timberland 棕色運動靴</p>
                </div>
                <a href="product_list_test.php">我要購買</a>
            </div>
        </div><!--                                                   地形一區 -->
		<div class="tag zone2 transition_fast show">
				<div class="mode transition hide">
				<h3 style="color: #eaa315">建議人數 32-50 玩家</h3>
				<img src="images/gametype_switch01_tdm.png" alt="" style="padding-left: 50px">
				<img src="images/gametype_switch03_ctf.png" alt="">
				<img src="images/gametype_switch02_conquest.png" alt="">
			</div>
			<h2>街道巷戰</h2><h3>地形02-城鎮郊區地形</h3>
		</div>
		<figure class="pic_zone2 transition hide">
            <img src="images/zone2_urban.png" alt="">
            <div class="tdm_zone2 typepic"><img src="images/zone2_urban.png" alt=""></div>
            <div class="ctf_zone2 typepic"><img src="images/zone2_urban_ctf.png" alt=""></div>
            <div class="conquest_zone2 typepic"><img src="images/zone2_urban_conquest.png" alt=""></div>
        </figure>
        <div class="info" id="info2">
            <div class="tag_inner"><h2>街道巷戰</h2><h3>地形02-城鎮郊區地形</h3></div>
            <div class="mode" style="width: 190px">
                <h3 style="color: #eaa315">建議人數 32-50 玩家</h3>
                <img src="images/gametype_switch01_tdm.png" alt="" style="padding-left: 50px">
                <img src="images/gametype_switch03_ctf.png" alt="">
                <img src="images/gametype_switch02_conquest.png" alt="">
            </div>
            <div class="infotext">
                <p>現代戰爭的衝突往往延伸到該地人民的居住地。在平民撤離後，敵我雙方必須分秒必爭，在水泥叢林中，從每個街區、大小巷弄、每棟建築物中推進，破壞敵隊的戰線。<br>建立堅強的防線!在建築裡居高臨下伏擊路過的敵方成員，或組織快速反應小隊從側翼突襲敵方，將對方殲滅並逐出此城鎮郊區。</p>
            </div>
            <div class="bigpic"><div class="pictitle"></div><img src="images/02-1-default_380.jpg" alt=""></div>
            <div class="smallpic"><img src="images/02-2-blackhawk_380.jpg" alt=""></div>
            <div class="smallpic"><img src="images/02-3-street_380.jpg" alt=""></div>
            <div class="smallpic"><img src="images/02-4-intersection_380.jpg" alt=""></div>
        </div>
        <div class="custom" id="custom2">
            <div class="game">
                <div class="pictitle" style="background: url(images/info_gametypes_title.png);"></div>
                <a href="activity_list.php">我要參加</a>
                <div class="game_typebox tdm_box actived">
                    <div class="game_typelogo"><img src="images/gametype_big_01tdm.png" alt=""></div>
                    <div class="game_typelist"><ul>
                        <li class="tdm" style="background: url(images/gametype_switch01_tdm_y.png);opacity: 1"></li>
                        <li class="ctf"></li>
                        <li class="conquest"></li>
                    </ul></div>
                    <h2 style="text-align: left">團隊死鬥</h2>
                    <h3 style="text-align: left">TEAM DEATHMATCH</h3>
                    <div class="game_typeinfo">
                        <p>將場地上的敵方團隊全部消滅。<br>保護好我方的醫護兵，維持人數優勢，提防敵隊的醫護兵救治敵人，壓制敵人並且殲滅敵方。殲滅敵方團隊所有成員即獲勝，遊戲結束。</p>
                    </div>
                </div><!-- tdm_box -->
               <div class="game_typebox ctf_box">
                    <div class="game_typelogo"><img src="images/gametype_big_03ctf.png" alt=""></div>
                    <div class="game_typelist"><ul>
                        <li class="tdm"></li>
                        <li class="ctf" style="background: url(images/gametype_switch03_ctf_y.png);opacity: 1"></li>
                        <li class="conquest"></li>
                    </ul></div>
                    <h2 style="text-align: left">搶奪旗幟</h2>
                    <h3 style="text-align: left">CAPTURE TH FLAG</h3>
                    <div class="game_typeinfo">
                        <p>奪取敵方軍旗。<br>在場地中找到敵方旗幟位置，將敵方旗幟並帶回我方旗幟基地得分。搶奪旗幟者若陣亡，則旗幟掉落，須由其他隊員繼續攜帶，若掉落90秒內無人撿拾，旗幟自動由裁判歸還。取得三分之團隊獲勝。</p>
                    </div>
                </div><!-- ctf_box -->
                <div class="game_typebox conquest_box">
                    <div class="game_typelogo"><img src="images/gametype_big_02conquest.png" alt=""></div>
                    <div class="game_typelist"><ul>
                        <li class="tdm"></li>
                        <li class="ctf"></li>
                        <li class="conquest" style="background: url(images/gametype_switch02_conquest_y.png);opacity: 1"></li>
                    </ul></div>
                    <h2 style="text-align: left">全面征服</h2>
                    <h3 style="text-align: left">CONQUEST</h3>
                    <div class="game_typeinfo">
                        <p>搶攻各個占領點，有些占領點擁有戰略優勢，將其列為優先進功的目標。人員進入佔領區域時間達60秒後成功占領，區域內若有敵隊人員，不予計時，將敵隊掃除後開始占領，同時佔領全部區域之團隊獲勝。<br>拿下所有佔領區域贏得第一回合，採取五回合制，贏得三回合團隊獲勝。</p>
                    </div>
                </div><!-- conquest_box -->
            </div><!-- game -->
            <div class="equip seal">
                <div class="pictitle" style="background: url(images/info_loadouts_title.png);" ></div>
                <div class="equiptext">
                <h2>美國海豹部隊</h2>
                <p>世界頂尖的多地形滲透特種部隊<br>主武器 : MK12步槍 / M4A1步槍<br>副武器 : M9 (BERETA)手槍<br>頭部裝備 : MICH2002頭盔 / Emerson闊葉帽<br>制服裝備 :<br>鞋類 : Timberland 棕色運動靴</p>
                </div>
                <a href="product_list_test.php">我要購買</a>
            </div>
        </div><!--                                                   地形二區 -->
		<div class="tag zone3 transition_fast show">
			<h2>路障廣場</h2><h3>地形03-開闊障礙區域</h3>
			<div class="mode transition hide">
				<h3 style="color: #eaa315">建議人數 32-40 玩家</h3>
				<img src="images/gametype_switch01_tdm.png" alt="" style="padding-left: 70px">
				<img src="images/gametype_switch03_ctf.png" alt="">
			</div>
		</div>
		<figure class="pic_zone3 transition hide">
            <img src="images/zone3_plaza.png" alt="">
            <div class="tdm_zone3 typepic"><img src="images/zone3_plaza.png" alt=""></div>
            <div class="ctf_zone3 typepic"><img src="images/zone3_plaza_ctf.png" alt=""></div>
        </figure>
            <div class="info" id="info3">
            <div class="tag_inner"><h2>路障廣場</h2><h3>地形03-開闊障礙區域</h3></div>
            <div class="mode" style="width: 190px">
                <h3 style="color: #eaa315">建議人數 32-40 玩家</h3>
                <img src="images/gametype_switch01_tdm.png" alt="" style="padding-left: 70px">
                <img src="images/gametype_switch03_ctf.png" alt="">
            </div>
            <div class="infotext">
                <p>各國作戰單位訓練戰鬥的障礙模擬區。<br>穿梭在各種路障中、考驗您團隊的臨場應變，提防狙擊塔上的偵察兵以及敵方小隊隨時突破戰線的可能性。<br>以交叉火網掩護提升隊伍的壓制能力，拿下對方的狙擊塔，掌控敵隊的一舉一動，將敵方完美封鎖。</p>
            </div>
            <div class="bigpic"><div class="pictitle"></div><img src="images/03-1-default_380.jpg" alt=""></div>
            <div class="smallpic"><img src="images/03-2-secretsoldier_380.jpg" alt=""></div>
            <div class="smallpic"><img src="images/03-3-obstacle_380.jpg" alt=""></div>
            <div class="smallpic"><img src="images/03-4-wide_380.jpg" alt=""></div>
        </div>
        <div class="custom" id="custom3">
            <div class="game">
                <div class="pictitle" style="background: url(images/info_gametypes_title.png);"></div>
                <a href="activity_list.php">我要參加</a>
                <div class="game_typebox tdm_box actived">
                    <div class="game_typelogo"><img src="images/gametype_big_01tdm.png" alt=""></div>
                    <div class="game_typelist"><ul>
                        <li class="tdm" style="background: url(images/gametype_switch01_tdm_y.png);opacity: 1"></li>
                        <li class="ctf"></li>
                    </ul></div>
                    <h2 style="text-align: left">團隊死鬥</h2>
                    <h3 style="text-align: left">TEAM DEATHMATCH</h3>
                    <div class="game_typeinfo">
                        <p>將場地上的敵方團隊全部消滅。<br>保護好我方的醫護兵，維持人數優勢，提防敵隊的醫護兵救治敵人，壓制敵人並且殲滅敵方。殲滅敵方團隊所有成員即獲勝，遊戲結束。</p>
                    </div>
                </div><!-- tdm_box -->
               <div class="game_typebox ctf_box">
                    <div class="game_typelogo"><img src="images/gametype_big_03ctf.png" alt=""></div>
                    <div class="game_typelist"><ul>
                        <li class="tdm"></li>
                        <li class="ctf" style="background: url(images/gametype_switch03_ctf_y.png);opacity: 1"></li>
                    </ul></div>
                    <h2 style="text-align: left">搶奪旗幟</h2>
                    <h3 style="text-align: left">CAPTURE TH FLAG</h3>
                    <div class="game_typeinfo">
                        <p>奪取敵方軍旗。<br>在場地中找到敵方旗幟位置，將敵方旗幟並帶回我方旗幟基地得分。搶奪旗幟者若陣亡，則旗幟掉落，須由其他隊員繼續攜帶，若掉落90秒內無人撿拾，旗幟自動由裁判歸還。取得三分之團隊獲勝。</p>
                    </div>
                </div><!-- ctf_box -->
            </div><!-- game -->
            <div class="equip secure">
                <div class="pictitle" style="background: url(images/info_loadouts_title.png);" ></div>
                <div class="equiptext">
                <h2>私人保全公司 PMC</h2>
                <p>民間私人的退役特種部隊保全團隊<br>主武器 : M4A1步槍 / M249輕機槍<br>副武器 : Glock17手槍<br>頭部裝備 : 多地形迷彩鴨舌帽<br>制服裝備 5.11-POLO短袖/Fast Tac  長褲<br>鞋類 : 5.11 Recon Trainer</p>
                </div>
                <a href="product_list_test.php">我要購買</a>
            </div>
        </div><!--                                                   地形三區 -->
		<div class="tag zone4 transition_fast show">
			<div class="mode transition hide">
				<h3 style="color: #eaa315">建議人數 24-40 玩家</h3>
				<img src="images/gametype_switch01_tdm.png" alt="" style="padding-left: 50px">
				<img src="images/gametype_switch05_hostage.png" alt="">
				<img src="images/gametype_switch04_bomb.png" alt="">
			</div>
			<h2>建築肅清</h2><h3>地形04-近距離室內作戰</h3>
		</div>
		<figure class="pic_zone4 transition hide">
            <img src="images/zone4_cqb.png" alt="">
            <div class="tdm_zone4 typepic"><img src="images/zone4_cqb.png" alt=""></div>
            <div class="hostage_zone4 typepic"><img src="images/zone4_cqb_hostage.png" alt=""></div>
            <div class="bomb_zone4 typepic"><img src="images/zone4_cqb_bomb.png" alt=""></div>
        </figure>
            <div class="info" id="info4">
            <div class="tag_inner"><h2>建築肅清</h2><h3 style="letter-spacing: 3px">地形04-近距離室內作戰</h3></div>
            <div class="mode" style="width: 190px">
                <h3 style="color: #eaa315">建議人數 24-40 玩家</h3>
                <img src="images/gametype_switch01_tdm.png" alt="" style="padding-left: 50px">
                <img src="images/gametype_switch05_hostage.png" alt="">
                <img src="images/gametype_switch04_bomb.png" alt="">
            </div>
            <div class="infotext" style="padding-right: 30px">
                <p>現代戰爭中建築物內部的近距離作戰。<br>恐怖主義蔓延、激進組織的威脅，反恐部隊針對狹窄的室內以及公共場所加強戰術訓練。<br>隊伍在狹小的空間展開攻勢，肅清各個室內空間，掃蕩每個區域的威脅。<br>躲在門後的埋伏，長廊的障礙物後，各種突發的戰況、任何失誤都決定了整個團隊的勝敗。</p>
            </div>
            <div class="bigpic"><div class="pictitle"></div><img src="images/04-1-default_380.jpg" alt=""></div>
            <div class="smallpic"><img src="images/04-2-johnwick_380.jpg" alt=""></div>
            <div class="smallpic"><img src="images/04-3-taipeicqb_380.jpg" alt=""></div>
            <div class="smallpic"><img src="images/04-4-bf3cqb_380.jpg" alt=""></div>
        </div>
        <div class="custom" id="custom4">
            <div class="game">
                <div class="pictitle" style="background: url(images/info_gametypes_title.png);"></div>
                <a href="activity_list.php">我要參加</a>
                <div class="game_typebox tdm_box actived">
                    <div class="game_typelogo"><img src="images/gametype_big_01tdm.png" alt=""></div>
                    <div class="game_typelist"><ul>
                        <li class="tdm" style="background: url(images/gametype_switch01_tdm_y.png);opacity: 1"></li>
                        <li class="hostage"></li>
                        <li class="bomb"></li>
                    </ul></div>
                    <h2 style="text-align: left">團隊死鬥</h2>
                    <h3 style="text-align: left">TEAM DEATHMATCH</h3>
                    <div class="game_typeinfo">
                        <p>將場地上的敵方團隊全部消滅。<br>保護好我方的醫護兵，維持人數優勢，提防敵隊的醫護兵救治敵人，壓制敵人並且殲滅敵方。殲滅敵方團隊所有成員即獲勝，遊戲結束。</p>
                    </div>
                </div><!-- tdm_box -->
               <div class="game_typebox hostage_box">
                    <div class="game_typelogo"><img src="images/gametype_big_05hostage.png" alt=""></div>
                    <div class="game_typelist"><ul>
                        <li class="tdm"></li>
                        <li class="hostage" style="background: url(images/gametype_switch05_hostage_y.png);opacity: 1"></li>
                        <li class="bomb"></li>
                    </ul></div>
                    <h2 style="text-align: left">人質營救</h2>
                    <h3 style="text-align: left">HOSTAGE</h3>
                    <div class="game_typeinfo">
                        <p>保護與營救您的重要人質，輪流進攻與防守。<br>進攻方必須找出人質位並安全護送回出發基地獲勝。<br>防守方全力阻止進攻方營救人質，殲滅進攻方獲勝。<br>任何一方打中人質頭部，該團隊直接失敗。<br>採取五回合制，獲勝三回合之團隊獲勝。</p>
                    </div>
                </div><!-- hostage_box -->
                <div class="game_typebox bomb_box">
                    <div class="game_typelogo"><img src="images/gametype_big_04bomb.png" alt=""></div>
                    <div class="game_typelist"><ul>
                        <li class="tdm"></li>
                        <li class="hostage"></li>
                        <li class="bomb" style="background: url(images/gametype_switch04_bomb_y.png);opacity: 1"></li>
                    </ul></div>
                    <h2 style="text-align: left">炸彈威脅</h2>
                    <h3 style="text-align: left">BOMB</h3>
                    <div class="game_typeinfo">
                        <p>雙方團隊輪流擔任進攻與防守方。<br>進攻方必須找到防守方的炸彈點並放置炸彈，守住炸彈90秒引爆獲勝。防守方全力阻止攻擊方放置炸彈，或花費10秒拆除炸彈獲勝。<br>炸彈威脅採取五回合制，獲勝三回合之團隊獲勝。</p>
                    </div>
                </div><!-- bomb_box -->
            </div><!-- game -->
            <div class="equip sas">
                <div class="pictitle" style="background: url(images/info_loadouts_title.png);" ></div>
                <div class="equiptext">
                <h2>英國皇家陸軍</h2>
                <p>維繫世界和平的王牌菁英盟友<br>主武器 : L85A2步槍 / M1014霰彈槍<br>副武器 : P226(SIG)手槍<br>頭部裝備 : MK6 頭盔<br>制服裝備 : MTP戰鬥夾克 MTP多地形迷彩長褲<br>鞋類 : 5.11 COYOTE 靴子<br></p>
                </div>
                <a href="product_list_test.php">我要購買</a>
            </div>
        </div><!--                                                   地形四區 -->
	</div>

<script src="js/jquery-3.1.1.js"></script>
<script>
	$(function(){

    // 導覽列----------------------------------------
    var x = $('.active').data("x");
    $(".bottom_bar").css({marginLeft:x});

    $(".nav_li a").mouseover(function(){
        var x = $(this).parent(".nav_li").data("x");

        $(".bottom_bar").stop().animate({marginLeft:x}, 300);
    });

    $(".nav_li a").mouseout(function () {
        $(".nav_li ul").css(display="block");
        var x = $('.active').data("x");
        $(".bottom_bar").stop().animate({marginLeft: x}, 300);
    });


    $(".flare").animate({                   
                    opacity: "1"
                }, 600, "linear");

    $(".map").removeClass("hide");
    $(".map").addClass("show");

    $(".tag").mouseover(function (){
    	$(this).find(".mode").addClass("show");
		$(this).find(".mode").removeClass("hide");
		$(".map").removeClass("show");
    	$(".map").addClass("hide");
    });
    $(".tag").mouseout(function (){
    	$(this).find(".mode").addClass("hide");
		$(this).find(".mode").removeClass("show");
		$(".map").removeClass("hide");
    	$(".map").addClass("show");
    }); 

    $(".tag").click(function(){
    	$(this).css("display","none");       
    	$(this).siblings(".tag").css("display","block");
        $(".flare").css("opacity","0");
    	$(".title").addClass("dimmed");
    	$(".map").css("opacity","0");
    });

    $(".zone1").click(function(){
        $(".pic_zone1").css("opacity","1");
        $("#info1").css("display","block");
        $("#custom1").css("display","block");
        $(".info_title").css("opacity","0");
        $(".container").css("overflow","hidden");
        if  ($(".pic_zone2").css("opacity") == "1") {
                $(".pic_zone2").css("opacity","0");
        }
        if  ($(".pic_zone3").css("opacity") == "1") {
                $(".pic_zone3").css("opacity","0");
        }
        if  ($(".pic_zone4").css("opacity") == "1") {
                $(".pic_zone4").css("opacity","0");
        }

        if ($("#info1").css("opacity") == "0") {
                $("#info1").animate({
                    left: ["60px", "swing"],
                    opacity: "1"
                }, 1000, "linear", function() {
                $("#title_01").css("opacity","1");
            });
        }
        if ($("#custom1").css("opacity") == "0") {
                $("#custom1").animate({
                    right: ["10px", "swing"],
                    opacity: "1",
                }, 1000, "linear", function() {
                $(".container").css("overflow","visible");
            });
        }

        if ($("#info2").css("opacity") == "1") {
                $("#info2").css("display","none");
                $("#info2").animate({
                    top: ["-600px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }
        if ($("#custom2").css("opacity") == "1") {
                $("#custom2").css("display","none");
                $("#custom2").animate({
                    bottom: ["-680px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }

        if ($("#info3").css("opacity") == "1") {
                $("#info3").css("display","none");
                $("#info3").animate({
                    bottom: ["-600px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }

        if ($("#custom3").css("opacity") == "1") {
                $("#custom3").css("display","none");
                $("#custom3").animate({
                    top: ["-680px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }

        if ($("#info4").css("opacity") == "1") {
                $("#info4").css("display","none");
                $("#info4").animate({
                    left: ["-400px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }
        if ($("#custom4").css("opacity") == "1") {
                $("#custom4").css("display","none");
                $("#custom4").animate({
                    right: ["-400px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }
    });

    $(".zone2").click(function(){
        $(".pic_zone2").css("opacity","1");
        $("#info2").css("display","block");
        $("#custom2").css("display","block");
        $(".info_title").css("opacity","0");

        if  ($(".pic_zone1").css("opacity") == "1") {
                $(".pic_zone1").css("opacity","0");
        }
        if  ($(".pic_zone3").css("opacity") == "1") {
                $(".pic_zone3").css("opacity","0");
        }
        if  ($(".pic_zone4").css("opacity") == "1") {
                $(".pic_zone4").css("opacity","0");
        }

        if ($("#info2").css("opacity") == "0") {
                $("#info2").animate({
                    top: ["206px", "swing"],
                    opacity: "1"
                }, 1000, "linear", function() {
                $("#title_02").css("opacity","1");
            });
        }
        if ($("#custom2").css("opacity") == "0") {
                $("#custom2").animate({
                    bottom: ["140px", "swing"],
                    opacity: "1",
                }, 1000, "linear");
        }

        if ($("#info1").css("opacity") == "1") {
                $("#info1").css("display","none");
                $("#info1").animate({
                    left: ["-400px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }
        if ($("#custom1").css("opacity") == "1") {
                $("#custom1").css("display","none");
                $("#custom1").animate({
                    right: ["-400px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }

        if ($("#info3").css("opacity") == "1") {
                $("#info3").css("display","none");
                $("#info3").animate({
                    bottom: ["-600px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }

        if ($("#custom3").css("opacity") == "1") {
                $("#custom3").css("display","none");
                $("#custom3").animate({
                    top: ["-680px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }

        if ($("#info4").css("opacity") == "1") {
                $("#info4").css("display","none");
                $("#info4").animate({
                    left: ["-400px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }
        if ($("#custom4").css("opacity") == "1") {
                $("#custom4").css("display","none");
                $("#custom4").animate({
                    right: ["-400px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }
    });

    $(".zone3").click(function(){
        $(".pic_zone3").css("opacity","1");
        $("#info3").css("display","block");
        $("#custom3").css("display","block");
        $(".info_title").css("opacity","0");

        if  ($(".pic_zone2").css("opacity") == "1") {
                $(".pic_zone2").css("opacity","0");
        }
        if  ($(".pic_zone1").css("opacity") == "1") {
                $(".pic_zone1").css("opacity","0");
        }
        if  ($(".pic_zone4").css("opacity") == "1") {
                $(".pic_zone4").css("opacity","0");
        }

        if ($("#info3").css("opacity") == "0") {
                $("#info3").animate({
                    bottom: ["250px", "swing"],
                    opacity: "1"
                }, 1000, "linear", function() {
                $("#title_03").css("opacity","1");
            });
        }

        if ($("#custom3").css("opacity") == "0") {
                $("#custom3").animate({
                    top: ["234px", "swing"],
                    opacity: "1",
                }, 1000, "linear");
        }

        if ($("#info1").css("opacity") == "1") {
                $("#info1").css("display","none");
                $("#info1").animate({
                    left: ["-400px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }
        if ($("#custom1").css("opacity") == "1") {
                $("#custom1").css("display","none");
                $("#custom1").animate({
                    right: ["-400px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }

        if ($("#info2").css("opacity") == "1") {
                $("#info2").css("display","none");
                $("#info2").animate({
                    top: ["-600px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }
        if ($("#custom2").css("opacity") == "1") {
                $("#custom2").css("display","none");
                $("#custom2").animate({
                    bottom: ["-680px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }

        if ($("#info4").css("opacity") == "1") {
                $("#info4").css("display","none");
                $("#info4").animate({
                    left: ["-400px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }
        if ($("#custom4").css("opacity") == "1") {
                $("#custom4").css("display","none");
                $("#custom4").animate({
                    right: ["-400px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }
    });

    $(".zone4").click(function(){
        $(".pic_zone4").css("opacity","1");
        $("#info4").css("display","block");
        $("#custom4").css("display","block");
        $(".info_title").css("opacity","0");
        $(".container").css("overflow","hidden");

        if  ($(".pic_zone2").css("opacity") == "1") {
                $(".pic_zone2").css("opacity","0");
        }
        if  ($(".pic_zone3").css("opacity") == "1") {
                $(".pic_zone3").css("opacity","0");
        }
        if  ($(".pic_zone1").css("opacity") == "1") {
                $(".pic_zone1").css("opacity","0");
        }

        if ($("#info4").css("opacity") == "0") {
                $("#info4").animate({
                    left: ["60px", "swing"],
                    opacity: "1"
                }, 1000, "linear", function() {
                $("#title_04").css("opacity","1");
            });
        }
        if ($("#custom4").css("opacity") == "0") {
                $("#custom4").animate({
                    right: ["10px", "swing"],
                    opacity: "1",
                }, 1000, "linear", function() {
                $(".container").css("overflow","visible");
            });
        }

        if ($("#info1").css("opacity") == "1") {
                $("#info1").css("display","none");
                $("#info1").animate({
                    left: ["-400px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }
        if ($("#custom1").css("opacity") == "1") {
                $("#custom1").css("display","none");
                $("#custom1").animate({
                    right: ["-400px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }

        if ($("#info2").css("opacity") == "1") {
                $("#info2").css("display","none");
                $("#info2").animate({
                    top: ["-600px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }
        if ($("#custom2").css("opacity") == "1") {
                $("#custom2").css("display","none");
                $("#custom2").animate({
                    bottom: ["-680px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }

        if ($("#info3").css("opacity") == "1") {
                $("#info3").css("display","none");
                $("#info3").animate({
                    bottom: ["-600px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }

        if ($("#custom3").css("opacity") == "1") {
                $("#custom3").css("display","none");
                $("#custom3").animate({
                    top: ["-680px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }
    });


    $(".title").click(function(){
        $(".title").removeClass("dimmed");
        $(".info_title").css("opacity","0");


        if ($("#info1").css("opacity") == "1") {
                $("#info1").css("display","none");
                $("#info1").animate({
                    left: ["-400px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }
        if ($("#custom1").css("opacity") == "1") {
                $("#custom1").css("display","none");
                $("#custom1").animate({
                    right: ["-400px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }

        if ($("#info2").css("opacity") == "1") {
                $("#info2").css("display","none");
                $("#info2").animate({
                    top: ["-600px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }
        if ($("#custom2").css("opacity") == "1") {
                $("#custom2").css("display","none");
                $("#custom2").animate({
                    bottom: ["-680px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }

        if ($("#info3").css("opacity") == "1") {
                $("#info3").css("display","none");
                $("#info3").animate({
                    bottom: ["-600px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }

        if ($("#custom3").css("opacity") == "1") {
                $("#custom3").css("display","none");
                $("#custom3").animate({
                    top: ["-680px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }

        if ($("#info4").css("opacity") == "1") {
                $("#info4").css("display","none");
                $("#info4").animate({
                    left: ["-400px", "swing"],
                    opacity: "0"
                }, 1000, "linear");
        }
        if ($("#custom4").css("opacity") == "1") {
                $("#custom4").css("display","none");
                $("#custom4").animate({
                    right: ["-400px", "swing"],
                    opacity: "0",
                }, 1000, "linear");
        }

        if  ($(".flare").css("opacity") == "0") {
                $(".pic_zone1").css("opacity","1");
                $(".pic_zone2").css("opacity","1");
                $(".pic_zone3").css("opacity","1");
                $(".pic_zone4").css("opacity","1");
                $(".tag").css("display","block");
                $(".mode").removeClass("hide");
                $(".mode").addClass("show");
                $(".map").css("opacity","");
                $(".map").addClass("hide");

                $(".flare").animate({
                    opacity: "1"
                }, 4500, "linear", function(){
                    $(".map").removeClass("hide");
                    $(".map").addClass("show");
                    $(".pic_zone1").css("opacity","");
                    $(".pic_zone2").css("opacity","");
                    $(".pic_zone3").css("opacity","");
                    $(".pic_zone4").css("opacity","");
                    $(".mode").removeClass("show");
                    $(".mode").addClass("hide");                    
            });
        }       

    });


    $(".zone1").mouseover(function(){
        $(".pic_zone1").addClass("show");
        $(".pic_zone1").removeClass("hide");
    });
    $(".zone1").mouseout(function(){
    	$(".pic_zone1").addClass("hide");
    	$(".pic_zone1").removeClass("show");
    });

    $(".zone2").mouseover(function(){
    	$(".pic_zone2").addClass("show");
    	$(".pic_zone2").removeClass("hide");
    });
    $(".zone2").mouseout(function(){
    	$(".pic_zone2").addClass("hide");
    	$(".pic_zone2").removeClass("show");
    });

    $(".zone3").mouseover(function(){
    	$(".pic_zone3").addClass("show");
    	$(".pic_zone3").removeClass("hide");
    });
    $(".zone3").mouseout(function(){
    	$(".pic_zone3").addClass("hide");
    	$(".pic_zone3").removeClass("show");
    });

    $(".zone4").mouseover(function(){
    	$(".pic_zone4").addClass("show");
    	$(".pic_zone4").removeClass("hide");
    });
    $(".zone4").mouseout(function(){
    	$(".pic_zone4").addClass("hide");
    	$(".pic_zone4").removeClass("show");
    });

    $("#custom1 .tdm").click(function(){
        $("#custom1 .tdm_box").addClass("actived");
        $("#custom1 .ctf_box").removeClass("actived");
        $("#custom1 .conquest_box").removeClass("actived");
        $(".tdm_zone1").addClass("actived");
        $(".ctf_zone1").removeClass("actived");
        $(".conquest_zone1").removeClass("actived");
    });

    $("#custom1 .ctf").click(function(){
        $("#custom1 .ctf_box").addClass("actived");
        $("#custom1 .tdm_box").removeClass("actived");
        $("#custom1 .conquest_box").removeClass("actived");
        $(".ctf_zone1").addClass("actived");
        $(".tdm_zone1").removeClass("actived");
        $(".conquest_zone1").removeClass("actived");
    });

    $("#custom1 .conquest").click(function(){
        $("#custom1 .conquest_box").addClass("actived");
        $("#custom1 .tdm_box").removeClass("actived");
        $("#custom1 .tf_box").removeClass("actived");
        $(".conquest_zone1").addClass("actived");
        $(".tdm_zone1").removeClass("actived");
        $(".ctf_zone1").removeClass("actived");
    });

   $("#custom2 .tdm").click(function(){
        $("#custom2 .tdm_box").addClass("actived");
        $("#custom2 .ctf_box").removeClass("actived");
        $("#custom2 .conquest_box").removeClass("actived");
        $(".tdm_zone2").addClass("actived");
        $(".ctf_zone2").removeClass("actived");
        $(".conquest_zone2").removeClass("actived");
    });

    $("#custom2 .ctf").click(function(){
        $("#custom2 .ctf_box").addClass("actived");
        $("#custom2 .tdm_box").removeClass("actived");
        $("#custom2 .conquest_box").removeClass("actived");
        $(".ctf_zone2").addClass("actived");
        $(".tdm_zone2").removeClass("actived");
        $(".conquest_zone2").removeClass("actived");
    });

    $("#custom2 .conquest").click(function(){
        $("#custom2 .conquest_box").addClass("actived");
        $("#custom2 .tdm_box").removeClass("actived");
        $("#custom2 .tf_box").removeClass("actived");
        $(".conquest_zone2").addClass("actived");
        $(".tdm_zone2").removeClass("actived");
        $(".ctf_zone2").removeClass("actived");
    });

   $("#custom3 .tdm").click(function(){
        $("#custom3 .tdm_box").addClass("actived");
        $("#custom3 .ctf_box").removeClass("actived");
        $(".tdm_zone3").addClass("actived");
        $(".ctf_zone3").removeClass("actived");
    });

    $("#custom3 .ctf").click(function(){
        $("#custom3 .ctf_box").addClass("actived");
        $("#custom3 .tdm_box").removeClass("actived");
        $(".ctf_zone3").addClass("actived");
        $(".tdm_zone3").removeClass("actived");
    });

    $("#custom4 .tdm").click(function(){
        $("#custom4 .tdm_box").addClass("actived");
        $("#custom4 .hostage_box").removeClass("actived");
        $("#custom4 .bomb_box").removeClass("actived");
        $(".tdm_zone4").addClass("actived");
        $(".hostage_zone4").removeClass("actived");
        $(".bomb_zone4").removeClass("actived");
    });

    $("#custom4 .hostage").click(function(){
        $("#custom4 .hostage_box").addClass("actived");
        $("#custom4 .tdm_box").removeClass("actived");
        $("#custom4 .bomb_box").removeClass("actived");
        $(".hostage_zone4").addClass("actived");
        $(".tdm_zone4").removeClass("actived");
        $(".bomb_zone4").removeClass("actived");
    });

    $("#custom4 .bomb").click(function(){
        $("#custom4 .bomb_box").addClass("actived");
        $("#custom4 .tdm_box").removeClass("actived");
        $("#custom4 .hostage_box").removeClass("actived");
        $(".bomb_zone4").addClass("actived");
        $(".tdm_zone4").removeClass("actived");
        $(".hostage_zone4").removeClass("actived");
    });


    var $showImage1 = $("#info1 .bigpic img");

    $("#info1 .smallpic").click(function(){
        
        var trans1=$showImage1.attr('src');
        $showImage1.attr('src', $(this).find('img').attr('src'));
        $(this).find('img').attr('src',trans1);
    });

    var $showImage2 = $("#info2 .bigpic img");

    $("#info2 .smallpic").click(function(){
        
        var trans2=$showImage2.attr('src');
        $showImage2.attr('src', $(this).find('img').attr('src'));
        $(this).find('img').attr('src',trans2);
    });

    var $showImage3 = $("#info3 .bigpic img");

    $("#info3 .smallpic").click(function(){
        
        var trans3=$showImage3.attr('src');
        $showImage3.attr('src', $(this).find('img').attr('src'));
        $(this).find('img').attr('src',trans3);
    });

    var $showImage4 = $("#info4 .bigpic img");

    $("#info4 .smallpic").click(function(){
        
        var trans4=$showImage4.attr('src');
        $showImage4.attr('src', $(this).find('img').attr('src'));
        $(this).find('img').attr('src',trans4);
    });

});

</script>


<?php include __DIR__ . '/__html_foot.php' ?>