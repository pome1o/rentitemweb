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
if(isset($_POST['user_id'])){
    $link = create_connection();
    $user_id = trim($_POST['user_id']);
    $sql_user = "SELECT * FROM student WHERE studentID = '$user_id' limit 1";
    $result = execute_sql($link,"borrow",$sql_user);
    
    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);
                //發送信件
                $mail = new PHPMailer(true);

                $rand = rand();
                $md5 = md5($user_id.$rand);
                $temp_pw = substr($md5,-5);

                $mail->SMTPDebug = 0;
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
                $mail->IsSMTP(); //設定使用SMTP方式寄信        
                $mail->SMTPAuth = true; //設定SMTP需要驗證   
                $mail->SMTPSecure = 'ssl';     
                $mail->Host = "smtp.gmail.com"; //Gamil的SMTP主機        
                $mail->Port = 465;  //SMTP主機的SMTP埠位為465埠
                $mail->Username  = "oitmisborrowsystem@gmail.com";
                $mail->Password = "oitmisborrow";                
                $mail->CharSet = "utf-8"; //設定郵件編碼        
                $mail->From = "oitmisborrowsystem@gmail.com"; //設定寄件者信箱        
                $mail->FromName = "亞東資管系"; //設定寄件者姓名
                $mail->Subject = "借還系統更換密碼"; //設定郵件標題        
                $mail->Body = "驗證碼:".$temp_pw; //設定郵件內容        
                $mail->IsHTML(true); //設定郵件內容為HTML        
                $mail->AddAddress($row['email'], $row['personName']); //設定收件者郵件及名稱
                if($mail->Send()){
                    $sql = "UPDATE student SET verfiy_code = '$temp_pw' WHERE studentID = '$user_id'";
                    execute_sql($link,"borrow",$sql);
                    $requestCode = "200";
                    $requestText = "我們將發送驗證信至學校信箱";
                }else{
                    $requestText = "發送錯誤";
                }                            
    }      
    mysqli_close($link);
}

$json = array(
    "numCode" => array($requestCode,$requestText)
);
echo json_encode($json, JSON_UNESCAPED_UNICODE);

?>