<?php
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
        $sql = "SELECT studentID,personName,cardId,foulCount,chmod FROM student WHERE studentID LIKE '%".$text."%' OR personName like '%".$text."%' OR  cardId like '%".$text."%'";
    }else if($mod == "getclass"){
        date_default_timezone_set('Asia/Taipei');
        $datetime = (int)date("Y") - 1911;
        
        switch($text){
            case "1A":
                $text = (string)$datetime."1111";
                break;
            case "1B":
                $text = (string)$datetime."1112";
                break;
            case "2A":
                $datetime = $datetime - 1;
                $text = (string)$datetime."1111";
                break;
            case "2B":
                 $datetime = $datetime - 1;
                $text = (string)$datetime."1112";
                break;
            case "3A":
                $datetime = $datetime - 2;
                $text = (string)$datetime."1111";
                break;
            case "3B":
                $datetime = $datetime - 2;
                $text = (string)$datetime."1112";
                break;
            case "4A":
                $datetime = $datetime - 3;
                $text = (string)$datetime."1111";
                break;
            case "4B":
                $datetime = $datetime - 3;
                $text = (string)$datetime."1112";
                break;
        }
        $sql = "SELECT studentID,personName,cardId,foulCount,chmod FROM student WHERE studentID LIKE '%".$text."%' order by studentID ASC";
    }
    $result = execute_sql($link,"borrow",$sql);
    $i = 1;
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_assoc($result)){
            $json[$i] = array("user_id"=>$row['studentID'],"user_name"=>$row['personName'],"card_id"=>$row['cardId'],"user_foul"=>$row['foulCount'],"user_type"=>$row['chmod']);
            $i++;
        }
    }else{
        $json[0] = 404;
    }
    mysqli_free_result($result);
}
   
echo json_encode($json,JSON_UNESCAPED_UNICODE);

?>