<?php
session_start();
require("../../boom/dbtools.inc.php");
$link = create_connection();
$requestcode = 404;
$item_bool = false;
$lab_bool = false;
$room_bool = false;

$i = 1;
if(isset($_POST['id'])){
    
        $id = $_POST['id'];    

        $sql = "SELECT tempborrow._id,tempborrow.studentID,tempborrow.personName,tempborrow.itemNo,item_info.specification,tempborrow.note,tempborrow.insert_time,tempborrow.expect_return_time FROM tempborrow INNER JOIN item_info on studentID =(SELECT studentID FROM student WHERE studentID= '$id' ) AND tempborrow.status ='0' AND tempborrow.itemNo = item_info.itemNo";
        $sql_2 = "SELECT temp._id,temp.studentID,temp.personName,temp.itemNo,category.name,temp.insert_time FROM templab AS temp inner join lab_category AS category on  temp.studentID = (SELECT studentID FROM student WHERE studentID= '$id' ) AND temp.status = '0' AND temp.category = category.num";
        $sql_3 = "SELECT roomborrow.id,roomborrow.studentID,roomborrow.personName,roomborrow.period,roomborrow.week,roomborrow.roomNo,roomborrow.insert_time FROM roomborrow INNER JOIN student on (student.cardId = '$id' ) AND roomborrow.studentID = student.studentID AND roomborrow.status = 0";
   
    
    
    $result_item = execute_sql($link,"borrow",$sql);
    $result_lab = execute_sql($link,"borrow",$sql_2);
    $result_room = execute_sql($link,"borrow",$sql_3);
    if(isset($_POST['id'])){
        echo "<h5 id='borrow_user' data = '$id' class='subtitle is-5'>借用者:$id</5>";
    }
    if(mysqli_num_rows($result_item) > 0){
        $k = 0;
        echo "<h4 class='subtitle is-4'>設備</h4>";
        echo "<table class='table' align='center'>";
        echo "<thead><th>編號</th><th>學號</th><th>姓名</th><th>物品編號</th><th>規格</th><th>附註</th><th>申請時間</th><th>預期歸還</th><th><th></th></th></thead>";
        while($row = mysqli_fetch_array($result_item)){
            echo "<tr>";
            for($j = 0; $j<mysqli_num_fields($result_item);$j++){
               
                echo "<td>".$row[$j]."</td>";
            }
            $item_id = $row[0];
            $date_time = new DateTime($row[6]);
            $start = $date_time -> format('Y-m-d');
            $date_time = new DateTime($row[7]);
            $end = $date_time -> format('Y-m-d');
            if(round((strtotime($end) - strtotime($start))/3600/24) > 0){
                echo "<td><form method='post' id='print_borrow".$k."' action='/boom/showpage/show_long_borrow.php' target='_blank'><input type='hidden' name='item_id' value='$item_id' ></form>";
                echo "<a class='button is-dark is-outlined' onclick='print_borrow($k)'>長期借用單</a></td>";
                
            }
            echo "<td><input type='checkbox' id='A@$item_id'></td>";
            $k++;
            echo "</tr>";
        }
        echo "</table>";
        $item_bool = true;
    }

    if(mysqli_num_rows($result_lab) > 0){
        echo "<h4 class='subtitle is-4'>實驗室</h4>";
        echo "<table class='table' align='center'>";           
        echo "<thead><th>編號</th><th>學號</th><th>姓名</th><th>實驗室位置</th><th>實驗室</th><th>申請時間</th><th></th></thead>";
        
        while($row = mysqli_fetch_array($result_lab)){
            echo "<tr>";
            for($j = 0; $j<mysqli_num_fields($result_lab);$j++){
                echo "<td>".$row[$j]."</td>";
            }
            $lab_id = $row[0];
            echo "<td><input type='checkbox' id='B@$lab_id'></td>";
            echo "</tr>";            
        }
        echo "</table>";
        $lab_bool = true;
    }

    if(mysqli_num_rows($result_room) > 0){
        echo "<h4 class='subtitle is-4'>教室</h4>";
        echo "<table class='table' align='center'>";           
        echo "<thead><th>編號</th><th>學號</th><th>姓名</th><th>節</th><th>星期</th><th>教室</th><th>申請時間</th></thead>";    
        while($row = mysqli_fetch_array($result_room)){        
            echo "<tr>";
            for($j = 0; $j<mysqli_num_fields($result_room);$j++){
                echo "<td>".$row[$j]."</td>";
            }
            $room_id = $row[0];
            echo "<td><input type='checkbox' name ='data_confirm[]' id='C@$room_id'></td>";
            echo "</tr>";            
        }
        echo "</table>";
        $room_bool = true;
    }

    if($lab_bool || $item_bool || $room_bool){        
        echo "<a class='button is-dark is-outlined' onclick='send_cancel()' style='margin-left:1%'>取消借用</a>";
        echo "<input type='checkbox' data-act='checkall' data-scope='[type=checkbox]' style='margin-left:1%' onclick='checkBoxAll()'>全選";
    }
}
mysqli_free_result($result_item);
mysqli_free_result($result_lab);
mysqli_free_result($result_room);
mysqli_close($link);

?>

<script>
function send_cancel(){
    if(check_box_checked()){
                var i =0;
                var temparray = [];
                $('table').find('input[type=checkbox]').each(function() {
                    var checkbox = $(this);
                    
                if (checkbox.prop('checked') == true) {
                    temparray[i] = checkbox.attr('id');
                    i++;
                }
            });
            var id = $("#borrow_user").attr("data");
              $.ajax({
                type:"POST",
                url:"/boom/do/do_cancel.php",
                dataType:"json",
                data:{ user_id: id,confirmData:temparray},
                success:function(data){
                    swal(data.numCode[1])
                    if(data.numCode[0] == 200){
                      
                            $("#displaytable").html("")
							count = 0;
							$.ajax({
								type:"POST",
								url:"/boom/showpage/user_get_borrow.php",
								dataType:"html",
								data:{id:<?php echo"'".$id."'";?>},
								success:function(data){
									$("#displaytable").html(data);
								}    
								});
                        
                    }
                }    
                });
            }
}

function print_borrow(a){
    var temp = "print_borrow" + a.toString();
    
    document.getElementById(temp).submit()
}

</script>