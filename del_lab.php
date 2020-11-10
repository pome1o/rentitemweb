<?php
session_start();
include("check_fun.php");
include("check_stop.php");
require_once("dbtools.inc.php");
$link = create_connection();
mysqli_select_db($link,"borrow");
$studentID = $_SESSION["studentId"];
date_default_timezone_set('Asia/Taipei');
$datetime = date("Y-m-d H:i:s");
include("header.php");
?>

<script type="text/javascript">
    
    var change = false;

    function select_change(){
        change = true;
    }
    
    function del_confirm(){
        if(change == true){
            var lab_num = document.getElementById("num").value;
            swal({
            title: '確定要刪除' + lab_num + '實驗室嗎?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText:"取消",
            confirmButtonText: '確定'
            }).then(function(result) {
            //alert(result);
            if (result) {
                myForm.submit();
            }
                    
            })
        }
        else{
            alert("請先選擇要刪除的實驗室");
        }
        
    }  
    
</script>
<?php

include("nav.php");
?>
    <div class="container">
        <div id="manyitem">
            <h1 class="title is-3" align="center">刪除實驗室</h1>
            <table align="center">
                <form id="myForm" name="myForm" method="post" action="do/del_lab_ck.php">
                    <tr>
                        <td colspan="2">
                            <select class="select is-dark" id="num" name="lab_num" onchange="select_change()">
                                <option id="lab_num">目前有的實驗室</option>
                                <?php
                                    $sql_ca = "SELECT * FROM lab_category";
                                    $catgory =  execute_sql($link,"borrow",$sql_ca);
                                    
                                    while($catgory1 = mysqli_fetch_assoc($catgory)){
                                        echo "<option value=".$catgory1['num'].">".$catgory1['name']."</option>";
                                    }
                                
                                ?>
                            </select>
                        </td>
                    </tr>
                       
                        <td><br><input class="button is-dark is-outlined" type='button'  value='刪除' onclick="del_confirm()"></td>
                </form>
            </table>
        </div>
    </div>
<?php mysqli_close($link) ?>
<?php include("footer.php");?>

