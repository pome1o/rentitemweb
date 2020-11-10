<?php
  //清除 cookie 內容
    session_start();
    session_destroy();
    if (isset($_SERVER['HTTP_COOKIE'])) {
      $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
      foreach($cookies as $cookie) {
          $parts = explode('=', $cookie);
          $name = trim($parts[0]);
          setcookie($name, '', time()-1000);
          setcookie($name, '', time()-1000, '/');
      }
    }
    //將使用者導回主網頁
    header("location:index.php");
    exit();
?>