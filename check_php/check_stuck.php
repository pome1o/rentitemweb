<?php
 $link = mysqli_connect("localhost", "RD", "103111123") or die("無法建立資料連接: " . mysqli_connect_error()); 
 mysqli_query($link, "SET NAMES utf8");
 mysqli_select_db($link, "borrow") or die("開啟資料庫失敗: " . mysqli_error($link));
 date_default_timezone_set('Asia/Taipei');

 $sql_select_item = "SELECT _id,studentID FROM tempborrow WHERE DATE(insert_time) = DATE(NOW()) AND status = '0'";
 $sql_select_lab = "SELECT _id,studentID FROM templab WHERE DATE(insert_time) = DATE(NOW()) AND status = '0'";
 $sql_select_room = "SELECT id,studentID FROM roomborrow WHERE DATE(insert_time) = DATE(NOW()) AND status = '0'";

 $result_item = mysqli_query($link,$sql_select_item);
 $result_lab = mysqli_query($link,$sql_select_lab);
 $result_room = mysqli_query($link,$sql_select_room);

 if(mysqli_num_rows($result_item) > 0){
    while($row = mysqli_fetch_row($result_item)){
        $sql_insert ="INSERT INTO borowperson (personName,studentID,itemNo,note,lendTime,lend_manager,status) SELECT personName,studentID,itemNo,note,lendTime,lend_manager,'-2' 
        FROM tempborrow WHERE _id = '$row[0]'";
        $sql_de = "DELETE FROM tempborrow WHERE _id = '$row[0]'";
        $sql_up = "UPDATE student SET foulCount = foulCount + 1 WHERE studentID = '$row[1]'";   

        mysqli_query($link,$sql_insert);
        $insert_id = mysqli_insert_id($link);

        $sql_violation = "INSERT INTO violation_record (user_id,type,record_id,reason) VALUES ('$row[1]','item','$insert_id','預約後尚未確認')";

        mysqli_query($link,$sql_up);
        mysqli_query($link,$sql_violation);
        mysqli_query($link,$sql_de);
    }
 }

 if(mysqli_num_rows($result_lab) > 0){
    while($row = mysqli_fetch_row($result_lab)){
        while($row = mysqli_fetch_row($result_item)){
            $sql_insert = "INSERT INTO borrowlab (personName,studentID,seat_num,lab_num,lendTime,lend_manager,start_time,end_time,status)  
            SELECT personName,studentID,itemNo,category,lendTime,lend_manager,start_time,end_time,'-2' FROM templab WHERE _id = '$row[0]'";
            $sql_de ="DELETE FROM tempborrow WHERE _id = $row[0]";
            $sql_up = "UPDATE student SET foulCount = foulCount + 1 WHERE studentID = '$row[1]'";
           
            
            mysqli_query($link,$sql_insert);
            $insert_id = mysqli_insert_id($link);

            $sql_violation = "INSERT INTO violation_record (user_id,type,record_id,reason) VALUES ('$row[1]','lab','$insert_id','預約後尚未確認')";
            mysqli_query($link,$sql_up);
            mysqli_query($link,$sql_violation);
            mysqli_query($link,$sql_de);
        }
    }
 }
 if(mysqli_num_rows($result_room) > 0){
    while($row = mysqli_fetch_row($result_room)){
        while($row = mysqli_fetch_row($result_item)){
            $sql_insert = "INSERT INTO borrowroom (studentID,personName,period,week,room_no,status) 
            SELECT studentID,personName,period,week,roomNo,'-2' FROM roomborrow WHERE id = '$row[0]'";

            $sql_de ="DELETE FROM tempborrow  WHERE _id = $row[0]";
            $sql_up = "UPDATE student SET foulCount = foulCount + 1 WHERE studentID = '$row[1]'";
           

            mysqli_query($link,$sql_insert);
            $insert_id = mysqli_insert_id($link);
            $sql_violation = "INSERT INTO violation_record (user_id,type,record_id,reason) VALUES ('$row[1]','class','$insert_id','預約後尚未確認')";
            
            mysqli_query($link,$sql_up);
            mysqli_query($link,$sql_violation);
            mysqli_query($link,$sql_de);
        }
    }
 }
 $today =date("Y-m-d H:i:s");
 $sql_date = "INSERT INTO value_data (_key,value) value ('check_borrow','$today') on DUPLICATE KEY UPDATE value = '$today'";
 //$sql_date = "UPDATE value_data SET value = '$today' WHERE _key = 'check_borrow'";
 mysqli_query($link,$sql_date);
 
 mysqli_close($link);
?>