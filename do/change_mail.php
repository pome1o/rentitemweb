<?php
require_once("../dbtools.inc.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
$json = array();
$requestCode = "404";
$requestText = "ERROR";

if(isset($_POST['mail']) && isset($_POST['user_id'])){
    $link = create_connection();
    $id = $_POST['user_id'];
    $email = mysqli_real_escape_string($link,trim($_POST['mail']));
    $sql_check = "SELECT * FROM student WHERE studentID = '$id'";
    $result = execute_sql($link,"borrow",$sql_check);
    if(mysqli_num_rows($result) > 0){
        $rand = rand();
        $md5 = md5($id.$rand);
        $temp_v = substr($md5,-5);
        $rand = rand();
        $md5 = md5($id.$rand);
        $temp_v2 = substr($md5,-5);
        $ver = $temp_v."_".$temp_v2;
        $sql_update = "INSERT INTO verfiy_mail (account,mail,verfiy) VALUES ('$id','$email','$ver') ON DUPLICATE KEY UPDATE mail='$email', verfiy='$ver'";
        if(execute_sql($link,"borrow",$sql_update)){
            $temp_href = "<a href='http://120.96.63.55/boom/mail_confirm.php?verfiy=$ver'>http://120.96.63.55/boom/mail_confirm.php?verfiy=$ver</a>";
            $mail = new PHPMailer(true);            
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
            $mail->Subject = "借還系統更換信箱"; //設定郵件標題        
            $mail->Body = "請點此連結".$temp_href; //設定郵件內容        
            $mail->IsHTML(true); //設定郵件內容為HTML        
            $mail->AddAddress($email,"您好"); //設定收件者郵件及名稱
            if($mail->Send()){               
                $requestCode = "200";
                $requestText = "我們將發送驗證信至新的信箱";
            }else{
                $requestText = "發送錯誤";
            }
        }else{
            $requestText = "有地方錯誤";
        }
    }else{
        $requestText = "無此帳號";
    }

    mysqli_close($link);
}

$json = array(
    "numCode" => array($requestCode,$requestText)
);
echo json_encode($json, JSON_UNESCAPED_UNICODE);
?>