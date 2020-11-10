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
 
    if(isset($_POST['confirmData']) && isset($_POST['user_id'])){       
            $result = false;     
            
            date_default_timezone_set('Asia/Taipei');
            $datetime = date("Y-m-d H:i:s");        
            $temparray = $_POST['confirmData'];           
            $borrower_id = $_POST['user_id'];
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
            if($result){
                $requestCode =200;
                $requestText = "成功";
            }else{
                $requestText = "有地方壞了";
            }
  
}
    $json = array(
        "numCode"=>array($requestCode,$requestText)
    );
    echo json_encode($json,JSON_UNESCAPED_UNICODE);
    mysqli_close($link);
?>