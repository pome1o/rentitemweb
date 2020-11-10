<?php
header("Content-Type:text/html; charset=utf-8");
require_once("../dbtools.inc.php");
$link = create_connection();

$lab_num = $_POST["lab_num"];
//echo "實驗室編號：".$lab_num."<br>";

$sql_temp = "SELECT * FROM templab WHERE category = $lab_num AND status <> -1";

execute_sql($link,"borrow",$sql_temp);

$sql_temp_result = execute_sql($link,"borrow",$sql_temp);
$temp = mysqli_fetch_assoc($sql_temp_result);
//echo count($temp)."<br>";

if(count($temp) > 0){
    echo "刪除失敗"."<br>";
    echo "原因：".$lab_num." 實驗室還有紀錄未審核或歸還"."<br>";
}
else{
    $sql_img = "SELECT img FROM lab_category WHERE num = $lab_num";
    $sql_info = "DELETE FROM laboratory_info WHERE lab_num = $lab_num";
    $sql_cate = "DELETE FROM lab_category WHERE num = $lab_num";
    $result_img = execute_sql($link,"borrow",$sql_img);
    $img_row = mysqli_fetch_assoc($result_img);
    $img_path = $img_row["img"];
    
    execute_sql($link,"borrow",$sql_info);
    execute_sql($link,"borrow",$sql_cate);
    //echo $img_path."<Br>";
    if(is_file("../uploads/labs/$img_path")){
        unlink("../uploads/labs/$img_path");
    }
    if(is_file("../uploads/labs/thumb_$img_path")){
        unlink("../uploads/labs/thumb_$img_path");
    }
    echo $lab_num." 實驗室刪除成功"."<Br>";
    
}

echo "五秒後返回"."<br>";
header("Refresh: 5; url=../del_lab.php");

?>