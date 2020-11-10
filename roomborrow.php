<?php
  //檢查 cookie 中的 passed 變數是否等於 TRUE
  ob_start();
    session_start();
  $passed = $_COOKIE["comein"];
  $studentID= $_SESSION["studentId"];
  $personName=$_COOKIE["personName"];	
  /*  如果 cookie 中的 passed 變數不等於 TRUE
      表示尚未登入網站，將使用者導向首頁 index.htm	*/
  if ($passed != "True"){
      header("location:index.php");
      exit();
  }
    include("header.php");
    include("nav.php");
    require_once("dbtools.inc.php");
	$link = create_connection();
	$sql_room = "SELECT roomNo FROM classroom";
    $room_aft_sql = execute_sql($link,"borrow",$sql_room);
	
?>
    <div class="container">
        <h3 align="center">教室可用時間</h3>
        <form method="post" id="form1" name="form1" action="/boom/do/doroom.php">
            <table align="center">
<?php
    while($roomcount = mysqli_fetch_array($room_aft_sql)){
        echo " <td><input type='radio' name='UserChose' onchange='chose()' value= ".$roomcount['roomNo']."> ".$roomcount['roomNo']."</td>";
    }
    if(isset($_GET['value'])){
?>
            </table>


<?php
        // todo 將選擇的教室編號寫入Cookie
        $room = "30801";
        if(isset($_GET['value'])){
            $getroom = $_GET['value'];
            $room = $getroom;
        }	
        if(isset($_COOKIE['room'])) {
        }
        else{
            setcookie("rooom",$room);
        }
     
        require_once("dbtools.inc.php");
        $link = create_connection();
        //echo $room;
  
        //echo "SELECT * FROM $room ORDER BY $room.period ASC ";
        $sql = "SELECT * FROM classperiod WHERE room = '$room' ORDER BY period ASC";
        $result = execute_sql($link,"borrow",$sql);
        $numfield = mysqli_num_fields($result);
 
?>
                <h3 align="center">
                    <?php echo "目前帳號&nbsp;:&nbsp;".$studentID.
	"&nbsp;&nbsp;使用者姓名&nbsp;:&nbsp;".$personName."&nbsp;&nbsp;".$room."教室";  ?>
                </h3>
                <table class="table is-bordered" align="center">
                    <th bgcolor='#333' style="width:18%">
                        <font color="#FFFFFF">節次</font>
                    </th>
                    <th bgcolor='#333' style='padding:10px;'>
                        <font color="#FFFFFF">星期一</font>
                    </th>
                    <th bgcolor='#333' style='padding:10px;'>
                        <font color="#FFFFFF">星期二</font>
                    </th>
                    <th bgcolor='#333' style='padding:10px;'>
                        <font color="#FFFFFF">星期三</font>
                    </th>
                    <th bgcolor='#333' style='padding:10px;'>
                        <font color="#FFFFFF">星期四</font>
                    </th>
                    <th bgcolor='#333' style='padding:10px;'>
                        <font color="#FFFFFF">星期五</font>
                    </th>
                    <?php  
        $j=1;
        while($row = mysqli_fetch_row($result)){
            
            echo "<tr>";
            for($i = 0; $i<$numfield;$i++){
                if ($i!=0){
                    // todo 顯示節次
                    if($i==1){
                        echo "<th  style='height:50px' align='center' bgcolor='#FFF2AF' ><font size='5'>".$row[$i]."</font></th>";
                    }
                    else{
                        // todo 不可借用
                        if($row[$i]==2){
				            echo "<th  style='height:50px' align='center' bgcolor='#C6007D' ></th>";
                        }
                        // todo 可借用
                        else if($row[$i]==0){
                            echo "<th  style='height:50px' align='center' bgcolor='#6BC9C9' >
				            <input type='radio' name='when1' value='$i$j'>
			                </th>";
                        }
                        // todo 借用中
                        else if($row[$i]==1){
                            echo "<th  style='height:50px' align='center' bgcolor='#566AFF' ></th>";
                        }
                    }
                }
            }
            
            echo "</tr>";
            $j++;
        }
        
        echo "<tr>";
        echo "<th  style='height:30px' align='center' bgcolor='#C6007D' ></th>";
	    echo "<th>不可借用</th>";
        echo "<th  style='height:30px' align='center' bgcolor='#6BC9C9' ></th>";
	    echo "<th>可借</tr>";
	    echo "<th  style='height:30px' align='center' bgcolor='#566AFF' ></th>";
	    echo "<th>借用中</th>";
	    echo "</tr>";
	    echo "<tr><td colspan='10' height='20' align='center'><input type='button' onclick='check_data()' value='送出'></td></tr>";


?>
        </form>
        </table>

<?php 
        
    mysqli_free_result($result);
    mysqli_free_result($room_aft_sql);
    mysqli_close($link);
    
    }
    ob_end_flush();
?>
    </div>
<?php include("footer.php");?>

