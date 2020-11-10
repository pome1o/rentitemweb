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
    
    if(isset($_POST['confirmData']) && isset($_POST['user_id']) && isset($_POST['mod'])){
        $id = $_POST['user_id'];
        $sql_check_user = "SELECT studentID FROM student WHERE studentID = '$id' OR cardId = '$id'";
        $check_row = mysqli_fetch_assoc(execute_sql($link,"borrow",$sql_check_user));
        $result = false;
        if($mananger_id != $check_row['studentID']){
            $borrower_id = $check_row['studentID'];
            date_default_timezone_set('Asia/Taipei');
            $datetime = date("Y-m-d H:i:s");        
            $mod = $_POST['mod'];
            $temparray = $_POST['confirmData'];
            
            if($mod == 0){
                for($i = 0; $i<count($temparray); $i++){

                    $temp_mark = explode("@",$temparray[$i]);
                        //物品
                    if($temp_mark[0] == "A"){
                        
                      $sql_st = "UPDATE tempborrow SET status='1', lendTime ='$datetime',lend_manager = '$mananger_id'  WHERE _id = '$temp_mark[1]' AND studentID = '$borrower_id' AND status = 0";

                    }else if($temp_mark[0] == "B"){                        
                        //LAB 需要調整lab using OR not
                        $sql_st = "UPDATE templab  SET status = '1',lendTime = '$datetime',lend_manager = '$mananger_id' WHERE _id = '$temp_mark[1]' AND studentID = '$borrower_id' AND status = 0";

                    }else if($temp_mark[0] == "C"){
                        //教室
                        $do_no = true;
                        if(isset($_POST['room_user'])){
                            $temp_id = $_POST['room_user'];
                            for($i = 0; $i < count($temp_id); $i ++){
                                $sql_s = "SELECT * FROM student WHERE studentID = '$temp_id[$i]' limit 1";
                                $result = execute_sql($link,"borrow",$sql_s);
                                if(mysqli_num_rows($result) <= 0 ){                                    
                                    $do_no = false;
                                    $requestText ="教室 卡號 不正確";
                                    break;
                                }
                                mysqli_free_result($result);
                            }
                        }
                        if(!$do_no){
                            continue;
                        }
                        $sql_st = "UPDATE roomborrow SET status = '1',lendTime = '$datetime',lend_manager = '$mananger_id' WHERE id = '$temp_mark[1]' AND studentID = '$borrower_id'";
                    }
                    
                    $a = execute_sql($link,"borrow",$sql_st);
                    if(!$a){
                        break;
                    }
                }
                $result = $a;
            }else if($mod ==1){
                
                for($i = 0; $i<count($temparray); $i++){

                    $temp_mark = explode("@",$temparray[$i]);

                    if($temp_mark[0] == "A"){
                        //物品
                        $del_sql = "DELETE FROM tempborrow  WHERE _id = '".$temp_mark[1]."' AND studentID = '$borrower_id' AND status = 0";

                    }else if($temp_mark[0] == "B"){
                        
                        //LAB 需要調整lab using OR not
                        $del_sql = "DELETE FROM templab WHERE _id = '".$temp_mark[1]."' AND studentID = '$borrower_id' AND status = 0";

                    }else if($temp_mark[0] == "C"){
                       //教室
                      $del_sql = "DELETE FROM roomborrow  WHERE id = '".$temp_mark[1]."' AND studentID = '$borrower_id'";                        
                    }
                   
                    $a = execute_sql($link,"borrow",$del_sql);
                    if(!$a){
                        break;
                    }
                }
                $result = $a;
            }
            if($result){
                $requestCode =200;
                $requestText = "成功";
            }else{
                $requestText = "有地方壞了";
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