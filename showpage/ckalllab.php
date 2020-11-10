
	<form name="myForm" id="myForm" action="do/docklab.php" method="post" >
         <table  align="center">
    <?php
    require_once("../dbtools.inc.php");
    $link = create_connection();
    if(!isset($_GET['choice'])&&!isset($_GET['name'])){
      
    }
    else{
        echo "<tr bgcolor='#748ECB'>"; 
        echo "<td align='center'><font color='#FFFFFF'>編號</font></td>";
        echo "<td align='center'><font color='#FFFFFF'>借用人</font></td>";
        echo "<td align='center'><font color='#FFFFFF'>實驗室</font></td>";
        echo "</tr>";
        
        $c =  $_GET['choice'];
        
        // todo 學號
        if(isset($_GET['name'])){
            $studentID = $_GET['name'];
        }
        // 全選
        if($c=="allitem"){
            //$sql_st = "SELECT b.studentID,b.personName,info.itemNo,info.specification,info.brand,info.catergory,info.os FROM item_info AS info,tempborrow AS b WHERE b.itemNo = info.itemNo AND b.status = 0 ";
            
            $sql_st = "SELECT b.studentID,b.personName,info.labNo,info.category FROM laboratory_info AS info,templab AS b WHERE b.itemNo = info.labNo AND b.status = 0 AND b.category = info.category";
        }
        // 個人紀錄
        else if(isset($_GET['name'])){
            $sql_st = "SELECT b.studentID,b.personName,info.itemNo,info.specification,info.brand,info.catergory,info.os FROM item_info AS info,tempborrow AS b WHERE b.itemNo = info.itemNo AND b.studentID = '$studentID' AND b.status = 0";
        }
        $sl = execute_sql($link,"borrow",$sql_st);
        if(mysqli_num_rows($sl)<=0){
              echo "<h1 align='center'style='color:red;'>沒有資料</h1>";
        }
        $as=0;
        $carray = array();
        $carray1 = array();
        $sql_ca = "SELECT * FROM laboratory_category";
        $catgory =  execute_sql($link,"borrow",$sql_ca);            
        while($catgory1 = mysqli_fetch_assoc($catgory)){
            $carray[$as] = $catgory1['id'];
            $carray1[$as] = $catgory1['labName'];
            $as++;
        }
        mysqli_free_result($catgory);
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        else{
            $page = 1;
        }
        
        $total_fields = mysqli_num_fields($sl);
        $per_page =10;
        $total_records = mysqli_num_rows($sl);
        $total_page = ceil($total_records/$per_page);
        $last1 = $total_page-1;
        $started = $per_page*($page-1);
        $showside = 3;
        mysqli_data_seek($sl,$started);
          
        $j=1;
        while ($row = mysqli_fetch_assoc($sl) and $j <= $per_page){
            
            switch($row["category"]){
                case "1":
                    $labName = "801實驗室";
                    break;
                case "2":
                    $labName = "802實驗室";
                    break;
                case "4":
                    $labName = "804實驗室";
                    break;
                case "5":
                    $labName = "813實驗室";
                    break;
                case "6":
                    $labName = "817實驗室";
                    break;    
            }
            
            $d  = array_search($row['category'],$carray);
            echo "<tr>";
            echo "<td bgcolor='#CCFFCC'> ";
            echo "<input align='center' type='checkbox' id='bno' name='bno[]'
            value=".$row['labNo'].'@@'.$row['studentID'].'@@'.$carray1[$d].">".$row['labNo']."</td>";	
            
            echo "<input type='hidden' name='category[]' value=".$row['category']."></td>";	
            echo "<td align='center' bgcolor='#FFCCCC'>".$row['personName']."</td>";
            echo "<td align='center' bgcolor='#FFCCCC'>".$labName."</td>";
            //echo "<td align='center' bgcolor='#FFCCCC'>".$row['specification']."</td>";
            //echo "<td align='center' bgcolor='#FFCCCC'>".$row['brand']."</td>";
            //echo "<td align='center' bgcolor='#FFCCCC'>".$row['personName']."</td>";
            //echo "<td align='center' style='padding:2px;' bgcolor='#FFCCCC'>$carray1[$d]</td>";
            echo "</tr>";
            $as++;
            $j++;
        }
        mysqli_free_result($sl);
		mysqli_close($link);
  
	  ?>

	   <p align="center">
    <?php 
        echo "<tr align='center'>";
        echo "<td >";
		echo "<input type='checkbox' name='all[]' onclick='check_all()'>全選   ";
        echo "</td>";
        echo "<td >";
        echo "<input type='button' value='確定' onClick='check_data(1)'>"; echo "</td>";
        echo "<td >";
        echo "<input type='button' value='駁回' onClick='check_data(2)'>"; echo "</td>";
        echo "</tr>";

    ?>
		</p>
    	   </table>
    </form>
    <?php
        // todo 換頁按鈕
       pagetag($page,$total_page,$showside);
    }

           
    ?>
	