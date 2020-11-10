<?php
    $passed = $_COOKIE["passed"];
    $studentID= $_COOKIE["studentID"];
    $personName=$_COOKIE["personName"];	
    
    // todo 檢查登入
    if ($passed != "TRUE"){
        header("location:index.php");
        exit();
	}
?>

<?php
    date_default_timezone_set('Asia/Taipei');
    $datetime = date("Y-m-d H:i:s");
    require_once("../dbtools.inc.php");
    header("Content-type: text/html; charset=utf-8");	
    $when1 =$_POST['when1'];
    $roomNo = $_COOKIE["rooom"];
    $period = $when1%10;
    $week = (($when1/10)%10)-1;
    echo $when1;
    switch($week){
            case 1:
            $week1 = "Mon";
		    break;
		    case 2:
		    $week1 = "Tue";
		    break;
		    case 3:
		    $week1 = "Wed";
		    break;
		    case 4:
		    $week1 = "Thu";
		    break;
		    case 5:
		    $week1 = "Fri";
		    break;
    }

    $link = create_connection();

    // todo 將教室狀態改為借用中
    $sql = "UPDATE  classperiod SET $week1 = 1 WHERE  $week1 = 0 AND period = $period AND room = '$roomNo' ";
    //$sqlperson = "INSERT INTO borowperson (itemName,personName,studentID,itemNo,lendTime) VALUES 
	             //('classroom','$personName','$studentID','$room','$datetime');";

    // todo 寫入借用紀錄
    $sqlroom = "INSERT INTO roomborrow (studentID,personName,period,week,roomNo,lendTime,status) VALUES 
            ($studentID , '$personName' , $period , '$week1' , '$roomNo' , '$datetime' , 0 ) " ;
    //execute_sql($link,"borrow",$sqlperson);
	execute_sql($link,"borrow",$sql);
	execute_sql($link,"borrow",$sqlroom);
	
    //echo "INSERT INTO roomborrow (studentID,personName,period,week,roomNo) VALUES 
          //($studentID , '$personName' , $period , '$week1' , $room ) " ;
   
    //echo "INSERT INTO borowperson (itemName,personName,studentID,itemNo,lendTime) VALUES 
	      //('classroom','$personName','$studentID','$room','$datetime');";
    
    //echo "UPDATE $roomNo SET $week1 = 1 WHERE $week1 = 0 AND period = $period ";
    mysqli_close($link);
  
    setcookie("rooom","");
    header("location:../roomborrow.php");
?>