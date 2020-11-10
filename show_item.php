<?php
ob_start();
session_start();
include("header.php");
include("nav.php");
include("check_stop.php");
require_once("dbtools.inc.php");
$link = create_connection();
 
?>
    <div class="container">
        <div id="bigtitle" class="section">
            <div class="title is-3" align="center">查看</div>
            <div class="search-box">
                <div><a class="button is-dark is-outlined" id="search_button" href='/boom/show_item.php?data_cate=item'>設備</a></div>
                <div><a class="button is-dark is-outlined" id="search_button" href='/boom/show_item.php?data_cate=class'>教室</a></div>
                <div><a class="button is-dark is-outlined" id="search_button" href='/boom/show_item.php?data_cate=lab'>實驗室</a></div>                  
                <div class="select is-dark">
                    
                <?php
                $type = "item";
                if(isset($_GET['data_cate'])){
                    $type =  $_GET['data_cate'];
                }
                $onchange = "";
                switch ($type) {
                    case "item":
                    $onchange ="onchange='droplist_show()";
                    $temp_type = "item_category";
                    break;

                    case "class":
                    $onchange ="onchange='droplist_show()";
                    $temp_type = "classroom";
                    break;

                    case "lab":
                    $onchange ="onchange='droplist_show()";
                    $temp_type = "lab_category";
                    break;                    
                }
                echo "<select id='itemselect' name='item_category' data-type='$type' $onchange '>";
                echo "<option value='no'>請選擇</option>";
                $sql_ca = "SELECT * FROM $temp_type";
                $catgory =  execute_sql($link,"borrow",$sql_ca);
                    // todo 顯示可借用物品
                while($row = mysqli_fetch_assoc($catgory)){
                    echo "<option value=".$row['num']." >".$row['name']."</option>";
                }
                  
                ?>
            </select>
                </div>                
            </div>                
        </div>
        <div id="displaytable" class="section">
        </div>
        <script>
        </script>

        <?php

mysqli_free_result($catgory);
mysqli_close($link);
?>

</div>
<?php include("footer.php");?>
