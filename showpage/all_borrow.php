<?php
session_start();
include("../../boom/check_fun.php");
require("../../boom/dbtools.inc.php");
$link = create_connection();
$requestcode = 404;
$item_bool = false;
$lab_bool = false;
$room_bool = false;

$i = 1;      
$mod = 0;
    if(isset($_POST['mod'])){
        $mod = $_POST['mod'];
    }   


    if($mod == 0 ){
        $sql = "SELECT * FROM item_category";
        $sql_2 = "SELECT num,name,open_off,off_time FROM lab_category";
        $sql_3 = "SELECT * FROM classroom";
        
        
        
        $result_item = execute_sql($link,"borrow",$sql);
        $result_lab = execute_sql($link,"borrow",$sql_2);
        $result_room = execute_sql($link,"borrow",$sql_3);
        if(mysqli_num_rows($result_item) > 0){
            //設備
            echo "<h4 class='subtitle is-4'>設備</h4>";
            echo "<table class='table' align='center'>";
            echo "<thead><th>編號</th><th>名稱</th><th>是否可借用</th><th>停用時間</th><th></th></thead>";
            while($row = mysqli_fetch_array($result_item)){
                echo "<tr>";
                for($j = 0; $j<mysqli_num_fields($result_item);$j++){
                    if($j == 2){
                        if($row[$j] == 0){
                            echo "<td>可借用</td>";
                        }else if($row[$j] == 1){
                            echo "<td>停止借用</td>";
                        }
                    }else{
                        echo "<td>".$row[$j]."</td>";
                    }
                    
                }
                 $item_id = $row[0];
                echo "<td><input type='checkbox' name = 'checkall' id='A@$item_id'</td>";
                echo "<td><a class='button is-dark is-outlined' onclick=borrow_detail(1,'A@".$item_id."')>修改附註</a></td>";
                echo "</tr>";
            }
            echo "</table>";
            $item_bool = true;
        }
    
        if(mysqli_num_rows($result_lab) > 0){
            //實驗室
            echo "<h4 class='subtitle is-4'>實驗室</h4>";
            echo "<table class='table'>";           
            echo "<thead><th>編號</th><th>名稱</th><th>是否可借用</th><th>停用時間</th><th></th></thead>";
            
            while($row = mysqli_fetch_array($result_lab)){
                echo "<tr>";
                for($j = 0; $j<mysqli_num_fields($result_lab);$j++){
                    if($j == 2){
                        if($row[$j] == 0){
                            echo "<td>可借用</td>";
                        }else if($row[$j] == 1){
                            echo "<td>停止借用</td>";
                        }else if($row[$j] == 2){
                            echo "<td>Meeting中</td>";
                        }
                        
                    }else{                    
                        echo "<td>".$row[$j]."</td>";
                    }
                }
                $lab_id = $row[0];
                echo "<td><input type='checkbox' name = 'checkall' id='B@$lab_id'</td>";
            
                echo "</tr>";            
            }
            echo "</table>";
            $lab_bool = true;
        }
    
        if(mysqli_num_rows($result_room) > 0){
            //教室
            echo "<h4 class='subtitle is-4'>教室</h4>";
            echo "<table class='table'>";           
            echo "<thead><th>編號</th><th>名稱</th><th>是否可借用</th><th>停用時間</th><th></th></thead>";  
            while($row = mysqli_fetch_array($result_room)){        
                echo "<tr>";
                for($j = 0; $j<mysqli_num_fields($result_room);$j++){
                    if($j == 2){
                        if($row[$j] == 0){
                            echo "<td>可借用</td>";
                        }else if($row[$j] == 1){
                            echo "<td>停止借用</td>";
                        }
                    }else{
                        echo "<td>".$row[$j]."</td>";
                    }
                }
                $room_id = $row[0];
                echo "<td><input type='checkbox' name ='checkall' id='C@$room_id'</td>";
               
                echo "</tr>";            
            }
            echo "</table>";
            $room_bool = true;
        }
    
        if($lab_bool || $item_bool || $room_bool){
            echo "<div><input type='text' id='date_pick'></div>";
            echo "<a class='button is-dark is-outlined' onclick='disable_borrow(0)'>停止借用</a> ";
            echo "<a class='button is-dark is-outlined' onclick='disable_borrow(1)'>開啟借用</a>";          
            echo "<input type='checkbox' data-act='checkall' data-scope='[name=checkall]' style='margin-left:1%' onclick='checkBoxAll()'>全選";
        }    
        mysqli_free_result($result_item);
        mysqli_free_result($result_lab);
        mysqli_free_result($result_room);

    }else if($mod ==1){
        if(isset($_POST['item_id'])){
            $id = $_POST['item_id'];
            $temp_id = explode("@",$id);
            echo "<form id='post_ps'>"; 
            echo "<table class='table' align='center'>";  
              
            $sql_other = "SELECT * FROM borrow_note WHERE category = '".$temp_id[1]."' order by other ASC";          
            $sql = "SELECT * FROM item_category WHERE num = '".$temp_id[1]."'";            
                                      
            
            $other_result = execute_sql($link,"borrow",$sql_other);
         
            $name_row =  mysqli_fetch_assoc(execute_sql($link,"borrow",$sql));
            echo "<tr><td>".$name_row['num']."</td><td>".$name_row['name']."</td></tr>";
            echo "<input type='hidden' name='item_id' value = '".$temp_id[1]."'>";
            if(mysqli_num_rows($other_result) > 0){
                while($row = mysqli_fetch_assoc($other_result)){
                    if($row['other'] == 0){
                        echo "<tr><td>內附:</td><td><input name='other_item' value ='".$row['content']."'></td></tr>";
                    }else if($row['other'] == 1){
                        echo "<tr><td>可額外借:</td><td><textarea name='ps_item' >".$row['content']."</textarea></td></tr>";
                    }                    
               }
            }else{
                echo "<tr><td>內附:</td><td><input name='other_item' ></td></tr>";
                echo "<tr><td>可額外借:</td><td><textarea name='ps_item'></textarea></td></tr>";
            }
           
            echo "</table></form><div><a class='button is-dark is-outlined' onclick='change_note_post()'>確認修改</a> <a class='button is-dark is-outlined' onclick='borrow_detail(0)'>返回</a></div>";
        }
    }
  


mysqli_close($link);

?>
<script>
function borrow_detail(a,id){
    var post_data = {}
    if(a == 1){
        post_data = {item_id:id,mod:a}
    }
    $.ajax({
        type:"post",
        url:"/boom/showpage/all_borrow.php",     
        data:post_data,
        success:function(data){
            $("#displaytable").html(data)
        }
    })
}

function change_note_post(){
    swal({
        title: '確定修改?',        
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '確定'
        }).then(function(result) {
        if (result) {
           $.ajax({
            type:"post",
            url:"/boom/do/update_ps.php",     
            data:$('#post_ps').serialize(),
            dataType:"json",
            success:function(data){
                swal(data.numCode[1])
                if(data.numCode[0]== 200){
                    borrow_detail(0)
                }
               
            }
           })
        }
    })
}

$("#date_pick").datepicker({
    dateFormat:"yy-mm-dd",
    minDate:0
})

function disable_borrow(mod){
    var i =0;
    var do_ajax = true;
    var temparray = [];
    var date_pick = "0";
    if(check_box_checked()){
        if(mod == 0){
        
            date_pick = $("#date_pick").val();
            
            if(date_pick.length > 0){
                var reg = /([1-9][0-9][0-9][0-9])[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])/
                if(reg.test(date_pick)){
                            
                }else{
                    do_ajax = false;
                    swal("日期格式錯誤 xxxx-xx-xx");
                }
            }else{
                swal("請先選擇時間");
            }
        }
    }else{
        do_ajax = false
    }
    
    
    if(do_ajax){
        $('table').find('input[type=checkbox]').each(function() {
                    var checkbox = $(this);
                    
                    if (checkbox.prop('checked') == true) {
                        temparray[i] = checkbox.attr('id');
                        i++;
                    }
        });

        $.ajax({
            type:"post",
            url:"/boom/do/item_open_off.php",
            dataType:"json",
            data:{itemdata:temparray,date:date_pick,mod:mod},
            success:function(data){
                swal(data.numCode[1])
		if(data.numCode[0] == 200){
			get_item();
		}
            }
        })
    }
}
</script>