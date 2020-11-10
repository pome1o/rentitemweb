<?php
require_once("../dbtools.inc.php");
$link = create_connection();
header("Content-Type:text/html; charset=utf-8");

if(!isset($_GET['choice'])){
    
}
else{
    $check = $_GET['choice'];

    if($_GET['choice']=="no"){
    
    }
    else{
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }
        else{
            $page = 1;
        }

        $c = $_GET['choice'];
        
		// todo	個人紀錄
        if($_GET['choice']=="name"){
            $id = $_GET['who'];
            $sql = "SELECT * FROM borowperson WHERE studentID='$id'  ORDER BY lendTime ASC";
            borderset();
            showperson();
        }
        // todo 物品狀態
        else{
            $sql = "SELECT * FROM item_info WHERE catergory='$c'";
            borderset();
            showlap();
        }
        $result = execute_sql($link,"borrow",$sql);
    
        if (mysqli_num_rows($result)>0){
            $per_page =10;
            $total_records = mysqli_num_rows($result);
            $total_page = ceil($total_records/$per_page);
            $started = $per_page*($page-1);
            $showside = 3;
            mysqli_data_seek($result,$started);
            $j=1;

            while($row = mysqli_fetch_assoc($result) and $j <=$per_page){
                echo "<tr>";
                if($_GET['choice']=="name"){$chshow = $row['itemName'];}else{$chshow=$row['specification'];}
				//$sqladdper = "SELECT stname FROM ".$StrName." WHERE laptopNo = '$row[0]'";
				//$getname = execute_sql($link,"borrow",$sqladdper);
				//$stname = mysqli_fetch_row($getname);
                
                echo "<td  align='center' bgcolor='#FFF2AF' >".$row['itemNo']."</td>"; 
                echo "<td  align='center' bgcolor='#FFF2AF' >".$chshow."</td>"; 
                if($_GET['choice']=="name"){
                    echo "<td  align='center' bgcolor='#FFF2AF' >".$row['lendTime']."</td>";
                    echo "<td  align='center' bgcolor='#FFF2AF' >".$row['returnTime']."</td>";
                }
                else{
                    echo "<td  align='center' bgcolor='#FFF2AF' >".$row['brand']."</td>"; 
                    if($row['usingORnot']!=0){
                        echo "<td align='center'bgcolor='#FFF2AF'><font color='red'>借用中</font></td>";
                    }
                    else{
                        echo "<td align='center' bgcolor='#FFF2AF'><font color='green'>可借用</font></td>";
                    }
                }
    
                echo "</tr>";
                $j++;
            }
            
            mysqli_free_result($result);
            mysqli_close($link);
            echo "<tr>";
            echo "<td colspan='10' height='20' align='center'>";
            //echo "<input type='button' align='center' value='上一頁' onClick='history.back()'>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
    ?>
    <?php
           pagetag($page,$total_page,$showside);
            
        }
        else{
            echo "<h1 align='center'style='color:red;'>沒有資料</h1>";
        }
    }			
}
    ?>


<?php

function borderset(){
    echo "<table class='table' cellpadding='2' align='center'><tr   align='center'>";
}

function showlap(){
    echo "<tr>";
    echo "<th bgcolor='#B0E0E6'>"."編號"."</th>";
    echo "<th bgcolor='#B0E0E6'>"."型號"."</th>";
    echo "<th bgcolor='#B0E0E6'>"."廠牌"."</th>";
    echo "<th bgcolor='#B0E0E6'>"."使用狀況"."</th>";
    //echo "<th bgcolor='#B0E0E6'>"."目前借用人"."</th>";
    echo "</tr>";
}
function showperson(){
    echo "<tr>";
    echo "<th bgcolor='#B0E0E6'>"."編號"."</th>";
    echo "<th bgcolor='#B0E0E6'>"."類型"."</th>";
    echo "<th bgcolor='#B0E0E6'>"."借用時間"."</th>";
    echo "<th bgcolor='#B0E0E6'>"."歸還時間"."</th>";				
    echo "</tr>";
}

?>