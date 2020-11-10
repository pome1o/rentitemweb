<?php
session_start();
header("Content-type: text/html; charset=utf-8");
include("../check_fun.php");
require_once("../dbtools.inc.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
$link = create_connection();
$request = 200;
if(isset($_POST['user_id']) && isset($_POST['mod'])){
    $id = mysqli_real_escape_string($link,$_POST['user_id']);   
    $mod = $_POST['mod'];    
    if($mod == 0 || $mod == 2){
        if(isset($_POST['user_id']) && isset($_POST['user_name']) &&isset($_POST['class']) &&isset($_POST['email'])&& isset($_POST['card_id']) && isset($_POST['type_select'])){
            
            $id = mysqli_real_escape_string($link,$_POST['user_id']);
            $name = mysqli_real_escape_string($link,$_POST['user_name']);
            $class = mysqli_real_escape_string($link,$_POST['class']);
            $email = mysqli_real_escape_string($link,$_POST['email']);
            $carid = mysqli_real_escape_string($link,$_POST['card_id']);
            $type = mysqli_real_escape_string($link,$_POST['type_select']);
			$class = strtoupper($class);
            switch($type){
                case "學生":
                $type = 0;
                break;
                case "老師":
                $type = 1;
                break;
                case "工讀生":
                $type = 2;
                break;
                case "系助":
                $type = 3;
                break;
            }
            if($mod == 0){
				if(isset($_POST['user_foul']) && isset($_POST['user_stop'])){
                $foul = mysqli_real_escape_string($link,$_POST['user_foul']);
                $stop = mysqli_real_escape_string($link,$_POST['user_stop']);
                switch($stop){
                    case 0:
                    $stop = 1;
					if(strlen($carid) < 10){
						$stop = -2;
					}
                        break;
                    case 1:
                        $stop = 5;
                        break;
                }
                    $sql = "UPDATE student SET studentID ='$id',personName = '$name',class = '$class',email = '$email',cardId = '$carid', foulCount = '$foul',stop='$stop',chmod = '$type' WHERE studentID = '$id'";
					execute_sql($link,"borrow",$sql);
                }
                
            }else if($mod == 2){
                if(strlen($carid) >= 10){
                    $stop = 0;
                }else{
                    $stop = -2;
                }
                $sql = "INSERT INTO student (studentID,personName,class,email,cardId,chmod,stop) VALUE ('$id','$name','$class','$email','$carid','$type','$stop')";
				$mail = new PHPMailer();
				$rand = rand();
                $md5 = md5($id.$rand);
                $temp_pw = substr($md5,-5);
           
                
                if(!execute_sql($link,"borrow",$sql)){
                    $requestCode = "404";
                    $requestText = "新增帳號至資料庫時錯誤";
                
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
					$mail->AddAddress($email, $name); //設定收件者郵件及名稱        
					if(!$mail->Send()){
						$requestCode = "404";
						$requestText = "發送信件錯誤";
						
					}
				}
            }            
            
        }else{
            $request = 404;
        }
    }else if($mod == 1 || $mod == 3){
		//停權或復權
        $i = 0;
        if($mod == 3){
            $i = 1;
        }else if($mod ==1){
            $i = 5;
        }
        $sql = "UPDATE student SET stop = $i WHERE studentID = '$id'";
        execute_sql($link,"borrow",$sql);    
    }else{
        $request = 404;
    }   
}else{
    $request = 404;
}
mysqli_close($link);
echo $request;

?>