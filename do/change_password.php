<?php
require_once("../dbtools.inc.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

$json = array();
$requestCode = "404";
$requestText = "查無此帳號";
if(isset($_POST['user_id']) && isset($_POST['user_verfiy']) && isset($_POST['user_new_pw'])){
    $link = create_connection();
    $user_id = trim($_POST['user_id']);
    $user_verfiy = trim($_POST['user_verfiy']);
   
    $sql_user = "SELECT * FROM student WHERE studentID = '$user_id' limit 1";
    $result = execute_sql($link,"borrow",$sql_user);
    
    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        if($user_verfiy != "null" && isset($_POST['user_new_pw'])){
             //更換密碼
            if($user_verfiy == $row['verfiy_code']){
                //加密
                $hash_pwd = password_hash($_POST['user_new_pw'], PASSWORD_BCRYPT,['COST'=>5]);
                $sql_change = "UPDATE student SET password = '$hash_pwd',verfiy_code ='',stop = IF(stop <= 0 ,stop + 1 , stop) WHERE studentID ='$user_id'"; 
                execute_sql($link,"borrow",$sql_change);
                $requestCode = "200";
                $requestText = "成功";
            }else{
                $requestText = "驗證碼錯誤";
            }            
        }
    }    
    mysqli_close($link);
}
$json[0] = $requestCode;
$json[1] = $requestText;
$json = array(
    "numCode" => array($requestCode,$requestText)
);
echo json_encode($json, JSON_UNESCAPED_UNICODE);

?>