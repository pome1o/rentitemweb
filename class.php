<?php
// todo 檢查登入及權限 
include("check_fun.php");

  $title = "教室歸還";
  $action = "roomsult.php";
  $status = 1;
    
if(isset($_GET['c'])){
    $title = "教室確認";
    $action = "roomck.php";
    $status = 0;
}
include("header.php");
include("nav.php");?>
    <div class="container">

        <table  align="center">
            <h1 align="center">
                <?php echo $title; ?>
            </h1>
            <tr align="center">
                <td><input id="ch" type="text" onkeypress="if (event.keyCode == 13) {ch()}"></td>
            </tr>
        </table>
        <form name="myForm" id="myForm" action="<?php echo $action; ?>" method="post">
            <table  align="center">
                <tr bgcolor="#333">
                    <td align="center">
                        <font color="#FFFFFF">教室編號</font>
                    </td>
                    <td align="center">
                        <font color="#FFFFFF">姓名</font>
                    </td>
                    <td align="center">
                        <font color="#FFFFFF">星期</font>
                    </td>
                    <td align="center">
                        <font color="#FFFFFF">節次</font>
                    </td>
                </tr>
                <p align="center">
                    登入使用者帳號:
                    <?php echo $studentID?> 使用者姓名:
                    <?php echo $personName?><br>
                </p>
                <?php
        // todo 教室歸還
        if(isset($_GET['name'])){
            $id = $_GET['name'];
            $sql = "SELECT * FROM `roomborrow` Where studentID = '$id' AND returnTime IS NULL AND status = $status ";
        }
        // todo 教室確認
        else{
            $sql = "SELECT * FROM `roomborrow` Where returnTime IS NULL AND status = $status ";
        }
		require_once("dbtools.inc.php");
		$link = create_connection();
		
		$result = execute_sql($link,"borrow",$sql);
		$as = 0;
		while ($row = mysqli_fetch_object($result)){
            echo "<tr>";
            echo "<td bgcolor='#CCFFCC'> ";
            echo "<input type='checkbox' id='bno' name='bno[]' value='$row->roomNo*$row->week*$row->period'>$row->roomNo</td>";		        
            //echo "<td bgcolor='#FFCCCC'>$row->usingORnot</td>";
            echo "<td bgcolor='#FFCCCC'align='center' >$row->personName</td>";
			echo "<td bgcolor='#FFCCCC'>$row->week</td>";
			echo "<td bgcolor='#FFCCCC'>$row->period</td>";
            echo "</tr>";
			$as++;
        }

		mysqli_close($link);
	  ?>
            </table>
            <p align="center">
                <?php 
		
		if( $as > 1 ){
            echo "<input type='checkbox' name='all' onclick=check_all('bno[]')>全選";
        }
		?>
                <input type="button" value="確定" onClick="check_data(1)">
                <?php if(isset($_GET['c'])){ echo "<input type='button' name='dowhat' value='駁回' onclick='check_data(2)'>";} ?>
                <input type="reset" value="重新設定">
            </p>
        </form>
    </div>
    <?php include("footer.php");?>
