<?php
require __DIR__ . '/__connect_db.php';


if (isset($_POST["email"])) {

    $stmt = $mysqli->prepare(" UPDATE `members` SET 
        `email` = ?,
        `name`= ?, 
        `gender`= ?,
        `phone`= ?,
        `address`= ?
        WHERE `sid` = ?");

    $stmt->bind_param('sssssi',
        $_POST['email'],
        $_POST['name'],
        $_POST['gender'],
        $_POST['phone'],
        $_POST['address'],
        $_SESSION['user']['sid']
    );

    $success = $stmt->execute();
    $affected = $stmt->affected_rows;

    $email = $_POST['email'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    if($affected==1){
        $_SESSION['user']['name'] = $_POST['name'];
    }

}
?>

<?php

    echo'<tbody>
        <tr>
            <td><p>電子信箱</p></td>
            <td><h2>' .  $email  . '</h2></td>
        </tr>
        <tr>
            <td><p>真實姓名</p></td>
            <td><h2>' . $name  .'</h2></td>
        </tr>
        <tr>
            <td><p>性別</p></td>
            <td><h2>' . $gender  .'</h2></td>
        </tr>
        <tr>
            <td><p>電話號碼</p></td>
            <td><h2>' . $phone  .'</h2></td>
        </tr>
        <tr>
            <td><p>地址</p></td>
            <td><h2>' . $address  .'</h2></td>
        </tr>
    
    </tbody>'

?>



