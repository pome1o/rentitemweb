<?php
  require_once("dbtools.inc.php");
  header("Content-type: text/html; charset=utf-8");
  session_start();    
  //建立資料連接
  $link = create_connection();
  date_default_timezone_set('Asia/Taipei');
  //取得表單資料
  $studentId = mysqli_real_escape_string($link,$_POST["studentID"]); 	
  $password = mysqli_real_escape_string($link,$_POST["password"]);
  $error_text = "";
  $error_bool = FALSE;
					
  //檢查帳號密碼是否正確
  $sql = "SELECT * FROM student Where studentID = '$studentId'";
  $result = execute_sql($link,"borrow", $sql);
  
  $row = mysqli_fetch_assoc($result);
  
  //如果帳號密碼錯誤
  if (mysqli_num_rows($result) > 0){
    $pw_sv = $row['password'];

    if(password_verify($password,$pw_sv)){
      $now = date("Y-m-d H:i:s");
      $sql_latest_login = "UPDATE student SET latest_login ='$now' WHERE studentID = '$studentId'";
      execute_sql($link,"borrow",$sql_latest_login);

      $sql_select_ban = "SELECT * FROM ban_record WHERE studentID = '$studentId' AND Date('$now') BETWEEN Date(ban_date_from) AND Date(ban_date_to)";
      $ban_result = execute_sql($link,"borrow",$sql_select_ban);
      
      if(mysqli_num_rows($ban_result) > 0){
        $stop = 5;
      }else{
        $stop = $row['stop'];
      }

      setcookie("personName",$row["personName"],0);
      setcookie("comein","True",0);
      $_SESSION['comein'] = true;
      $_SESSION['chmod'] = $row["chmod"];  
      $_SESSION['studentId'] = $studentId;
      $_SESSION['stop'] = $stop;
      $_SESSION['log_time'] = round(microtime(true) * 1000);
      $_SESSION['user_name'] = $row['personName'];      
      if($row['stop'] <= 0){
        echo "<script type='text/javascript'>document.location.href='user_info.php';</script>";
      }else{
        echo "<script type='text/javascript'>document.location.href='borrowitem.php';</script>";
      }    

    }else{
      $error_bool = TRUE;
      $error_text = "密碼錯誤";
    }

  }else{
    $error_bool = TRUE;
    $error_text = "無此帳號";
  }

  if($error_bool){
    echo "<script>";
    echo "alert('$error_text');";
    echo "history.back();";
    echo "</script>";
  }
  
mysqli_free_result($result);
mysqli_close($link);
?>