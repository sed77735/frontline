<?php
require __DIR__ . '/__connect_db.php';
$pname = 'none';
$title = '會員註冊';
$success = false;

if (isset($_SESSION['team_members'])){
    unset($_SESSION['team_members']);
}



if(isset($_POST['email'])) {
//    echo '<pre>';
//    print_r($_POST);
//    echo '</pre>';

    $hash = md5( $_POST['email']. uniqid() );


    $sql = "INSERT INTO `members`(`sid`,
    `email`, `password`, `name`, 
    `gender`, `phone`, `address`, 
    `hash`, `created_at`) VALUES 
    ( NULL,
    ?, ?, ?, 
    ?, ?, ?, 
    ?, NOW() )" ;
//  echo $sql;
//  exit;

    $stmt = $mysqli->prepare($sql);
    $stmt -> bind_param('sssssss',
        $_POST['email'], sha1($_POST['password']), $_POST['name'],
        $_POST['gender'], $_POST['phone'], $_POST['address'],
        $hash
    );

    $success = $stmt->execute();

    //$mysqli->errno
    //$mysqli->error
    //exit; //die();
}


if($success) {
    echo '<script>
                alert("註冊成功!")
                window.location.href = "members.php";
            </script>';
//    header("Location: members.php");
};


?>




<?php include __DIR__.'/__html_head.php'?>
<link rel="stylesheet" href="css/register.css">
    <style>

        body {
            font-family: Microsoft JhengHei;
        }

    </style>

<?php include __DIR__ . '/__navbar.php' ?>
 
	<div class="container">
		<div class="paper">
			<div class="title"><h1>會員註冊資料</h1></div>
            <form name="form1" method="post" onsubmit="return checkForm();">
			<div class="formgroup" id="register_data">
				<table>
					<tbody>
						<tr>
							<label for="registerEmail"><td><h2>電子信箱</h2></td></label>
							<td><input type="text" name="email" class="" id="registerEmail"></td>
						</tr>
						<tr>
							<td><label for="registerPassword"><h2>建立密碼</h2></td></label>
							<td><input type="password" name="password" class="register_input" id="registerPassword" placeholder="14個字元以內"></td>
						</tr>
						<tr>	
							<td><label for="registerPassword_check"><h2>再次輸入</h2></label></td>
							<td><input type="password" class="register_input" id="registerPassword_check" placeholder="請再次輸入上列密碼"></td>
						</tr>
						<tr>
							<td><label for="registerName"><h2>真實姓名</h2></label></td>
							<td><input type="text" name="name" class="register_input" id="registerName"></td>
						</tr>
						<tr>
							<td><label for="registerGender"><h2>性別</h2></label></td>
							<td>
								<select class="error" name="gender" id="registerGender">
									<option class="error" value="#" selected="true">請選擇</option>
									<option value="男">男性</option>
									<option value="女">女性</option>
								</select>
							</td>
						</tr>
						<tr>
							<td><label for="registerTel"><h2>電話號碼</h2></label></td>
							<td><input type="tel" name="phone" class="register_input" id="registerTel"></td>
						</tr>
						<tr>
							<td></td>
							<td><p>請使用手機格式或市內電話格式</p><br><p style="color: #aaa">例如02-XXXX-XXXX / 09XX-XXX-XXX</p></td>
						</tr>
						<tr>
							<td style="vertical-align: top"><label for="registerPlace"><h2>聯絡地址</h2></label></td>
							<td><textarea name="address" id="registerPlace" cols="30" rows="10"></textarea></td>
						</tr>
						<tr>
							<td></td>
							<td><p>聯絡地址將會成為購物的預設收件地址</p></td>
						</tr>						
					</tbody>
				</table>
			</div>
				<button type="submit" class="board submit">送出會員資料</button>
				<div class="board cancel"><a href="members.php">取消</a></div>
			</form>
		</div><!-- paper -->
	</div>

    <script>


        //檢查表單---------------------------------------
        function checkForm() {
            var $email = $('#registerEmail');
            var $password = $('#registerPassword');
            var $password_check = $('#registerPassword_check');
            var $name = $('#registerName');
            var $phone = $('#registerTel');
            var $address = $('#registerPlace');

            var items = [$email, $password, $password_check, $name, $phone, $address];

            var email = $email.val();
            var password = $password.val();
            var password_check = $password_check.val();
            var name = $name.val();
            var phone = $phone.val();
            var address = $address.val();

            var i;
            var email_pattern = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
            var phone_pattern = /^[09]{2}[0-9]{8}$/;
            var isPass = true;


            for (i = 0; i < items.length; i++) {
//                items[i].val('');
                items[i].attr('');
                items[i].removeClass('error');
            }

            if (!email_pattern.test(email)) {
                $email.val('');
                $email.attr('placeholder', 'E-mail格式不正確 !');
                $email.addClass('error');
                isPass = false;
            }

            if (!email) {
                $email.val('');
                $email.attr('placeholder', '請填寫E-mail !');
                $email.addClass('error');
                isPass = false;
            }

            if (password.length > 14) {
                $password.val('');
                $password.attr('placeholder', '密碼太多了 !');
                $password.addClass('error');
                isPass = false;
            }

            if (password.length < 6) {
                $password.val('');
                $password.attr('placeholder', '密碼至少 6 個字元 !');
                $password.addClass('error');
                isPass = false;
            }


            if (!(password_check == password)) {
                $password_check.val('');
                $password_check.attr('placeholder', '密碼不相符 !');
                $password_check.addClass('error');
                isPass = false;
            }

            if (!password_check) {
                $password_check.val('');
                $password_check.attr('placeholder', '請再輸入一次密碼 !');
                $password_check.addClass('error');
                isPass = false;
            }

            if (name.length < 2) {
                $name.val('');
                $name.attr('placeholder', '填寫真實姓名!');
                $name.addClass('error');
                isPass = false;
            }

            if (!phone_pattern.test(phone)) {
                $phone.val('');
                $phone.attr('placeholder', '電話格式不正確 !');
                $phone.addClass('error');
                isPass = false;
            }

            if (!phone) {
                $phone.val('');
                $phone.attr('placeholder', '請填寫電話!');
                $phone.addClass('error');
                isPass = false;
            }

            if (!address) {
                $address.val('');
                $address.attr('placeholder', '請填寫地址!');
                $address.addClass('error');
                isPass = false;
            }


            $.get('aj_check_email.php', {email: email}, function (data) {
                if (data >= '1') {
                    $email.val('');
                    $email.attr('placeholder','此 email 已經使用過了!');
                    $email.addClass('error');
                    isPass = false;
                }

                if (isPass) {
                    document.form1.submit();
                }

            });


            return false;


        }


        // 輸入欄位錯誤樣式解除

        $("input, textarea").click(function (){
            $(this).removeClass("error");
        });

        </script>



<?php include __DIR__ . '/__html_foot.php' ?>