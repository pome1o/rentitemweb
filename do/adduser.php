<?php
header("Content-type: text/html; charset=utf-8");
require("../dbtools.inc.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
$requestCode = 200;
$requestText = "成功";
$insert_ok = true;
if(isset($_FILES['fileToUpload'])){
       
	$file_type =  pathinfo($_FILES['fileToUpload']['name'],PATHINFO_EXTENSION);
    if($file_type != "csv"){
        $requestCode = "404";
        $requestText = "不是CSV檔";
    }else{
		$link = create_connection();
    $file = fopen( $_FILES['fileToUpload']['tmp_name'],"r");
    $i = 0 ;
    $mail = new PHPMailer(); 
    while(!feof($file)){
        $data =  fgetcsv($file);        
        if($i == 0 ){
           $i = 1;
            continue;            
        }
        if(strlen($data[0]) > 0){
            
            for($a = 0; $a<count($data); $a++){
                $data[$a] = iconv("big5","UTF-8",$data[$a]);
            }

            $sql_insert_temp = "INSERT INTO temp_add_user (studentID,personName,class,mail) VALUES ('$data[0]','$data[2]','$data[1]','$data[3]')";
        
            if(execute_sql($link,"borrow",$sql_insert_temp)){
                $requestCode = "404";
                $requestText = "新增至temp_table錯誤";
                $insert_ok = false;
                break;
            }
        
        }

    }
    fclose($file); 

    if($insert_ok){
        //帳號存在兩張表 更新年級
        $sql_old_user = "UPDATE student RIGHT JOIN temp_add_user on student.studentID = temp_add_user.studentID SET student.class=temp_add_user.class WHERE temp_add_user.studentID = student.studentID";
        //帳號不再上傳的資料內 停用
        $sql_leave_school = "UPDATE student LEFT JOIN temp_add_user on student.studentID = temp_add_user.studentID SET student.class='not_in_school',chmod = '5' WHERE temp_add_user.studentID IS NULL AND student.chmod = '0' AND student.chmod = '2'";
        
        
        if(!execute_sql($link,"borrow",$sql_old_user) && !execute_sql($link,"borrow",$sql_leave_school)){
            $requestCode = "404";
            $requestText = "搜尋兩表時錯誤";
        }else{     
            //新帳號
            $sql_select_new = "SELECT temp_add_user.studentID,temp_add_user.personName,temp_add_user.class,temp_add_user.mail FROM student RIGHT JOIN temp_add_user on temp_add_user.studentID = student.studentID WHERE student.studentID IS NULL";
            $result = execute_sql($link,"borrow",$sql_select_new);

            while( $row = mysqli_fetch_row($result)){
                $rand = rand();
                $md5 = md5($row[0].$rand);
                $temp_pw = substr($md5,-5);
                $user_class = strtoupper($row[2]);
                if($user_class == "5A" || $user_class == "6A" || $user_class == "6B" || $user_class == "6B"){
                    $user_class = "delay";
                }
                $sql_insert = "INSERT INTO student (studentID,personName,class,email,verfiy_code) VALUES ('$row[0]','$row[1]','$row[2]','$row[3]','$temp_pw')";
                
                if(!execute_sql($link,"borrow",$sql_insert)){
                    $requestCode = "404";
                    $requestText = "新增帳號至資料庫時錯誤";
                    break;
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
                $mail->Subject = "借還系統更換密碼"; //設定郵件標題        
                $mail->Body = "驗證碼:".$temp_pw; //設定郵件內容        
                $mail->IsHTML(true); //設定郵件內容為HTML        
                $mail->AddAddress("$row[3]", "$row[1]"); //設定收件者郵件及名稱        
                if(!$mail->Send()){
                    $requestCode = "404";
                    $requestText = "發送信件錯誤";
                    break;
                }
            }
            mysqli_free_result($result);
        }
    } 
    $sql_delete = "DELETE FROM temp_add_user";
    execute_sql($link,"borrow",$sql_delete);                  
    mysqli_close($link);
	}
}

$json = array(
    "numCode" => array($requestCode,$requestText)
);
echo json_encode($json, JSON_UNESCAPED_UNICODE);


?>