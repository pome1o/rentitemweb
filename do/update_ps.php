<?php
header("Content-Type:text/html; charset=utf-8");
require_once("../dbtools.inc.php");
$link = create_connection();
$requestCode = "404";
$requestText = "錯誤";
if(isset($_POST['other_item']) && isset($_POST['ps_item']) && isset($_POST['item_id'])){
    $other = $_POST['other_item'];
    $ps = $_POST['ps_item'];
    $id = $_POST['item_id'];
    $sql_select_other = "SELECT * FROM borrow_note WHERE category = '$id' AND other = '0'";
    $sql_select_other_2 = "SELECT * FROM borrow_note WHERE category = '$id' AND other = '1'";

    if(mysqli_num_rows(execute_sql($link,"borrow",$sql_select_other)) > 0 ){
    echo    $sql_update = "UPDATE borrow_note SET content = '$other' WHERE category = '$id' AND other = '0'";
    }else{
        echo   $sql_update = "INSERT INTO borrow_note (category,other,content) Values ('$id','0','$other') WHERE category = '$id' AND other = '0'";
    }

    if(mysqli_num_rows(execute_sql($link,"borrow",$sql_select_other_2)) > 0){
        echo   $sql_update_2 = "UPDATE borrow_note SET content = '$ps' WHERE category = '$id' AND other = '1'";
    }else{
        echo  $sql_update_2 = "INSERT INTO borrow_note (category,other,content) Values ('$id','1','$ps') WHERE category = '$id' AND other = '1'";
    }
    
    
   
    if(execute_sql($link,"borrow",$sql_update) && execute_sql($link,"borrow",$sql_update_2)){
        $requestCode = "200";
        $requestText = "成功";
    }else{
        $requestText = "有地方錯誤 請找工程師";
    }
        
}
mysqli_close($link);

$json = array(
    "numCode" => array($requestCode,$requestText)
);
echo json_encode($json, JSON_UNESCAPED_UNICODE);

?>