<?php 
    session_start();
    require_once("../dbtools.inc.php");
    header("Content-type: text/html; charset=utf-8");
    $link = create_connection();
    $requestCode = 404;
    $requestText = "錯誤";
    $json = array();
    $passed = $_COOKIE["comein"];
    $mananger_id= $_SESSION["studentId"];
    $personName = $_COOKIE["personName"];	
    $do_update = false;
    if(isset($_POST['confirmData']) && isset($_POST['user_id'])){
        $id = $_POST['user_id'];
        $sql_check_user = "SELECT studentID FROM student WHERE studentID = '$id' OR cardId = '$id'";
        $check_row = mysqli_fetch_assoc(execute_sql($link,"borrow",$sql_check_user));
        if($mananger_id != $check_row['studentID']){
            date_default_timezone_set('Asia/Taipei');
            $datetime = date("Y-m-d H:i:s");
            $temparray = $_POST['confirmData'];
            $borrower_id = $check_row['studentID'];
                for($i = 0; $i<count($temparray); $i++){

                    $temp_mark = explode("@",$temparray[$i]);

                    if($temp_mark[0] == "A"){
                        //item
                        $sql_check = "SELECT status FROM tempborrow WHERE _id ='$temp_mark[1]'";
                        $status_row = mysqli_fetch_row(execute_sql($link,"borrow",$sql_check));

                        if($status_row[0] == -1){
                            $do_update = true;
                        }

                        $del_sql = "DELETE FROM tempborrow  WHERE _id = '".$temp_mark[1]."' AND studentID = '$borrower_id' AND status = '1'";
                        $copy_sql = "INSERT INTO borowperson (personName,studentID,itemNo,note,lendTime,lend_manager,returnTime,return_manager,status) SELECT personName,studentID,itemNo,note,lendTime,lend_manager,'$datetime','$mananger_id',status FROM tempborrow WHERE _id = '".$temp_mark[1]."'";
                    }else if($temp_mark[0] == "B"){
                        //lab
                       
                        $sql_select = "SELECT itemNo,category,status FROM templab WHERE _id = '$temp_mark[1]'";
                        $select_result = execute_sql($link,"borrow",$sql_select);
                        $sel_row = mysqli_fetch_row($select_result);

                        if($sel_row[2] == -1){
                            $do_update = true;
                        }

                        $copy_sql = "INSERT INTO borrowlab (personName,studentID,lab_num,seat_num,lendTime,lend_manager,returnTime,return_manager,status) SELECT personName,studentID,category,itemNo,lendTime,lend_manager,'$datetime','$mananger_id',status FROM templab WHERE _id ='".$temp_mark[1]."'";
                        if(strtoupper($sel_row[0]) == "MEETING"){                            
                            $copy_sql = "INSERT INTO borrowlab (personName,studentID,lab_num,seat_num,lendTime,lend_manager,start_time,end_time,returnTime,return_manager,status) SELECT personName,studentID,category,itemNo,lendTime,lend_manager,start_time,end_time,'$datetime','$mananger_id',status FROM templab WHERE _id ='".$temp_mark[1]."'";
                        }
                        $del_sql = "DELETE FROM templab  WHERE _id = '".$temp_mark[1]."' AND studentID = '$borrower_id' AND status = '1'";
                        
                    }else if($temp_mark[0] == "C"){
                        //class
                        $sql_check = "SELECT status FROM roomborrow WHERE id ='$temp_mark[1]'";
                        $status_row = mysqli_fetch_row(execute_sql($link,"borrow",$sql_check));

                        if($status_row[0] == -1){
                            $do_update = true;
                        }
                        $del_sql = "DELETE FROM roomborrow WHERE id = '".$temp_mark[1]."' AND studentID = '$borrower_id'";
                        $copy_sql = "INSERT INTO borrowroom (personName,studentID,period,week,room_no,lendTime,lend_manager,returnTime,return_manager,status) SELECT personName,studentID,period,week,roomNo,lendTime,lend_manager,'$datetime','$mananger_id',status FROM roomborrow WHERE id ='".$temp_mark[1]."'";
                    }

                    if(execute_sql($link,"borrow",$copy_sql)){

                        if($do_update){
                            $insert_id = mysqli_insert_id($link);
                            $sql_update = "UPDATE violation_record SET record_id = '$insert_id' WHERE record_id = '$temp_mark[1]'";
                        }                      

                        if(execute_sql($link,"borrow",$del_sql)){
                            $requestCode = 200;
                            $requestText = "成功";
                        }else{
                            $requestText = "有地方壞了";
                        }
                    }else{
                        $requestText = "複製時錯誤-請找工程師";
                    }
                    
                }
            }else{
                $requestText ="錯誤-借用人與確認人相同";
            }   
    }

    $json = array(
        "numCode"=>array($requestCode,$requestText)
    );
    echo json_encode($json,JSON_UNESCAPED_UNICODE);
    mysqli_close($link);
?>