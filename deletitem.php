<?php
    session_start();
    include("../boom/check_fun.php");
    include("../boom/header.php");
    include("../boom/nav.php");
    include("check_stop.php");
    require_once("dbtools.inc.php");
    $link = create_connection();
?>

<div class="container">
    <div id="bigtitle" class="section">
        <div class="title is-3">物品刪除</div>
            <div class="search-box">
            <div class="select is-dark">
                <?php
                echo "<select id='itemselect' name='item_category' onchange='droplist_show()' >";
                echo "<option value='no'>請選擇</option>";
                $sql_ca = "SELECT * FROM item_category";
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
    <div id="displaytable" class="section" style="
    text-align: -webkit-center;">
    </div>
</div>

<script>
    $("#displaytable").load("showpage/delshow.php")  ;
</script>
<?php

mysqli_free_result($catgory);
mysqli_close($link);
ob_end_flush();
?>
</div>
<?php include("footer.php");?>