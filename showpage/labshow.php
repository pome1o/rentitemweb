<form  method="post" id="aaa" name="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
<table class="table" align="center">
    <?php
    session_start();
    require_once("../dbtools.inc.php");
    $link = create_connection();
    $studentID = $_SESSION["studentId"];
    $sqlstdname = "SELECT personName FROM student WHERE studentID =".$studentID;
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
            
            echo "<tr><th bgcolor='#B0E0E6'>編號</th><th bgcolor='#B0E0E6'>名稱</th><th bgcolor='#B0E0E6'>實驗室編號</th></tr>";

            $c = $_GET['choice'];
            $sql =  "SELECT info.labNo AS labId,info.labName AS labName,category.labName AS labNo FROM laboratory_info AS info INNER JOIN laboratory_category AS category on info.category = category.id";
            $getitem =  execute_sql($link,"borrow",$sql);
            $total_fields = mysqli_num_fields($getitem);    
            $per_page =10;
            $total_records = mysqli_num_rows($getitem);
            $total_page = ceil($total_records/$per_page);
            $last1 = $total_page-1;
            $started = $per_page*($page-1);
            $showside = 3;
           
            if($total_page==0){
                echo "<h1 align='center' style='color:red;'>物品已借完</h1>";
            }
            
            mysqli_data_seek($getitem,$started);
            $j=1;
            
            while( $row = mysqli_fetch_assoc($getitem) and $j <=$per_page){
                echo "<tr><td style='padding:5px;' align='center' bgcolor='#FFF2AF' >";
                echo "<input type='radio' name='choselp' value=".$row['labId'].">".$row['labId'];
                echo "<td>".$row['labName']."</td>";
                echo "<td>".$row['labNo']."</td>";
                //echo "<th style='padding:5px;' align='center' bgcolor='#FFF2AF' ><font size='5'>".$row['specification']."</th>";
                //echo "<th style='padding:5px;' align='center' bgcolor='#FFF2AF' ><font size='5'>".$row['brand']."</th>";
                echo "</tr>";
                $j++;
            }
         
?>
<tr>
    
    <td colspan='10' height='20' align='center'>
        <a class="button is-dark is-outlined" type="button" name="hi" onclick="check_data()" value="借用">借用</a>
        <a class="button is-dark is-outlined" type="button" value="返回" onclick="location.href='/boom/borrowlab.php'" >返回</a>
	</td>
</tr>
</table>
</form>
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
        //$sqladd = "INSERT INTO tempborrow (personName,studentID,itemNo,lendTime, status) VALUES ('$okname[0]','$studentID','$chose','$datetime', '0');";
        $sqladd = "INSERT INTO templab (personName,studentID,itemNo,status) VALUES ('$okname[0]','$studentID','$chose', '0');";
        //echo "INSERT INTO tempborrow (personName,studentID,itemNo,lendTime) VALUES ('$okname[0]','$studentID','$chose','$datetime')";
        //$ac = "UPDATE item_info SET usingORnot = 1 WHERE itemNo = '$chose' ";
        $ac = "UPDATE laboratory_info SET usingORnot = 1 WHERE labNo = '$chose'";
        mysqli_query($link,$sqladd)or die("爆炸摟1".mysqli_error($link));
        mysqli_query($link,$ac)or die("爆炸摟1".mysqli_error($link));
        mysqli_free_result($stdname);
        mysqli_close($link);
        setcookie('submit',null);
        echo "<script> location.href='../borrowlab.php' </script>";    
        //header("location:../borrowitem.php");
    }

?>




