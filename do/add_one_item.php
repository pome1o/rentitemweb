<?php

require_once("../dbtools.inc.php");
header("Content-type: text/html; charset=utf-8");
$link = create_connection();
$itemno = $_POST['itemNo'];         // 物品編號
$itemsp = $_POST['itemsp'];         // 物品型號
$itembrand = $_POST['itembrand'];   // 物品廠牌
$os = null;

$drop = $_POST['drop']; 

// todo　新增種類
if($drop =="newcate"){
    $itemca = $_POST['sp'];
    $sql_ca = "SELECT * FROM item_category WHERE name='$itemca'";
    $catgory =  execute_sql($link,"borrow",$sql_ca);
    
    // 如果種類不存在
    if(mysqli_num_rows($catgory)<=0){
        $sql_inca = "INSERT INTO item_category (name) VALUES ('$itemca')";
        execute_sql($link,"borrow",$sql_inca);
    }       
}

// todo 已存在類別
else{
    $itemca = $_POST['drop'];
}

// todo 作業系統(可以為null)
if(isset($_POST['os'])){
    $os = $_POST['os'];
}

$sql_ca = "SELECT * FROM item_category WHERE name='$itemca'";
$catgory =  execute_sql($link,"borrow",$sql_ca); 
$catgory1 = mysqli_fetch_assoc($catgory);
$id= $catgory1['num'];
$sql_in = "INSERT INTO item_info (itemNo,specification,brand,catergory) VALUES ('$itemno','$itemsp','$itembrand',$id)";

/*
$a = execute_sql($link,"borrow",$sql_in); 
if($a ==true){
    echo "成功";
}else
    echo "失敗";

*/
if (mysqli_query($link, $sql_in)){
    echo "成功";
}
else{
    echo "error ".mysqli_error($link);
}



mysqli_free_result($catgory);
mysqli_close($link);

header("Refresh: 3; url=../newitem.php");


?>