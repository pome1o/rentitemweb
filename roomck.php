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
  require_once("dbtools.inc.php");
  header("Content-type: text/html; charset=utf-8");
  
  //取得表單資料
  
  $bno = $_POST["bno"];	
   
   
  //建立資料連接
  $link = create_connection();
  
  $i=0;
  while($i<count($bno)) {	
      $text = explode("*",$bno[$i]);
      for($j=0;$j<3;$j++){
	       $roomNo = $text[0];     
		   $week = $text[1];
		   $period = $text[2];
      }
      // todo 駁回
	  if(isset($_GET['what'])){
          //echo "if week =" .$week. " period =". $period. " roonNo =". $roomNo;
          $sqltime = "UPDATE classperiod  SET $week = 0 WHERE period = $period AND $week = 1 AND room = '$roomNo' ";
          $sql = "DELETE FROM `roomborrow` WHERE period = $period AND week = '$week'
	                 AND roomNo = '$roomNo' AND studentID = $studentID ";
      }
      // todo 確定
      else{
          //echo "else week =" .$week. " period =". $period. " roonNo =". $roomNo;
          $sqltime = "UPDATE classperiod  SET $week = 1 WHERE period = $period AND $week = 0 AND room = '$roomNo' ";
	      $sql = "UPDATE `roomborrow` SET `status` = 1 WHERE period = $period AND week = '$week'
	                 AND roomNo = '$roomNo' AND studentID = $studentID AND returnTime IS NULL  ";
      }
	  $result = execute_sql($link,"borrow",$sqltime);
      $result2 = execute_sql($link,"borrow",$sql);
	  $i++;
  }
  mysqli_close($link); 
  
  

  //將使用者導向 result.php 網頁
  header("location:class?c=1.php");
?>
