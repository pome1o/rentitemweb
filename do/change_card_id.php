<?php
header("Content-type: text/html; charset=utf-8");
require("../dbtools.inc.php");
$requestCode = "404";

if(isset($_POST['json_data'])){
    $link = create_connection();
    
    $json_data = $_POST['json_data'];
    
    foreach($json_data as $value){
        $card =  trim($value['card_id']);
        $id = $value['id'];
        if(strlen($card) == 10){
            $sql = "UPDATE student SET cardID = '$card' stop = IF(stop < 0 , stop + 2,stop) WHERE studentID = '$id'";
            execute_sql($link,"borrow",$sql);
        }
    }
    $requestCode = "200";
    mysqli_close($link);
}
$json = array(
    "numCode" => array($requestCode)
);
echo json_encode($json, JSON_UNESCAPED_UNICODE);
?>