<form  method="post" data-act="itemChooseForm" id="aaa" name="form1" action="../do/doborrow.php" >
<table class="table table is-hoverable is-bordered" id="borrow_table" align="center" >
<?php
require_once("../dbtools.inc.php");

if(isset($_POST['room_num']) && isset($_POST['date'])){
    date_default_timezone_set('Asia/Taipei');
    $link = create_connection();
    
    $room_num = $_POST['room_num'];
    $date = $_POST['date'];
    $day_week = date('w',strtotime($date));

    $sql_open = "SELECT * FROM classroom WHERE DATE(off_time) = DATE('$date') AND open_off = '1'";
    $can_result = execute_sql($link,"borrow",$sql_open);
     

    if(mysqli_num_rows($can_result) <= 0){    
        $sql = "SELECT * FROM classperiod1 WHERE room_no = '$room_num' AND day = '$day_week'";
        $result = execute_sql($link,"borrow",$sql);
        $day_th = array("星期一","星期二","星期三","星期四","星期五");
        $per = array("第一節","第二節","第三節","第四節","休息時間","第五節","第六節","第七節","第八節");

        echo "<input type='hidden' id='borrow_type' name='type' value='class'>";
        if(mysqli_num_rows($result) > 0){
            echo "<tr><th bgcolor='#B0E0E6'>節</th><th bgcolor='#B0E0E6'>".$day_th[$day_week-1]."</th></tr>";  
            while($row = mysqli_fetch_assoc($result)){
                $day = $row['day'];
                $p = $row['period'];
                $sql_check = "SELECT * FROM roomborrow WHERE period = '$p' AND week = '$day' AND Date(insert_time) = '$date' limit 1";
                $check_result = execute_sql($link,"borrow",$sql_check);                
                echo "<tr id='period_$p'  style='height:50px;'><td bgcolor='#FFEBCD'>".$per[$p-1]."</td>";                
                $temp_class_name ="空堂";
                if($row['class_name'] != "no_class"){
                    $temp_class_name = $row['class_name'];
                    echo "<td id='day_$day'>".$temp_class_name."</td>";
                }else{
                    if(mysqli_num_rows($check_result) > 0){                                            
                        $temp_class_name = "已被借用";
                        echo "<td id='day_$day' bgcolor ='#DDA0DD'>".$temp_class_name."</td>";
                    }else{
                        echo "<td id='day_$day'><input type='checkbox' name='user_select[]' id='choosebox' value = '$p@$day'>".$temp_class_name."</td>";
                    }
                    
                }
                    echo "</tr>";
            }
        }else{
            echo "<p>沒有資料</p>";
        }
    }else{
        echo "<p>今日停止借用</p>";
    }
?>
</table>
</form>
<div style="margin-bottom:2%">
<a type="button" class="button is-dark is-outlined" name="hi" onclick="check_choose_simple()" >借用</a>
<a type="button" class="button is-dark is-outlined" value="返回" onclick="location.href='/boom/borrowitem.php'" >返回</a>
</div>
<script>

<?php
        // todo 顯示換頁按鈕   
        mysqli_close($link);
    }
    
    function time_check($item_time){
        $time = $item_time;
        if(strtotime("now") > strtotime($item_time)){
            $time = "尚無借用";
        }
        return $time;
    }

    function usingOrNot($status){
        if($status == 1){
            return "<td id='borrow_using'bgcolor='#F08080'>使用中</td>";
        }
            return "<td >空閒中</td>";
    }
?>