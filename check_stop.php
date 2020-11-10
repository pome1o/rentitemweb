<?php
if(isset($_SESSION['stop'])){
    if($_SESSION['stop'] < 0 || $_SESSION['stop'] == 5){
        header("location:/boom/user_info.php");
    }
}

if(!isset($_COOKIE['comein'])){
    header("location:index.php");
}
if(isset($_COOKIE['comein'])){
    if(isset($_SESSION['comein'])){
        if($_SESSION['comein'] != true){
            header("location:index.php");
        }
    }else{
        header("location:index.php");
    }    
}



?>