<?php

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
                <div><a class="button is-dark is-outlined" id="search_button" href='/boom/report.php?data_cate=all'>總分類</a></div>
                <div><a class="button is-dark is-outlined" id="search_button" href='/boom/report.php?data_cate=item'>設備</a></div>
                <div><a class="button is-dark is-outlined" id="search_button" href='/boom/report.php?data_cate=class'>教室</a></div>
                <div><a class="button is-dark is-outlined" id="search_button" href='/boom/report.php?data_cate=lab'>實驗室</a></div>                  
                
                    
                            
        </div>
        <div class="section" style="padding:0;">
        <?php
                $type = "item";
               
                if(isset($_GET['data_cate'])){
                    $type =  $_GET['data_cate'];
                }
                $onchange = "";
                switch ($type) {
                    case "all":
                    $onchange ="onchange='droplist_show()";
                    $temp_type = "semester_value ORDER BY semester DESC";
                    break;

                    case "item":                   
                    $temp_type = "item_category";
                    break;

                    case "class":                    
                    $temp_type = "classroom";
                    break;

                    case "lab":                   
                    $temp_type = "lab_category";
                    break;                    
                }
                
                echo "<div class='select is-dark'><select id='itemselect' name='item_category' data-type='$type' $onchange '>";
                echo "<option value='no'>請選擇</option>";
                $sql_ca = "SELECT * FROM $temp_type";
                $catgory =  execute_sql($link,"borrow",$sql_ca);
                // todo 顯示可借用物品
                while($row = mysqli_fetch_assoc($catgory)){
                    if($type=="all"){
                        echo "<option value=".$row['semester']." >".$row['semester']."</option>";
                    }else{
                        echo "<option value=".$row['num']." >".$row['name']."</option>";
                    }                    
                }
                mysqli_free_result($catgory);
                
                
            ?>
            </select>
            </div>    
            <?php
            if($type != "all"){
                echo "<div class='select is-dark'><select id='semester'>";                
                    $sql_semester = "SELECT * FROM semester_value ORDER BY semester DESC";
                    $semester =  execute_sql($link,"borrow",$sql_semester);
                     while($row = mysqli_fetch_assoc($semester)){                        
                        echo "<option value=".$row['semester']." >".$row['semester']."</option>";   
                    }                
                echo "</select></div>";
                echo " <a class='button is-dark is-outlined' id='submit_button'>GO</a>";
            }               
            ?>   
            </div>    
        </div>
        <div id="displaytable" class="section">
        </div>
        <script>
            $('#submit_button').click(function(){
                var semester = $('#semester').val()
                var type = $("#itemselect").data("type")
                var a = document.getElementById("itemselect").value;
                $("#displaytable").load("showpage/report_data.php?choice=" + a + "&type="+type + "&semester=" +semester);
            })

        </script>

        <?php


mysqli_close($link);
?>

</div>
<?php include("footer.php");?>
