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
        
        $sql_select = "SELECT * FROM classperiod1 WHERE room_no = '$choice' AND day ='$day_week' ORDER by period ASC  , day ASC";
        echo "<div class='subtitle is-4' style='color:red;'>當日</div>";
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
            $check_can_borrow = "SELECT * FROM item_category WHERE num = '$choice' AND DATE(off_time) = DATE(NOW())";
            $can_result = execute_sql($link,"borrow",$check_can_borrow);
           
            echo "<div>";
            if(mysqli_num_rows($can_result) <= 0){
                
                echo "<table class='table table is-hoverable is-bordered' id='borrow_table' align='center' >";

                echo "<tr><th bgcolor='#B0E0E6'>編號</th><th bgcolor='#B0E0E6'>型號</th><th bgcolor='#B0E0E6'>廠牌</th><th bgcolor='#B0E0E6'>預計歸還時間</th>";
                while( $row = mysqli_fetch_assoc($result) and $j <=$per_page){
                    echo "<tr><td  bgcolor='#FFF2AF'>";
                    echo "<input id='choosebox' type='radio'  name='user_select' value=".$row['itemNo']."><span>".$row['itemNo']."</span></td>";
                    echo "<td  bgcolor='#FFF2AF' ><span>".$row['specification']."</span></td>";
                    echo "<td  bgcolor='#FFF2AF' ><span>".$row['brand']."</span></td>";
                    $sql_time = "SELECT expect_return_time FROM tempborrow WHERE itemNo = '".$row['itemNo']."' AND status = '1' order by expect_return_time DESC  limit 1";
                    $result_time = execute_sql($link,"borrow",$sql_time);
                    $row_time = mysqli_fetch_row($result_time);
                    
                    echo "<td  bgcolor='#FFF2AF' ><span>".time_check($row_time[0])."</span></td>";
                    echo "</tr>";
                    mysqli_free_result($result_time);
                    $j++;
                }
            }else{
                echo "<div><p>此設備暫時停止借用</p></div>";
            }
                
        }else if($type == "lab"){
            $check_can_borrow = "SELECT * FROM lab_category WHERE num = '$choice' AND DATE(off_time) = DATE(NOW())";
            $can_result = execute_sql($link,"borrow",$check_can_borrow);
            $today = date('Y-m-d H:i:s');

            if(mysqli_num_rows($can_result) <= 0){       
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
                    if(mysqli_num_rows($check_result) == 1){
                        echo "<p>".$item_no."</p>";
                        $using =1;
                    }else{
                        if(strtoupper($item_no) =="MEETING"){
                            echo "<p>".$item_no."</p>";
                        }else{
                            echo "<input type='radio' id='choosebox' name='user_select' value=".$item_no.">".$item_no;
                        }
                        
                    }                
                    echo "<td>".$choice."</td>";
                    echo usingOrNot($using);
                    echo "</tr>";
                    $j++;
                }
                $sql_lab_img = "SELECT img FROM lab_category WHERE num = $choice";
                $result_img = execute_sql($link,"borrow",$sql_lab_img);
                $img_row = mysqli_fetch_assoc($result_img);
                //echo $img_row["img"];
                $img_path = $img_row["img"];   
                $show = true;
            }else{
                echo "<div><p>實驗室今日暫停借用</p></div>";
            }
            
        }else if($type == "class"){
            $check_can_borrow = "SELECT * FROM classroom WHERE num = '$choice' AND DATE(off_time) = DATE(NOW())";
            $can_result = execute_sql($link,"borrow",$check_can_borrow);
         
            echo "<div>";
            if(mysqli_num_rows($can_result) <= 0){ 
                echo "<table class='table table is-hoverable is-bordered' id='borrow_table' align='center' >";
                $day_th = array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
                $per = array("第一節","第二節","第三節","第四節","休息時間","第五節","第六節","第七節","第八節");
                echo "<tr><th bgcolor='#B0E0E6'>節</th><th bgcolor='#B0E0E6'>".$day_th[$day_week]."</th></tr>";
                $date = date("Y-m-d");
                
                while($row = mysqli_fetch_assoc($result) and $j <=$per_page){
                    
                    $day = $row['day'];
                    $p = $row['period'];
                    $sql_check = "SELECT * FROM roomborrow WHERE period = '$p' AND week = '$day' AND  Date(insert_time) = Date('$date') limit 1";
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
                echo "<div><p>教室今日暫停借用</p></div>";   
            }
        }
        $sql_note = "SELECT * FROM borrow_note WHERE category = '$choice'";
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

if($type != "lab"){
    $count = mysqli_num_rows($result_note);
    $text_content = "";
    $text_note = "";
    if($count > 0){        
        while($row_note = mysqli_fetch_assoc($result_note)){
            if($row_note['other'] == 0){
                $text_content = "<div><p>內附:".$row_note['content']."</p></div>";
            }else{
                $text_note = "<div><textarea rows='4' cols='50' name='note' placeholder='".$row_note['content']."'></textarea></div>";
            }
        }
    }
    echo $text_content;
        
    if($type =="class"){
       echo "<div><p>當日:教室借用需要5個人刷卡</p></div>";
    }else{
        echo "<div><input type='text' placeholder='借用時間' id='start_time' name='start_time' onkeypress='return false;'> ~ <input type='text' placeholder='歸還時間' id='end_time' name='end_time' disabled='true' onkeypress='return false;'></div>";
    }    
    echo $text_note;
}

?>

</form>
</div>
<div style="margin-bottom:2%">
<a type="button" class="button is-dark is-outlined" name="hi" onclick="check_choose_simple()" >借用</a>
<a type="button" class="button is-dark is-outlined" value="返回" onclick="location.href='/boom/borrowitem.php'" >返回</a>
<?php
    if($type == "lab"){
        $time_array = ['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00'];
        echo "<a type='button' class='button is-dark is-outlined' value='預約MEEETING' onclick='meeting_pick()' >預約MEEETING</a>";
        echo "<div class='class_confirm' title='請選擇日期時間'><input type='text' id='meeting_date' placeholder='日期'><p>開始時間</p><select id='meet_start'>";
      
        for($i = 0; $i < count($time_array); $i++){
            if($i ==8){
               continue;
            }
            echo "<option value = '$i'>".$time_array[$i]."</option>";
        }   
        echo "</select><div><p>結束時間</p><select id='meet_end'>";
        for($i = 0; $i < count($time_array); $i++){
            if($i==0){
                continue;
            }           
            echo "<option id='end_option' value ='$i'>".$time_array[$i]."</option>";
        }   
        echo "</select></div><div><button type='button' class='button is-dark is-outlined' onclick='meeting_ok()'>確認</button>        
        </div></div>";
    }

    
?>

</div>
<script>
//物品選擇 選時間

$("input[type=radio]").click(function(){   
    var borrow_type = $('#borrow_type').val();
    var a;    
    
    if(borrow_type !="lab"){
        if(borrow_type =="item"){
            a ={time:$(this).val(),type:borrow_type}
        }else if(borrow_type=="class"){
            var col = $(this).closest("td").index();
            var row = $(this).closest("tr").index();
            a ={time:$(this).val(),type:borrow_type,period:row,day:col}
        }
        $.ajax({
                type:"post",
                async:false,
                data:a,
                url:"/boom/do/check_item_time.php",
                dataType:"json",
                success:function(data){
                    var DisableDate = [];
                    for(var i = 0; i < data; i++){
                        DisableDate.push(data[i]);
                        }
                        show_start_date(data)                            
            }
        })    
    }  
}) 

function show_start_date(DisableDate){
    var default_start = new Date(DisableDate[DisableDate.length -2]);    
    default_start.setDate(default_start.getDate() + 1)
    
    $("#start_time").datepicker("destroy")
    $("#start_time").datepicker({
                minDate:0,
                dateFormat:"yy-mm-dd",
                defaultDate: default_start.getFullYear()+"-"+(parseInt(default_start.getMonth())+1)+"-"+default_start.getDate(),
                beforeShowDay: function(date){ 
                    var temp_mon =(date.getMonth()+1);
                    var temp_date = date.getDate();
                    if(temp_mon < 10 ){
                        temp_mon = "0"+(date.getMonth()+1)
                    }
                    if(temp_date < 10){
                        temp_date = "0" + date.getDate()
                    }                                    
                    var startDate = date.getFullYear() + "-" +temp_mon + "-" + temp_date
                    
                    var datearray = [true,""];
                    $.each(DisableDate,function(key,value){
                        if(value == startDate || date.getDay() == 6 || date.getDay() == 0){
                            datearray = [false,"","不可選"];
                        }
                    });
					
                    return datearray;
                },
                onSelect:function(dateText,inst){
                    $("#end_time").prop("disabled",false)
                    var mydate = $(this).datepicker('getDate');
                    var mydate2 = $(this).datepicker('getDate');
                    mydate2.setDate(mydate2.getDate() + 14)
                    var format = $.datepicker.formatDate("yy-mm-dd",mydate2)                      
                    $("#end_time").datepicker("option","minDate",mydate)                                    
                    $("#end_time").datepicker("option","maxDate",format)                  
                   
                }
    })
    $('#end_time').datepicker({       
        dateFormat: 'yy-mm-dd',      
        beforeShowDay: function(date){ 
                    var temp_mon =(date.getMonth()+1);
                    var temp_date = date.getDate();
                    if(temp_mon < 10 ){
                        temp_mon = "0"+(date.getMonth()+1)
                    }
                    if(temp_date < 10){
                        temp_date = "0" + date.getDate()
                    }                                    
                    var startDate = date.getFullYear() + "-" +temp_mon + "-" + temp_date
                    var datearray = [true,""];
                    $.each(DisableDate,function(key,value){
                        if(value == startDate || date.getDay() == 6 || date.getDay() == 0){
                            datearray = [false,"","不可選"];
                        }
                    });
                    return datearray;
                }
    })
    
}

function meeting_pick(){      
    $(".class_confirm").dialog();
    $("#meeting_date").datepicker({
         dateFormat:"yy-mm-dd",
         minDate:0
     });   
}

function meeting_ok(){
    var do_post = true;    
    var date_time = $("#meeting_date").val();
    if($('#meet_start').val() >= $('#meet_end').val()){
        swal("時間錯誤");
        do_post = false
    }
    if(date_time.length > 0){
        var reg = /([1-9][0-9][0-9][0-9])[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])/
        if(!reg.test(date_time)){
            swal("日期錯誤")
            do_post = false
        }
    }

    if(do_post){
        $.ajax({
                type:"POST",
                url:"/boom/do/doborrow.php",
                data:"type=lab" + "&lab_cate=" + $('#itemselect').val() + "&user_select=Meeting" + "&date_time=" + date_time + "&meet_start=" + $('#meet_start').val() + "&meet_end=" + $('#meet_end').val(),
                dataType:"json",
                success:function(data){                            
                    swal(data.numCode[1]);                       
                    if(data.numCode[0] == "200"){
                        droplist_show();
                    }
                }
            });
    }

}
</script>
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

    function usingOrNot($status){
        if($status == 1){
            return "<td id='borrow_using'bgcolor='#F08080'>使用中</td>";
        }
            return "<td >空閒中</td>";
    }
?>