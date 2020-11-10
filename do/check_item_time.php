<?php
require_once("../dbtools.inc.php");
if(isset($_POST['time']) && isset($_POST['type'])){
    $all_date = array();
    $no = $_POST['time'];
    $type = $_POST['type'];
    $link = create_connection();
    if($type == "item"){
        $sql_get_time = "SELECT lendTime,expect_return_time FROM tempborrow WHERE itemNo = '$no' AND status >= '0'";
        $sql_select = "SELECT off_time FROM item_category inner join item_info on item_category.num = item_info.catergory WHERE item_info.itemNo = '$no'";        
        $row = mysqli_fetch_row(execute_sql($link,"borrow",$sql_select));
        $off_time = $row[0];
    }else if($type =="class"){
        $p = $_POST['period'];
        $day = $_POST['day'];
        $sql_get_time = "SELECT lendTime FROM roomborrow WHERE period = '$p' AND week = '$day' AND status >= '0'";
    }
    
    $result = execute_sql($link,"borrow",$sql_get_time);
    $i = 0;
    while($row = mysqli_fetch_assoc($result)){
        if($type =="item"){
            $period = new DatePeriod(
                new DateTime($row['lendTime']),
                new DateInterval('P1D'),
                new DateTime(date('Y-m-d',strtotime($row['expect_return_time'].'+1 day')))
            );
        
            foreach($period as $value){
                $all_date[$i] = $value->format('Y-m-d');
                $i++;
            }
        }else{
            $all_date[$i] = date("Y-m-d",strtotime($row['lendTime']));
            $i++;
        }
    }
    $all_date[$i] = date("Y-m-d",strtotime($off_time));
    mysqli_close($link);
    echo json_encode($all_date,JSON_UNESCAPED_UNICODE);
}
?>