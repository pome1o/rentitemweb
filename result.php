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
  else if($chmod != 1){
      echo "<script type='text/javascript'>";
      echo "alert('想幹壞事嗎?');";
      echo "history.back();";
      echo "</script>";
      exit();
  }

?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>歸還成功</title>
    <?php include("style.php");?>
</head>
<body>
<?php include("nav.php");?>
<div id="contentAll">
<div id="contentL"></div>
<div id="contentR"></div>
<div id="content">
    
    <h1 align='CENTER'>歸還成功</h1>
	<p align="center">
	登入使用者帳號: <?php echo $studentID?>
	使用者姓名:<?php echo $personName?><br>
	
      <a href="returnitem.php">回到歸還頁面</a>。
    </p>
  </div>
</div>
<?php include("footer.php");?>
</html>