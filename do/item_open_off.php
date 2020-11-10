<?php
 session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
 require_once("../dbtools.inc.php");
 header("Content-type: text/html; charset=utf-8");
 $link = create_connection();
 $requestCode = 404;
 $requestText = "錯誤";



 if(isset($_POST['itemdata']) && isset($_POST['mod'])){
     $a = false;
     $data_array = $_POST['itemdata'];
     $mail = new PHPMailer(true);
     if($_POST['mod'] == 0){
        //停止借用
        $date = date("Y-m-d");
        if(isset($_POST['date'])){
            $date = $_POST['date'];
        }
        
        for($i = 0; $i < count($data_array); $i ++){
            $temp_mark = explode("@",$data_array[$i]);
            if($temp_mark[0] == "A"){
                //物品
                $sql_update = "UPDATE item_category SET open_off = '1',off_time = '$date' WHERE num = '$temp_mark[1]'";
                $sql_select_user ="SELECT student.personName,student.email FROM tempborrow INNER JOIN student on tempborrow.studentID = student.studentID INNER JOIN 
                item_info on tempborrow.itemNo = item_info.itemNo WHERE  item_info.catergory = '$temp_mark[1]' AND insert_time < '$date' AND expect_return_time >'$date' ";
            }else if($temp_mark[0] == "B"){
                //lab
                $sql_update = "UPDATE lab_category SET open_off = '1',off_time = '$date' WHERE num = '$temp_mark[1]'";
                
            }else if($temp_mark[0] == "C"){
                //class
                $sql_update = "UPDATE classroom SET open_off = '1',off_time = '$date' WHERE num = '$temp_mark[1]'";
                $sql_select_user = "SELECT student.personName,student.email FROM roomborrow INNER JOIN student on roomborrow.studentID = student.studentID WHERE roomNo ='$temp_mark[1]' AND insert_time <'$date' AND lendTime > '$date' AND status >= 0";
            }

            if($temp_mark[0] == "A" || $temp_mark[0] == "C"){
                $user_result = execute_sql($link,"borrow",$sql_select_user);
                $item_name = "";
                if($temp_mark[0] == "A" ){
                    $item_name = "設備";
                }
                if($temp_mark[0] == "C" ){
                    $item_name = "教室";
                }

                if(mysqli_num_rows($user_result) > 0){                   
                    $row_user = mysqli_fetch_row($user_result); 
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
                    $mail->Body = "您所借用的".$item_name."將於".$date."請提前歸還"; //設定郵件內容        
                    $mail->IsHTML(true); //設定郵件內容為HTML        
                    $mail->AddAddress($row_user[1], $row_user[0]); //設定收件者郵件及名稱
                    if($mail->Send()){
                        $requestCode = "200";
                    }else{
                        $requestText = "發送信錯誤";
                        break;
                    }                                             
                }              
            }
            
            $a = execute_sql($link,"borrow",$sql_update);

        }
        if($a){
            $requestCode = "200";
            $requestText = "成功";
        }
        
     }else if ($_POST['mod'] == 1){
        //開啟借用
        for($i = 0; $i < count($data_array); $i ++){
            $temp_mark = explode("@",$data_array[$i]);
            if($temp_mark[0] == "A"){
                //物品
                $sql_update = "UPDATE item_category SET open_off = '0',off_time = '0000-00-00' WHERE num = '$temp_mark[1]'";
            }else if($temp_mark[0] == "B"){
                //lab
                $sql_update = "UPDATE lab_category SET open_off = '0',off_time = '0000-00-00' WHERE num = '$temp_mark[1]'";
            }else if($temp_mark[0] == "C"){
                //class
                $sql_update = "UPDATE classroom SET open_off = '0',off_time = '0000-00-00' WHERE num = '$temp_mark[1]'";
            }
            $a = execute_sql($link,"borrow",$sql_update);
        }
        if($a){
            $requestCode = "200";
            $requestText = "成功";
        }

     }
 }

 $json = array(
    "numCode"=>array($requestCode,$requestText)
);
echo json_encode($json,JSON_UNESCAPED_UNICODE);
mysqli_close($link);

?>


