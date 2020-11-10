<?php
require_once("../dbtools.inc.php");
session_start();
date_default_timezone_set('Asia/Taipei');
$requestCode = "404";
$requestText = "失敗";
$result = false;
if(isset($_POST['type']) && isset($_POST['user_select'])){
    $link = create_connection();
    $user_name = $_SESSION['user_name'];
    $user_id = $_SESSION['studentId'];
    $user_select_item = $_POST['user_select'];    
    $type = $_POST['type'];
    switch ($type) {
        case "item":
        borrow_item($link,$user_name,$user_id,$user_select_item);
        break;
                
        case "class":
        borrow_class($link,$user_name,$user_id,$user_select_item);
        break;
                
        case "lab":   
        borrow_lab($link,$user_name,$user_id,$user_select_item);
        break;                        
    }  

    if($result){
        $requestCode = "200";
        $requestText = "借用成功!!";
    }

    mysqli_close($link);
}
$json = array(
    "numCode"=>array($requestCode,$requestText)
);
echo json_encode($json,JSON_UNESCAPED_UNICODE);

//借物品
function borrow_item($link,$user_name,$user_id,$user_select_item){
    $time = date("H:i:s");
    $date = $_POST['start_time'];          
    $date = $date." ".$time;
    $end_time = $_POST['end_time'];
    $end_time = $end_time." ".$time;
    $note = "";

    if(isset($_POST['note'])){
        $note = trim($_POST['note']);
        $note = mysqli_real_escape_string($link,$note);
    }

    $sql_check = "SELECT * FROM tempborrow WHERE itemNo = '$user_select_item' AND '$date' BETWEEN insert_time AND expect_return_time limit 1";
    $result_check = execute_sql($link,"borrow",$sql_check);

    global $result;
    global $requestText;
    $sql_check_count_5 = "SELECT COUNT(studentID) FROM tempborrow WHERE studentID = '$user_id' AND status ='0' OR status = '1'";
    $row_count = mysqli_fetch_row(execute_sql($link,"borrow",$sql_check_count_5));
    if($row_count[0] < 5){
        if(mysqli_num_rows($result_check) <= 0){       
            $sql_insert = "INSERT INTO tempborrow (personName,studentID,itemNo,note,insert_time,expect_return_time) VALUES ('$user_name','$user_id','$user_select_item','$note','$date','$end_time')";  
            $result = execute_sql($link,"borrow",$sql_insert);
        }else{        
            $requestText = "選擇的時段已被預借";
        }
    }else{
        $requestText = "最多借5樣東西!!";
    }
}

//借實驗室
function borrow_lab($link,$user_name,$user_id,$user_select_item){
    global $result;
    global $requestText;
    if(isset($_POST['lab_cate'])){
       
        $lab_cate = $_POST['lab_cate'];
        
        $sql_check_if_same_lab = "SELECT * FROM templab WHERE studentID ='$user_id' AND category = '$lab_cate' AND itemNo != 'Meeting'";
        if(mysqli_num_rows(execute_sql($link,"borrow",$sql_check_if_same_lab)) > 0){
            $requestText = "同實驗室不可重複借用";
        }else{

            $sql_insert = "INSERT INTO templab (personName,studentID,itemNo,category) VALUES ('$user_name','$user_id','$user_select_item','$lab_cate')";
            
            
            if($user_select_item == "Meeting"){
                $time_array = ['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];

                $date_time = $_POST['date_time'];
                $start_time = $date_time." ".$time_array[$_POST['meet_start']];
                $end_time = $date_time." ".$time_array[$_POST['meet_end']];
                $sql_insert = "INSERT INTO templab (personName,studentID,itemNo,category,start_time,end_time) VALUES ('$user_name','$user_id','$user_select_item','$lab_cate','$start_time','$end_time')";
                
            }            
        
            $result = execute_sql($link,"borrow",$sql_insert);
        }        
    }       
}

function borrow_class($link,$user_name,$user_id,$user_select_item){
    global $result;
    global $requestText;
    $time = date("H:i:s");
    $date = date("Y-m-d");
    if(isset($_POST['class_expect'])){
        if($_POST['class_expect'] == 1){
            $date = $_POST['start_time'];
        }
    }
    

    $date = $date." ".$time;
    $temp_room_no = $_POST['item_category'];   
    for($i = 0; $i < count($user_select_item); $i++){
        $temp_select = explode("@",$user_select_item[$i]);
        $period = $temp_select[0];
        $day = $temp_select[1];
        $sql_insert = "INSERT INTO roomborrow (studentID,personName,period,week,roomNo,insert_time) VALUES ('$user_id','$user_name','$period','$day','$temp_room_no','$date')";
        $a = execute_sql($link,"borrow",$sql_insert);
        if($a == false){            
            break;
        }
    }
    $result = $a;
    
}
?>