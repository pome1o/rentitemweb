<?php
if(isset($_COOKIE["comein"]) && isset($_SESSION['chmod'])){
  $passed = $_COOKIE["comein"];
  $chmod = $_SESSION["chmod"];
 
  if ($passed != "True")
  {
    echo "<script type='text/javascript'>document.location.href='/boom/index.php';</script>";
    exit();
  }
    // todo 檢查權限 
   else if($chmod < 2){
        echo "<script type='text/javascript'>";
        echo "alert('想幹壞事嗎?');";
        echo "history.back();";
        echo "</script>";
        exit();
    }else{
      $studentID = $_SESSION["studentId"];
      $personName = $_COOKIE["personName"];
      $logtime = $_SESSION["log_time"];
    }
}else{
  echo "<script type='text/javascript'>document.location.href='/boom/index.php';</script>";
  exit();
}

?>