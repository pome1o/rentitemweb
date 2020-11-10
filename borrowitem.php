<?php
ob_start();
session_start();
include("header.php");
include("nav.php");
include("check_stop.php");

  // todo 檢查登入



require_once("dbtools.inc.php");
$link = create_connection();
mysqli_select_db($link,"borrow");

$studentID = $_SESSION["studentId"];
$sqlstdname = "SELECT personName FROM student WHERE studentID ='$studentID'";
$stdname = execute_sql($link,"borrow",$sqlstdname);
$okname = mysqli_fetch_row($stdname);
date_default_timezone_set('Asia/Taipei');
$datetime = date("Y-m-d H:i:s");
 
?>
    <div class="container">
        <div id="bigtitle" class="section">
            <div class="title is-3" align="center">借用</div>
            <div class="search-box">
               
                <div><p id="user" class="subtitle is-4">目前帳號:&nbsp;<?php echo $studentID;?></p>
                </div>
                <div class="select is-dark">
                    
                <?php
                $type = "item";
                if(isset($_GET['borrow_type'])){
                    $type =  $_GET['borrow_type'];
                }
                $onchange = "";
                switch ($type) {
                    case "item":
                    $onchange ="onchange='droplist_show()";
                    $temp_type = "item_category";
                    break;

                    case "class":
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
                <?php
                    if($type == "class"){
                        echo "<a class='button is-dark is-outlined' onclick='check_class_search()'>當日</a> ";
                        echo "<a class='button is-dark is-outlined' onclick='exepect_class()'>預借</a>";
                        echo "<div id='date_dialog' title='請先選擇時間'> <input type='text' id='dummydate'> <p>請選擇欲借用日期</p> <input type='text' id='class_date_pick'> <a class='button is-dark is-outlined' onclick='class_date_confirm()'>確認</a> </div>";
                    }
                ?>
            </div>                
        </div>
        <div id="displaytable" class="section">
        </div>
        <script>
            $("#abc").load("showpage/itemshow.php");
            function check_class_search(){
                if($("#itemselect").val()!="no"){
                    $("#user").data("class_type","today");
                    droplist_show()
                }else{
                    swal("請先選擇")
                }                
            }

            function exepect_class(){
                if($("#itemselect").val()!="no"){
                    $("#user").data("class_type","expect");
                    $('#class_date_pick').datepicker({
                        minDate:1,
                        dateFormat:"yy-mm-dd"
                    });
                    $('#date_dialog').dialog(); 
                }else{
                    swal("請先選擇")
                }       
            }

            function class_date_confirm(){                
                var date = $('#class_date_pick').val();
                $('#date_dialog').dialog("close"); 
                $("#displaytable").html("")
                if(date.length > 0){
                    var reg = /([1-9][0-9][0-9][0-9])[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])/
                    if(reg.test(date)){
                        var start = new Date(date)
                        var now = new Date()
                        if(start.getDate() - now.getDate() > 0 ){
                            $.ajax({
                                type:"post",
                                url:"/boom/showpage/class_expect.php",
                                data:{room_num:$("#itemselect").val(),date:date},
                                dataType:"html",
                                success:function(data){
                                    $("#displaytable").html(data)
                                }
                            })
                        }else{
                            swal("不可選過去的時間");
                        }
                    }
                }
            }
        </script>

        <?php
mysqli_free_result($stdname);
mysqli_free_result($catgory);
mysqli_close($link);
setcookie('submit',null);
ob_end_flush();
?>

</div>
<?php include("footer.php");?>
