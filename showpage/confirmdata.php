<?php
session_start();
include("../../boom/check_fun.php");
require("../../boom/dbtools.inc.php");
$link = create_connection();
$requestcode = 404;
$item_bool = false;
$lab_bool = false;
$room_bool = false;
$all = 1;
$i = 1;
if(isset($_POST['id']) || isset($_POST['all'])){
    if(isset($_POST['id'])){
        $id = $_POST['id'];
    }
    if(isset($_POST['all'])){
        $all = $_POST['all'];
    }
    
    if($all == 1){       
        $sql = "SELECT tempborrow._id,tempborrow.studentID,tempborrow.personName,tempborrow.itemNo,item_info.specification,tempborrow.note,tempborrow.insert_time,tempborrow.expect_return_time FROM tempborrow INNER JOIN item_info on  tempborrow.status ='0' AND tempborrow.itemNo = item_info.itemNo";
        $sql_2 = "SELECT temp._id,temp.studentID,temp.personName,temp.itemNo,category.name,temp.insert_time,temp.start_time,temp.end_time FROM templab AS temp inner join lab_category AS category on   temp.status = '0' AND temp.category = category.num";
        $sql_3 = "SELECT roomborrow.id,roomborrow.studentID,roomborrow.personName,roomborrow.period,roomborrow.week,roomborrow.roomNo,roomborrow.insert_time FROM roomborrow INNER JOIN student on  roomborrow.studentID = student.studentID AND roomborrow.status = 0";
    }else{
        $sql = "SELECT tempborrow._id,tempborrow.studentID,tempborrow.personName,tempborrow.itemNo,item_info.specification,tempborrow.note,tempborrow.insert_time,tempborrow.expect_return_time FROM tempborrow INNER JOIN item_info on studentID =(SELECT studentID FROM student WHERE studentID= '$id' OR cardId = '$id') AND tempborrow.status ='0' AND tempborrow.itemNo = item_info.itemNo";
        $sql_2 = "SELECT temp._id,temp.studentID,temp.personName,temp.itemNo,category.name,temp.insert_time,temp.start_time,temp.end_time FROM templab AS temp inner join lab_category AS category on  temp.studentID = (SELECT studentID FROM student WHERE studentID= '$id' OR cardId = '$id') AND temp.status = '0' AND temp.category = category.num";
        $sql_3 = "SELECT roomborrow.id,roomborrow.studentID,roomborrow.personName,roomborrow.period,roomborrow.week,roomborrow.roomNo,roomborrow.insert_time FROM roomborrow INNER JOIN student on (student.cardId = '$id' OR student.studentID = '$id') AND roomborrow.studentID = student.studentID AND roomborrow.status = 0";
    }
    
    
    $result_item = execute_sql($link,"borrow",$sql);
    $result_lab = execute_sql($link,"borrow",$sql_2);
    $result_room = execute_sql($link,"borrow",$sql_3);
    if(isset($_POST['id'])){
        echo "<h5 id='borrow_user' data = '$id' class='subtitle is-5'>借用者:$id</5>";
    }
    if(mysqli_num_rows($result_item) > 0){
        echo "<h4 class='subtitle is-4'>設備</h4>";
        echo "<table class='table' align='center'>";
        echo "<thead><th>編號</th><th>學號</th><th>姓名</th><th>物品編號</th><th>規格</th><th>附註</th><th>申請時間</th><th>預期歸還</th></thead>";
        while($row = mysqli_fetch_array($result_item)){
            echo "<tr>";
            for($j = 0; $j<mysqli_num_fields($result_item);$j++){
               
                echo "<td>".$row[$j]."</td>";
            }
             $item_id = $row[0];
             if($all != 1){
                echo "<td><input type='checkbox' name = 'checkall' id='A@$item_id'</td>";
             }
                
                         
            echo "</tr>";
        }
        echo "</table>";
        $item_bool = true;
    }

    if(mysqli_num_rows($result_lab) > 0){
        echo "<h4 class='subtitle is-4'>實驗室</h4>";
        echo "<table class='table'>";           
        echo "<thead><th>編號</th><th>學號</th><th>姓名</th><th>實驗室位置</th><th>實驗室</th><th>申請時間</th><th>Meeting起</th><th>Meeting結束</th><th></th></thead>";
        
        while($row = mysqli_fetch_array($result_lab)){
            echo "<tr>";
            for($j = 0; $j<mysqli_num_fields($result_lab);$j++){
                if($row[3] == "Meeting"){

                }else{
                    if($j == 6 || $j == 7){
                        continue;
                    }
                }
                echo "<td>".$row[$j]."</td>";
            }
            $lab_id = $row[0];
            if($all != 1){
                echo "<td><input type='checkbox' name = 'checkall' id='B@$lab_id'</td>";
            }
            echo "</tr>";            
        }
        echo "</table>";
        $lab_bool = true;
    }

    if(mysqli_num_rows($result_room) > 0){
        echo "<h4 class='subtitle is-4'>教室</h4>";
        echo "<table class='table'>";           
        echo "<thead><th>編號</th><th>學號</th><th>姓名</th><th>節</th><th>星期</th><th>教室</th><th>申請時間</th></thead>";    
        while($row = mysqli_fetch_array($result_room)){        
            echo "<tr>";
            for($j = 0; $j<mysqli_num_fields($result_room);$j++){
                echo "<td>".$row[$j]."</td>";
            }
            $room_id = $row[0];
            if($all != 1){
                echo "<td><input type='checkbox' name ='nocheck' id='C@$room_id'</td>";
            }
            echo "</tr>";            
        }
        echo "</table>";
        $room_bool = true;
    }

    if(($lab_bool || $item_bool || $room_bool) && $all != 1){
        echo "<a class='button is-dark is-outlined' onclick='sendConfirmOrReject(0)'>確認</a>";
        echo "<a class='button is-dark is-outlined' onclick='sendConfirmOrReject(1)' style='margin-left:1%'>駁回</a>";
        echo "<input type='checkbox' data-act='checkall' data-scope='[name=checkall]' style='margin-left:1%' onclick='checkBoxAll()'>全選";
    }
    echo "<div class='class_confirm' title='Basic dialog'>";
    echo "<form id='check_room_name'>";    
    echo "<input type='text' name='check_name[]'>";
    echo "<input type='text' name='check_name[]'>";
    echo "<input type='text' name='check_name[]'>";
    echo "<input type='text' name='check_name[]'>";
    echo "<input type='text' name='check_name[]'></form>";
    echo "<button type='button' onclick='room_check()'>確認</button>";
    echo "</div>";
}
mysqli_free_result($result_item);
mysqli_free_result($result_lab);
mysqli_free_result($result_room);
mysqli_close($link);

?>
<script>
$('input[name="nocheck"]').on('change', function() {
    if($(this).is(":checked")) {
        $(".class_confirm").dialog();        
    }
});

function room_check(){
    var id_array = new Array();
    var do_thing = false;
    $("input[name='check_name[]']").each(function(){
        if($(this).val().length > 0){
            if(id_array.indexOf($(this).val()) == -1){
                id_array.push($(this).val())
                do_thing = true;
            }else{
                do_thing = false;
            return false;
            }     
        }else{
            do_thing = false
            return false
        }
           
    })
    if(do_thing){
        $(".class_confirm").dialog('close'); 
    }else{
        swal("卡號重複");
    }
    $('input[name="nocheck"]').prop('checked',do_thing)    
}
</script>