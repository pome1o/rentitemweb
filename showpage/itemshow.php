<form  method="post" data-act="itemChooseForm" id="aaa" name="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
<table class="table" align="center" >
    <?php
    require_once("../dbtools.inc.php");
    session_start();
    $link = create_connection();
    $studentID = $_SESSION["studentId"];
    $sqlstdname = "SELECT personName FROM student WHERE studentID ='$studentID'";
    $stdname = execute_sql($link,"borrow",$sqlstdname);
    $okname = mysqli_fetch_row($stdname);
    date_default_timezone_set('Asia/Taipei');
    $datetime = date("Y-m-d H:i:s");
    
    if(!isset($_GET['choice'])){
        echo "<tr><th style='font-size: 150%'><p>請選擇</p></th></tr>";
    }
    else{
        if($_GET['choice']=="no"){
        
        }
        else{
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }
            else{
                $page = 1;
            }
            
            echo "<tr><th bgcolor='#B0E0E6'>編號</th><th bgcolor='#B0E0E6'>型號</th><th bgcolor='#B0E0E6'>廠牌</th>";

            $c = $_GET['choice'];
            $sql =  "SELECT * FROM item_info where catergory='$c' AND usingORnot ='0'";
            $getitem =  execute_sql($link,"borrow",$sql);
            $total_fields = mysqli_num_fields($getitem);    
            $per_page =10;
            $total_records = mysqli_num_rows($getitem);
            $total_page = ceil($total_records/$per_page);
            $last1 = $total_page-1;
            $started = $per_page*($page-1);
            $showside = 3;
           
            if($total_page==0){
                echo "<div class='subtitle is-4' style='color:red;'>物品已借完</div>";
            }
            
            mysqli_data_seek($getitem,$started);
            $j=1;
            
            while( $row = mysqli_fetch_assoc($getitem) and $j <=$per_page){
                echo "<tr><td  bgcolor='#FFF2AF'>";
                echo "<input id='choosebox' type='radio'  name='choselp' value=".$row['itemNo']."><span>".$row['itemNo']."</span></td>";
                echo "<td  bgcolor='#FFF2AF' ><span>".$row['specification']."</span></td>";
                echo "<td  bgcolor='#FFF2AF' ><span>".$row['brand']."</span></td>";
                echo "</tr>";
                $j++;
            }
         ?>
        <tr><td colspan="3"><a type="button" class="button is-dark is-outlined" name="hi" onclick="check_choose_simple()" >借用</a>
    <a type="button" class="button is-dark is-outlined" value="返回" onclick="location.href='/boom/borrowitem.php'" >返回</a></td></tr>
</table>
</form>
<div style="margin-bottom:2%">
    
</div>
            <?php
                // todo 顯示換頁按鈕
              pagetag($page,$total_page,$showside);
        }
    }   
    ?>
<?php
    if(!empty($_POST["choselp"])){
        $chose = $_POST["choselp"];
        
        // todo 將借用紀錄寫入待審核資料表
        $sqladd = "INSERT INTO tempborrow (personName,studentID,itemNo, status) VALUES ('$okname[0]','$studentID','$chose', '0');";
        
        //echo "INSERT INTO tempborrow (personName,studentID,itemNo,lendTime) VALUES ('$okname[0]','$studentID','$chose','$datetime')";
        $ac = "UPDATE item_info SET usingORnot = 1 WHERE itemNo = '$chose' ";
        mysqli_query($link,$sqladd)or die("爆炸摟1".mysqli_error($link));
        mysqli_query($link,$ac)or die("爆炸摟1".mysqli_error($link));
        mysqli_free_result($stdname);
        mysqli_close($link);
        setcookie('submit',null);
        echo "<script> location.href='../borrowitem.php' </script>";    
        //header("location:../borrowitem.php");
    }

?>




