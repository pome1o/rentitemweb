<?php
header("Content-type: text/html; charset=utf-8");
include("../check_fun.php");
require_once("../dbtools.inc.php");
$link = create_connection();
$request = 200;
if(isset($_POST['user_id']) && isset($_POST['mod'])){
    $id = mysqli_real_escape_string($link,$_POST['user_id']);   
    $mod = $_POST['mod'];    
    if($mod == 0 || $mod == 2){
        if(isset($_POST['user_name']) && isset($_POST['card_id']) && isset($_POST['user_foul']) && isset($_POST['type_select'])){
            $name = mysqli_real_escape_string($link,$_POST['user_name']);
            $carid = mysqli_real_escape_string($link,$_POST['card_id']);
            $foul = mysqli_real_escape_string($link,$_POST['user_foul']);
            $type = mysqli_real_escape_string($link,$_POST['type_select']);
            if($mod == 0){
                $sql = "UPDATE student SET personName = '$name' , cardId = '$carid', foulCount = '$foul',chmod = '$type' WHERE studentID = '$id'";
            }else if($mod == 2){
                $sql = "INSERT INTO student (studentID,personName,cardId,foulCount,chmod) VALUE ('$id','$name','$carid','$foul','$type')";
            }            
            execute_sql($link,"borrow",$sql);
        }else{
            $request = 404;
        }
    }else if($mod == 1){
        $sql = "DELETE FROM student WHERE studentID = '$id'";
        execute_sql($link,"borrow",$sql);
    }else{
        $request = 404;
    }   
}else{
    $request = 404;
}
mysqli_close($link);
echo $request;

?>