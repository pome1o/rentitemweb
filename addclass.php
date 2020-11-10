<?php
session_start();
include("check_fun.php");
require_once("dbtools.inc.php");
$link = create_connection();
mysqli_select_db($link,"borrow");
$studentID = $_SESSION["studentId"];
$sqlstdname = "SELECT personName FROM student WHERE studentID =".$studentID;
$stdname = execute_sql($link,"borrow",$sqlstdname);
$okname = mysqli_fetch_row($stdname);
date_default_timezone_set('Asia/Taipei');
$datetime = date("Y-m-d H:i:s");
include("header.php");
include("nav.php");?>
    <div class="container">
        <div id="manyitem">
            <h1 align="center">教室新增</h1>
            <table align="center">
                <form id="doform" name="doform" method="post" action="do/uploadclass.php" enctype="multipart/form-data">
                    <tr>
                        <td colspan="2">
                            <a href='教室上傳格式.csv' download>教室格式下載</a>
                            <select>
                                <option>目前有的教室</option>
                                <?php
                                    $sql_ca = "SELECT * FROM classroom";
                                    $catgory =  execute_sql($link,"borrow",$sql_ca);
                                    
                                    while($catgory1 = mysqli_fetch_assoc($catgory)){
                                        echo "<option value=".$catgory1['roomNo']." >".$catgory1['roomNo']."</option>";
                                    }
                                
                                ?>
                                    </select>
                        </td>
                    </tr>
                    <tr>
                        <td>請另存成csv檔,並以　，為欄位分隔　＂為文字分隔
                        </td>
                    </tr>
                    <tr>
                        <td>
                            輸入教室編號:<input id="t1" type="text" name="roomno">

                        </td>

                    </tr>
                    <tr>
                        <td>
                            輸入教室名稱:<input id="t2" type="text" name="roomname">
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'><input type='file' id='fileup' name='fileup' value='選擇檔案'>
                            <input type='button' value='上傳資料' onclick="ck()"></tr>
                    </td>
                </form>
            </table>
        </div>
    </div>
<?php mysqli_close($link) ?>
<?php include("footer.php");?>

