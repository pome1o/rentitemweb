<?php
date_default_timezone_set('Asia/Taipei');
if(isset($_SESSION['log_time'])){
    $nowtime = round(microtime(true) * 1000);
    $logtime = $_SESSION['log_time'];
   

    if(($nowtime - $logtime) >= (1000*60*30)){
        ob_start();
        setcookie("personName","",0);
        setcookie("comein","adasdsad",0);
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
            }
        }
        unset($_SESSION['comein']);
        unset($_SESSION['chmod']);
        unset($_SESSION['stop']);      
        ob_end_flush();
        echo "<script type='text/javascript'>document.location.href='http://".$_SERVER['HTTP_HOST']."/boom/index.php';</script>";
    }
 
}
?>