<?php
    //檢查 cookie 中的 passed 變數是否等於 TRUE
    $passed = $_COOKIE["passed"];
    $studentID= $_COOKIE["studentID"];
    $personName=$_COOKIE["personName"];	
    /*  如果 cookie 中的 passed 變數不等於 TRUE
        表示尚未登入網站，將使用者導向首頁 index.htm	*/
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
    
    $bno = $_POST["bno"];	
    $category = $_POST["category"];

    $link = create_connection();

    $i=0;
    // todo $gg[0] = 物品編號 $gg[1] = 借用人姓名 $gg[2] = 物品編號
    while($i<count($bno)) {
        $gg =  explode("@@",$bno[$i]);
        echo $gg[0]. " : ". $gg[1]. " : ".$gg[2];
		/*echo "INSERT INTO borowperson (personName,studentID,itemNo,lendTime) SELECT personName,studentID,itemNo,lendTime FROM tempborrow WHERE 
        itemNo = '$gg[0]' AND studentID = '$gg[1]'; UPDATE borowperson SET itemName = '$gg[2]'  ; <br> ";
		echo "UPDATE item_info SET usingORnot = 0 WHERE  itemNo = '$gg[0]' <br>";*/
	    //$sqltime ="UPDATE `borowperson` SET `returnTime` = '$datetime' WHERE itemNo = $bno[$i] AND studentID = $studentID AND returnTime IS NULL ";
        
        // todo 寫入借用紀錄
        $sqlreturn = "INSERT INTO borrowperson (personName,studentID,itemNo,lendTime,lend_manager) SELECT personName,studentID,itemNo,lendTime,lend_manager FROM templab WHERE itemNo = '$gg[0]' AND studentID = '$gg[1]' AND status = 1";
        
        // todo 將實驗室狀態改為可借用
        $sql = "UPDATE laboratory_info SET usingORnot = 0 WHERE  labNo = '$gg[0]' ";
        //$sql_up = "UPDATE borowperson SET itemName = '$gg[2]' ";
        
        // todo 更新借用紀錄
       
        
        // todo 刪除暫存資料
        $sql_de = "DELETE FROM templab WHERE itemNo = '$gg[0]' AND studentID = '$gg[1]' AND status = 1";
        
	    execute_sql($link,"borrow",$sqlreturn);
        $last_id =  mysqli_insert_id($link);
        
        $sql_up = "UPDATE borrowlab SET itemName = '$gg[2]',return_manager = '' where itemNo = '$gg[0]' AND _id ='$last_id'";
        execute_sql($link,"borrow",$sql_up);         
        
        execute_sql($link,"borrow",$sql);
       
        execute_sql($link,"borrow",$sql_de); 
        
        /*
	    if (mysqli_query($link, $sql_de)){
            echo "成功";
        }
        else{
            echo "error ".mysqli_error($link);
        }
        */
        
        $i++;
    }

    //$sql = "UPDATE laptop SET usingORnot = 0, stname='' WHERE  laptopNo= $laptopNo";
    //$sqltime ="UPDATE `borowperson` SET `returnTime` = '$datetime' WHERE itemNo = '$laptopNo' AND studentID = '$studentID' AND returnTime IS NULL ";
    mysqli_close($link);

    header("location:../returnitem.php");
?>
