<?php
require("../dbtools.inc.php");

$link = create_connection();
$json = array();
$requestCode = 404;
$requestText = "失敗";
$sql = "UPDATE student SET stop = '5', class='畢業生' WHERE class ='4A' OR class='4B'";
$result = execute_sql($link,"borrow",$sql);
if($result){
    $requestCode = 200;
    $requestText = "成功";
}
$json = array(
    "numCode"=>array($requestCode,$requestText)
);
echo json_encode($json,JSON_UNESCAPED_UNICODE);
?>