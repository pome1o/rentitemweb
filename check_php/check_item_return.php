<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'C:/xampp/htdocs/boom/vendor/phpmailer/phpmailer/src/Exception.php';
    require 'C:/xampp/htdocs/boom/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'C:/xampp/htdocs/boom/vendor/phpmailer/phpmailer/src/SMTP.php';
    $link = mysqli_connect("localhost", "RD", "103111123") or die("fail to connect: " . mysqli_connect_error()); 
    mysqli_query($link, "SET NAMES utf8");
    mysqli_select_db($link, "borrow") or die("open database fail: " . mysqli_error($link));
    date_default_timezone_set('Asia/Taipei');
    $sql_time = "SELECT * FROM value_data WHERE _key = 'check_return'";
    $time_result = mysqli_query($link,$sql_time);
    $row = mysqli_fetch_row($time_result);
    $today = date("Y-m-d H:i:s");
    $mail_bool_7 = true;
    $mail_bool = true;

    $mail_array = array();
    $name_array_3 = array();
    $student_id_3 = array();
    $name_array_7 = array();
    $student_id_7 = array();
	$interval = round((strtotime(date("Y-m-d")) - strtotime(date("Y-m-d",strtotime($row[1]))))/(60*60*24));
    if($interval > 0){
        
        $sql_select_viol = "SELECT _id,personName,studentID FROM tempborrow WHERE DATE(expect_return_time) = DATE(DATE_SUB( NOW() , INTERVAL 3 DAY )) AND status = '1'";
        $result = mysqli_query($link,$sql_select_viol);
        if($result){
            if(mysqli_num_rows($result) >0){             
                while($row = mysqli_fetch_row($result)){
                    $sql_copy = "UPDATE tempborrow SET status = '-1' WHERE _id = '$row[0]'";
                    $sql_violate = "INSERT INTO violation_record (user_id,type,record_id,reason) VALUES ('$row[2]','item','$row[0]','設備逾期3天')";
                    if(!mysqli_query($link,$sql_copy)){
                        echo "insert copy fail";
                        $mail_bool = false;
                        break;
                    }
                    if(!mysqli_query($link,$sql_violate)){
                        echo "insert to violate fail";
                        $mail_bool = false;
                        break;
                    }                   
                    array_push($name_array_3,$row[1]);
                    array_push($student_id_3,$row[2]);
                }
            }else{
                $mail_bool = false;
            }
            mysqli_free_result($result);
        }else{
            $mail_bool = false;
        }

        $sql_select_viol_7 = "SELECT _id,personName,studentID FROM tempborrow WHERE DATE(expect_return_time) = DATE(DATE_SUB( NOW() , INTERVAL 7 DAY )) AND status = '1'";
        $result_7 = mysqli_query($link,$sql_select_viol_7);
        if($result_7){
            $ban = date("Y-m-d H:i:s",strtotime('+14 days'));
            if(mysqli_num_rows($result_7) > 0){
                while($row = mysqli_fetch_row($result)){
                    $sql_copy = "UPDATE tempborrow SET status = '-1' WHERE _id = '$row[0]'";
                    $sql_violate = "INSERT INTO violation_record (user_id,type,record_id,reason) VALUES ('$row[2]','item','$row[0]','設備逾期7天')";
                    if(!mysqli_query($link,$sql_copy)){
                        echo "insert copy fail";
                        $mail_bool_7 = false;
                        break;
                    }
                    if(!mysqli_query($link,$sql_violate)){
                        echo "insert to violate fail";
                        $mail_bool_7 = false;
                        break;
                    }               
                    $violate_id = mysqli_insert_id($link);                        
                    $sql_ban = "INSERT INTO ban_record (studentID,violation_id,ban_date_from,ban_date_to) VALUES ('$row[2]','$violate_id','$today','$ban') ON DUPLICATE KEY UPDATE violation_id = '$violate_id',ban_date_from = '$today',ban_date_to ='$ban'";
                    if(!mysqli_query($link,$sql_ban)){
                        echo "insert ban fail";
                        $mail_bool_7 = false;
                        break;
                    }
                    $sql_stop = "UPDATE student SET stop = '5' WHERE studentID = '$row[1]'";
                    if(!mysqli_query($link,$sql_stop)){
                        echo "update stop fail";
                        $mail_boo7 = false;
                        break;
                    }
                    array_push($name_array_7,$row[1]);
                    array_push($student_id_7,$row[2]);
                }
            }else{
                $mail_bool_7 = false;
            }
            mysqli_free_result($result_7);
        }else{
            $mail_bool_7 = false;
        }


        if($mail_bool || $mail_bool_7){
            $mail = new PHPMailer();             
            $sql_admin_mail = "SELECT email FROM student WHERE chmod = '3' AND stop = '1'";
            $mail_result = mysqli_query($link,$sql_admin_mail);    
            $mail_array = array();           
    
            if($mail_result){
                while($row_mail = mysqli_fetch_row($mail_result)){
                    array_push($mail_array,$row_mail[0]);                    
                }
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
                $mail->Subject = "借還系統設備逾期歸還"; //設定郵件標題
                $text = "";              
                $text_7 ="";    
                for($i = 0; $i < count($name_array_3); $i++){
                    $text += $name_array_3[$i]." ".$student_id_3[$i]."<br>";
                }                    
                for($i = 0; $i < count($name_array_7); $i ++){
                    $text_7 += $name_array_7[$i]." ".$student_id_7[$i]."<br>";
                }
                $mail->Body = "設備逾期歸還3天<br>".$text."設備逾期歸還7天<br>".$text_7; //設定郵件內容        
                $mail->IsHTML(true); //設定郵件內容為HTML
                for($i = 0; $i < count($mail_array); $i ++){
                    $mail->AddAddress("$mail_array[$i]", "To:系助"); //設定收件者郵件及名稱        
                    if(!$mail->Send()){
                        $requestCode = "404";
                        $requestText = "fail to send email";
                        echo $mail->ErrorInfo;
                        break;
                    }
                }       
                  
            }else{
                echo "search mail fail";
            }
        }
		$sql_update_time = "INSERT INTO value_data (_key,value) value ('check_return','$today') on DUPLICATE KEY UPDATE value = '$today'";
        //$sql_update_time = "UPDATE value_data SET value = '$today' WHERE _key = 'check_return'";
        mysqli_query($link,$sql_update_time);
       
    }
    mysqli_close($link);
?>