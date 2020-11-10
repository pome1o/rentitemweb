<?php
    //檢查 cookie 中的 passed 變數是否等於 TRUE
    session_start();
    $passed = $_COOKIE["comin"];
    $studentID= $_SESSION["studentId"];
    $personName=$_COOKIE["personName"];	
    /*  如果 cookie 中的 passed 變數不等於 TRUE
      表示尚未登入網站，將使用者導向首頁 index.htm	*/
    if ($passed != "TRUE"){
        header("location:index.htm");
        exit();
    }
?>

<?php
    date_default_timezone_set('Asia/Taipei');
    $datetime = date("Y-m-d H:i:s");
    require_once("../dbtools.inc.php");
    header("Content-type: text/html; charset=utf-8");
    if(isset($_GET['do'])){
        $do = true;
    }
    else{
        $do = false;
    }
  
    $itemArray = $_POST["itemBundle"];	
    $link = create_connection();

    $i=0;
    // todo $gg[0] = 物品編號 $gg[1] = 借用人姓名  
    while($i<count($itemArray)) {
        $gg = explode("@@",$itemArray[$i]);
		/*echo "INSERT INTO borowperson (personName,studentID,itemNo,lendTime) SELECT personName,studentID,itemNo,lendTime FROM tempborrow WHERE 
        itemNo = '$gg[0]' AND studentID = '$gg[1]'; UPDATE borowperson SET itemName = '$gg[2]'  ; <br> ";
		echo "UPDATE item_info SET usingORnot = 0 WHERE  itemNo = '$gg[0]' <br>";*/
	    //$sqltime ="UPDATE `borowperson` SET `returnTime` = '$datetime' WHERE itemNo = $bno[$i] AND studentID = $studentID AND returnTime IS NULL  ";
        
        // todo 駁回
        if($do){
            $sql = "DELETE FROM tempborrow WHERE itemNo='$gg[0]' AND $studentID='$gg[1]' ";
            $sql_st = "UPDATE item_info SET usingORnot = 0 WHERE itemNo='$gg[0]'";
        }
        
        // todo 確定
        else{
            $sql = "UPDATE item_info SET usingORnot = 1 WHERE  itemNo = '$gg[0]' ";
            $sql_st = "UPDATE tempborrow SET status = 1 WHERE itemNo = '$gg[0]' AND studentID = '$gg[1]' AND status = 0";
        }
        echo $gg[0]." ".$gg[1]." ";
	    execute_sql($link,"borrow",$sql_st);
        execute_sql($link,"borrow",$sql);
        $i++;
    }
	
    //$sql = "UPDATE laptop SET usingORnot = 0, stname='' WHERE  laptopNo= $laptopNo";
  
	//$sqltime ="UPDATE `borowperson` SET `returnTime` = '$datetime' WHERE itemNo = '$laptopNo' AND studentID = '$studentID' AND returnTime IS NULL ";
	
    mysqli_close($link);

    header("location:../ckborrow.php");
?>
