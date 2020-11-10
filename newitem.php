<?php
session_start();
include("check_fun.php");
require_once("dbtools.inc.php");
$link = create_connection();
mysqli_select_db($link,"borrow");
$datetime = date("Y-m-d H:i:s");

include("header.php");
include("nav.php");
include("check_stop.php");?>
    <div class="container">
        <div id="eachitem" style="width:100%;">
            <h1 align="center">新增物品</h1>
            <table class="table table is-hoverable is-bordered" align="center" border='1'>
                <form id='myForm' name='myForm' method="post" action="do/add_one_item.php">
                    <tr align="center">
                        <tr>
                            <td> <input type='button' class="button is-dark is-outlined" value='csv上傳' onclick='goup()'></td>
                        </tr>
                        <td> 種類: <input name='sp' id='sp' type='text' disabled></td>
                        <td><select name='drop' id='drop' onchange="droplist_simple()">
<?php
$sql_ca = "SELECT * FROM item_category";
$catgory =  execute_sql($link,"borrow",$sql_ca);            
while($catgory1 = mysqli_fetch_assoc($catgory)){
echo "<option value=".$catgory1['name']." >".$catgory1['name']."</option>";
}
echo "<option value='newcate' >新增種類</option>";                        
?>                                                    
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td> 編號: <input id='t1' name='itemNo' type='text' placeholder='請將分類號和序號連在一起'></td>
                    </tr>
                    <tr>
                        <td> 型號: <input id='t2' name='itemsp' type='text'></td>
                    </tr>
                    <tr>
                        <td> 廠牌: <input id='t3' name='itembrand' type='text'></td>
                    </tr>                    
                    <tr>
                        <td><input type='button' class="button is-dark is-outlined" value="送出" onclick="ck()"></td>
                    </tr>
                    </tr>
                </form>
            </table>
        </div>
        <div id="manyitem" style="display:none">
            <table class="table table is-hoverable is-bordered" align="center">
                <form method="post" action="do/add_lot_item.php" enctype="multipart/form-data">
                    <tr>
                        <td colspan="2"><input type='button' class="button is-dark is-outlined" value='新增單筆' onclick='back()' required='required'>
                            <a href='/boom/uploads/物品上傳格式.csv' class="button is-dark is-outlined" download>格式下載</a>
                            <select>
                                <option>目前有的種類</option>
<?php
$sql_ca = "SELECT * FROM item_category";
$catgory =  execute_sql($link,"borrow",$sql_ca);                                 
while($catgory1 = mysqli_fetch_assoc($catgory)){
echo "<option value=".$catgory1['name']." >".$catgory1['name']."</option>";
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
                        <td colspan='2'><input type='file' class="button is-dark is-outlined" name='fileup' value='選擇檔案'>
                            <input type='submit' class="button is-dark is-outlined" value='上傳資料' name='submit'></tr>
                    </td>
                </form>
            </table>
        </div>
    </div>
    <?php mysqli_close($link) ?>
    <?php include("footer.php");?>
