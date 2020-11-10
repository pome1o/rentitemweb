<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'C:/xampp/htdocs/boom/vendor/phpmailer/phpmailer/src/Exception.php';
    require 'C:/xampp/htdocs/boom/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'C:/xampp/htdocs/boom/vendor/phpmailer/phpmailer/src/SMTP.php';
    $link = mysqli_connect("localhost", "RD", "103111123") or die("無法建立資料連接: " . mysqli_connect_error()); 
    mysqli_query($link, "SET NAMES utf8");
    mysqli_select_db($link, "borrow") or die("開啟資料庫失敗: " . mysqli_error($link));
    date_default_timezone_set('Asia/Taipei');
    $now_hour = date("H:i");
    $today = date("Y-m-d H:i:s");
    $ban = date("Y-m-d H:i:s",strtotime('+14 days'));
    $mail_bool = true;
    if($now_hour > date("16:59")){    
        $datetime = date("Y-m-d");
        $sql_check = "SELECT * FROM templab WHERE Date(lendTime) = Date('$datetime') AND  status ='1'";
        $result =  mysqli_query($link,$sql_check);
        
        if($result){
           
            if(mysqli_num_rows($result) > 0){
                $mail = new PHPMailer();             
                $sql_admin_mail = "SELECT email FROM student WHERE chmod = '3' AND stop = '1'";
                $mail_result = mysqli_query($link,$sql_admin_mail);
                $mail_array = array();
                $name_array = array();
                $student_id = array();
                if($mail_result){
                    while($row_mail = mysqli_fetch_row($mail_result)){
                        array_push($mail_array,$row_mail[0]);                    
                    }
                }else{
                    echo "search mail fail";
                    $mail_bool = false;
                }
                
                while($row = mysqli_fetch_row($result)){
                    $sql_copy = "UPDATE templab SET status = '-1' WHERE _id = '$row[0]'";
                    $sql_violate = "INSERT INTO violation_record (user_id,type,record_id,reason) VALUES ('$row[2]','lab','$row[0]','實驗室5點尚未歸還')";
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
                    $violate_id = mysqli_insert_id($link);
                    
                    $sql_ban = "INSERT INTO ban_record (studentID,violation_id,ban_date_from,ban_date_to) VALUES ('$row[2]','$violate_id','$today','$ban') ON DUPLICATE KEY UPDATE violation_id = '$violate_id',ban_date_from = '$today',ban_date_to ='$ban'";
                    $sql_stop = "UPDATE student SET stop = '5' WHERE studentID = '$row[1]'";
                    if(!mysqli_query($link,$sql_ban)){
                        echo "insert ban fail";
                        $mail_bool = false;
                        break;
                    }
                    if(!mysqli_query($link,$sql_stop)){
                        echo "update stop fail";
                        $mail_bool = false;
                        break;
                    }
                    array_push($name_array,$row[1]);
                    array_push($student_id,$row[2]);
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
                $mail->Subject = "借還系統實驗室逾期歸還"; //設定郵件標題
                $text = "";

                if($mail_bool){
                    echo "fuck";
                    for($i = 0; $i < count($name_array); $i++){
                        $text += $name_array[$i]." ".$student_id[$i]."<br>";
                    }                    
                    $mail->Body = "實驗室逾期歸還<br>".$text; //設定郵件內容        
                    $mail->IsHTML(true); //設定郵件內容為HTML
                    for($i = 0; $i < count($mail_array); $i ++){
                        $mail->AddAddress("$mail_array[$i]", "To:系助"); //設定收件者郵件及名稱        
                        if(!$mail->Send()){
                            $requestCode = "404";
                            $requestText = "發送信件錯誤";
                            echo $mail->ErrorInfo;
                            break;
                        }
                    }       
                }                  
             }
			$sql_date = "INSERT INTO value_data (_key,value) value ('check_lab','$today') on DUPLICATE KEY UPDATE value = '$today'";
            //$sql_excute_time = "UPDATE value_data SET value = '$today' WHERE _key ='check_lab'";
            mysqli_query($link,$sql_excute_time);
            mysqli_free_result($result);
        }
    }
    mysqli_close($link);

?>