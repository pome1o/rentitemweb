<div>
<form  method="post" data-act="itemChooseForm" id="borrow_form" name="form1" action="/boom/showpage/show_long_borrow.php" target="_blank">

<?php
require_once("../dbtools.inc.php");


if(isset($_GET['choice']) && isset($_GET['type'])){
    date_default_timezone_set('Asia/Taipei');
    $choice = $_GET['choice'];
    $type = $_GET['type'];
    $link = create_connection();
    $day_week = date('w');
    switch ($type) {
        case "item":
        $type_note = 0;
        $sql_select =  "SELECT * FROM item_info where catergory='$choice'";
        break;

        case "class":
        $type_note = 2;
        
        $sql_select = "SELECT * FROM classperiod1 WHERE room_no = '$choice'  ORDER by period ASC  , day ASC";
        
        break;

        case "lab":
        $type_note = 1;    
        $sql_select =  "SELECT info.lab_num AS lab_id,info.seat_num AS seat_num ,category.name AS lab_name,usingORnot FROM laboratory_info AS info INNER JOIN lab_category AS category on info.lab_num = category.num AND info.lab_num = $choice order by info.seat_num ASC";
        break;                        
    }
if($choice != "no"){
    $page = 1;
    if(isset($_GET['page'])){
        $page = $_GET['page'];
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
            echo "<div class='subtitle is-4' style='color:red;'>物品已借完</div>";
        }
        
        mysqli_data_seek($result,$started);
        $j=1;
        if($type == "item"){
            
           
            echo "<div>";
          
                
                echo "<table class='table table is-hoverable is-bordered' id='borrow_table' align='center' >";

                echo "<tr><th bgcolor='#B0E0E6'>編號</th><th bgcolor='#B0E0E6'>型號</th><th bgcolor='#B0E0E6'>廠牌</th><th bgcolor='#B0E0E6'>預計歸還時間</th>";
                while( $row = mysqli_fetch_assoc($result) and $j <=$per_page){
                    echo "<tr><td  bgcolor='#FFF2AF'>";
                    echo "<span>".$row['itemNo']."</span></td>";
                    echo "<td  bgcolor='#FFF2AF' ><span>".$row['specification']."</span></td>";
                    echo "<td  bgcolor='#FFF2AF' ><span>".$row['brand']."</span></td>";
                    $today = date('Y-m-d');
                    $sql_time = "SELECT personName FROM tempborrow WHERE itemNo = '".$row['itemNo']."' AND status = '1' AND '$today' BETWEEN DATE(lendTime) AND DATE(expect_return_time) limit 1";
                    $result_time = execute_sql($link,"borrow",$sql_time);
                    $row_time = mysqli_fetch_row($result_time);
                    
                    echo "<td  bgcolor='#FFF2AF' ><span>".time_check($row_time[0])."</span></td>";
                    echo "</tr>";
                    mysqli_free_result($result_time);
                    $j++;
                }
           
                
        }else if($type == "lab"){
            
            $today = date('Y-m-d H:i:s');

                 
                $sql_check_meet = "SELECT * FROM templab WHERE category = $choice AND  end_time > '$today'";
                $meet_result = execute_sql($link,"borrow",$sql_check_meet);
                
                if(mysqli_num_rows($meet_result) > 0){
                    $meet_row = mysqli_fetch_assoc($meet_result);
                    echo "<div><p class='subtitle is-4' style='margin-bottom:1%;'>此時段為Meeting時間".$meet_row['start_time']."~".$meet_row['end_time']."</p> </div>";
                }
                echo "<div style='display:  inline-block; vertical-align: top;'>";
                echo "<table class='table table is-hoverable is-bordered' id='borrow_table' align='center' >";  

                
                echo "<tr><th bgcolor='#B0E0E6'>名稱</th><th bgcolor='#B0E0E6'>實驗室編號</th><th bgcolor='#B0E0E6'>使用狀況</th></tr>";
                $today = date('Y-m-d');
                while( $row = mysqli_fetch_assoc($result) and $j <=$per_page){
                    echo "<tr><td style='padding:5px;' align='center'>";
                    $item_no = $row['seat_num'];
                    //SQL 確認是否使用中
                    $sql_check_using = "SELECT * FROM templab WHERE itemNo = '$item_no' AND category = '$choice' AND status >=0  limit 1";
                    $check_result = execute_sql($link,"borrow",$sql_check_using);
                    $using = 0;
                    $name ="";
                    if(mysqli_num_rows($check_result) == 1){
                        $check_row = mysqli_fetch_assoc($check_result);
                        $name = $check_row['personName'];
                        echo "<p>".$item_no."</p>";
                        $using =1;
                    }else{
                        if(strtoupper($item_no) =="MEETING"){
                            echo "<p>".$item_no."</p>";
                        }else{
                            echo $item_no;
                        }
                        
                    }                
                    echo "<td>".$choice."</td>";
                    echo usingOrNot($using,$name);
                    echo "</tr>";
                    $j++;
                }
                $sql_lab_img = "SELECT img FROM lab_category WHERE num = $choice";
                $result_img = execute_sql($link,"borrow",$sql_lab_img);
                $img_row = mysqli_fetch_assoc($result_img);
                //echo $img_row["img"];
                $img_path = $img_row["img"];   
                $show = true;
           
            
        }else if($type == "class"){
           
         
                echo "<div>";
             
                echo "<table class='table table is-hoverable is-bordered' id='borrow_table' align='center' >";
                $day_th = array("星期一","星期二","星期三","星期四","星期五");
                $per = array("第一節","第二節","第三節","第四節","休息時間","第五節","第六節","第七節","第八節");
                echo "<tr><th bgcolor='#B0E0E6'>節</th>";
                foreach($day_th as $value){
                    echo "<th bgcolor='#B0E0E6'>".$value."</th>";
                }
                echo "</tr>";
                $date = date("Y-m-d");
              
                while($row = mysqli_fetch_assoc($result) and $j <=$per_page){
                    
                    $day = $row['day'];
                    $p = $row['period'];
                    $sql_check = "SELECT * FROM roomborrow WHERE period = '$p' AND week = '$day' AND  Date(insert_time) = Date('$date') limit 1";
                    $check_result = execute_sql($link,"borrow",$sql_check);   
                    if($day == 1){
                        echo "<tr id='period_$p'  style='height:50px;'><td bgcolor='#FFEBCD'>".$per[$p-1]."</td>";     
                    }                  
                        $temp_class_name ="空堂";
                        if($row['class_name'] != "no_class"){
                            $temp_class_name = $row['class_name'];
                            echo "<td id='day_$day'>".$temp_class_name."</td>";
                        }else{
                            if(mysqli_num_rows($check_result) > 0){                       
                                
                                echo "<td id='day_$day' bgcolor ='#DDA0DD'>".$row['personName']."</td>";
                            }else{
                                echo "<td id='day_$day'>$temp_class_name</td>";
                            }
                        }
                                          
                    if($day == 5){
                        echo "</tr>";
                    }
                    
                                 
                   
                                        
                }          
        }
        $sql_note = "SELECT * FROM borrow_note WHERE type = '$type_note' AND category = '$choice'";
        $result_note = execute_sql($link,"borrow",$sql_note);
        

?>


</table>
</div>
<?php
if($type == "lab" && $show){
    if(is_file("../uploads/labs/$img_path")){
                echo "<a href='uploads/labs/$img_path' data-lightbox='example-set' data-title='$choice 實驗室座位圖'>";
                echo "<img src='uploads/labs/thumb_$img_path' width=25% height=30% align='center'>";
                echo "</a>";
    }
}    

?>

</form>
</div>
<div style="margin-bottom:2%">



</div>
<?php
        // todo 顯示換頁按鈕
            if($type != "class"){
                pagetag($page,$total_page,$showside);
            }        
        
        mysqli_free_result($result);
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