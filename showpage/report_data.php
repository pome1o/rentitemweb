<div>
<form  method="post" data-act="itemChooseForm" id="borrow_form">

<?php
require_once("../dbtools.inc.php");

$show_page = false;
if(isset($_GET['choice']) && isset($_GET['type'])){
    date_default_timezone_set('Asia/Taipei');
    $choice = $_GET['choice'];
    $type = $_GET['type'];
    $link = create_connection();
    $day_week = date('w');
    
if($choice != "no" && $type != "all"){
    $show_page = true;
    $page = 1;
    $semester = "1061";
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }

    if(isset($_GET['semester'])){
        $semester = $_GET['semester'];
    }


    $sql_select = "SELECT date_from,date_to FROM semester_value WHERE semester = '$semester'";
    $time_result = execute_sql($link,"borrow",$sql_select);
    $time_row = mysqli_fetch_row($time_result);
       
    $time_from = $time_row[0];
    $time_to = $time_row[1];
    $intervalday = round((strtotime($time_to) - strtotime($time_from))/(60*60*24));
   
    mysqli_free_result($time_result);
    
    switch ($type) {
        case "item":
        $type_note = 0;
        $sql_select =  "SELECT itemNo,specification,brand,IFNULL(count_data,0) FROM item_info LEFT JOIN (SELECT borowperson.itemNo as num,COUNT(*) AS count_data FROM borowperson INNER JOIN item_info on item_info.itemNo = borowperson.itemNo WHERE item_info.catergory = '$choice' AND Date('$time_from') <= Date(lendTime) AND Date('$time_to') >= Date(lendTime) GROUP BY borowperson.itemNo) AS temp on temp.num = item_info.itemNo WHERE catergory ='$choice' ORDER BY item_info.itemNo ASC";
        break;

        case "class":
        $type_note = 2;
        
        $sql_select = "SELECT classperiod1.room_no,classperiod1.period,classperiod1.day,classperiod1.class_name,IFNULL(count_data,0) FROM classperiod1 LEFT JOIN ( SELECT borrowroom.period as num,borrowroom.week AS weekday,COUNT(*) AS count_data FROM borrowroom WHERE room_no = '$choice' AND Date('$time_from') <= Date(lendTime) AND Date('$time_to') >= Date(lendTime) GROUP BY borrowroom.period,borrowroom.week) AS temp on temp.num = classperiod1.period AND temp.weekday = classperiod1.day WHERE room_no = '$choice'  
                ORDER BY classperiod1.period ASC";
        
        break;

        case "lab":
        $type_note = 1;    
        $sql_select =  "SELECT  laboratory_info.lab_num,laboratory_info.seat_num,IFNULL(count_data,0) FROM laboratory_info LEFT JOIN (
            SELECT borrowlab.seat_num as num,borrowlab.lab_num AS labnum,COUNT(*) AS count_data FROM borrowlab WHERE lab_num = '$choice' AND Date('$time_from') <= Date(lendTime) AND Date('$time_to') >= Date(lendTime) GROUP BY borrowlab.seat_num) AS temp 
            on temp.num = laboratory_info.seat_num AND temp.labnum = laboratory_info.lab_num WHERE lab_num = '$choice'
            ORDER BY laboratory_info.seat_num ASC";
        break;                
    }


    $result = execute_sql($link,"borrow",$sql_select);
    $total_fields = mysqli_num_fields($result);    
    $per_page =10;
    $total_records = mysqli_num_rows($result);
    $total_page = ceil($total_records/$per_page);
    $last1 = $total_page-1;
    $started = $per_page*($page-1);
    $showside = 3;
    $show = false;
    echo "<input type='hidden' id='borrow_type' name='type' value='$type'>";
 
        if($total_page==0){
            echo "<div class='subtitle is-4' style='color:red;'></div>";
        }
        
        mysqli_data_seek($result,$started);
        $j=1;
        echo "<div class='subtitle is-4' style='color:red;'>學期:".$semester."</div>";
        


        if($type == "item"){
            
           
            echo "<div>";        
                
                echo "<table class='table table is-hoverable is-bordered' id='borrow_table' align='center' >";

                echo "<tr><th bgcolor='#B0E0E6'>編號</th><th bgcolor='#B0E0E6'>型號</th><th bgcolor='#B0E0E6'>廠牌</th><th bgcolor='#B0E0E6'>次數</th><th bgcolor='#B0E0E6'>使用率(次/學期天數)</th>";
                while( $row = mysqli_fetch_row($result) and $j <=$per_page){
                    echo "<tr><td  bgcolor='#FFF2AF'>";
                    echo "<span>".$row[0]."</span></td>";
                    echo "<td  bgcolor='#FFF2AF' ><span>".$row[1]."</span></td>";
                    echo "<td  bgcolor='#FFF2AF' ><span>".$row[2]."</span></td>";
                    echo "<td  bgcolor='#FFF2AF' ><span>".$row[3]."</span></td>";
                    echo "<td  bgcolor='#FFF2AF' ><span>".round(($row[3]/$intervalday)*100,2) ."%</span></td>";
                    
                    
                    echo "</tr>";
                    
                    $j++;
                }
           
                
        }else if($type == "lab"){           
                               
                
                echo "<table class='table table is-hoverable is-bordered' id='borrow_table' align='center' >";  
                
                echo "<tr><th bgcolor='#B0E0E6'>實驗室編號</th><th bgcolor='#B0E0E6'>位置</th><th bgcolor='#B0E0E6'>次數</th><th bgcolor='#B0E0E6'>使用率(次/學期天數)</th></tr>";
                
                while( $row = mysqli_fetch_row($result) and $j <=$per_page){
                    echo "<tr>";
            
                    echo "<td>".$row[0]."</td>";
                    echo "<td>".$row[1]."</td>";
                    echo "<td>".$row[2]."</td>";
                    echo "<td>".round(($row[2]/$intervalday)*100,2) ."%</td>";
                    echo "</tr>";
                    $j++;
                }             
           
            
        }else if($type == "class"){
           
         
            echo "<div>";
             
            echo "<table class='table table is-hoverable is-bordered' id='borrow_table' align='center' >";
            $day_th = array("節","星期","課程","次數","使用率(次/學期天數)");
            $per = array("第一節","第二節","第三節","第四節","休息時間","第五節","第六節","第七節","第八節");
            echo "<tr><th bgcolor='#B0E0E6'>編號</th>";
            foreach($day_th as $value){
                echo "<th bgcolor='#B0E0E6'>".$value."</th>";
            }
            echo "</tr>";
              
            while($row = mysqli_fetch_row($result) and $j <=$per_page){
                    
               
                
                echo "<td>".$row[0]."</td>";
                echo "<td>".$row[1]."</td>";
                echo "<td>".$row[2]."</td>";
                if($row[3] == "no_class"){
                    echo "<td>空堂</td>";
                }else{
                    echo "<td>".$row[3]."</td>";
                }
                
                echo "<td>".$row[4]."</td>";
                echo "<td>".round(($row[4]/$intervalday)*100,2) ."%</td>";
                echo "</tr>";
                                    
            }          
        }
        mysqli_free_result($result);
    }

    if($choice != "no" && $type == "all"){
        $sql_select = "SELECT date_from,date_to FROM semester_value WHERE semester = '$choice'";
        $time_result = execute_sql($link,"borrow",$sql_select);
        $time_row = mysqli_fetch_row($time_result);
       
        $time_from = $time_row[0];
        $time_to = $time_row[1];
        mysqli_free_result($time_result);

        $sql_item = "SELECT temp.name,SUM(count_cate) sum_data FROM (SELECT item_info.itemNo,(SELECT COUNT(*) FROM borowperson WHERE borowperson.itemNo = item_info.itemNo AND Date('$time_from') <= Date(lendTime) AND Date('$time_to') >= Date(lendTime)) AS count_cate,item_category.name FROM item_info INNER JOIN item_category on item_category.num =item_info.catergory) AS temp GROUP BY temp.name";
        $item_result = execute_sql($link,"borrow",$sql_item);
        echo "<div><p class='subtitle is-5' style='margin-bottom:1%;'>學期:".$choice." </p></div>";
        echo "<div><p class='subtitle is-5' style='margin-bottom:1%;'>設備</p></div>";
        echo "<table class='table is-bordered' align='center'>";
        echo "<tr><th>名稱</th><th>次數</th></tr>";
        while($row_item = mysqli_fetch_row($item_result)){
           echo "<tr><td>".$row_item[0]."</td><td>".$row_item[1]."</td></tr>";
        }
        echo "</table>";

        $sql_lab = "SELECT lab_category.num,IFNULL(count_data,0) FROM lab_category LEFT JOIN (SELECT borrowlab.lab_num as num,COUNT(*) AS count_data FROM borrowlab WHERE Date('$time_from') <= Date(lendTime) AND Date('$time_to') >= Date(lendTime) GROUP BY lab_num) AS temp on temp.num = lab_category.num ORDER BY lab_category.num ASC";
        $lab_result = execute_sql($link,"borrow",$sql_lab);
        
        echo "<div><p class='subtitle is-5' style='margin-bottom:1%;'>實驗室</p></div>";
        echo "<table class='table is-bordered' align='center'>";
        echo "<tr><th>名稱</th><th>次數</th></tr>";
        while($row_lab = mysqli_fetch_row($lab_result)){
           echo "<tr><td>".$row_lab[0]."</td><td>".$row_lab[1]."</td></tr>";
        }
        echo "</table>";

        $sql_room = "SELECT classroom.num,IFNULL(count_data,0) FROM classroom LEFT JOIN (SELECT roomborrow.roomNo as num,COUNT(*) AS count_data FROM roomborrow WHERE Date('$time_from') <= Date(lendTime) AND Date('$time_to') >= Date(lendTime) GROUP BY roomNo) AS temp on temp.num = classroom.num ORDER BY classroom.num ASC";
        $room_result = execute_sql($link,"borrow",$sql_room);
        
        echo "<div><p class='subtitle is-5' style='margin-bottom:1%;'>教室</p></div>";
        echo "<table class='table is-bordered' align='center'>";
        echo "<tr><th>名稱</th><th>次數</th></tr>";
        while($row_room = mysqli_fetch_row($room_result)){
           echo "<tr><td>".$row_room[0]."</td><td>".$row_room[1]."</td></tr>";
        }
        echo "</table>";

    }
        

?>


</table>
</div>
<?php

?>

</form>
</div>
<div style="margin-bottom:2%">



</div>
<?php
        // todo 顯示換頁按鈕
            if($type != "class" && $show_page){
                pagetag($page,$total_page,$showside);
            }        
        
        
        
        mysqli_close($link);
    }
    
    function time_check($item_time){
        $time = $item_time;
        if(strtotime("now") > strtotime($item_time)){
            $time = "尚無借用";
        }
        return $time;
    }

    function usingOrNot($status,$name){
        
        if($status == 1){
            return "<td id='borrow_using'bgcolor='#F08080'>$name</td>";
        }
            return "<td >空閒中</td>";
    }
?>