<?php
ob_start();
session_start();
include("header.php");
    $passed = $_COOKIE["comein"];
    // todo 檢查登入
    if($passed != "True"){
        echo "你沒登入";
        header("location:index.php");
    }
    require_once("dbtools.inc.php");
    $link = create_connection();
    mysqli_select_db($link,"borrow");
    $studentID = $_SESSION["studentId"];
    $sqlstdname = "SELECT personName FROM student WHERE studentID =".$studentID;
    $stdname = execute_sql($link,"borrow",$sqlstdname);
    $okname = mysqli_fetch_row($stdname);
    date_default_timezone_set('Asia/Taipei');
    $datetime = date("Y-m-d H:i:s");
    
    include("nav.php");?>
    <div class="container">
        <div id="bigtitle" class="section">
            <div class="title is-3">借用實驗室</div>
            <div class="search-box">
                <div>
                    <p class="subtitle is-4">目前帳號:&nbsp;
                        <?php echo $studentID;?>
                    </p>
                </div>
                <div class="select is-dark">
                    <select id="itemselect" name="item_category" onchange='droplist_show()'>
                        <option value="no">請選擇</option>
                        <?php
                            $sql_ca = "SELECT * FROM laboratory_category";
                            $catgory =  execute_sql($link,"borrow",$sql_ca);
        
                            // todo 顯示可借用實驗室
                            while($catgory1 = mysqli_fetch_assoc($catgory)){
                                echo "<option value=".$catgory1['id']." >".$catgory1['labName']."</option>";
                            }          
            ?>            
                    </select>
                </div>
            </div>
        </div>
        <div id="displaytable" class="section">
        </div>
    </div>
    <script>
        $("#displaytable").load("showpage/labshow.php");

    </script>
    <?php
            mysqli_free_result($stdname);
            mysqli_free_result($catgory);
            mysqli_close($link);
            setcookie('submit',null);
            ob_end_flush();
        ?>
        <?php include("footer.php");?>
