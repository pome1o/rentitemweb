<?php
    //檢查 cookie 中的 passed 變數是否等於 TRUE
    $passed = $_COOKIE["passed"];
    $studentID= $_COOKIE["studentID"];
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
  
    $bno = $_POST["bno"];
    $category = $_POST["category"];

    $link = create_connection();

    $i=0;
    // todo $gg[0] = 物品編號 $gg[1] = 借用人姓名  
    while($i<count($bno)) {
        $gg = explode("@@",$bno[$i]);
        if($do){
            $sql = "DELETE FROM templab WHERE itemNo='$gg[0]' AND $studentID='$gg[1]' ";
            
            $sql_st = "UPDATE laboratory_info SET usingORnot = 0 WHERE labNo='$gg[0]' AND category = '$category[$i]' ";
            echo "labNo = ". $gg[0]." category = ".$category[$i]." ";
        }else{
            $sql = "UPDATE laboratory_info SET usingORnot = 1 WHERE labNo = '$gg[0]' AND category = '$category[$i]' ";
            
            $sql_st = "UPDATE templab SET status = 1 WHERE itemNo = '$gg[0]' AND studentID = '$gg[1]' AND status = 0";
        }

	    execute_sql($link,"borrow",$sql_st);
        execute_sql($link,"borrow",$sql);
        $i++;
    }
	
    mysqli_close($link);

    header("location:../cklab.php");
?>
