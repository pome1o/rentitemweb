<?php
session_start();
include("check_fun.php");
require_once("dbtools.inc.php");
$link = create_connection();
mysqli_select_db($link,"borrow");
date_default_timezone_set('Asia/Taipei');
$datetime = date("Y-m-d H:i:s");
include("header.php");
?>

<script type="text/javascript">
    function lab_ck(){
        //alert("t"); 
        var t = true;
        for (var i = 1; i <= 2; i++) {
            var a = document.getElementById("t" + i).value.length;
            if (a <= 0) {
                var t = false;
                break;
            }
        }
        
        for(var i = 1; i <= 2; i++) {
            var a = document.getElementById("file" + i).value.length;
            if(a <= 0){
                alert("請選擇要上傳的檔案");
                t = false;
            }
        }

        if (t == false) {
            alert("請勿留白");
        } else {
            myForm.submit();
        }
        
    }
</script>
<?php

include("nav.php");?>
    <div class="container">
        <div id="manyitem">
            <h1 class="title is-3" align="center">新增實驗室</h1>
            <table align="center">
                <form id="myForm" name="myForm" method="post" action="do/upload_lab.php" enctype="multipart/form-data">
                    <tr>
                        <td colspan="2">
                            <a href='uploads/實驗室上傳格式.xlsx' download>實驗室格式下載</a>
                            <select>
                                <option>目前有的實驗室</option>
                                <?php
                                    $sql_ca = "SELECT * FROM lab_category";
                                    $catgory =  execute_sql($link,"borrow",$sql_ca);
                                    
                                    while($catgory1 = mysqli_fetch_assoc($catgory)){
                                        echo "<option value=".$catgory1['num']." >".$catgory1['name']."</option>";
                                    }
                                
                                ?>
                            </select>
                            
                        </td>
                    </tr>
                    <tr><td>請輸入實驗室的編號(208XX) <input id="t1" type="text" name="lab_num"></td></tr>
                    <tr><td>輸入實驗室名稱(8XX實驗室) <input id="t2" type="text" name="lab_name"></td></tr>
                    <tr><td colspan='2'>實驗室檔案(CSV檔) <input type='file' id='file1' name='file[]' value='選擇檔案'></td></tr>
                        <td>實驗室座位圖(.jpg 或 .png檔) <input type='file' id='file2' name='file[]' value='選擇檔案'></td>
                    <tr><td><br><input class="button is-dark is-outlined" type='button' value='上傳' onclick="lab_ck()"></td></tr>
                </form>
            </table>
        </div>
    </div>
<?php mysqli_close($link) ?>
<?php include("footer.php");?>

