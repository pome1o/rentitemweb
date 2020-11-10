<div>
    <form method="post" data-act="itemChooseForm" id="aaa" name="form1" action="../do/dodelete.php">
        <table class="slt" align="center">
            <table class="table table is-hoverable is-bordered" id="borrow_table" align="center">
<?php
require_once("../dbtools.inc.php");

if(isset($_GET['choice'])){
    $link = create_connection();
    $choice = $_GET['choice'];
    
    $page = 1;
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }
    $sql_select = "SELECT * FROM item_info WHERE catergory = '$choice'";
    $result = execute_sql($link,"borrow",$sql_select);
    $total_fields = mysqli_num_fields($result);    
    $per_page =10;
    $total_records = mysqli_num_rows($result);
    $total_page = ceil($total_records/$per_page);
    $last1 = $total_page-1;
    $started = $per_page*($page-1);
    $showside = 3;
   
 
    if($total_page==0){
        echo "<div class='subtitle is-4' style='color:red;'>沒有</div>";
    }      
    mysqli_data_seek($result,$started);
    $j=1;
    
    echo "<tr><th bgcolor='#B0E0E6'>編號</th><th bgcolor='#B0E0E6'>型號</th><th bgcolor='#B0E0E6'>廠牌</th></tr>";
    
    while( $row = mysqli_fetch_assoc($result) and $j <=$per_page){
                echo "<tr><td  bgcolor='#FFF2AF'>";
                echo "<input id='choosebox' type='checkbox'  name='user_select[]' value=".$row['itemNo']."><span>".$row['itemNo']."</span></td>";
                echo "<td  bgcolor='#FFF2AF' ><span>".$row['specification']."</span></td>";
                echo "<td  bgcolor='#FFF2AF' ><span>".$row['brand']."</span></td>";                
                echo "</tr>";                
                $j++;
            }
    

?>
</table>
</form>
</div>
<div style="margin-bottom:2%">
<a type="button" class="button is-dark is-outlined" name="hi" onclick="delete_send()" >確認</a>
<input type="checkbox" data-act="checkall" data-scope="[type=checkbox]" style="margin-left:1%" onclick="checkBoxAll()">全選
</div>
<?php
   
        pagetag($page,$total_page,$showside);
       
    mysqli_close($link);
}
?>
