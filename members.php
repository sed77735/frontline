<?php
require __DIR__ . '/__connect_db.php';

$pname = 'none';

$dir = __DIR__. '/user_img/';

if (isset($_SESSION['team_members'])){
    unset($_SESSION['team_members']);
}


$success = false;
$success_pw = false;

//登入
if( isset( $_POST['email_login'] ) ){
    $sql = sprintf("SELECT * FROM `members` WHERE `email`='%s' AND `password`='%s'",
        $mysqli->escape_string($_POST['email_login']),
        sha1($_POST['password_login'])
    );


    $result = $mysqli->query($sql);
    if($result->num_rows){
        echo '<script> alert("登入成功!") </script>';
        $row = $result->fetch_assoc();
        $_SESSION['user'] = $row;
//        $_SESSION['login'] = 1;

        if (isset($_SESSION['server'])){
            header("Location:".$_SESSION['server']);
        }
    }

};


// 會員介紹
if ( isset($_SESSION['user'])){

//    if ( $_SESSION['login'] == 1){
//        echo '<script> alert("登入成功!") </script>';
//    }

    $sql = "SELECT * FROM `members` WHERE `sid`=".intval($_SESSION['user']['sid'] );
    $rs = $mysqli->query($sql);
    $row = $rs->fetch_assoc();

    $image = $row['image'];
    $email = $row['email'];
    $name = $row['name'];
    $intorduction = $row['intorduction'];
    $place = $row['place'];
    $gender = $row['gender'];
    $phone = $row['phone'];
    $address = $row['address'];
    $hash = $row['hash'];
}

if (! isset($_SESSION['user_img_file'])){
    $_SESSION['user_img_file']=array();
}
//$_SESSION['user_img_file']['my_file']['name'] = $_FILES;

//會員介紹頁編輯
if (isset($_FILES["my_file"])) {
//    echo $image;

    $image = $_FILES['my_file']['name'];

    if (! empty($image) ){

        $stmt = $mysqli->prepare(" UPDATE `members` SET 
        `image` = ?,
        `intorduction`= ?, 
        `place`= ?
        WHERE `sid` = ?");

        $stmt->bind_param('sssi',
            $image,
            $_POST['intorduction'],
            $_POST['place'],
            $_SESSION['user']['sid']
        );

        $success = $stmt->execute();
        $affected = $stmt->affected_rows;

//        $image = $_POST['image'];
        $intorduction = $_POST['intorduction'];
        $place = $_POST['place'];


    } else {

        $stmt = $mysqli->prepare(" UPDATE `members` SET 
        `image` = ?,
        `intorduction`= ?, 
        `place`= ?
        WHERE `sid` = ?");

        $stmt->bind_param('sssi',
            $_SESSION['user_img_file']['my_file']['name'],
            $_POST['intorduction'],
            $_POST['place'],
            $_SESSION['user']['sid']
        );
//        echo $stmt;
//        exit;
        $success = $stmt->execute();
        $affected = $stmt->affected_rows;

        $image = $_POST['image'];
        $intorduction = $_POST['intorduction'];
        $place = $_POST['place'];

        if ($success) {
            header('Location: members.php');
        }
    }


}



//會員資料頁編輯
//if (isset($_POST["email"])) {
//
//        $stmt = $mysqli->prepare(" UPDATE `members` SET
//        `email` = ?,
//        `name`= ?,
//        `gender`= ?,
//        `phone`= ?,
//        `address`= ?
//        WHERE `sid` = ?");
//
//        $stmt->bind_param('sssssi',
//            $_POST['email'],
//            $_POST['name'],
//            $_POST['gender'],
//            $_POST['phone'],
//            $_POST['address'],
//            $_SESSION['user']['sid']
//        );
//
//        $success = $stmt->execute();
//        $affected = $stmt->affected_rows;
//
//        $email = $_POST['email'];
//        $name = $_POST['name'];
//        $gender = $_POST['gender'];
//        $phone = $_POST['phone'];
//        $address = $_POST['address'];
//
//    }


//變更密碼
if(isset($_POST['new_password'])) {
//    echo '<pre>';
//    print_r($_POST);
//    echo '</pre>';
    $sql = sprintf( "UPDATE `members` SET `password`= '%s' WHERE `sid`='%s' AND `password`='%s'",
        sha1($_POST['new_password']), $_SESSION['user']['sid'], sha1($_POST['old_password']) );
    $success_pw =  $mysqli->query($sql);

}

if ($success_pw){
    echo ' <script> alert( "密碼變更成功" ) </script> ';
    unset($_SESSION['user']);
}


//文碩右上----------------
if (!empty($_SESSION['cart'])) {

    $sids = array_keys($_SESSION['cart']);

    $sql = sprintf("SELECT * FROM `products` WHERE type=1 AND `sid` IN (%s)", implode(',', $sids));

    $rs = $mysqli->query($sql);

    $cart_data = array();

    while ($row = $rs->fetch_assoc()) {
        $row['qty'] = $_SESSION['cart'][$row['sid']];
        $cart_data[$row['sid']] = $row;
    }
}



//團隊資訊---------自己的-----------------
if (! empty( $_SESSION['user']['team_sid'] )){
    $tinfo_sql = "SELECT t.* FROM `members` m JOIN `team` t ON m.team_sid = t.sid WHERE m.`sid`=".intval($_SESSION['user']['sid'] );
    $tinfo_rs = $mysqli->query($tinfo_sql);
    $tinfo_row = $tinfo_rs->fetch_assoc();

}

//團隊資訊---------其他的-----------------
if (! empty( $_SESSION['user']['team_sid'] )){
    $oinfo_sql = "SELECT * FROM `team` WHERE sid NOT IN (". $_SESSION['user']['team_sid'] .") ORDER BY rand() LIMIT 3";
    $oinfo_rs = $mysqli->query($oinfo_sql);


}







?>




<?php include __DIR__.'/__html_head.php'?>
<link rel="stylesheet" href="css/members.css">
    <style>

        body {
            font-family: Microsoft JhengHei;
        }

    </style>

<?php include __DIR__ . '/__navbar.php' ?>

	<div class="container">
		<div class="four">
			<div class="member">
                <?php if (isset($_SESSION['user'])): ?>
				<div class="pack datapack show actived"><!-- 登入後主框架 -->
					<div class="box_slide">
						<ul class="slide_all transition">
							<li id="intro" class="box_inside"><!-- 會員介紹頁 -->
								<div class="edit hide"></div>
								<figure class="bighead no_edit_img"><img src="<?= empty($image) ? "user_img/non_member.jpg" : 'user_img/' . $hash . '/' . $image ?>" alt=""></figure>
								<h1 class="username" ><?= $name ?></h1>
								<h2><?= $email ?></h2>
								<p style="color:#ccc; height: 120px;"><?= empty($intorduction)? "使用者自我介紹區域，使用者座右銘文字輸入區塊，字限制50字元以內。你好、我好大家好，一起玩生存遊戲。真的好想贏韓國。" : $intorduction ?></p>
								<h3><?= empty($place)? "位置 台灣 台北市 家住台北101頂樓" : $place ?></h3>
							</li>
							<li id="data" class="box_inside"><!-- 會員資料頁 -->
								<div class="dataedit hide"><a href="#"></a></div>
								<h1>會員資料</h1>
								<table id="ajuserinfo">
									<tbody>
										<tr>
											<td><p>電子信箱</p></td>
											<td><h2><?= $email ?></h2></td>
										</tr>
										<tr>
											<td><p>真實姓名</p></td>
											<td><h2><?= $name ?></h2></td>
										</tr>
										<tr>
											<td><p>性別</p></td>
											<td><h2><?= $gender ?></h2></td>
										</tr>
										<tr>
											<td><p>電話號碼</p></td>
											<td><h2><?= $phone ?></h2></td>
										</tr>
										<tr>
											<td><p>地址</p></td>
											<td><h2><?= $address ?></h2></td>
										</tr>

									</tbody>
								</table>
								<div class="password">
									<form name="form_psd" action="" method="post" onsubmit="return checkPassword()">
									<span><p>密碼</p><h2>●●●●●●●</h2></span>
									<div class="board3 actived">變更密碼</div>
									<div class="board3">取消</div>
									<button type="submit" id="password_confirm">確認變更</button>
										<div id="password_change">
											<ul>
												<li><input type="password" name="old_password" class="data_edit" id="old_password" placeholder="輸入舊密碼"></li>
												<li><input type="password" name="new_password" class="data_edit" id="new_password" placeholder="輸入新密碼"></li>
												<li><input type="password" name="check_new_password" class="data_edit" id="confirm_password" placeholder="再次輸入新密碼"></li>
											</ul>
										</div>
									</form>
								</div>					
							</li>
						</ul>
					</div><!-- box_slide -->
					<div class="node">
						<ul>
							<li id="node_intro" class="circle_on"></li>
							<li id="node_data" class="circle_off"></li>
						</ul>
					</div><!-- node -->
					<div class="board_cancel" id="logout"><a href="logout.php">登出</a></div>
				</div><!-- pack,datapack -->
				<div class="pack hide" id="intro_edit"><!-- 會員介紹頁編輯 -->
					<form  name="form_intro" method="post" enctype="multipart/form-data" onsubmit="return checkForm();">
					<div class="box_inside">	
						<div class="edit hide"></div>
						<figure class="bighead edit_img"><img src="<?=! empty($image) ? "user_img/non_member.jpg" : 'user_img/' . $hash . '/' . $image ?>" alt=""></figure>
						<label for="editPhoto" class="photo_edit" id="uploadPhoto">上傳圖片</label>
						<input type="file" name="my_file" class="my_file" id="editPhoto">
						<textarea name="intorduction" id="hello" cols="25" rows="6" maxlength="150" placeholder="哈囉！寫點什麼讓大家認識你吧！"><?= $intorduction ?></textarea>
						<input type="text" name="place" class="place_edit" id="place" placeholder="我的活動區域" value="<?= $place ?>">
					</div>
					<button type="submit">更新</button>
					<div class="board_cancel" id="intro_cancel"><a href="#">取消</a></div>
					</form>
				</div><!-- intro_edit -->
				<div class="datapack hide" id="data_edit"><!-- 會員資料頁編輯 -->
						<form name="form_intro" action="" method="post"  onsubmit="return checkUserInfo();">
                            <div id="data" class="box_inside">
						<div class="dataedit hide"></div>
						<h1>會員資料</h1>
						<table>
							<tbody>
								<tr>
									<td><label for="editEmail"><p>電子信箱</p></label></td>
									<td><input type="text" name="$email" class="data_edit" id="editEmail" value="<?= $email ?>" disabled="disabled"></td>
								</tr>
								<tr>
									<td><label for="editName"><p>真實姓名</p></label></td>
									<td><input type="text" name="name" class="data_edit" id="editName" value="<?= $name ?>"></td>
								</tr>
								<tr>
									<td><label for="editGender"><p>性別</p></label></td>
									<td><input type="text" name="gender" class="data_edit" id="editGender" value="<?= $gender ?>"></td>
								</tr>
								<tr>
									<td><label for="editTel"><p>電話號碼</p></label></td>
									<td><input type="tel" name="phone" class="data_edit" id="editTel" value="<?= $phone ?>"></td>
								</tr>
								<tr>
									<td><label for="editAddress"><p>地址</p></label></td>
									<td><input type="text" name="address" class="data_edit" id="editAddress" value="<?= $address ?>"></td>
								</tr>
								</tbody>
						</table>
						<div class="password">
							<div id="password_change">
								<ul>
									<li><input type="password" class="data_edit" id="old_password" placeholder="輸入舊密碼"></li>
									<li><input type="password" class="data_edit" id="new_password" placeholder="輸入新密碼"></li>
									<li><input type="password" class="data_edit" id="confirm_password" placeholder="再次輸入新密碼"></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="node"></div>
					<button type="submit">更新</button>
					<div class="board_cancel" id="data_cancel"><a href="#">取消</a></div>
					</form>
				</div><!-- data_edit -->
                <?php endif; ?>

                <?php if( empty($_SESSION['user']) ): ?>
				<div id="login">
					<div class="password_pack account_pack show actived"><!-- 登入頁主框架，目前放在最前面 -->
						<div class="login_box">
							<div class="mix"></div>

							<form name="login_form" action="" method="post" onsubmit="return checkLoginForm();">
							<div class="formgroup">
								<p>電子信箱</p>
								<input type="text" name="email_login" class="data_log" id="getEmail" placeholder="email">
								<p>輸入密碼</p>
								<input type="password" name="password_login" class="data_log" id="getPassword" placeholder="password">
								<span><button type="submit" onclick="checkLoginForm()" id="login_btn" class="login_button">登入</button><div class="board_aa aa_register"><a href="register.php">註冊</a></div></span>
								<span><div class="board_aa forgot fp">忘記密碼？</div><div class="board_aa forgot faccount">忘記帳號？</div></span>
							</div>
							</form>

						</div>
					</div><!-- password_pack account_pack -->
					<div id="forgot_p" class="password_pack hide"><!-- 忘記密碼狀態 -->
						<div class="login_box">
							<div class="mix"></div>
							<div class="step">
								<h1>忘記密碼</h1>
								<p>請提供您的電子信箱<br>我們會傳送密碼給您<br>藉此驗證您是使用者<br>以重新登入會員</p>
							</div>
							<form action="" method="post">
							<div class="formgroup">
								<label for="forgotEmail"><p>電子信箱</p></label>
								<input type="email" class="data_log" id="forgotEmail" placeholder="email">
								<span><button class="nb" style="margin-left: 230px">寄送密碼</button></span>
							</div>
							</form>
						</div>
					</div><!-- forgot_p -->
					<div id="forgot_a" class="account_pack hide"><!-- 忘記帳號狀態 -->
						<div class="login_box">
							<div class="mix"></div>
							<div class="step">
								<h1>忘記帳號</h1>
								<p>請提供您的手機號碼<br>我們會以簡訊的方式<br>傳送帳號到您的手機<br>以重新登入會員</p>
							</div>
							<form action="" method="post">
							<div class="formgroup">
								<label for="forgotAccount"><p style="margin-left: 105px">電話號碼</p></label>
								<input type="tel" class="data_log" id="forgotAccount" placeholder="phonenumber">
								<span><button class="nb" style="margin-left: 230px">寄送簡訊</button></span>
							</div>
							</form>
						</div>
					</div><!-- forgot_a -->
					<div id="return" class="return_pack hide"><!-- 重啟帳號Email，目前掛隱藏樣式 -->
						<div class="login_box">
							<div class="mix return_back"></div>
							<div class="step">
								<h1>重新驗證</h1>
								<p>重啟會員只差一步!<br>請前往您的電子信箱<br>檢查我們提供的資訊<br>點選驗證連結</p>
							</div>
							<div class="formgroup" style="margin-top: 10px">
								<input type="text" class="data_log" id="returnLink" value="驗證連結將在24小時後自動失效">
								<span><p><i class="fa fa-exclamation-triangle fa-cog" aria-hidden="true"></i>驗證連結將在24小時後自動失效</p></span>
							</div>
						</div>
					</div><!-- return -->
					<div class="return_pack hide"><!-- 重啟帳號手機，目前掛隱藏樣式 -->
						<div class="login_box">
							<div class="mix return_back"></div>
							<div class="step">
								<h1>重新驗證</h1>
								<p>請查看發送到您手機的簡訊<br>使用您正確的電子信箱帳號<br>再次登入會員</p>
							</div>
						</div>
					</div><!-- return_pack -->			
				</div><!-- login -->
                <?php endif; ?>
				<div class="leftup_seal"></div>
				<div class="rightup_seal"></div>
			</div><!-- member -->

			<div class="list">
                <?php if( empty($_SESSION['user']) ): ?>
				<div class="list_cover covered"></div><!--                        訂單區塊登入前遮蓋，掛.covered後啟動 -->
                <?php endif; ?>
                <?php if (isset($_SESSION['user'])): ?>
                <div class="tab">
					<label for="order" class="on"><h2>檢視訂單</h2></label>
					<input type="radio" name="listpage" id="order" value="page1" checked="checked">
					<label for="following" class="off"><h2>追蹤清單</h2></label>
					<input type="radio" name="listpage" id="following" value="page2">
					<label for="cart" class="off"><h2>購物車</h2></label>
					<input type="radio" name="listpage" id="cart" value="page3">
				</div>
                <?php endif; ?>
<!----------------------------------------------------------TAB1------------------------------------------------->
				<div class="page_pack">
					<div class="order_list show actived">
						<div class="action">
							<div class="board_aaa aaa_listall"><a href="cart_list_test.php">完整列表</a></div>
							<div class="board">戰地活動</div>
							<table>
								<tbody>
                                <?php if (isset($_SESSION['user'])){
                                $user_sid = $_SESSION['user']['sid'];
                                $order_sql = sprintf("SELECT * FROM `order_details` d JOIN `orders` o ON d.order_sid = o.sid JOIN `products` p ON d.product_sid = p.sid
                                        WHERE p.type=0 AND o.type = 0 AND o.member_sid=$user_sid ORDER BY `o`.`order_date` DESC LIMIT 0,1");
                                $order_rs = $mysqli->query($order_sql);

                                while($order_row = $order_rs->fetch_assoc()): ;

                                ?>
									<tr>
										<td><figure><img src="activity_img/<?= $order_row['head_image'] ?>"></figure></td>
										<td><p><?= date("Y-m-d", strtotime($order_row['date'])) ?><br><?= $order_row['name'] ?></p></td>
										<td><div class="board2"><?= $order_row['host'] ?></div><p><?= $order_row['ground'] ?><br><?= $order_row['people'] ?></p></td>
										<td><div class="board2">現場付款</div><div class="board2">等待中</div></td>
									</tr>
                                <?php endwhile; } ?>
								</tbody>
							</table>
						</div>
						<div class="product">
							<div class="board">裝備商品</div>
							<table>
								<tbody>
                                <?php if (isset($_SESSION['user'])){
                                $user_sid = $_SESSION['user']['sid'];
                                $order_sql = sprintf("SELECT * FROM `order_details` d JOIN `orders` o ON d.order_sid = o.sid JOIN `products` p ON d.product_sid = p.sid
                                        WHERE p.type=1 AND o.type = 1 AND o.member_sid=$user_sid ORDER BY `o`.`order_date` DESC LIMIT 0,3");
                                $order_rs = $mysqli->query($order_sql);

                                while($order_row = $order_rs->fetch_assoc()): ;

                                    ?>

									<tr>
										<td><figure><img style="width: 100%;height: 90px"  src="imgs/small/<?= $order_row['head_image'] ?>.jpeg"
                                                         alt=""></figure></td>
                                        <td><p><?= $order_row['order_date'] ?></p><p style=" text-overflow : ellipsis;" ><?= $order_row['name'] ?></p></td>
										<td><p>規格：<?= $order_row['description_5'] ?><br><?= $order_row['quantity'] ?>項<br><?= $order_row['price'] ?>元</p></td>
										<td><div class="board2">等待付款</div><div class="board2">未出貨</div></td>
									</tr>
                                <?php endwhile;  }?>
<!--									<tr>-->
<!--										<td><figure><img src="images/2.jpg"></figure></td>-->
<!--										<td><p>2017/04/27<br>商品名稱商品名稱<br>商品名稱商品名稱<br></p></td>-->
<!--										<td><p>規格：XL<br>5項<br>550元</p></td>-->
<!--										<td><div class="board2">付款完成</div><div class="board2">已送達</div></td>-->
<!--									</tr>-->
<!--									<tr>-->
<!--										<td><figure><img src="images/2.jpg"></figure></td>-->
<!--										<td><p>2017/04/27<br>商品名稱商品名稱<br>商品名稱商品名稱<br></p></td>-->
<!--										<td><p>規格：XL<br>5項<br>550元</p></td>-->
<!--										<td><div class="board2">付款完成</div><div class="board2">已送達</div></td>-->
<!--									</tr>-->
								</tbody>
							</table>
						</div>
					</div><!-- order_list -->

                    <!----------------------------------------------------------TAB2------------------------------------------------->
					<div class="following_list hide">
						<div class="action">
							<div class="board_aaa aaa_listall"><a href="cart_list_test.php">完整列表</a></div>
							<div class="board">戰地活動</div>
							<table>
								<tbody>
                                <?php

                                $like_sql = sprintf("SELECT  p.name as pname, p.sid as psid,p.*,m.*,l.* FROM `like_products` l JOIN `products` p ON
                                            l.products_sid = p.sid JOIN `members` m ON l.member_sid = m.sid 
                                            WHERE p.type=0 ORDER BY p.name LIMIT 0,1");
                                $like_rs = $mysqli->query($like_sql);

                                while ($like_row = $like_rs->fetch_assoc()):;
                                ?>
									<tr>
										<td><figure><img src="activity_img/<?= $like_row['head_image'] ?>"></figure></td>
										<td><p><?= date("Y-m-d", strtotime($like_row['date'])) ?><br><?= $like_row['pname'] ?></p></td>
										<td><div class="board2"><?= $like_row['host'] ?></div><p><?= $like_row['ground'] ?><br><?= $like_row['people'] ?></p></td>
										<td>
											<ul>
                                                <li class="re like_remove_item"  data-like="<?= $like_row['sid'] ?>">
                                                    <div class="re_progress">
                                                        <p><i class="fa fa-times" aria-hidden="true">

                                                            </i></p><br>
                                                        <p>移除</p>
                                                    </div>
                                                </li>

                                                <li class="add">
                                                    <div class="add_progress">
                                                        <a href="single_activity.php?type=0&sid=<?= $like_row['psid'] ?>">
                                                            <p style="height: 27px">
                                                                <img class="join_img" src="images/join.png" alt="">
                                                            </p>

                                                            <p>我要報名</p>
                                                        </a>
                                                    </div>
                                                </li>

											</ul>
										</td>
									</tr>
                                <?php endwhile ?>
								</tbody>
							</table>
						</div>
						<div class="product">
							<div class="board">裝備商品</div>
							<table>
								<tbody>
                                <?php

                                $like_sql = sprintf("SELECT  p.name as pname,p.*,m.*,l.* FROM `like_products` l JOIN `products` p ON
                                            l.products_sid = p.sid JOIN `members` m ON l.member_sid = m.sid 
                                            WHERE p.type=1 ORDER BY p.name LIMIT 0,3");
                                $like_rs = $mysqli->query($like_sql);

                                while ($like_row = $like_rs->fetch_assoc()):;
                                ?>
									<tr data-like="<?= $like_row['products_sid'] ?>">
										<td><figure><img style="width: 100%;height: 98px" src="imgs/small/<?= $like_row['head_image'] ?>.jpeg"
                                                         alt=""></figure></td>
										<td><p><?= $like_row['like_time'] ?><br><?= $like_row['pname'] ?></p></td>
										<td><p>規格：<?= $like_row['description_5'] ?><br><?= $like_row['price'] ?>元</p></td>
										<td>
											<ul>
												<li class="re like_remove_item"  data-like="<?= $like_row['sid'] ?>"><div class="re_progress"><p><i class="fa fa-times" aria-hidden="true"></i></p><br><p>移除</p></div></li>
												<li class="add like_like_item" data-like="<?= $like_row['products_sid'] ?>"><div class="add_progress"><p><i class="fa fa-shopping-cart" aria-hidden="true"></i></p><br><p>加入購物車</p></div></li>
											</ul>
										</td>
									</tr>
                                <?php endwhile ?>
<!--									<tr>-->
<!--										<td><figure><img src="images/2.jpg"></figure></td>-->
<!--										<td><p>2017/04/27<br>商品名稱商品名稱<br>商品名稱商品名稱<br></p></td>-->
<!--										<td><p>規格：XL<br>5項<br>550元</p></td>-->
<!--										<td>-->
<!--											<ul>-->
<!--												<li class="re"><div class="re_progress"><a href=""><p><i class="fa fa-times" aria-hidden="true"></i></p><br><p>移除</p></a></div></li>-->
<!--												<li class="add"><div class="add_progress"><a href=""><p><i class="fa fa-shopping-cart" aria-hidden="true"></i></p><br><p>加入購物車</p></a></div></li>-->
<!--											</ul>-->
<!--										</td>-->
<!--									</tr>-->
<!--									<tr>-->
<!--										<td><figure><img src="images/2.jpg"></figure></td>-->
<!--										<td><p>2017/04/27<br>商品名稱商品名稱<br>商品名稱商品名稱<br></p></td>-->
<!--										<td><p>規格：XL<br>5項<br>550元</p></td>-->
<!--										<td>-->
<!--											<ul>-->
<!--												<li class="re"><div class="re_progress"><a href=""><p><i class="fa fa-times" aria-hidden="true"></i></p><br><p>移除</p></a></div></li>-->
<!--												<li class="add"><div class="add_progress"><a href=""><p><i class="fa fa-shopping-cart" aria-hidden="true"></i></p><br><p>加入購物車</p></a></div></li>-->
<!--											</ul>-->
<!--										</td>-->
<!--									</tr>-->
								</tbody>
							</table>
						</div>
					</div><!-- following_list -->

   <!----------------------------------------------------------TAB3------------------------------------------------->
					<div class="cart_list hide">
						<div class="product" style="margin-top: 5px">
							<div class="board_aaa aaa_listall" style="top:0"><a href="cart_list_test.php">完整列表</a></div>
							<div class="board">裝備商品</div>
							<table>
								<tbody>

                                <?php


                                $total = 0;
                                foreach ($_SESSION['cart'] as $sid => $qty):
                                    $i=0;
                                    $i++;

                                $row = $cart_data[$sid];
                                $total += $row['price'] * $row['qty'];

                                    ?>
									<tr data-sid="<?= $row['sid'] ?>">
										<td><figure><img style="width: 100%;height: 98px"
                                                         src="imgs/small/<?= $row['head_image'] ?>.jpeg"
                                                         alt=""></figure></td>
										<td><p><?= $row['name'] ?></p></td>
										<td><p>規格：<?= $row['description_5'] ?><br><?= $row['qty'] ?>項<br><?= $row['price'] * $row['qty'] ?>元</p></td>
										<td>
											<ul>
												<li class="re remove_item"><div class="re_progress"><p><i class="fa fa-times" aria-hidden="true"></i></p><br><p>移除</p></div></li>
												<li class="add like_item"><div class="add_progress"><p><i class="fa fa-heart" aria-hidden="true"></i></p><br><p>加入追蹤</p></div></li>
											</ul>
										</td>
									</tr>
                                <?php  endforeach; ?>
<!--									<tr>-->
<!--										<td><figure><img src="images/2.jpg"></figure></td>-->
<!--										<td><p>2017/04/27<br>商品名稱商品名稱<br>商品名稱商品名稱<br></p></td>-->
<!--										<td><p>規格：XL<br>5項<br>550元</p></td>-->
<!--										<td>-->
<!--											<ul>-->
<!--												<li class="re"><div class="re_progress"><a href=""><p><i class="fa fa-times" aria-hidden="true"></i></p><br><p>移除</p></a></div></li>-->
<!--												<li class="add"><div class="add_progress"><a href=""><p><i class="fa fa-heart" aria-hidden="true"></i></p><br><p>加入追蹤</p></a></div></li>-->
<!--											</ul>-->
<!--										</td>-->
<!--									</tr>-->
<!--									<tr>-->
<!--										<td><figure><img src="images/2.jpg"></figure></td>-->
<!--										<td><p>2017/04/27<br>商品名稱商品名稱<br>商品名稱商品名稱<br></p></td>-->
<!--										<td><p>規格：XL<br>5項<br>550元</p></td>-->
<!--										<td>-->
<!--											<ul>-->
<!--												<li class="re"><div class="re_progress"><a href=""><p><i class="fa fa-times" aria-hidden="true"></i></p><br><p>移除</p></a></div></li>-->
<!--												<li class="add"><div class="add_progress"><a href=""><p><i class="fa fa-heart" aria-hidden="true"></i></p><br><p>加入追蹤</p></a></div></li>-->
<!--											</ul>-->
<!--										</td>-->
<!--									</tr>-->
								</tbody>
							</table>
						</div>
					</div><!-- cart_list -->
				</div><!-- page_pack -->
			</div>
			<div class="score">
                <?php if( empty($_SESSION['user']) ): ?>
				<div class="score_cover covered"></div><!--                        戰績區塊登入前遮蓋，掛.covered後啟動 -->
                <?php endif; ?>

                <div class="title1"><h2 style="margin-left: 40px">戰績表</h2></div>

                <?php if( empty($_SESSION['user']['join_num']&&$_SESSION['user']['kill_num']&&$_SESSION['user']['missoni_complete']&&$_SESSION['user']['kda']) ):  ?>
				<div class="score_empty actived"><!-- 											戰績區塊空白狀態，掛.actived後啟動 -->
					<p>您還沒有任何戰鬥紀錄！<br>現在就為自己預約或舉辦一場戰鬥</p>
				</div>
                <?php endif; ?>

                <?php if(! empty($_SESSION['user']['join_num']&&$_SESSION['user']['kill_num']&&$_SESSION['user']['missoni_complete']&&$_SESSION['user']['kda']) ): ?>
				<div class="pin">
					<div class="circle"></div>
					<div class="progress_A"></div>
					<div class="info"><h3><?= is_null($_SESSION['user']['win']) || is_null($_SESSION['user']['lose']) ? "F" : round($_SESSION['user']['win'] / $_SESSION['user']['lose'],2 ) ?></h3>
					<p style="float: left">獲勝</p><p style="float: right"><?= is_null($_SESSION['user']['win']) ? "F" : $_SESSION['user']['win'] ?>場</p>
					<p style="float: left">戰敗</p><p style="float: right"><?= is_null($_SESSION['user']['lose']) ? "F" : $_SESSION['user']['lose'] ?>場</p>
					</div>
				</div>
				<div class="pin">
					<div class="circle"></div>
					<div class="progress_B"></div>
					<div class="info"><h3><?=  is_null($_SESSION['user']['kill_num']) || is_null($_SESSION['user']['die']) ? "F" : round($_SESSION['user']['kill_num'] / $_SESSION['user']['die'],2) ?></h3>
					<p style="float: left">擊殺</p><p style="float: right"><?= is_null($_SESSION['user']['kill_num']) ? "F" : $_SESSION['user']['kill_num'] ?>人</p>
					<p style="float: left">陣亡</p><p style="float: right"><?= is_null($_SESSION['user']['die']) ? "F" : $_SESSION['user']['die'] ?>次</p>
					</div>
				</div>
				<h2>勝負比</h2>
				<h2>戰損比</h2>
				<div class="board_aaa aaa_activity"><a href="activity_list.php">參加活動</a></div>
                <?php endif; ?>

				<div class="left_seal"></div>
				<div class="right_seal"></div>
				</div>
			<div class="team">
            <?php if( empty($_SESSION['user']) ): ?>
			<div class="team_cover covered"></div><!--                        團隊區塊登入前遮蓋，掛.covered後啟動 -->
            <?php endif; ?>

                <div class="title2">
					<h2>我的團隊</h2>
					<div class="board_aaa aaa_teamcreate actived"><a href="create_team.php">建立團隊</a></div><!--		團隊區塊空白狀態，掛.actived後啟動 -->
					<div class="board_aaa aaa_teammanage"><a href="manage_team.php?sid=<?= $_SESSION['user']['team_sid'] ?>">管理團隊</a></div>
					<div class="board_aaa aaa_listteam" style="top:10px"><a href="team_list.php">團隊列表</a></div></div>

                <?php if( empty($_SESSION['user']['team_sid']) ): ?>
				<div class="mine_empty actived"><!-- 團隊區塊空白狀態，掛.actived後啟動 -->
                    <div class="teamtext">
                        <p>想提高您的聲望嗎？不想再獨自一人在戰場上<br>孤軍奮戰或不想再跟豬隊友被高手壓制了嗎?<br>現在就建立一個屬於自己的強悍團隊!<br>邀請親朋好友一同組織戰力堅強的陣容!</p>
                    </div>
                    <div class="teamgood">
                        <p>建立團隊立刻享有:<br>在排行榜上積分排名<br>上傳自製徽章<br>最多50人的龐大團隊<br>與其他團隊專屬的約戰活動<br>隊員的積分與技巧分析</p>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(! empty($_SESSION['user']['team_sid']) ): ?>
                <div class="mine">
				<figure class="teamlogo"><img src="team_img/<?= $tinfo_row['code'] ?>/<?= $tinfo_row['image'] ?>"></figure>
				<div class="teamabout">
					<h1><?= $tinfo_row['name'] ?></h1>
					<h4><?= $tinfo_row['code'] ?></h4>
					<span><h3 class="count"><?= $tinfo_row['members_qty'] ?></h3><p>人</p></span>
					<div class="board2" style="float:left"><?= $tinfo_row['public']=="public" ? "公開團隊" : "私人團隊"  ?></div>
				</div>
				<div class="quote"><p style="color:#eee">座右銘 :<br><?= $tinfo_row['motto'] ?></p></div>
				</div>
				<div class="others">
					<table>
						<tbody>
							<tr>
                                <?php while ($oinfo_row = $oinfo_rs->fetch_assoc()): ?>
								<td>
									<figure class="otherslogo"><img src="team_img/<?= $oinfo_row['code'] ?>/<?= $oinfo_row['image'] ?>"></figure>
									<div class="othersabout"><p style="color:#eee"><?= $oinfo_row['name'] ?></p><h4><?= $oinfo_row['code'] ?></h4></div>
									<p><?= $oinfo_row['members_qty'] ?>人</p>
									<div class="teamboard_a"><a href="team_info.php?sid=<?= $oinfo_row['sid'] ?>">查看</a></div>
								</td>
                                <?php endwhile; ?>
<!--								<td>-->
<!--									<figure class="otherslogo"><img src="images/101.png"></figure>-->
<!--									<div class="othersabout"><p style="color:#eee">其他團隊名稱02</p><h4>ROC1</h4></div>-->
<!--									<p>16人</p>-->
<!--									<div class="teamboard_a"><a href="">查看</a></div>-->
<!--								</td>-->
<!--								<td>-->
<!--									<figure class="otherslogo"><img src="images/101.png"></figure>-->
<!--									<div class="othersabout"><p style="color:#eee">其他團隊名稱03</p><h4>USA1</h4></div>-->
<!--									<p>25人</p>-->
<!--									<div class="teamboard_a"><a href="">查看</a></div>-->
<!--								</td>-->
							</tr>
						</tbody>
					</table>

				</div>
                <?php endif; ?>

            </div>
		</div>
	</div>
  	<script src="js/jquery-3.1.1.js"></script>
  	<script src="https://use.fontawesome.com/566f5bff53.js"></script>
	<script type="text/javascript">



        //改變我要報名鈕樣式-----------------------
        $('.add_progress').mouseover(function () {
            $(this).find(".join_img").attr("src","images/join_hover.png")
        });

        $('.add_progress').mouseleave(function () {
            $(this).find(".join_img").attr("src","images/join.png")
        });




        //變更密碼確認---------------
        function checkPassword(){
            var $oldpassword = $('#old_password');
            var $newpassword = $('#new_password');
            var $newpassword_check = $('#confirm_password');

            var items = [$oldpassword, $newpassword, $newpassword_check];

            var oldpassword = $oldpassword.val();
            var newpassword = $newpassword.val();
            var newpassword_check = $newpassword_check.val();

            var i;
            var isPass = true;

            for(i=0; i<items.length; i++){
//                items[i].val('');
                items[i].attr('placeholder','');
                items[i].removeClass('error');
            }


            if(oldpassword.length < 6){
                $oldpassword.val('');
                $oldpassword.attr('placeholder',' 密碼輸入錯誤 !');
                $oldpassword.addClass('error');
                isPass = false;
            }

            if(! oldpassword){
                $oldpassword.val('');
                $oldpassword.attr('placeholder',' 請輸入舊密碼 !');
                $oldpassword.addClass('error');
                isPass = false;
            }

            if(newpassword.length < 6){
                $newpassword.val('');
                $newpassword.attr('placeholder',' 密碼至少 6 個字元 !');
                $newpassword.addClass('error');
                isPass = false;
            }

            if(! newpassword){
                $newpassword.val('');
                $newpassword.attr('placeholder',' 請輸入新密碼 !');
                $newpassword.addClass('error');
                isPass = false;
            }

            if(! (newpassword_check == newpassword) ){
                $newpassword_check.val('');
                $newpassword_check.attr('placeholder',' 密碼不一致 !');
                $newpassword_check.addClass('error');
                isPass = false;
            }

            if(! newpassword_check){
                $newpassword_check.val('');
                $newpassword_check.attr('placeholder',' 請再輸入一次 !');
                $newpassword_check.addClass('error');
                isPass = false;
            }

            $.get('aj_check_password.php', {old_password: oldpassword}, function(data) {
                if (data == '0') {
                    $oldpassword.val('');
                    $oldpassword.attr('placeholder', '密碼錯誤！');
                    $oldpassword.addClass('error');
                    isPass = false;

                }
                if(isPass){
                    document.form_psd.submit();
                }
            });


            return false;

        }



        //會員資料編輯後表單送出不刷新-----------------------------------------------
        function checkUserInfo() {
            var email = $('#editEmail').val();
            var name = $('#editName').val();
            var gender = $('#editGender').val();
            var phone = $('#editTel').val();
            var address = $('#editAddress').val();
            var username = $('#username').val();
//            var $username = "<?//= isset($_SESSION['user'])? $_SESSION['user']['name']:"" ?>//";

            console.log(email,name,gender,phone,address);

            $.post('check_User_Info.php', {email:email,
                name:name,gender:gender,phone:phone,address:address}, function (data) {
                $('#ajuserinfo').html(data);

                $('.datapack').toggleClass("show hide actived");

                $.post('user_name.php',{name:name},function (data) {

                    $('.username').text(data);
                    $('#username').text(data);
                });

            });

            return false;

        }



        //判斷登入錯誤資訊------------------------------------------------
        function checkLoginForm(){
            var $email = $('#getEmail');
            var $password = $('#getPassword');
            var $bg = $('.mix');

//            var $er = "";

            var items = [$email, $password];

            var email = $email.val();
            var password = $password.val();

            var i;
            var email_pattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            var isPass = true;

            for(i=0; i<items.length; i++){
//                alert('123');
                items[i].attr('placeholder','');
                items[i].removeClass('error');
                items[i].removeClass('backerror');
            }

//            if(!$er ) {
//                $password.val('');
//                $password.attr('placeholder',' 密碼輸入錯誤 !');
//                $password.addClass('error');
//                $bg.addClass('backerror');
//                isPass = false;
//            }

//            if(! email_pattern.test(email)){
//                $email.val('');
//                $email.attr('placeholder',' 電子信箱錯誤 !');
//                $email.addClass('error');
//                $bg.addClass('backerror');
//                isPass = false;
//            }
//
//            if(! email){
//                $email.val('');
//                $email.attr('placeholder',' 電子信箱錯誤 !');
//                $email.addClass('error');
//                $bg.addClass('backerror');
//                isPass = false;
//            }

            if(password.length > 14){
                $password.val('');
                $password.attr('placeholder',' 密碼輸入錯誤 !');
                $password.addClass('error');
                $bg.addClass('backerror');
                isPass = false;
            }

            if(password.length < 6){
                $password.val('');
                $password.attr('placeholder',' 密碼輸入錯誤 !');
                $password.addClass('error');
                $bg.addClass('backerror');
                isPass = false;
            }

//            $.get('aj_check_login_email.php', {email_login: email, password_login:password}, function(data){
//
//                if(data.success){
//                    document.login_form.submit();
//                } else {
//                    if(data.info.email.msg){
//                        alert(data.info.email.msg);
//                        $email.val('');
//                        $email.attr('placeholder',data.info.email.msg);
//                        $email.addClass('error');
//                        $bg.addClass('backerror');
//                    }
//                    if(data.info.password.msg){
//                        //alert(data.info.password.msg);
//                        $password.closest('.form-group').find('.info').text( data.info.password.msg );
//                    }
//
//
//                }

            $.get('aj_check_login_email.php', {email_login: email, password_login:password}, function(data){

                if(data==0){
                    $email.val('');
                    $email.attr('placeholder',' 電子信箱錯誤 !');
                    $email.addClass('error');
                    $password.val('');
                    $password.attr('placeholder',' 密碼輸入錯誤 !');
                    $password.addClass('error');
                    $bg.addClass('backerror');
                    isPass = false;
                }

                if(isPass){
                    document.login_form.submit();
                }

            });

            return false;

        }




		$(function(){


		    //文碩右上區塊-----------------
            $('.remove_item').click(function () {
                var tr = $(this).closest('tr');
                var sid = tr.attr("data-sid");
                $.get('add_to_cart.php', {sid: sid}, function (data) {
                    tr.fadeOut(function () {
                        tr.remove();
                    });
                }, 'json');
            });

            $('.like_item').click(function () {
                var tr = $(this).closest('tr');
                var sid = tr.attr("data-sid");
                $.get('add_to_like_all.php', {sid: sid}, function (data) {
                    location.reload();
                }, 'json');

            });

            $('.like_remove_item').click(function () {
                var sid = $(this).attr('data-like');
                var tr = $(this).closest('tr');
                $.get('add_to_like_remove.php', {sid: sid}, function (data) {
                    tr.fadeOut();
                }, 'json');
            });

            $('.like_like_item').click(function () {
                var tr = $(this).closest('tr');
                var sid = $(this).attr('data-like');
                var qty = 1;
                $.get('add_to_cart.php', {sid: sid, qty: qty}, function (data) {
                    location.reload();
                }, 'json');

            });


		    // 上傳圖片
            var my_file = $('.my_file');
//            var $file_image = "<?//= isset($_SESSION['user_img_file'])? $_SESSION['user_img_file']['my_file']['name']:"" ?>//";

            my_file.change(function(){
                var fd = new FormData();
                var file = $(this)[0].files[0];
                var $hash = "<?= isset($_SESSION['user'])? $_SESSION['user']['hash']:"" ?>";
                fd.append('my_file', file);

                $.ajax({
                    url: 'file_upload.php',
                    data: fd,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    success: function ( data ) {
                        $('figure.edit_img img').attr("src","user_img/" + $hash + "/" + data );

//                        if (data){
//                            $('figure.edit_img img').attr("src","user_img/" + $hash + "/" + data );
//                        } else {
//                            $('figure.edit_img img').attr("src","user_img/" + $hash + "/" + $file_image );
//                        }
                    }

                });

            });



				// 訂單頁面標籤切換

			$(".tab label" ).click(function(){
				$(this).addClass("on");
				$(this).removeClass("off");
				$(this).siblings().removeClass("on");
				$(this).siblings().addClass("off");
			});

			$('input[name="listpage"]').click(function(){
				if ($(this).attr("value")=="page1") {
					$(".order_list").addClass("show actived");
					$(".order_list").removeClass("hide");
					$(".following_list").addClass("hide");
					$(".following_list").removeClass("show actived");
					$(".cart_list").addClass("hide");
					$(".cart_list").removeClass("show actived");
				}
				if ($(this).attr("value")=="page2") {
					$(".order_list").addClass("hide");
					$(".order_list").removeClass("show actived");
					$(".following_list").addClass("show actived");
					$(".following_list").removeClass("hide");
					$(".cart_list").addClass("hide");
					$(".cart_list").removeClass("show actived");
				}
				if ($(this).attr("value")=="page3") {
					$(".order_list").addClass("hide");
					$(".order_list").removeClass("show actived");
					$(".following_list").addClass("hide");
					$(".following_list").removeClass("show actived");
					$(".cart_list").addClass("show actived");
					$(".cart_list").removeClass("hide");
				}

			});


				// 團隊人數計數

			$('.count').each(function () {
			    $(this).prop('Counter',0).animate({
			        Counter: $(this).text()
			    }, {
			        duration: 4000,
			        easing: 'swing',
			        step: function (now) {
			            $(this).text(Math.ceil(now));
			        }
			    });
			});

				// 會員介紹與資料頁slide

			$(".node li").click(function(){
				$(this).addClass("circle_on");
				$(this).removeClass("circle_off");
				$(this).siblings().removeClass("circle_on");
				$(this).siblings().addClass("circle_off");
				slide=$(this).index();
				width=0-450*slide+"px";
				$(".slide_all").css("left", width);
			});

				// 編輯鈕隱藏

			$('.box_inside').hover(function (){
				$('.edit').toggleClass("show hide");
				$('.dataedit').toggleClass("show hide");
			});

				// 會員介紹與資料編輯頁切換

			$('.edit').click(function(){
				$('.pack').toggleClass("show hide actived");
//                var $image = "<?//= $image ?>//";
//                var $username = "<?//= $_SESSION['user']['name'] ?>//";
                var $test = "<?= empty($image) ? "user_img/non_member.jpg" : 'user_img/' . $hash . '/' . $image ?>"
                $('figure.edit_img img').attr("src" , $test );
            });

			$('.dataedit').click(function(){
				$('.datapack').toggleClass("show hide");
				$('.datapack').toggleClass("actived");
			});

			$('#intro_cancel').click(function(){
				$('.pack').toggleClass("show hide actived");
//                var $image = "<?//= $image ?>//";
//                var $username = "<?//= $_SESSION['user']['name'] ?>//";
//                $('figure.edit_img img').attr("src","user_img/" + $hash + "/" + $image );
			});

			$('#data_cancel').click(function(){
				$('.datapack').toggleClass("show hide");
				$('.datapack').toggleClass("actived");
			});


				// 變更密碼動畫

			$(".board3").click(function (){
					$(".board3").toggleClass("actived");

				if($("#password_change").css("right")=='-'+250+'px'){
					$("#password_change").animate({
						right:["30px", "swing"]}, 600, "linear");
					}

				if($("#password_change").css("right")=='30px'){
					$("#password_change").animate({
						right:['-'+250+'px', "swing"]}, 600, "linear");
					}

				if($("#password_confirm").css("top")=='30px'){
					$("#password_confirm").animate({
						top:["65px", "swing"]}, 600, "linear");
					}

				if($("#password_confirm").css("top")=='65px'){
					$("#password_confirm").animate({
						top:["30px", "swing"]}, 600, "linear");
					}


				});

				// 輸入欄位錯誤樣式解除
		
			$("input").click(function (){
				$(this).removeClass("error");
				$(".mix").removeClass("backerror");
			});

				// 登入頁密碼與帳號切換

			$(".fp").click(function(){
				$(".password_pack").toggleClass("show hide");
				$(".password_pack").toggleClass("actived");
			});

			$(".faccount").click(function(){
				$(".account_pack").toggleClass("show hide");
				$(".account_pack").toggleClass("actived");
			});

				// 大頭貼預覽

//			function loadImage(e) {
//			    var image = document.querySelector('#intro_edit .bighead img');
//			 image.src = e.target.result;
//			}
//			function previewImage() {
//			 var reader = new FileReader();
//			 var file = document.getElementById("editPhoto").files[0];
//			 reader.readAsDataURL(file);
//			 reader.onload = loadImage;
//			}
//			$("#editPhoto").change(previewImage);

		});


	</script>

<?php include __DIR__ . '/__html_foot.php' ?>