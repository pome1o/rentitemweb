<?php
session_start();
header("Content-type: text/html; charset=utf-8");
include("../check_fun.php");
require_once("../dbtools.inc.php");
$link = create_connection();
$requestCode = 404;
$json = [$requestCode];

if(isset($_POST['id']) && isset($_POST['mod'])){
    $mod = $_POST['mod'];
    $json[0] = 200;
    $text = mysqli_real_escape_string($link,$_POST['id']);
    if($mod == "getDetail"){
        $sql = "SELECT studentID,class,personName,cardId,email,foulCount,stop,chmod FROM student WHERE studentID ='".$text."'";
    }else if($mod == "getclass"){            
        if($text == "search"){            
            $input = $_POST['userInput'];
            $sql = "SELECT studentID,class,personName,cardId,email,foulCount,stop,chmod FROM student WHERE studentID LIKE '%".$input."%' OR personName like '%".$input."%' OR  cardId like '%".$input."%'";
        }else{
            if($text =='teacher' || $text == 'manager' || $text =='master'){
                $num = 0;
                switch($text){
                    case "teacher":
                    $num = 1;
                    break;
                    case "manager":
                    $num = 2;
                    break;
		    case "master":
		    $num = 3;
		    break;
                }
                $sql = "SELECT studentID,class,personName,cardId,email,foulCount,stop,chmod FROM student WHERE chmod = '$num' order by studentID ASC";
            }else{
                $sql = "SELECT studentID,class,personName,cardId,email,foulCount,stop,chmod FROM student WHERE class = '$text' order by studentID ASC";
            }
           
        }
               
    }
    $result = execute_sql($link,"borrow",$sql);
    $i = 1;
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $json[$i] = array("user_id"=>$row['studentID'],"user_name"=>$row['personName'],"card_id"=>$row['cardId']
            ,"user_foul"=>$row['foulCount'],"user_stop"=>$row['stop'],"user_type"=>$row['chmod'],"email"=>$row['email'],"class"=>$row['class']);
            $i++;
        }
    }else{
        $json[0] = 404;
    }
    mysqli_free_result($result);
}

echo json_encode($json,JSON_UNESCAPED_UNICODE);

?>