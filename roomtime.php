<?php
    session_start();
    include("header.php");
    include("nav.php");
    ob_start();   
    require_once("dbtools.inc.php");
    $link = create_connection();
    $sql_room = "SELECT roomNo FROM classroom";
    $room_aft_sql = execute_sql($link,"borrow",$sql_room);
?>
    <div class="container">
        <h3 align="center">教室可用時間</h3>
        <form method="post" id="form1" name="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table align="center">
                <tr>
                    <?php
		while($roomcount = mysqli_fetch_array($room_aft_sql)){
			echo " <td><input type='radio' name='UserChose' onchange='chose()' value= ".$roomcount['roomNo']."> ".$roomcount['roomNo']."</td>";
		}
	 
	?>
                </tr>
                <td colspan='10' height='20' align='center'>
            </table>
<?php
ob_start();
  $room = "30801";
  if(isset($_GET['value'])){
      $getroom = $_GET['value'];
      $room = $getroom;
  }	
  require_once("dbtools.inc.php");
  $link = create_connection();
  $sql = "SELECT * FROM classperiod WHERE room = '$room' ORDER BY period ASC";
  $result = execute_sql($link,"borrow",$sql);
  $numfield = mysqli_num_fields($result);
  if(isset($_GET['value'])){
?>
        </form>
        <h3 align="center">
            <?php echo $room."教室";  ?>
        </h3>
        <table align="center">
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
                            
$j = 1;
while($row = mysqli_fetch_row($result)){
    echo "<tr>";
     	 
    for($i = 0; $i<$numfield;$i++){
        if ($i!=0){
            // todo 節次
            if($i==1){{
                echo "<th  style='height:50px' align='center' bgcolor='#FFF2AF' ><font size='5'>".$row[$i]."</font></th>";
            }
        }
		else{
            // todo 不可借用
			if($row[$i]==2){
				echo "<th  style='height:50px' align='center' bgcolor='#C6007D' ></th>";
			}
            // todo 可借用
			else if($row[$i]==0){
                echo "<th  style='height:50px' align='center' bgcolor='#6BC9C9' ></th>";
			}
            // todo 借用中
            else if($row[$i]==1){
                switch($i-1){
                        case 1:
                        $week1 = "Mon";
					    break;
					    case 2:
					    $week1 = "Tue";
					    break;
					    case 3:
					    $week1 = "Wed";
					    break;
					    case 4:
					    $week1 = "Thu";
					    break;
					    case 5:
					    $week1 = "Fri";
					    break;
				}
                
			    // echo "SELECT * FROM roomborrow WHERE roomNo IN('$roomis') AND period = '$j' AND roomNo = '$roomis' AND week = '$week1' AND returnTime IS NULL <br>";
			    $sqle = "SELECT * FROM roomborrow WHERE roomNo IN('$room') AND period = '$j' AND roomNo = '$room' AND week = '$week1' AND returnTime IS NULL";
			    $result3 =  execute_sql($link,"borrow",$sqle); 
			    $studen_br = mysqli_fetch_object($result3);
                echo "<th  style='height:50px' align='center' bgcolor='#566AFF' ><font color='#fffff'></font></th>";
			    mysqli_free_result($result3);
			}			
        }
    }		 
    }
    echo "</tr>";
 $j++;
 }   
      echo "<tr>";
	  echo "<th  style='height:30px' align='center' bgcolor='#C6007D' ></th>";
	  echo "<th>不可借用</th></tr>";
	  echo "<tr><th  style='height:30px' align='center' bgcolor='#6BC9C9' ></th>";
	  echo "<th>可借</th></tr>";
	  echo "<tr><th  style='height:30px' align='center' bgcolor='#566AFF' ></th>";
	  echo "<th>借用中</th></tr>";
	  
//
mysqli_free_result($result);
mysqli_free_result($room_aft_sql);                            
  }    
mysqli_close($link);
ob_end_flush();
?>
        </table>
    </div>
    <?php include("footer.php");?>
